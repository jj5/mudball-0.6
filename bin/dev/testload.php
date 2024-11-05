#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../src/code/5-module/6-tool/630-testload/mud_testload.php';

require_once __DIR__ . '/../../../../src/code/1-bootstrap/9-keystone.php';

(new MudTestload)->run( $argv );
