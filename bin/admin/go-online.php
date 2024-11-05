#!/usr/bin/env php
<?php

define( 'ADMIN', true );

require_once __DIR__ . '/../../src/code/5-module/6-tool/625-dbadmin/mud_dbadmin.php';

require_once __DIR__ . '/../../../../src/code/1-bootstrap/9-keystone.php';

(new MudDbadmin)->go_online( $argv );
