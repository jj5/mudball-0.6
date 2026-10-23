<?php declare(strict_types=1);

// Resource limits for untrusted HTTP input.
const MUD_HTTP_MAX_TOTAL_STRING_BYTES = 4 * 1024 * 1024;

const MUD_HTTP_MAX_STRING_BYTES = 1024 * 1024;
const MUD_HTTP_MAX_ARRAY_DEPTH = 8;
const MUD_HTTP_MAX_ARRAY_ELEMENTS = 1000;

const MUD_HTTP_MAX_TOTAL_INPUT_BYTES = 4 * 1024 * 1024;
const MUD_HTTP_MAX_TOTAL_OUTPUT_BYTES = 4 * 1024 * 1024;

trait MudHttpInputNormalization {

  public function get_raw_input() {

    return file_get_contents( 'php://input' );

  }

  /**
  * Normalise an untrusted UTF-8 string.
  *
  * - Enforce maximum input and output lengths.
  * - Validate UTF-8.
  * - Normalise Unicode to NFC.
  * - Convert whitespace separators to spaces.
  * - Optionally preserve newlines.
  * - Remove Unicode control and format characters.
  * - Collapse horizontal whitespace.
  * - Trim leading and trailing whitespace.
  */
  function normalize_input(
    string $value,
    bool $allow_newlines = false
  ): string {

    // Check size before expensive Unicode processing.
    if (strlen($value) > MUD_HTTP_MAX_STRING_BYTES) {
      throw new InvalidArgumentException(
        'HTTP input exceeds maximum string length.'
      );
    }

    if (!mb_check_encoding($value, 'UTF-8')) {
      throw new InvalidArgumentException(
        'Invalid UTF-8 input.'
      );
    }

    $value = Normalizer::normalize(
      $value,
      Normalizer::FORM_C
    );

    if ($value === false) {
      throw new RuntimeException(
        'Unicode normalisation failed.'
      );
    }

    // Convert vertical tab and form feed to spaces.
    $value = str_replace(["\v", "\f"], ' ', $value);

    // Standardise line endings to LF.
    $value = preg_replace(
      '/\r\n|\r|\x{0085}|\x{2028}|\x{2029}/u',
      "\n",
      $value
    );

    if ($value === null) {
      throw new RuntimeException(
        'Line ending normalisation failed.'
      );
    }

    if ($allow_newlines) {

      // Collapse horizontal whitespace to one space.
      $value = preg_replace('/[\h]+/u', ' ', $value);

      // Remove controls and format characters except LF.
      $value = preg_replace_callback(
        '/[\p{Cc}\p{Cf}]/u',
        static fn(array $match): string =>
          $match[0] === "\n" ? "\n" : '',
        $value
      );

    }
    else {

      // Collapse all Unicode whitespace to one space.
      $value = preg_replace(
        '/[\s\p{Z}]+/u',
        ' ',
        $value
      );

      // Remove remaining control and format characters.
      $value = preg_replace(
        '/[\p{Cc}\p{Cf}]/u',
        '',
        $value
      );

    }

    if ($value === null) {
      throw new RuntimeException(
        'Unicode sanitisation failed.'
      );
    }

    // Trim Unicode whitespace from both ends.
    $value = preg_replace(
      '/^[\s\p{Z}]+|[\s\p{Z}]+$/u',
      '',
      $value
    );

    if ($value === null) {
      throw new RuntimeException(
        'Unicode whitespace trimming failed.'
      );
    }

    // NFC and other transformations can change byte length.
    if (strlen($value) > MUD_HTTP_MAX_STRING_BYTES) {
      throw new InvalidArgumentException(
        'Normalised HTTP input exceeds maximum string length.'
      );
    }

    return $value;
  }

  /**
  * Recursively normalise an array of untrusted strings.
  *
  * Enforces:
  * - Maximum array nesting depth.
  * - Maximum total array elements.
  * - Maximum individual string length.
  * - Maximum cumulative input string bytes.
  * - Maximum cumulative output string bytes.
  *
  * Array keys are preserved without normalisation.
  *
  * @throws InvalidArgumentException
  * @throws RuntimeException
  */
  function normalize_input_array(
    array $values,
    bool $allow_newlines = false
  ): array {

    $count = 0;
    $input_bytes = 0;
    $output_bytes = 0;

    return $this->normalize_input_array_recursive(
      $values,
      $allow_newlines,
      1,
      $count,
      $input_bytes,
      $output_bytes
    );
  }

  /**
  * Internal recursive implementation.
  *
  * All counters are shared across recursive calls.
  */
  function normalize_input_array_recursive(
    array $values,
    bool $allow_newlines,
    int $depth,
    int &$count,
    int &$input_bytes,
    int &$output_bytes
  ): array {

    // Enforce maximum nesting depth.
    if ($depth > MUD_HTTP_MAX_ARRAY_DEPTH) {
      throw new InvalidArgumentException(
        'HTTP input exceeds maximum array nesting depth.'
      );
    }

    // Count all elements, including nested array entries.
    if (count($values) > MUD_HTTP_MAX_ARRAY_ELEMENTS - $count) {
      throw new InvalidArgumentException(
        'HTTP input exceeds maximum array element count.'
      );
    }

    $count += count($values);

    $result = [];

    foreach ($values as $key => $value) {

      if (is_string($value)) {

        // Check individual input string length.
        $bytes = strlen($value);

        if ($bytes > MUD_HTTP_MAX_STRING_BYTES) {
          throw new InvalidArgumentException(
            "HTTP input string exceeds maximum length at key: $key"
          );
        }

        // Enforce cumulative original input length.
        if ($bytes > MUD_HTTP_MAX_TOTAL_INPUT_BYTES - $input_bytes) {
          throw new InvalidArgumentException(
            'HTTP input exceeds maximum cumulative input length.'
          );
        }

        $input_bytes += $bytes;

        // Normalise the string.
        // This also enforces the individual output length.
        $normalized = $this->normalize_input(
          $value,
          $allow_newlines
        );

        // Enforce cumulative normalised output length.
        $normalized_bytes = strlen($normalized);

        if (
          $normalized_bytes >
          MUD_HTTP_MAX_TOTAL_OUTPUT_BYTES - $output_bytes
        ) {
          throw new InvalidArgumentException(
            'HTTP input exceeds maximum cumulative output length.'
          );
        }

        $output_bytes += $normalized_bytes;

        $result[$key] = $normalized;

      }
      elseif (is_array($value)) {

        $result[$key] = $this->normalize_input_array_recursive(
          $value,
          $allow_newlines,
          $depth + 1,
          $count,
          $input_bytes,
          $output_bytes
        );

      }
      else {

        throw new InvalidArgumentException(
          "Invalid HTTP input array element at key: $key"
        );

      }

    }

    return $result;
  }

  /**
  * Retrieve and normalise a scalar GET parameter.
  */
  function get_query(
    string $name,
    ?string $default = null,
    bool $allow_newlines = false
  ): ?string {

    if (!array_key_exists($name, $_GET)) {
      return $default;
    }

    if (!is_string($_GET[$name])) {
      throw new InvalidArgumentException(
        "Expected string for GET parameter: $name"
      );
    }

    return $this->normalize_input(
      $_GET[$name],
      $allow_newlines
    );
  }

  /**
  * Retrieve and normalise a scalar POST parameter.
  */
  function get_input(
    string $name,
    ?string $default = null,
    bool $allow_newlines = false
  ): ?string {

    if (!array_key_exists($name, $_POST)) {
      return $default;
    }

    if (!is_string($_POST[$name])) {
      throw new InvalidArgumentException(
        "Expected string for POST parameter: $name"
      );
    }

    return $this->normalize_input(
      $_POST[$name],
      $allow_newlines
    );
  }

  /**
  * Retrieve and normalise a scalar SERVER parameter.
  */
  function get_server(
    string $name,
    ?string $default = null,
    bool $allow_newlines = false
  ): ?string {

    if (!array_key_exists($name, $_SERVER)) {
      return $default;
    }

    if (!is_string($_SERVER[$name])) {
      throw new InvalidArgumentException(
        "Expected string for SERVER parameter: $name"
      );
    }

    return $this->normalize_input(
      $_SERVER[$name],
      $allow_newlines
    );
  }

  /**
  * Retrieve and normalise an array GET parameter.
  */
  function get_query_array(
    string $name,
    ?array $default = null,
    bool $allow_newlines = false
  ): ?array {

    if (!array_key_exists($name, $_GET)) {
      return $default;
    }

    if (!is_array($_GET[$name])) {
      throw new InvalidArgumentException(
        "Expected array for GET parameter: $name"
      );
    }

    return $this->normalize_input_array(
      $_GET[$name],
      $allow_newlines
    );
  }

  /**
  * Retrieve and normalise an array POST parameter.
  */
  function get_input_array(
    string $name,
    ?array $default = null,
    bool $allow_newlines = false
  ): ?array {

    if (!array_key_exists($name, $_POST)) {
      return $default;
    }

    if (!is_array($_POST[$name])) {
      throw new InvalidArgumentException(
        "Expected array for POST parameter: $name"
      );
    }

    return $this->normalize_input_array(
      $_POST[$name],
      $allow_newlines
    );
  }

  /**
  * Retrieve and normalise an array SERVER parameter.
  */
  function get_server_array(
    string $name,
    ?array $default = null,
    bool $allow_newlines = false
  ): ?array {

    if (!array_key_exists($name, $_SERVER)) {
      return $default;
    }

    if (!is_array($_SERVER[$name])) {
      throw new InvalidArgumentException(
        "Expected array for SERVER parameter: $name"
      );
    }

    return $this->normalize_input_array(
      $_SERVER[$name],
      $allow_newlines
    );
  }
}
