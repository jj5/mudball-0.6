<?php

require_once __DIR__ . '/../../src/code/5-module/6-tool/620-linter/mud_linter.php';

require_once __DIR__ . '/../../../../src/code/1-bootstrap/9-keystone.php';

(new MudLinter)->run( $argv );
