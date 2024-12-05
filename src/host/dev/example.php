<?php

<<<<<<< HEAD
require_once __DIR__ . '/inc/run-cli.php';
=======
require_once __DIR__ . '/inc/cli.php';
>>>>>>> e3a066e (Work, work...)

function declare_examples() { return declare_things( $catch = true, func_get_args() ); }

function declare_raw() { return declare_things( $catch = false, func_get_args() ); }
