<?php declare(strict_types=1);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../../inc/framework/test.php';

require_once __DIR__ . '/mud_http.php';

// Resource limits for untrusted HTTP input.
// Contract: maximum nesting depth 8 (root array counts as level 1),
// maximum 1,000 elements across the entire tree (including array-valued
// elements), maximum 1 MiB per string (measured in bytes).
// These are security regression tests: implementations must enforce limits.
const TEST_MAX_DEPTH = 8;
const TEST_MAX_ELEMENTS = 1000;
const TEST_MAX_STRING_BYTES = 1048576;


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - declare tests...
//

mud_declare_tests([

  'normalize-input' => function() {

    $without_newlines = [
      "  Hello  "                => "Hello",
      "Hello   World"            => "Hello World",
      "Hello\tWorld"             => "Hello World",
      "Hello\nWorld"             => "Hello World",
      "Hello\r\nWorld"           => "Hello World",
      "Hello\rWorld"             => "Hello World",
      "Hello\n\nWorld"           => "Hello World",
      "Hello \t \n World"        => "Hello World",
      "Hello\u{00A0}World"       => "Hello World",
      "Hello\u{2028}World"       => "Hello World",
      "Hello\u{200B}World"       => "HelloWorld",
      "Hello\0World"             => "HelloWorld",
      "  café  "                 => "café",
      "cafe\u{0301}"             => "café",
      "\t\n Hello \r\n"          => "Hello",
      ""                         => "",
    ];

    $with_newlines = [
      "  Hello  "                => "Hello",
      "Hello   World"            => "Hello World",
      "Hello\tWorld"             => "Hello World",
      "Hello\nWorld"             => "Hello\nWorld",
      "Hello\r\nWorld"           => "Hello\nWorld",
      "Hello\rWorld"             => "Hello\nWorld",
      "Hello\n\nWorld"           => "Hello\n\nWorld",
      "Hello \t \n World"        => "Hello \n World",
      "Hello\u{00A0}World"       => "Hello World",
      "Hello\u{2028}World"       => "Hello\nWorld",
      "Hello\u{200B}World"       => "HelloWorld",
      "Hello\0World"             => "HelloWorld",
      "  café  "                 => "café",
      "cafe\u{0301}"             => "café",
      "\t\n Hello \r\n"          => "Hello",
      ""                         => "",
    ];

    foreach ($without_newlines as $input => $expected) {
      $actual = mud_http_normalize_input($input, false);

      if ($actual !== $expected) {
        throw new RuntimeException(
          'Single-line test failed: ' . var_export($input, true)
        );
      }
    }

    foreach ($with_newlines as $input => $expected) {
      $actual = mud_http_normalize_input($input, true);

      if ($actual !== $expected) {
        throw new RuntimeException(
          'Multiline test failed: ' . var_export($input, true)
        );
      }
    }

    // Invalid UTF-8 must be rejected.
    try {
      mud_http_normalize_input("\xFF");
      throw new RuntimeException('Invalid UTF-8 was accepted.');
    }
    catch (InvalidArgumentException $e) {
      // Expected.
    }

    return 0;

  },

  'normalize-input-ChatGPT' => function() {

    $functions = [
      'mud_http_normalize_input',
      'mud_http_normalize_input_array',
      'mud_http_get_query',
      'mud_http_get_input',
      'mud_http_get_query_array',
      'mud_http_get_input_array',
    ];
    foreach ($functions as $function) {
      if (!function_exists($function)) {
        fwrite(STDERR, "Missing function: $function\nSet MUD_HTTP_SOURCE=/path/to/your/functions.php\n");
        exit(2);
      }
    }

    $passed = 0;
    $failed = 0;

    function check_case(string $label, callable $action, mixed $expected): void {
      global $passed, $failed;
      try {
        $actual = $action();
        if ($actual !== $expected) {
          throw new RuntimeException('Expected ' . var_export($expected, true) . '; got ' . var_export($actual, true));
        }
        ++$passed;
      }
      catch (Throwable $ex) {
        ++$failed;
        fwrite(STDERR, "FAIL $label: " . $ex->getMessage() . "\n");
      }
    }

    function check_exception(string $label, callable $action, string $exceptionClass): void {
      global $passed, $failed;
      try {
        $action();
        ++$failed;
        fwrite(STDERR, "FAIL $label: expected $exceptionClass, no exception thrown\n");
      }
      catch (Throwable $ex) {
        if ($ex instanceof $exceptionClass) {
          ++$passed;
        }
        else {
          ++$failed;
          fwrite(STDERR, "FAIL $label: expected $exceptionClass; got " . get_class($ex) . ': ' . $ex->getMessage() . "\n");
        }
      }
    }

    $singleLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", 'Hello World'],
      'CRLF' => ["Hello\r\nWorld", 'Hello World'],
      'CR' => ["Hello\rWorld", 'Hello World'],
      'multiple lines' => ["Hello\n\nWorld", 'Hello World'],
      'mixed whitespace' => ["Hello \t \n World", 'Hello World'],
      'leading trailing line breaks' => ["\t\n Hello \r\n", 'Hello'],
      'all whitespace' => [" \t\n\r \u{00A0}", ''],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'em space' => ["Hello\u{2003}World", 'Hello World'],
      'thin space' => ["Hello\u{2009}World", 'Hello World'],
      'ideographic space' => ["Hello\u{3000}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", 'Hello World'],
      'line separator' => ["Hello\u{2028}World", 'Hello World'],
      'paragraph separator' => ["Hello\u{2029}World", 'Hello World'],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'zero width joiner' => ["a\u{200D}b", 'ab'],
      'BOM' => ["\u{FEFF}Hello\u{FEFF}", 'Hello'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'BEL' => ["Hello\x07World", 'HelloWorld'],
      'DEL' => ["Hello\x7FWorld", 'HelloWorld'],
      'backspace' => ["Hello\x08World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'precomposed accent' => ['café', 'café'],
      'non-Latin' => ['  Καλημέρα 世界  ', 'Καλημέρα 世界'],
      'emoji' => ['  😀  ', '😀'],
      'NFC not NFKC' => ['①  ﬁ', '① ﬁ'],
      'keep ordinary punctuation' => ['  A-B_123!  ', 'A-B_123!'],
      'internal whitespace collapse' => ["a  \t \r\n b", 'a b'],
    ];

    $multiLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", "Hello\nWorld"],
      'CRLF' => ["Hello\r\nWorld", "Hello\nWorld"],
      'CR' => ["Hello\rWorld", "Hello\nWorld"],
      'blank lines' => ["Hello\n\nWorld", "Hello\n\nWorld"],
      'spaces adjacent to newline' => ["Hello \t \n World", "Hello \n World"],
      'trim external newlines' => ["\t\n Hello \r\n", 'Hello'],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", "Hello\nWorld"],
      'line separator' => ["Hello\u{2028}World", "Hello\nWorld"],
      'paragraph separator' => ["Hello\u{2029}World", "Hello\nWorld"],
      'mixed line endings' => ["A\r\nB\rC\nD", "A\nB\nC\nD"],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'emoji' => ['😀', '😀'],
    ];

    foreach ($singleLine as $label => [$input, $expected]) {
      check_case("normalize single: $label", static fn() => mud_http_normalize_input($input), $expected);
    }
    foreach ($multiLine as $label => [$input, $expected]) {
      check_case("normalize multiline: $label", static fn() => mud_http_normalize_input($input, true), $expected);
    }
    foreach (["\xFF", "\xC3\x28", "\xE2\x82", "\xED\xA0\x80"] as $index => $bad) {
      check_exception("invalid UTF-8 #$index single", static fn() => mud_http_normalize_input($bad), InvalidArgumentException::class);
      check_exception("invalid UTF-8 #$index multiline", static fn() => mud_http_normalize_input($bad, true), InvalidArgumentException::class);
    }

    $arrayCases = [
      'empty' => [[], []],
      'indexed' => [['  Hello  ', "A\nB"], ['Hello', 'A B']],
      'associative' => [['name' => ' Alice ', 'city' => ' Sydney '], ['name' => 'Alice', 'city' => 'Sydney']],
      'nested' => [['user' => ['name' => ' Alice ', 'tags' => [' PHP ', "A\tB"]]], ['user' => ['name' => 'Alice', 'tags' => ['PHP', 'A B']]]],
      'numeric keys' => [[10 => ' a ', 25 => ' b '], [10 => 'a', 25 => 'b']],
      'empty strings' => [['', '   ', ' x '], ['', '', 'x']],
      'unicode' => [['café' => "cafe\u{0301}", 'emoji' => ' 😀 '], ['café' => 'café', 'emoji' => '😀']],
      'deep nested' => [['a' => ['b' => ['c' => [' d ']]]], ['a' => ['b' => ['c' => ['d']]]]],
    ];
    foreach ($arrayCases as $label => [$input, $expected]) {
      $original = $input;
      check_case("array single: $label", static fn() => mud_http_normalize_input_array($input), $expected);
      check_case("array does not mutate: $label", static fn() => $input, $original);
    }
    check_case('array multiline nested', static fn() => mud_http_normalize_input_array(['x' => ["A\r\nB", "C\tD"]], true), ['x' => ["A\nB", 'C D']]);
    foreach ([['x' => 123], ['x' => null], ['x' => false], ['x' => 1.5], ['x' => new stdClass()], ['nested' => ['x' => 7]]] as $index => $badArray) {
      check_exception("array invalid type #$index", static fn() => mud_http_normalize_input_array($badArray), InvalidArgumentException::class);
    }
    check_exception('array invalid UTF-8', static fn() => mud_http_normalize_input_array(['x' => "\xFF"]), InvalidArgumentException::class);

    $oldGet = $_GET;
    $oldPost = $_POST;
    try {
      foreach ([
        ['GET', 'mud_http_get_query', 'mud_http_get_query_array'],
        ['POST', 'mud_http_get_input', 'mud_http_get_input_array'],
      ] as [$sourceName, $scalarFn, $arrayFn]) {
        $sample = [
          'name' => '  Alice  ',
          'empty' => '',
          'blank' => '  ',
          'zero' => '0',
          'lines' => "A\r\nB",
          'accent' => "cafe\u{0301}",
          'items' => ['  One  ', "Two\nThree"],
          'nested' => ['x' => [' y ']],
          'empty_array' => [],
          'invalid_utf8' => "\xFF",
          'invalid_array' => ['bad' => 42],
        ];
        if ($sourceName === 'GET') {
          $_GET = $sample;
        }
        else {
          $_POST = $sample;
        }
        check_case("$sourceName missing scalar default", static fn() => $scalarFn('missing', 'fallback'), 'fallback');
        check_case("$sourceName missing scalar null", static fn() => $scalarFn('missing'), null);
        check_case("$sourceName present scalar", static fn() => $scalarFn('name', 'fallback'), 'Alice');
        check_case("$sourceName empty scalar", static fn() => $scalarFn('empty', 'fallback'), '');
        check_case("$sourceName blank scalar", static fn() => $scalarFn('blank', 'fallback'), '');
        check_case("$sourceName zero string", static fn() => $scalarFn('zero', 'fallback'), '0');
        check_case("$sourceName single-line", static fn() => $scalarFn('lines'), 'A B');
        check_case("$sourceName multiline", static fn() => $scalarFn('lines', null, true), "A\nB");
        check_case("$sourceName unicode", static fn() => $scalarFn('accent'), 'café');
        check_exception("$sourceName scalar rejects array", static fn() => $scalarFn('items'), InvalidArgumentException::class);
        check_exception("$sourceName scalar invalid UTF-8", static fn() => $scalarFn('invalid_utf8'), InvalidArgumentException::class);
        check_case("$sourceName missing array default", static fn() => $arrayFn('missing', ['fallback']), ['fallback']);
        check_case("$sourceName missing array null", static fn() => $arrayFn('missing'), null);
        check_case("$sourceName indexed array", static fn() => $arrayFn('items'), ['One', 'Two Three']);
        check_case("$sourceName multiline array", static fn() => $arrayFn('items', null, true), ['One', "Two\nThree"]);
        check_case("$sourceName nested array", static fn() => $arrayFn('nested'), ['x' => ['y']]);
        check_case("$sourceName empty array", static fn() => $arrayFn('empty_array', ['fallback']), []);
        check_exception("$sourceName array rejects scalar", static fn() => $arrayFn('name'), InvalidArgumentException::class);
        check_exception("$sourceName array invalid element", static fn() => $arrayFn('invalid_array'), InvalidArgumentException::class);
        check_case("$sourceName source not mutated", static fn() => $sourceName === 'GET' ? $_GET : $_POST, $sample);
      }
      // Verify the functions access the correct superglobal.
      $_GET = ['only_get' => ' GET ', 'only_post' => ' GET '];
      $_POST = ['only_post' => ' POST '];
      check_case('GET reads GET only', static fn() => mud_http_get_query('only_get'), 'GET');
      check_case('GET ignores POST only', static fn() => mud_http_get_query('missing', 'fallback'), 'fallback');
      check_case('POST reads POST only', static fn() => mud_http_get_input('only_post'), 'POST');
      check_case('POST ignores GET only', static fn() => mud_http_get_input('only_get', 'fallback'), 'fallback');
    }
    finally {
      $_GET = $oldGet;
      $_POST = $oldPost;
    }

    if ( $failed ) {

      printf("\nTests: %d passed, %d failed\n", $passed, $failed);

      return 1;

    }

    return 0;

  },

  'normalize-input-ChatGPT-2' => function() {

    $functions = [
      'mud_http_normalize_input',
      'mud_http_normalize_input_array',
      'mud_http_get_query',
      'mud_http_get_input',
      'mud_http_get_query_array',
      'mud_http_get_input_array',
    ];
    foreach ($functions as $function) {
      if (!function_exists($function)) {
        fwrite(STDERR, "Missing function: $function\nSet MUD_HTTP_SOURCE=/path/to/your/functions.php\n");
        exit(2);
      }
    }

    $passed = 0;
    $failed = 0;

    function check_case(string $label, callable $action, mixed $expected): void {
      global $passed, $failed;
      try {
        $actual = $action();
        if ($actual !== $expected) {
          throw new RuntimeException('Expected ' . var_export($expected, true) . '; got ' . var_export($actual, true));
        }
        ++$passed;
      }
      catch (Throwable $ex) {
        ++$failed;
        fwrite(STDERR, "FAIL $label: " . $ex->getMessage() . "\n");
      }
    }

    function check_exception(string $label, callable $action, string $exceptionClass): void {
      global $passed, $failed;
      try {
        $action();
        ++$failed;
        fwrite(STDERR, "FAIL $label: expected $exceptionClass, no exception thrown\n");
      }
      catch (Throwable $ex) {
        if ($ex instanceof $exceptionClass) {
          ++$passed;
        }
        else {
          ++$failed;
          fwrite(STDERR, "FAIL $label: expected $exceptionClass; got " . get_class($ex) . ': ' . $ex->getMessage() . "\n");
        }
      }
    }

    $singleLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", 'Hello World'],
      'CRLF' => ["Hello\r\nWorld", 'Hello World'],
      'CR' => ["Hello\rWorld", 'Hello World'],
      'multiple lines' => ["Hello\n\nWorld", 'Hello World'],
      'mixed whitespace' => ["Hello \t \n World", 'Hello World'],
      'leading trailing line breaks' => ["\t\n Hello \r\n", 'Hello'],
      'all whitespace' => [" \t\n\r \u{00A0}", ''],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'em space' => ["Hello\u{2003}World", 'Hello World'],
      'thin space' => ["Hello\u{2009}World", 'Hello World'],
      'ideographic space' => ["Hello\u{3000}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", 'Hello World'],
      'line separator' => ["Hello\u{2028}World", 'Hello World'],
      'paragraph separator' => ["Hello\u{2029}World", 'Hello World'],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'zero width joiner' => ["a\u{200D}b", 'ab'],
      'BOM' => ["\u{FEFF}Hello\u{FEFF}", 'Hello'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'BEL' => ["Hello\x07World", 'HelloWorld'],
      'DEL' => ["Hello\x7FWorld", 'HelloWorld'],
      'backspace' => ["Hello\x08World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'precomposed accent' => ['café', 'café'],
      'non-Latin' => ['  Καλημέρα 世界  ', 'Καλημέρα 世界'],
      'emoji' => ['  😀  ', '😀'],
      'NFC not NFKC' => ['①  ﬁ', '① ﬁ'],
      'keep ordinary punctuation' => ['  A-B_123!  ', 'A-B_123!'],
      'internal whitespace collapse' => ["a  \t \r\n b", 'a b'],
    ];

    $multiLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", "Hello\nWorld"],
      'CRLF' => ["Hello\r\nWorld", "Hello\nWorld"],
      'CR' => ["Hello\rWorld", "Hello\nWorld"],
      'blank lines' => ["Hello\n\nWorld", "Hello\n\nWorld"],
      'spaces adjacent to newline' => ["Hello \t \n World", "Hello \n World"],
      'trim external newlines' => ["\t\n Hello \r\n", 'Hello'],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", "Hello\nWorld"],
      'line separator' => ["Hello\u{2028}World", "Hello\nWorld"],
      'paragraph separator' => ["Hello\u{2029}World", "Hello\nWorld"],
      'mixed line endings' => ["A\r\nB\rC\nD", "A\nB\nC\nD"],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'emoji' => ['😀', '😀'],
    ];

    foreach ($singleLine as $label => [$input, $expected]) {
      check_case("normalize single: $label", static fn() => mud_http_normalize_input($input), $expected);
    }
    foreach ($multiLine as $label => [$input, $expected]) {
      check_case("normalize multiline: $label", static fn() => mud_http_normalize_input($input, true), $expected);
    }
    foreach (["\xFF", "\xC3\x28", "\xE2\x82", "\xED\xA0\x80"] as $index => $bad) {
      check_exception("invalid UTF-8 #$index single", static fn() => mud_http_normalize_input($bad), InvalidArgumentException::class);
      check_exception("invalid UTF-8 #$index multiline", static fn() => mud_http_normalize_input($bad, true), InvalidArgumentException::class);
    }

    $arrayCases = [
      'empty' => [[], []],
      'indexed' => [['  Hello  ', "A\nB"], ['Hello', 'A B']],
      'associative' => [['name' => ' Alice ', 'city' => ' Sydney '], ['name' => 'Alice', 'city' => 'Sydney']],
      'nested' => [['user' => ['name' => ' Alice ', 'tags' => [' PHP ', "A\tB"]]], ['user' => ['name' => 'Alice', 'tags' => ['PHP', 'A B']]]],
      'numeric keys' => [[10 => ' a ', 25 => ' b '], [10 => 'a', 25 => 'b']],
      'empty strings' => [['', '   ', ' x '], ['', '', 'x']],
      'unicode' => [['café' => "cafe\u{0301}", 'emoji' => ' 😀 '], ['café' => 'café', 'emoji' => '😀']],
      'deep nested' => [['a' => ['b' => ['c' => [' d ']]]], ['a' => ['b' => ['c' => ['d']]]]],
    ];
    foreach ($arrayCases as $label => [$input, $expected]) {
      $original = $input;
      check_case("array single: $label", static fn() => mud_http_normalize_input_array($input), $expected);
      check_case("array does not mutate: $label", static fn() => $input, $original);
    }
    check_case('array multiline nested', static fn() => mud_http_normalize_input_array(['x' => ["A\r\nB", "C\tD"]], true), ['x' => ["A\nB", 'C D']]);
    foreach ([['x' => 123], ['x' => null], ['x' => false], ['x' => 1.5], ['x' => new stdClass()], ['nested' => ['x' => 7]]] as $index => $badArray) {
      check_exception("array invalid type #$index", static fn() => mud_http_normalize_input_array($badArray), InvalidArgumentException::class);
    }
    check_exception('array invalid UTF-8', static fn() => mud_http_normalize_input_array(['x' => "\xFF"]), InvalidArgumentException::class);

    $oldGet = $_GET;
    $oldPost = $_POST;
    try {
      foreach ([
        ['GET', 'mud_http_get_query', 'mud_http_get_query_array'],
        ['POST', 'mud_http_get_input', 'mud_http_get_input_array'],
      ] as [$sourceName, $scalarFn, $arrayFn]) {
        $sample = [
          'name' => '  Alice  ',
          'empty' => '',
          'blank' => '  ',
          'zero' => '0',
          'lines' => "A\r\nB",
          'accent' => "cafe\u{0301}",
          'items' => ['  One  ', "Two\nThree"],
          'nested' => ['x' => [' y ']],
          'empty_array' => [],
          'invalid_utf8' => "\xFF",
          'invalid_array' => ['bad' => 42],
        ];
        if ($sourceName === 'GET') {
          $_GET = $sample;
        }
        else {
          $_POST = $sample;
        }
        check_case("$sourceName missing scalar default", static fn() => $scalarFn('missing', 'fallback'), 'fallback');
        check_case("$sourceName missing scalar null", static fn() => $scalarFn('missing'), null);
        check_case("$sourceName present scalar", static fn() => $scalarFn('name', 'fallback'), 'Alice');
        check_case("$sourceName empty scalar", static fn() => $scalarFn('empty', 'fallback'), '');
        check_case("$sourceName blank scalar", static fn() => $scalarFn('blank', 'fallback'), '');
        check_case("$sourceName zero string", static fn() => $scalarFn('zero', 'fallback'), '0');
        check_case("$sourceName single-line", static fn() => $scalarFn('lines'), 'A B');
        check_case("$sourceName multiline", static fn() => $scalarFn('lines', null, true), "A\nB");
        check_case("$sourceName unicode", static fn() => $scalarFn('accent'), 'café');
        check_exception("$sourceName scalar rejects array", static fn() => $scalarFn('items'), InvalidArgumentException::class);
        check_exception("$sourceName scalar invalid UTF-8", static fn() => $scalarFn('invalid_utf8'), InvalidArgumentException::class);
        check_case("$sourceName missing array default", static fn() => $arrayFn('missing', ['fallback']), ['fallback']);
        check_case("$sourceName missing array null", static fn() => $arrayFn('missing'), null);
        check_case("$sourceName indexed array", static fn() => $arrayFn('items'), ['One', 'Two Three']);
        check_case("$sourceName multiline array", static fn() => $arrayFn('items', null, true), ['One', "Two\nThree"]);
        check_case("$sourceName nested array", static fn() => $arrayFn('nested'), ['x' => ['y']]);
        check_case("$sourceName empty array", static fn() => $arrayFn('empty_array', ['fallback']), []);
        check_exception("$sourceName array rejects scalar", static fn() => $arrayFn('name'), InvalidArgumentException::class);
        check_exception("$sourceName array invalid element", static fn() => $arrayFn('invalid_array'), InvalidArgumentException::class);
        check_case("$sourceName source not mutated", static fn() => $sourceName === 'GET' ? $_GET : $_POST, $sample);
      }
      // Verify the functions access the correct superglobal.
      $_GET = ['only_get' => ' GET ', 'only_post' => ' GET '];
      $_POST = ['only_post' => ' POST '];
      check_case('GET reads GET only', static fn() => mud_http_get_query('only_get'), 'GET');
      check_case('GET ignores POST only', static fn() => mud_http_get_query('missing', 'fallback'), 'fallback');
      check_case('POST reads POST only', static fn() => mud_http_get_input('only_post'), 'POST');
      check_case('POST ignores GET only', static fn() => mud_http_get_input('only_get', 'fallback'), 'fallback');
    }
    finally {
      $_GET = $oldGet;
      $_POST = $oldPost;
    }

    if ( $failed ) {

      printf("\nTests: %d passed, %d failed\n", $passed, $failed);

      return 1;

    }

    return 0;

  },

  'check-maximums-ChatGPT' => function() {

    $functions = [
      'mud_http_normalize_input',
      'mud_http_normalize_input_array',
      'mud_http_get_query',
      'mud_http_get_input',
      'mud_http_get_query_array',
      'mud_http_get_input_array',
    ];
    foreach ($functions as $function) {
      if (!function_exists($function)) {
        fwrite(STDERR, "Missing function: $function\nSet MUD_HTTP_SOURCE=/path/to/your/functions.php\n");
        exit(2);
      }
    }

    $passed = 0;
    $failed = 0;

    function check_case(string $label, callable $action, mixed $expected): void {
      global $passed, $failed;
      try {
        $actual = $action();
        if ($actual !== $expected) {
          throw new RuntimeException('Expected ' . var_export($expected, true) . '; got ' . var_export($actual, true));
        }
        ++$passed;
      }
      catch (Throwable $ex) {
        ++$failed;
        fwrite(STDERR, "FAIL $label: " . $ex->getMessage() . "\n");
      }
    }

    function check_exception(string $label, callable $action, string $exceptionClass): void {
      global $passed, $failed;
      try {
        $action();
        ++$failed;
        fwrite(STDERR, "FAIL $label: expected $exceptionClass, no exception thrown\n");
      }
      catch (Throwable $ex) {
        if ($ex instanceof $exceptionClass) {
          ++$passed;
        }
        else {
          ++$failed;
          fwrite(STDERR, "FAIL $label: expected $exceptionClass; got " . get_class($ex) . ': ' . $ex->getMessage() . "\n");
        }
      }
    }

    $singleLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", 'Hello World'],
      'CRLF' => ["Hello\r\nWorld", 'Hello World'],
      'CR' => ["Hello\rWorld", 'Hello World'],
      'multiple lines' => ["Hello\n\nWorld", 'Hello World'],
      'mixed whitespace' => ["Hello \t \n World", 'Hello World'],
      'leading trailing line breaks' => ["\t\n Hello \r\n", 'Hello'],
      'all whitespace' => [" \t\n\r \u{00A0}", ''],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'em space' => ["Hello\u{2003}World", 'Hello World'],
      'thin space' => ["Hello\u{2009}World", 'Hello World'],
      'ideographic space' => ["Hello\u{3000}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", 'Hello World'],
      'line separator' => ["Hello\u{2028}World", 'Hello World'],
      'paragraph separator' => ["Hello\u{2029}World", 'Hello World'],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'zero width joiner' => ["a\u{200D}b", 'ab'],
      'BOM' => ["\u{FEFF}Hello\u{FEFF}", 'Hello'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'BEL' => ["Hello\x07World", 'HelloWorld'],
      'DEL' => ["Hello\x7FWorld", 'HelloWorld'],
      'backspace' => ["Hello\x08World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'precomposed accent' => ['café', 'café'],
      'non-Latin' => ['  Καλημέρα 世界  ', 'Καλημέρα 世界'],
      'emoji' => ['  😀  ', '😀'],
      'NFC not NFKC' => ['①  ﬁ', '① ﬁ'],
      'keep ordinary punctuation' => ['  A-B_123!  ', 'A-B_123!'],
      'internal whitespace collapse' => ["a  \t \r\n b", 'a b'],
    ];

    $multiLine = [
      'empty' => ['', ''],
      'plain' => ['Hello', 'Hello'],
      'trim ASCII' => ['  Hello  ', 'Hello'],
      'collapse spaces' => ['Hello   World', 'Hello World'],
      'tab' => ["Hello\tWorld", 'Hello World'],
      'LF' => ["Hello\nWorld", "Hello\nWorld"],
      'CRLF' => ["Hello\r\nWorld", "Hello\nWorld"],
      'CR' => ["Hello\rWorld", "Hello\nWorld"],
      'blank lines' => ["Hello\n\nWorld", "Hello\n\nWorld"],
      'spaces adjacent to newline' => ["Hello \t \n World", "Hello \n World"],
      'trim external newlines' => ["\t\n Hello \r\n", 'Hello'],
      'NBSP' => ["Hello\u{00A0}World", 'Hello World'],
      'NEL' => ["Hello\u{0085}World", "Hello\nWorld"],
      'line separator' => ["Hello\u{2028}World", "Hello\nWorld"],
      'paragraph separator' => ["Hello\u{2029}World", "Hello\nWorld"],
      'mixed line endings' => ["A\r\nB\rC\nD", "A\nB\nC\nD"],
      'zero width space' => ["Hello\u{200B}World", 'HelloWorld'],
      'NUL' => ["Hello\0World", 'HelloWorld'],
      'form feed' => ["Hello\fWorld", 'Hello World'],
      'vertical tab' => ["Hello\vWorld", 'Hello World'],
      'NFC accent' => ["cafe\u{0301}", 'café'],
      'emoji' => ['😀', '😀'],
    ];

    foreach ($singleLine as $label => [$input, $expected]) {
      check_case("normalize single: $label", static fn() => mud_http_normalize_input($input), $expected);
    }
    foreach ($multiLine as $label => [$input, $expected]) {
      check_case("normalize multiline: $label", static fn() => mud_http_normalize_input($input, true), $expected);
    }
    foreach (["\xFF", "\xC3\x28", "\xE2\x82", "\xED\xA0\x80"] as $index => $bad) {
      check_exception("invalid UTF-8 #$index single", static fn() => mud_http_normalize_input($bad), InvalidArgumentException::class);
      check_exception("invalid UTF-8 #$index multiline", static fn() => mud_http_normalize_input($bad, true), InvalidArgumentException::class);
    }

    $arrayCases = [
      'empty' => [[], []],
      'indexed' => [['  Hello  ', "A\nB"], ['Hello', 'A B']],
      'associative' => [['name' => ' Alice ', 'city' => ' Sydney '], ['name' => 'Alice', 'city' => 'Sydney']],
      'nested' => [['user' => ['name' => ' Alice ', 'tags' => [' PHP ', "A\tB"]]], ['user' => ['name' => 'Alice', 'tags' => ['PHP', 'A B']]]],
      'numeric keys' => [[10 => ' a ', 25 => ' b '], [10 => 'a', 25 => 'b']],
      'empty strings' => [['', '   ', ' x '], ['', '', 'x']],
      'unicode' => [['café' => "cafe\u{0301}", 'emoji' => ' 😀 '], ['café' => 'café', 'emoji' => '😀']],
      'deep nested' => [['a' => ['b' => ['c' => [' d ']]]], ['a' => ['b' => ['c' => ['d']]]]],
    ];
    foreach ($arrayCases as $label => [$input, $expected]) {
      $original = $input;
      check_case("array single: $label", static fn() => mud_http_normalize_input_array($input), $expected);
      check_case("array does not mutate: $label", static fn() => $input, $original);
    }
    check_case('array multiline nested', static fn() => mud_http_normalize_input_array(['x' => ["A\r\nB", "C\tD"]], true), ['x' => ["A\nB", 'C D']]);
    foreach ([['x' => 123], ['x' => null], ['x' => false], ['x' => 1.5], ['x' => new stdClass()], ['nested' => ['x' => 7]]] as $index => $badArray) {
      check_exception("array invalid type #$index", static fn() => mud_http_normalize_input_array($badArray), InvalidArgumentException::class);
    }
    check_exception('array invalid UTF-8', static fn() => mud_http_normalize_input_array(['x' => "\xFF"]), InvalidArgumentException::class);

    $oldGet = $_GET;
    $oldPost = $_POST;
    try {
      foreach ([
        ['GET', 'mud_http_get_query', 'mud_http_get_query_array'],
        ['POST', 'mud_http_get_input', 'mud_http_get_input_array'],
      ] as [$sourceName, $scalarFn, $arrayFn]) {
        $sample = [
          'name' => '  Alice  ',
          'empty' => '',
          'blank' => '  ',
          'zero' => '0',
          'lines' => "A\r\nB",
          'accent' => "cafe\u{0301}",
          'items' => ['  One  ', "Two\nThree"],
          'nested' => ['x' => [' y ']],
          'empty_array' => [],
          'invalid_utf8' => "\xFF",
          'invalid_array' => ['bad' => 42],
        ];
        if ($sourceName === 'GET') {
          $_GET = $sample;
        }
        else {
          $_POST = $sample;
        }
        check_case("$sourceName missing scalar default", static fn() => $scalarFn('missing', 'fallback'), 'fallback');
        check_case("$sourceName missing scalar null", static fn() => $scalarFn('missing'), null);
        check_case("$sourceName present scalar", static fn() => $scalarFn('name', 'fallback'), 'Alice');
        check_case("$sourceName empty scalar", static fn() => $scalarFn('empty', 'fallback'), '');
        check_case("$sourceName blank scalar", static fn() => $scalarFn('blank', 'fallback'), '');
        check_case("$sourceName zero string", static fn() => $scalarFn('zero', 'fallback'), '0');
        check_case("$sourceName single-line", static fn() => $scalarFn('lines'), 'A B');
        check_case("$sourceName multiline", static fn() => $scalarFn('lines', null, true), "A\nB");
        check_case("$sourceName unicode", static fn() => $scalarFn('accent'), 'café');
        check_exception("$sourceName scalar rejects array", static fn() => $scalarFn('items'), InvalidArgumentException::class);
        check_exception("$sourceName scalar invalid UTF-8", static fn() => $scalarFn('invalid_utf8'), InvalidArgumentException::class);
        check_case("$sourceName missing array default", static fn() => $arrayFn('missing', ['fallback']), ['fallback']);
        check_case("$sourceName missing array null", static fn() => $arrayFn('missing'), null);
        check_case("$sourceName indexed array", static fn() => $arrayFn('items'), ['One', 'Two Three']);
        check_case("$sourceName multiline array", static fn() => $arrayFn('items', null, true), ['One', "Two\nThree"]);
        check_case("$sourceName nested array", static fn() => $arrayFn('nested'), ['x' => ['y']]);
        check_case("$sourceName empty array", static fn() => $arrayFn('empty_array', ['fallback']), []);
        check_exception("$sourceName array rejects scalar", static fn() => $arrayFn('name'), InvalidArgumentException::class);
        check_exception("$sourceName array invalid element", static fn() => $arrayFn('invalid_array'), InvalidArgumentException::class);
        check_case("$sourceName source not mutated", static fn() => $sourceName === 'GET' ? $_GET : $_POST, $sample);
      }
      // Verify the functions access the correct superglobal.
      $_GET = ['only_get' => ' GET ', 'only_post' => ' GET '];
      $_POST = ['only_post' => ' POST '];
      check_case('GET reads GET only', static fn() => mud_http_get_query('only_get'), 'GET');
      check_case('GET ignores POST only', static fn() => mud_http_get_query('missing', 'fallback'), 'fallback');
      check_case('POST reads POST only', static fn() => mud_http_get_input('only_post'), 'POST');
      check_case('POST ignores GET only', static fn() => mud_http_get_input('only_get', 'fallback'), 'fallback');
    }
    finally {
      $_GET = $oldGet;
      $_POST = $oldPost;
    }

    function test_nested_array(int $depth): array {
      $result = ['leaf' => '  OK  '];
      for ($level = 1; $level < $depth; ++$level) {
        $result = ['nested' => $result];
      }
      return $result;
    }

    function test_nested_expected(int $depth): array {
      $result = ['leaf' => 'OK'];
      for ($level = 1; $level < $depth; ++$level) {
        $result = ['nested' => $result];
      }
      return $result;
    }

    function test_with_superglobal(string $source, string $name, mixed $value, callable $action): mixed {
      $oldGet = $_GET;
      $oldPost = $_POST;
      try {
        if ($source === 'GET') {
          $_GET[$name] = $value;
        }
        else {
          $_POST[$name] = $value;
        }
        return $action();
      }
      finally {
        $_GET = $oldGet;
        $_POST = $oldPost;
      }
    }

    // Nesting: 8 levels accepted; 9 levels rejected.
    check_case('limits array nesting depth 8 accepted',
      static fn() => mud_http_normalize_input_array(test_nested_array(TEST_MAX_DEPTH)),
      test_nested_expected(TEST_MAX_DEPTH));
    check_exception('limits array nesting depth 9 rejected',
      static fn() => mud_http_normalize_input_array(test_nested_array(TEST_MAX_DEPTH + 1)),
      InvalidArgumentException::class);

    // Element count: a flat array has one element per string value.
    $atElementLimit = array_fill(0, TEST_MAX_ELEMENTS, ' x ');
    $overElementLimit = array_fill(0, TEST_MAX_ELEMENTS + 1, ' x ');
    check_case('limits array 1000 elements accepted',
      static fn() => count(mud_http_normalize_input_array($atElementLimit)),
      TEST_MAX_ELEMENTS);
    check_exception('limits array 1001 elements rejected',
      static fn() => mud_http_normalize_input_array($overElementLimit),
      InvalidArgumentException::class);

    // Count nested array-valued elements as well as string-valued elements.
    $nestedAtLimit = ['nested' => array_fill(0, TEST_MAX_ELEMENTS - 1, 'x')];
    $nestedOverLimit = ['nested' => array_fill(0, TEST_MAX_ELEMENTS, 'x')];
    check_case('limits nested total 1000 elements accepted',
      static fn() => count(mud_http_normalize_input_array($nestedAtLimit)['nested']),
      TEST_MAX_ELEMENTS - 1);
    check_exception('limits nested total 1001 elements rejected',
      static fn() => mud_http_normalize_input_array($nestedOverLimit),
      InvalidArgumentException::class);

    // String size: use ASCII for exact byte-boundary tests.
    $atStringLimit = str_repeat('a', TEST_MAX_STRING_BYTES);
    $overStringLimit = $atStringLimit . 'a';
    check_case('limits string 1 MiB accepted',
      static fn() => strlen(mud_http_normalize_input($atStringLimit)),
      TEST_MAX_STRING_BYTES);
    check_exception('limits string 1 MiB plus one byte rejected',
      static fn() => mud_http_normalize_input($overStringLimit),
      InvalidArgumentException::class);
    check_exception('limits oversized string inside array rejected',
      static fn() => mud_http_normalize_input_array(['text' => $overStringLimit]),
      InvalidArgumentException::class);

    // Unicode byte count: 262144 four-byte emoji occupy exactly 1 MiB.
    $unicodeAtLimit = str_repeat("\u{1F600}", TEST_MAX_STRING_BYTES / 4);
    check_case('limits Unicode 1 MiB accepted',
      static fn() => strlen(mud_http_normalize_input($unicodeAtLimit)),
      TEST_MAX_STRING_BYTES);
    check_exception('limits Unicode 1 MiB plus one byte rejected',
      static fn() => mud_http_normalize_input($unicodeAtLimit . 'x'),
      InvalidArgumentException::class);

    // Verify public GET and POST entry points enforce the same limits.
    foreach ([
      ['GET', 'mud_http_get_query', 'mud_http_get_query_array'],
      ['POST', 'mud_http_get_input', 'mud_http_get_input_array'],
    ] as [$sourceName, $scalarFn, $arrayFn]) {
      check_case("$sourceName limits scalar 1 MiB accepted",
        static fn() => test_with_superglobal($sourceName, 'limit_text', $atStringLimit,
          static fn() => strlen($scalarFn('limit_text'))),
        TEST_MAX_STRING_BYTES);
      check_exception("$sourceName limits scalar oversized rejected",
        static fn() => test_with_superglobal($sourceName, 'limit_text', $overStringLimit,
          static fn() => $scalarFn('limit_text')),
        InvalidArgumentException::class);
      check_case("$sourceName limits depth 8 accepted",
        static fn() => test_with_superglobal($sourceName, 'limit_array', test_nested_array(TEST_MAX_DEPTH),
          static fn() => $arrayFn('limit_array')),
        test_nested_expected(TEST_MAX_DEPTH));
      check_exception("$sourceName limits depth 9 rejected",
        static fn() => test_with_superglobal($sourceName, 'limit_array', test_nested_array(TEST_MAX_DEPTH + 1),
          static fn() => $arrayFn('limit_array')),
        InvalidArgumentException::class);
      check_case("$sourceName limits 1000 elements accepted",
        static fn() => test_with_superglobal($sourceName, 'limit_array', $atElementLimit,
          static fn() => count($arrayFn('limit_array'))),
        TEST_MAX_ELEMENTS);
      check_exception("$sourceName limits 1001 elements rejected",
        static fn() => test_with_superglobal($sourceName, 'limit_array', $overElementLimit,
          static fn() => $arrayFn('limit_array')),
        InvalidArgumentException::class);
      check_exception("$sourceName limits oversized array element rejected",
        static fn() => test_with_superglobal($sourceName, 'limit_array', ['text' => $overStringLimit],
          static fn() => $arrayFn('limit_array')),
        InvalidArgumentException::class);
    }

    if ( $failed ) {

      printf("\nTests: %d passed, %d failed\n", $passed, $failed);

      return 1;

    }

    return 0;

  },

  'more-ChatGPT-test-cases' => function() {

    // Exactly 4 MiB across four strings: accepted.
    $input = array_fill(0, 4, str_repeat('A', 1024 * 1024));

    assert(
      mud_http_normalize_input_array($input) === $input
    );

    // One byte over the cumulative limit: rejected.
    $input[] = 'B';

    try {
      mud_http_normalize_input_array($input);
      throw new RuntimeException('Expected cumulative limit exception.');
    }
    catch (InvalidArgumentException $ex) {
      // Expected.
    }

    // Nested arrays share the same cumulative limit.
    $input = [
      'first' => [
        str_repeat('A', 1024 * 1024),
        str_repeat('B', 1024 * 1024),
      ],
      'second' => [
        str_repeat('C', 1024 * 1024),
        str_repeat('D', 1024 * 1024),
        'E',
      ],
    ];

    try {
      mud_http_normalize_input_array($input);
      throw new RuntimeException('Expected nested cumulative limit exception.');
    }
    catch (InvalidArgumentException $ex) {
      // Expected.
    }

    // UTF-8 limits are measured in bytes, not characters.
    $input = [
      str_repeat('é', 524288), // Exactly 1 MiB.
    ];

    assert(
      mud_http_normalize_input_array($input) === $input
    );

    return 0;

  },

  'ChatGPT-2026-10-24-044543' => function() {

    // Exactly 4 MiB input and output: accepted.
    $input = array_fill(
      0,
      4,
      str_repeat('A', 1024 * 1024)
    );

    assert(
      mud_http_normalize_input_array($input) === $input
    );

    // Cumulative input exceeds 4 MiB: rejected.
    $input[] = 'B';

    try {
      mud_http_normalize_input_array($input);
      throw new RuntimeException('Expected input limit exception.');
    }
    catch (InvalidArgumentException $ex) {
      // Expected.
    }

    // Unicode NFC can reduce byte length.
    // "e" + combining acute accent = 3 bytes.
    // NFC "é" = 2 bytes.
    $input = [
      str_repeat("e\u{0301}", 300000),
    ];

    $output = mud_http_normalize_input_array($input);

    assert(
      $output === [str_repeat('é', 300000)]
    );

    // Unicode NFC can also increase byte length.
    // U+0344 (2 bytes) normalises to U+0308 U+0301
    // (4 bytes).
    $input = [
      str_repeat("\u{0344}", 250000),
    ];

    $output = mud_http_normalize_input_array($input);

    assert(
      $output === [
        str_repeat("\u{0308}\u{0301}", 250000),
      ]
    );

    // Test cumulative output expansion beyond 4 MiB.
    // Each original string fits within the 1 MiB limit.
    $input = array_fill(
      0,
      5,
      str_repeat("\u{0344}", 220000)
    );

    try {
      mud_http_normalize_input_array($input);

      throw new RuntimeException(
        'Expected output limit exception.'
      );
    }
    catch (InvalidArgumentException $ex) {

      assert(
        $ex->getMessage() ===
        'HTTP input exceeds maximum cumulative output length.'
      );

    }

    return 0;

  },

  'ChatGPT-2026-10-24-045554' => function() {

    $original_get = $_GET;
    $original_post = $_POST;

    try {

      // Test GET parameters.
      $_GET = [
        'enabled' => 'true',
        'page' => '42',
        'ratio' => '0.75',
        'disabled' => 'false',
        'zero' => '0',
        'negative' => '-123',
        'scientific' => '1.5e3',
        'whitespace' => '  42  ',
      ];

      assert(mud_http_get_query_bool('enabled', false) === true);
      assert(mud_http_get_query_bool('disabled', true) === false);
      assert(mud_http_get_query_bool('zero', true) === false);

      assert(mud_http_get_query_int('page', 1) === 42);
      assert(mud_http_get_query_int('negative') === -123);
      assert(mud_http_get_query_int('whitespace') === 42);

      assert(mud_http_get_query_float('ratio') === 0.75);
      assert(mud_http_get_query_float('scientific') === 1500.0);

      // Test missing GET parameters and defaults.
      assert(mud_http_get_query_bool('missing') === null);
      assert(mud_http_get_query_bool('missing', true) === true);
      assert(mud_http_get_query_bool('missing', false) === false);

      assert(mud_http_get_query_int('missing') === null);
      assert(mud_http_get_query_int('missing', 100) === 100);
      assert(mud_http_get_query_int('missing', 0) === 0);

      assert(mud_http_get_query_float('missing') === null);
      assert(mud_http_get_query_float('missing', 1.5) === 1.5);
      assert(mud_http_get_query_float('missing', 0.0) === 0.0);

      // Test POST parameters.
      $_POST = [
        'active' => '1',
        'inactive' => '0',
        'quantity' => '25',
        'negative' => '-50',
        'price' => '19.95',
        'exponent' => '2.5e2',
      ];

      assert(mud_http_get_input_bool('active') === true);
      assert(mud_http_get_input_bool('inactive') === false);

      assert(mud_http_get_input_int('quantity') === 25);
      assert(mud_http_get_input_int('negative') === -50);

      assert(mud_http_get_input_float('price') === 19.95);
      assert(mud_http_get_input_float('exponent') === 250.0);

      // Test missing POST parameters and defaults.
      assert(mud_http_get_input_bool('missing') === null);
      assert(mud_http_get_input_bool('missing', true) === true);
      assert(mud_http_get_input_bool('missing', false) === false);

      assert(mud_http_get_input_int('missing') === null);
      assert(mud_http_get_input_int('missing', 10) === 10);
      assert(mud_http_get_input_int('missing', 0) === 0);

      assert(mud_http_get_input_float('missing') === null);
      assert(mud_http_get_input_float('missing', 3.14) === 3.14);
      assert(mud_http_get_input_float('missing', 0.0) === 0.0);

      // Test invalid supplied values.
      $invalid_cases = [
        ['bool', 'yes'],
        ['bool', ''],
        ['bool', '2'],
        ['int', '12.5'],
        ['int', '1e3'],
        ['int', ''],
        ['int', '999999999999999999999999999999'],
        ['float', 'NaN'],
        ['float', 'INF'],
        ['float', ''],
        ['float', '1e9999'],
      ];

      foreach ($invalid_cases as [$type, $value]) {

        $_GET['invalid'] = $value;
        $_POST['invalid'] = $value;

        foreach (['query', 'input'] as $source) {

          $function = "mud_http_get_{$source}_{$type}";
          $thrown = false;

          try {
            $function('invalid');
          }
          catch (InvalidArgumentException $ex) {
            $thrown = true;
          }

          if (!$thrown) {
            throw new RuntimeException(
              "Expected InvalidArgumentException: " .
              "$function(" . var_export($value, true) . ")"
            );
          }
        }
      }

      //echo "All HTTP typed-input tests passed.\n";

    }
    finally {
      $_GET = $original_get;
      $_POST = $original_post;
    }

    return 0;

  }

]);
