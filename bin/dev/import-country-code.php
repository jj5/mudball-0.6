<?php

require_once __DIR__ . '/../../src/code/5-module/7-tool/715-codegen/mud_codegen.php';

require_once __DIR__ . '/../../../../src/code/1-bootstrap/9-keystone.php';

(new MudCountryCodeImporter)->run( $argv );
