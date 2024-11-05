#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../src/code/5-module/1-critical/115-exit/mud_exit.php';

function main( $argv ) {

  mud_module_exit()->generate_php();

}

main( $argv );
