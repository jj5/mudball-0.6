<?php declare(strict_types=1);

trait MudHttpInputValue {

  public function parse_bool(string $value): bool {
    return mud_parse_bool($value);
  }

  public function parse_int(string $value): int {
    return mud_parse_int($value);
  }

  public function parse_float(string $value): float {
    return mud_parse_float($value);
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

  public function get_server_bool(
    string $name,
    ?bool $default = null
  ): ?bool {

    $value = $this->get_server($name);

    return $value === null
      ? $default
      : $this->parse_bool($value);
  }

  public function get_server_int(
    string $name,
    ?int $default = null
  ): ?int {

    $value = $this->get_server($name);

    return $value === null
      ? $default
      : $this->parse_int($value);
  }

  public function get_server_float(
    string $name,
    ?float $default = null
  ): ?float {

    $value = $this->get_server($name);

    return $value === null
      ? $default
      : $this->parse_float($value);
  }
}
