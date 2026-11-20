<?php declare(strict_types=1);

class MudModuleOption extends MudModuleCritical {

  public function get_option( array $map, string $key, mixed $default = null ): mixed {

    return $map[ $key ] ?? $default;

  }
}
