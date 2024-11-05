<?php

require_once __DIR__ . '/../../src/code/5-module/6-tool/615-codegen/mud_codegen.php';

require_once __DIR__ . '/../../../../src/code/1-bootstrap/9-keystone.php';

(new MudDalGenerator)->run( $argv );
