<?php

require_once __DIR__ . '/inc/run-cli.php';

function declare_examples() { return declare_things( $catch = true, func_get_args() ); }

function declare_raw() { return declare_things( $catch = false, func_get_args() ); }
