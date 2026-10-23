<?php declare(strict_types=1);

trait MudHttpInputValue {

  /**
  * Convert a normalised string to bool.
  *
  * @throws InvalidArgumentException
  */
  protected function parse_bool(string $value): bool {

    return match (strtolower($value)) {
      'true', '1' => true,
      'false', '0' => false,
      default => throw new InvalidArgumentException(
        'Invalid boolean value.'
      ),
    };
  }

  /**
  * Convert a normalised string to int.
  *
  * Rejects non-decimal values and integer overflow.
  *
  * @throws InvalidArgumentException
  */
  protected function parse_int(string $value): int {

    if (!preg_match('/^[+-]?[0-9]+$/D', $value)) {
      throw new InvalidArgumentException(
        'Invalid integer value.'
      );
    }

    $result = filter_var(
      $value,
      FILTER_VALIDATE_INT
    );

    if ($result === false) {
      throw new InvalidArgumentException(
        'Integer value is out of range or invalid.'
      );
    }

    return $result;
  }

  /**
  * Convert a normalised string to float.
  *
  * Rejects NaN, infinity, and malformed values.
  *
  * @throws InvalidArgumentException
  */
  protected function parse_float(string $value): float {

    if (!preg_match(
      '/^[+-]?(?:[0-9]+(?:\.[0-9]*)?|\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/D',
      $value
    )) {
      throw new InvalidArgumentException(
        'Invalid floating-point value.'
      );
    }

    $result = (float) $value;

    if (!is_finite($result)) {
      throw new InvalidArgumentException(
        'Floating-point value is out of range.'
      );
    }

    return $result;
  }

  public function get_query_bool(
    string $name,
    ?bool $default = null
  ): ?bool {

    $value = $this->get_query($name);

    return $value === null
      ? $default
      : $this->parse_bool($value);
  }

  public function get_query_int(
    string $name,
    ?int $default = null
  ): ?int {

    $value = $this->get_query($name);

    return $value === null
      ? $default
      : $this->parse_int($value);
  }

  public function get_query_float(
    string $name,
    ?float $default = null
  ): ?float {

    $value = $this->get_query($name);

    return $value === null
      ? $default
      : $this->parse_float($value);
  }

  public function get_input_bool(
    string $name,
    ?bool $default = null
  ): ?bool {

    $value = $this->get_input($name);

    return $value === null
      ? $default
      : $this->parse_bool($value);
  }

  public function get_input_int(
    string $name,
    ?int $default = null
  ): ?int {

    $value = $this->get_input($name);

    return $value === null
      ? $default
      : $this->parse_int($value);
  }

  public function get_input_float(
    string $name,
    ?float $default = null
  ): ?float {

    $value = $this->get_input($name);

    return $value === null
      ? $default
      : $this->parse_float($value);
  }
}
