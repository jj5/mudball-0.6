<?php declare(strict_types=1);

class MudModuleParse extends MudModuleCritical {

  /**
  * Convert a normalised string to bool.
  *
  * @throws InvalidArgumentException
  */
  public function parse_bool(string $value): bool {

    if (!$this->try_bool($value, $result)) {
      throw new InvalidArgumentException(
        'Invalid boolean value.'
      );
    }

    assert( is_bool( $result ) );

    return (bool)$result;

  }

  public function try_bool(string $value, ?bool &$result, ?bool $default = null): bool {

    $normalized = strtolower($this->trim_whitespace($value));

    if ($normalized === 'true' || $normalized === '1') {
      $result = true;
      return true;
    }

    if ($normalized === 'false' || $normalized === '0') {
      $result = false;
      return true;
    }

    $result = $default;
    return false;
  }

  /**
  * Convert a normalised string to int.
  *
  * Rejects non-decimal values and integer overflow.
  *
  * @throws InvalidArgumentException
  */
  public function parse_int(string $value): int {

    if (!$this->try_int($value, $result)) {
      throw new InvalidArgumentException(
        'Invalid integer value.'
      );
    }

    assert( is_int( $result ) );

    return (int)$result;

  }

  public function try_int(string $value, ?int &$result, ?int $default = null): bool {

    $value = $this->trim_whitespace($value);

    if (!preg_match('/^([+-]?)([0-9]+)$/D', $value, $matches)) {
      $result = $default;
      return false;
    }

    // 2026-10-24 jj5 - strip leading zeros; FILTER_VALIDATE_INT rejects them
    // even though they're a valid representation of the same integer...
    //
    $digits = ltrim($matches[2], '0');

    if ($digits === '') {
      $digits = '0';
    }

    $normalized = ($matches[1] === '-' ? '-' : '') . $digits;

    $parsed = filter_var(
      $normalized,
      FILTER_VALIDATE_INT
    );

    if ($parsed === false) {
      $result = $default;
      return false;
    }

    $result = $parsed;
    return true;
  }

  /**
  * Convert a normalised string to float.
  *
  * Rejects NaN, infinity, and malformed values.
  *
  * @throws InvalidArgumentException
  */
  public function parse_float(string $value): float {

    if (!$this->try_float($value, $result)) {
      throw new InvalidArgumentException(
        'Invalid floating-point value.'
      );
    }

    assert( is_float( $result ) );

    return (float)$result;
  }

  public function try_float(string $value, ?float &$result, ?float $default = null): bool {

    $value = $this->trim_whitespace($value);

    if (!preg_match(
      '/^[+-]?(?:[0-9]+(?:\.[0-9]*)?|\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/D',
      $value
    )) {
      $result = $default;
      return false;
    }

    $parsed = (float) $value;

    if (!is_finite($parsed)) {
      $result = $default;
      return false;
    }

    $result = $parsed;
    return true;
  }

  // 2026-10-24 jj5 - trim() strips the NUL byte by default, which would
  // let embedded NULs through as leading/trailing whitespace; exclude it...
  //
  private function trim_whitespace(string $value): string {

    return trim($value, " \t\n\r\x0B");
  }
}
