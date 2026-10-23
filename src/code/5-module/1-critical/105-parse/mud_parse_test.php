<?php declare(strict_types=1);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../../inc/framework/test.php';

require_once __DIR__ . '/mud_parse.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - test constants...
//

/*
* Parser contract configuration.
*
* Adjust these to match your intended parser semantics.
*/

const TEST_TRIM_WHITESPACE = true;
const TEST_BOOL_CASE_INSENSITIVE = true;
const TEST_BOOL_YES_NO = false;
const TEST_BOOL_ON_OFF = false;

const TEST_FLOAT_ALLOW_LEADING_DOT = true;
const TEST_FLOAT_ALLOW_TRAILING_DOT = true;
const TEST_FLOAT_ALLOW_SPECIAL = false;
const TEST_FLOAT_ALLOW_UNDERFLOW = true;

const TEST_INT_ALLOW_PLUS = true;
const TEST_INT_ALLOW_LEADING_ZEROS = true;

const TEST_MAX_INPUT_LENGTH = 65536;
const TEST_ENFORCE_MAX_LENGTH = false;

const TEST_MAX_SECONDS_PER_CALL = 1.0;
const TEST_ENFORCE_TIME_LIMIT = false;

const TEST_MAX_MEMORY_INCREASE = 8 * 1024 * 1024;
const TEST_ENFORCE_MEMORY_LIMIT = false;


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - declare tests...
//

mud_declare_tests([

  'test-parse' => function() {

    // require_once __DIR__ . '/bootstrap.php';

    /*
    * Test framework.
    */

    $passed = 0;
    $failed = 0;
    $failures = [];

    function test_assert(
      bool $condition,
      string $description,
      string $detail = ''
    ): void {

      global $passed, $failed, $failures;

      if ($condition) {

        $passed++;
        return;

      }

      $failed++;

      $message = $description;

      if ($detail !== '') {

        $message .= ': ' . $detail;

      }

      $failures[] = $message;

      echo "FAIL $message\n";

    }

    function test_repr(mixed $value): string {

      if (is_string($value) && strlen($value) > 100) {

        return var_export(substr($value, 0, 80), true) .
          '... [length=' . strlen($value) . ']';

      }

      return var_export($value, true);

    }

    function test_equal(
      mixed $expected,
      mixed $actual,
      string $description
    ): void {

      test_assert(
        $expected === $actual,
        $description,
        'expected ' . test_repr($expected) .
        ', got ' . test_repr($actual)
      );

    }

    function test_throws(
      callable $callback,
      string $description,
      string $expected_class = Throwable::class
    ): void {

      try {

        $callback();

        test_assert(
          false,
          $description,
          "expected $expected_class"
        );

      }
      catch (Throwable $ex) {

        test_assert(
          $ex instanceof $expected_class,
          $description,
          'got ' . get_class($ex) .
          ': ' . $ex->getMessage()
        );

      }

    }

    /*
    * Exact floating-point comparison.
    *
    * pack('d') captures the native binary representation.
    * This distinguishes +0.0 from -0.0.
    *
    * On conventional PHP platforms, float is IEEE 754
    * binary64.
    */

    function test_float_bits(float $value): string {

      return bin2hex(pack('d', $value));

    }

    function test_float_exact(
      float $expected,
      float $actual,
      string $description
    ): void {

      test_assert(
        test_float_bits($expected) === test_float_bits($actual),
        $description,
        'expected ' . test_repr($expected) .
        ' [' . test_float_bits($expected) . ']' .
        ', got ' . test_repr($actual) .
        ' [' . test_float_bits($actual) . ']'
      );

    }

    /*
    * Test cases.
    *
    * Every valid case is [input, expected].
    */

    $bool_valid = [
      ['true', true],
      ['false', false],
      ['1', true],
      ['0', false],
    ];

    if (TEST_BOOL_CASE_INSENSITIVE) {

      array_push(
        $bool_valid,
        ['TRUE', true],
        ['FALSE', false],
        ['True', true],
        ['False', false],
        ['TrUe', true],
        ['FaLsE', false]
      );

    }

    if (TEST_BOOL_YES_NO) {

      array_push(
        $bool_valid,
        ['yes', true],
        ['no', false],
        ['YES', true],
        ['NO', false]
      );

    }

    if (TEST_BOOL_ON_OFF) {

      array_push(
        $bool_valid,
        ['on', true],
        ['off', false],
        ['ON', true],
        ['OFF', false]
      );

    }

    if (TEST_TRIM_WHITESPACE) {

      array_push(
        $bool_valid,
        [' true ', true],
        ["\tfalse\t", false],
        ["\n1\n", true],
        ["\r\n0\r\n", false]
      );

    }

    $bool_invalid = [
      '',
      ' ',
      '2',
      '-1',
      '+1',
      '00',
      '01',
      '1.0',
      '0.0',
      'truth',
      'falsehood',
      'truefalse',
      'false true',
      'null',
      'undefined',
      'NaN',
      'INF',
      '0x1',
      '1e0',
      't',
      'f',
      "true\0",
      "\0false",
      "tr\nue",
      '✓',
      '✗',
    ];

    if (!TEST_BOOL_YES_NO) {

      array_push($bool_invalid, 'yes', 'no');

    }

    if (!TEST_BOOL_ON_OFF) {

      array_push($bool_invalid, 'on', 'off');

    }

    if (!TEST_BOOL_CASE_INSENSITIVE) {

      array_push($bool_invalid, 'TRUE', 'FALSE');

    }

    if (!TEST_TRIM_WHITESPACE) {

      array_push($bool_invalid, ' true ', "\tfalse\n");

    }

    /*
    * Integer cases.
    */

    $int_valid = [
      ['0', 0],
      ['1', 1],
      ['-1', -1],
      ['42', 42],
      ['-42', -42],
      ['123456789', 123456789],
      ['-123456789', -123456789],
      ['-0', 0],
      [(string) PHP_INT_MAX, PHP_INT_MAX],
      [(string) PHP_INT_MIN, PHP_INT_MIN],
    ];

    if (TEST_INT_ALLOW_PLUS) {

      array_push(
        $int_valid,
        ['+0', 0],
        ['+1', 1],
        ['+42', 42]
      );

    }

    if (TEST_INT_ALLOW_LEADING_ZEROS) {

      array_push(
        $int_valid,
        ['00', 0],
        ['0001', 1],
        ['00123', 123],
        ['-0001', -1]
      );

    }

    if (TEST_TRIM_WHITESPACE) {

      array_push(
        $int_valid,
        [' 42 ', 42],
        ["\t-42\t", -42],
        ["\n0\n", 0]
      );

    }

    $int_invalid = [
      '',
      ' ',
      '+',
      '-',
      '++1',
      '--1',
      '+-1',
      '-+1',
      '1.0',
      '1.5',
      '.5',
      '1.',
      '1e2',
      '1E2',
      '0x10',
      '0XFF',
      '0b1010',
      '0o10',
      '1_000',
      '1,000',
      '1 000',
      '12abc',
      'abc12',
      'true',
      'false',
      'null',
      'NaN',
      'INF',
      'Infinity',
      '１２３',
      '١٢٣',
      '−1',
      "12\0",
      "1\n2",
      '(123)',
    ];

    if (!TEST_INT_ALLOW_PLUS) {

      array_push($int_invalid, '+1', '+42');

    }

    if (!TEST_INT_ALLOW_LEADING_ZEROS) {

      array_push($int_invalid, '00', '00123');

    }

    if (!TEST_TRIM_WHITESPACE) {

      array_push($int_invalid, ' 42 ', "\t42\n");

    }

    if (PHP_INT_SIZE === 8) {

      array_push(
        $int_invalid,
        '9223372036854775808',
        '-9223372036854775809'
      );

    }
    else {

      array_push(
        $int_invalid,
        '2147483648',
        '-2147483649'
      );

    }

    array_push(
      $int_invalid,
      str_repeat('9', 100),
      '-' . str_repeat('9', 100)
    );

    /*
    * Float cases.
    */

    $float_valid = [
      ['0', 0.0],
      ['1', 1.0],
      ['-1', -1.0],
      ['+1', 1.0],
      ['0.0', 0.0],
      ['-0.0', -0.0],
      ['+0.0', 0.0],
      ['1.5', 1.5],
      ['-1.5', -1.5],
      ['+1.5', 1.5],
      ['123.456', 123.456],
      ['0.001', 0.001],
      ['1e2', 100.0],
      ['1E2', 100.0],
      ['1e+2', 100.0],
      ['1e-2', 0.01],
      ['-1e2', -100.0],
      ['1.5e2', 150.0],
      ['1.5e-2', 0.015],
      ['0001.500', 1.5],
      ['1.23456789', 1.23456789],
      ['2.2250738585072014e-308', 2.2250738585072014e-308],
      ['1.7976931348623157e308', PHP_FLOAT_MAX],
      ['4.9406564584124654e-324', 5e-324],
      ['-4.9406564584124654e-324', -5e-324],
    ];

    if (TEST_FLOAT_ALLOW_LEADING_DOT) {

      array_push(
        $float_valid,
        ['.5', 0.5],
        ['-.5', -0.5],
        ['+.5', 0.5]
      );

    }

    if (TEST_FLOAT_ALLOW_TRAILING_DOT) {

      array_push(
        $float_valid,
        ['1.', 1.0],
        ['-1.', -1.0],
        ['1.e2', 100.0]
      );

    }

    if (TEST_FLOAT_ALLOW_UNDERFLOW) {

      array_push(
        $float_valid,
        ['1e-9999', 0.0],
        ['-1e-9999', -0.0]
      );

    }

    if (TEST_TRIM_WHITESPACE) {

      array_push(
        $float_valid,
        [' 1.5 ', 1.5],
        ["\t-1.5\t", -1.5],
        ["\n1e2\n", 100.0]
      );

    }

    $float_invalid = [
      '',
      ' ',
      '+',
      '-',
      '.',
      '+.',
      '-.',
      '1.2.3',
      '1e',
      '1e+',
      '1e-',
      'e10',
      '1e2e3',
      '1_000.5',
      '1,000.5',
      '1 000.5',
      '1,5',
      '0x10',
      '0x1.8p2',
      '0b101',
      'true',
      'false',
      'null',
      'undefined',
      '12abc',
      'abc12',
      '1.5abc',
      "1.5\0",
      "1\n.5",
      '∞',
      '−1.5',
      '1e9999',
      '-1e9999',
    ];

    if (!TEST_FLOAT_ALLOW_LEADING_DOT) {

      array_push($float_invalid, '.5', '-.5');

    }

    if (!TEST_FLOAT_ALLOW_TRAILING_DOT) {

      array_push($float_invalid, '1.', '1.e2');

    }

    if (!TEST_FLOAT_ALLOW_UNDERFLOW) {

      array_push($float_invalid, '1e-9999', '-1e-9999');

    }

    if (!TEST_FLOAT_ALLOW_SPECIAL) {

      array_push(
        $float_invalid,
        'NaN',
        'nan',
        'NAN',
        'INF',
        '-INF',
        '+INF',
        'Infinity',
        '-Infinity'
      );

    }

    if (!TEST_TRIM_WHITESPACE) {

      array_push($float_invalid, ' 1.5 ', "\t1.5\n");

    }

    /*
    * Generic parser tests.
    */

    function test_value(
      string $strict,
      string $try,
      string $input,
      mixed $expected,
      string $type
    ): void {

      $description = "$strict " . test_repr($input);

      try {

        $actual = $strict($input);

        test_equal(
          $type,
          get_debug_type($actual),
          "$description type"
        );

        if ($type === 'float') {

          test_float_exact(
            $expected,
            $actual,
            "$description value"
          );

        }
        else {

          test_equal(
            $expected,
            $actual,
            "$description value"
          );

        }

      }
      catch (Throwable $ex) {

        test_assert(
          false,
          "$description strict",
          get_class($ex) . ': ' . $ex->getMessage()
        );

      }

      $result = null;

      try {

        $success = $try($input, $result);

        test_equal(
          true,
          $success,
          "$description try success"
        );

        test_equal(
          $type,
          get_debug_type($result),
          "$description try type"
        );

        if ($type === 'float' && is_float($result)) {

          test_float_exact(
            $expected,
            $result,
            "$description try value"
          );

        }
        else {

          test_equal(
            $expected,
            $result,
            "$description try value"
          );

        }

      }
      catch (Throwable $ex) {

        test_assert(
          false,
          "$description try",
          get_class($ex) . ': ' . $ex->getMessage()
        );

      }

    }

    function test_invalid(
      string $strict,
      string $try,
      string $input,
      array $defaults
    ): void {

      $description = "$strict invalid " . test_repr($input);

      test_throws(
        fn() => $strict($input),
        "$description strict"
      );

      foreach ($defaults as $default) {

        $result = $default;

        try {

          $success = $try($input, $result, $default);

          test_equal(
            false,
            $success,
            "$description try success default=" .
            test_repr($default)
          );

          if (is_float($default) && is_float($result)) {

            test_float_exact(
              $default,
              $result,
              "$description try default"
            );

          }
          else {

            test_equal(
              $default,
              $result,
              "$description try default"
            );

          }

        }
        catch (Throwable $ex) {

          test_assert(
            false,
            "$description try",
            get_class($ex) . ': ' . $ex->getMessage()
          );

        }

      }

    }

    /*
    * Run normal cases.
    */

    echo "Testing boolean values...\n";

    foreach ($bool_valid as [$input, $expected]) {

      test_value(
        'mud_parse_bool',
        'mud_parse_try_bool',
        $input,
        $expected,
        'bool'
      );

    }

    foreach ($bool_invalid as $input) {

      test_invalid(
        'mud_parse_bool',
        'mud_parse_try_bool',
        $input,
        [null, true, false]
      );

    }

    echo "Testing integer values...\n";

    foreach ($int_valid as [$input, $expected]) {

      test_value(
        'mud_parse_int',
        'mud_parse_try_int',
        $input,
        $expected,
        'int'
      );

    }

    foreach ($int_invalid as $input) {

      test_invalid(
        'mud_parse_int',
        'mud_parse_try_int',
        $input,
        [null, 0, 123, -123, PHP_INT_MAX, PHP_INT_MIN]
      );

    }

    echo "Testing floating-point values...\n";

    foreach ($float_valid as [$input, $expected]) {

      test_value(
        'mud_parse_float',
        'mud_parse_try_float',
        $input,
        $expected,
        'float'
      );

    }

    foreach ($float_invalid as $input) {

      test_invalid(
        'mud_parse_float',
        'mud_parse_try_float',
        $input,
        [null, 0.0, -0.0, 123.456, -123.456]
      );

    }

    /*
    * Typed default argument tests.
    *
    * These tests verify strict_types=1 behaviour.
    *
    * PHP accepts int arguments for float parameters,
    * even in strict mode.
    */

    echo "Testing typed defaults...\n";

    // Each parser's own type (bool/int) is a legitimate default for itself,
    // so it's excluded from that parser's own wrong-type list. Float also
    // accepts int (PHP widens int to float even under strict_types).

    $wrong_defaults_bool = [
      'string' => '123',
      'array' => [],
      'object' => new stdClass(),
    ];

    $wrong_defaults_int = [
      'string' => '123',
      'bool' => true,
      'array' => [],
      'object' => new stdClass(),
    ];

    $wrong_defaults_float = [
      'string' => '123',
      'bool' => true,
      'array' => [],
      'object' => new stdClass(),
    ];

    foreach ($wrong_defaults_bool as $name => $default) {

      test_throws(
        function () use ($default): void {

          $result = null;
          mud_parse_try_bool('invalid', $result, $default);

        },
        "bool rejects $name default",
        TypeError::class
      );

    }

    foreach ($wrong_defaults_int as $name => $default) {

      test_throws(
        function () use ($default): void {

          $result = null;
          mud_parse_try_int('invalid', $result, $default);

        },
        "int rejects $name default",
        TypeError::class
      );

    }

    foreach ($wrong_defaults_float as $name => $default) {

      test_throws(
        function () use ($default): void {

          $result = null;
          mud_parse_try_float('invalid', $result, $default);

        },
        "float rejects $name default",
        TypeError::class
      );

    }

    // An int is accepted for a float parameter in PHP strict mode.

    $result = null;

    try {

      $success = mud_parse_try_float('invalid', $result, 42);

      test_equal(false, $success, 'float integer default success');
      test_float_exact(42.0, $result, 'float integer default');

    }
    catch (Throwable $ex) {

      test_assert(
        false,
        'float integer default',
        $ex->getMessage()
      );

    }

    /*
    * Typed output reference tests.
    *
    * A nullable typed reference can only hold its
    * declared type or null.
    */

    echo "Testing typed output references...\n";

    test_throws(
      function (): void {

        $result = 123;
        mud_parse_try_bool('true', $result);

      },
      'bool rejects int output variable',
      TypeError::class
    );

    test_throws(
      function (): void {

        $result = 'wrong';
        mud_parse_try_int('42', $result);

      },
      'int rejects string output variable',
      TypeError::class
    );

    test_throws(
      function (): void {

        $result = 'wrong';
        mud_parse_try_float('1.5', $result);

      },
      'float rejects string output variable',
      TypeError::class
    );

    /*
    * Reference reuse.
    */

    echo "Testing reference reuse...\n";

    $result = null;

    test_equal(
      true,
      mud_parse_try_bool('true', $result),
      'bool reuse first success'
    );

    test_equal(true, $result, 'bool reuse first value');

    test_equal(
      true,
      mud_parse_try_bool('false', $result),
      'bool reuse second success'
    );

    test_equal(false, $result, 'bool reuse second value');

    test_equal(
      false,
      mud_parse_try_bool('invalid', $result, null),
      'bool reuse failure'
    );

    test_equal(null, $result, 'bool reuse null default');

    $result = null;

    test_equal(
      true,
      mud_parse_try_int('123', $result),
      'int reuse first success'
    );

    test_equal(123, $result, 'int reuse first value');

    test_equal(
      true,
      mud_parse_try_int('-456', $result),
      'int reuse second success'
    );

    test_equal(-456, $result, 'int reuse second value');

    test_equal(
      false,
      mud_parse_try_int('invalid', $result, 789),
      'int reuse failure'
    );

    test_equal(789, $result, 'int reuse default');

    $result = null;

    test_equal(
      true,
      mud_parse_try_float('1.5', $result),
      'float reuse first success'
    );

    test_float_exact(1.5, $result, 'float reuse first value');

    test_equal(
      true,
      mud_parse_try_float('-2.5', $result),
      'float reuse second success'
    );

    test_float_exact(-2.5, $result, 'float reuse second value');

    test_equal(
      false,
      mud_parse_try_float('invalid', $result, 3.5),
      'float reuse failure'
    );

    test_float_exact(3.5, $result, 'float reuse default');

    /*
    * Floating-point precision edge cases.
    */

    echo "Testing IEEE 754 precision...\n";

    $precision_cases = [
      ['0.1', 0.1],
      ['0.2', 0.2],
      ['0.3', 0.3],
      ['0.30000000000000004', 0.30000000000000004],
      ['1.0000000000000002', 1.0000000000000002],
      ['9007199254740992', 9007199254740992.0],
      ['9007199254740993', 9007199254740992.0],
      ['9007199254740994', 9007199254740994.0],
      ['-0', -0.0],
      ['-0.0', -0.0],
      ['-0e0', -0.0],
      ['5e-324', 5e-324],
      ['1e-323', 1e-323],
      ['2.2250738585072014e-308', 2.2250738585072014e-308],
      ['1.7976931348623157e308', PHP_FLOAT_MAX],
    ];

    foreach ($precision_cases as [$input, $expected]) {

      test_value(
        'mud_parse_float',
        'mud_parse_try_float',
        $input,
        $expected,
        'float'
      );

    }

    /*
    * Explicit numeric syntax tests.
    */

    echo "Testing numeric syntax...\n";

    $syntax_invalid = [
      '0xFF',
      '0b1010',
      '0o777',
      '1_000',
      '1,000',
      '1 000',
      '１２３',
      '١٢٣',
      '−123',
      "1\0",
      "1\n2",
      "1\t2",
      '1e',
      '1e+',
      '1e-',
      '1.2.3',
      '1e2e3',
      '123abc',
      'abc123',
    ];

    foreach ($syntax_invalid as $input) {

      test_invalid(
        'mud_parse_int',
        'mud_parse_try_int',
        $input,
        [null, 0]
      );

      test_invalid(
        'mud_parse_float',
        'mud_parse_try_float',
        $input,
        [null, 0.0]
      );

    }

    /*
    * Resource-limit tests.
    *
    * When TEST_ENFORCE_MAX_LENGTH is true, all inputs
    * exceeding TEST_MAX_INPUT_LENGTH must be rejected,
    * even if their numeric syntax would otherwise be valid.
    */

    echo "Testing resource limits...\n";

    $large_invalid_inputs = [
      str_repeat('x', 1000),
      str_repeat('x', 100000),
      str_repeat('9', 100000),
      str_repeat(' ', 100000),
      '1e' . str_repeat('9', 100000),
      str_repeat('1', 50000) . 'x',
    ];

    foreach ($large_invalid_inputs as $input) {

      test_invalid(
        'mud_parse_bool',
        'mud_parse_try_bool',
        $input,
        [null, false]
      );

      test_invalid(
        'mud_parse_int',
        'mud_parse_try_int',
        $input,
        [null, 0]
      );

      test_invalid(
        'mud_parse_float',
        'mud_parse_try_float',
        $input,
        [null, 0.0]
      );

    }

    if (TEST_ENFORCE_MAX_LENGTH) {

      $over_limit = [
        str_repeat(' ', TEST_MAX_INPUT_LENGTH + 1),
        str_repeat('0', TEST_MAX_INPUT_LENGTH + 1),
        str_repeat('1', TEST_MAX_INPUT_LENGTH + 1),
        str_repeat('x', TEST_MAX_INPUT_LENGTH + 1),
      ];

      foreach ($over_limit as $input) {

        test_invalid(
          'mud_parse_bool',
          'mud_parse_try_bool',
          $input,
          [null, false]
        );

        test_invalid(
          'mud_parse_int',
          'mud_parse_try_int',
          $input,
          [null, 0]
        );

        test_invalid(
          'mud_parse_float',
          'mud_parse_try_float',
          $input,
          [null, 0.0]
        );

      }

    }

    /*
    * Time and memory budgets.
    *
    * These are optional performance tests, not strict
    * functional correctness tests.
    *
    * Memory measurement uses memory_get_usage(false),
    * so allocator behaviour may influence results.
    */

    function test_resource_budget(
      callable $callback,
      string $description
    ): void {

      $memory_before = memory_get_usage(false);
      $time_before = hrtime(true);

      try {

        $callback();

      }
      catch (Throwable $ex) {

        // Parsing failures are expected for these inputs.

      }

      $seconds = (hrtime(true) - $time_before) / 1e9;

      $memory_increase = max(
        0,
        memory_get_usage(false) - $memory_before
      );

      if (TEST_ENFORCE_TIME_LIMIT) {

        test_assert(
          $seconds <= TEST_MAX_SECONDS_PER_CALL,
          "$description time budget",
          "$seconds seconds"
        );

      }

      if (TEST_ENFORCE_MEMORY_LIMIT) {

        test_assert(
          $memory_increase <= TEST_MAX_MEMORY_INCREASE,
          "$description memory budget",
          "$memory_increase bytes"
        );

      }

    }

    echo "Testing performance budgets...\n";

    $stress_input = str_repeat('9', 100000);

    foreach ([
      'mud_parse_bool',
      'mud_parse_int',
      'mud_parse_float',
    ] as $function) {

      test_resource_budget(
        fn() => $function($stress_input),
        "$function stress"
      );

    }

    if ($failed > 0) {

      echo "\n";
      echo "========================================\n";
      echo "Passed: $passed\n";
      echo "Failed: $failed\n";
      echo "========================================\n";

      echo "\nFailure details:\n";

      foreach ($failures as $failure) {

        echo "  - $failure\n";

      }

      return 1;

    }

    //echo "All tests passed.\n";

    return 0;

  },

]);
