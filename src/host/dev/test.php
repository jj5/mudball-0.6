<?php

require_once __DIR__ . '/inc/run-cli.php';

function declare_tests() { return declare_things( $catch = true, func_get_args() ); }
