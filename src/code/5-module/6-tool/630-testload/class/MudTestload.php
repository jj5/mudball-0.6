<?php

class MudTestload extends MudTool {

  public function run( $argv ) {

    foreach ( [ MUDBALL_PATH, APP_PATH ] as $base_path ) {

      foreach ( [ 'src/code/7-action', 'src/code/8-facility' ] as $index => $rel_path ) {

        $this->testload( "$base_path/$rel_path", $index );

      }
    }

    $this->one_of();

  }

  protected function testload( $path, $type ) {

    static $type_map = [
      APP_OBJECT_TYPE_ACTION => 'MudAction',
      APP_OBJECT_TYPE_FACILITY => 'MudFacility',
    ];

    $class = $type_map[ $type ];

    //mud_stderr( "processing $path...\n" );

    foreach ( scandir( $path ) as $file ) {

      if ( $file === '.' || $file === '..' ) { continue; }

      //mud_stderr( "checking file $file...\n" );

      if ( is_dir( "$path/$file" ) ) { $this->testload( "$path/$file", $type ); }

      if ( ! is_file( "$path/$file" ) ) { continue; }

      //mud_stderr( "checking file $file...\n" );

      if ( ! preg_match( '/\.php$/', $file ) ) { continue; }

      mud_stderr( "including $path/$file...\n" );

      $object = require "$path/$file";

      if ( ! is_a( $object, $class ) ) {

        mud_fail(
          MUD_ERR_TESTLOAD_INVALID_CLASS,
          [ 'expected_class' => $class, 'returned_object' => $object ]
        );

      }
    }
  }

  protected function one_of() {

    // 2022-03-06 jj5 - in this function we create one of every class in our library to make sure
    // the constructors are working as they should.

    //
    // 2022-03-06 jj5 - 0-module
    //

    $this->obj( new MudModuleModule(), 'module' );

    //
    // 2022-03-06 jj5 - 115-error
    //

    $this->obj( new MudException(
      $message = 'test',
      $code = 123,
      $previous = null,
      $name = 'test',
      $hint = 'hint',
      $data = []
    ));

    $this->obj( new MudModuleError(), 'error' );

    //
    // 2022-03-06 jj5 - 120-exit
    //

    $this->obj( new MudModuleExit(), 'exit' );

    //
    // 2022-03-06 jj5 - 125-io
    //

    $this->obj( new MudModuleIo(), 'io' );

    //
    // 2022-03-06 jj5 - 130-retry
    //

    $this->obj( new MudModuleRetry(), 'retry' );

    //
    // 2022-03-06 jj5 - 135-environment
    //

    $this->obj( new MudModuleEnvironment(), 'environment' );

    //
    // 2022-03-06 jj5 - 140-file
    //

    $this->obj( new MudModuleFile(), 'file' );

    //
    // 2022-03-06 jj5 - 145-directory
    //

    $this->obj( new MudModuleDirectory(), 'directory' );

    //
    // 2022-03-06 jj5 - 150-flags
    //

    $this->obj( new MudModuleFlags(), 'flags' );

    //
    // 2022-03-06 jj5 - 155-random
    //

    $this->obj( new MudModuleRandom(), 'random' );

    //
    // 2022-03-06 jj5 - 160-string
    //

    $this->obj( new MudModuleString(), 'string' );

    //
    // 2022-03-06 jj5 - 165-array
    //

    $this->obj( new MudModuleArray(), 'array' );

    //
    // 2022-03-06 jj5 - 170-config
    //

    $this->obj( new MudModuleConfig(), 'config' );

    //
    // 2022-03-06 jj5 - 175-compression
    //

    $this->obj( new MudModuleCompression(), 'compression' );

    //
    // 2022-03-06 jj5 - 180-json
    //

    $this->obj( new MudModuleJson(), 'json' );

    //
    // 2022-03-06 jj5 - 185-log
    //

    $this->obj( new MudLoggerNull() );
    $this->obj( new MudLoggerStderr() );
    $this->obj( new MudLoggerWeblog() );
    $this->obj( new MudLoggerSyslog() );
    $this->obj( new MudLoggerFile( '/tmp/test.log' ) );

    $this->obj( new MudModuleLog(), 'log' );

    //
    // 2022-03-06 jj5 - 190-pclog
    //

    $this->obj( new MudModulePclog(), 'pclog' );

    // 2022-03-06 jj5 - we can ignore this one...
    //
    //$this->obj( new MudModulePclogDispatcher() );

    //
    // 2022-03-06 jj5 - 195-monitor
    //

    $this->obj( new MudMonitorStandard( new stdClass ) );
    $this->obj( new MudMonitorArray( [ 1, 2, 3 ] ) );

    //
    // 2022-03-06 jj5 - 215-general
    //

    $this->obj( new MudModuleGeneral(), 'general' );

    //
    // 2022-03-06 jj5 - 225-null
    //

    $this->obj( new MudNullObject() );

    //
    // 2022-03-06 jj5 - 230-locator
    //

    $this->obj( new MudModuleLocator() );

    //
    // 2022-03-06 jj5 - 235-exception
    //

    $this->obj(
      new MudHttpException(
        $http_status_code = 500,
        $location = '/eg/whatever',
        $data = [],
        $previous = null
      )
    );

    //
    // 2022-03-06 jj5 - 240-temp
    //

    $this->obj( new MudModuleTemp(), 'temp' );

    //
    // 2022-03-06 jj5 - 245-password
    //

    $this->obj( new MudModulePassword(), 'password' );

    //
    // 2022-03-06 jj5 - 250-secret
    //

    $this->obj( new MudModuleSecret(), 'secret' );

    //
    // 2022-03-06 jj5 - 255-time
    //

    $this->obj( new MudModuleTime(), 'time' );

    //
    // 2022-03-06 jj5 - 260-define
    //

    $this->obj( new MudModuleDefine(), 'define' );

    //
    // 2022-03-06 jj5 - 265-ensure
    //

    $this->obj( new MudModuleEnsure(), 'ensure' );

    //
    // 2022-03-06 jj5 - 270-validation
    //

    $this->obj( new MudModuleValidation(), 'validation' );

    //
    // 2022-03-06 jj5 - 275-settings
    //

    $this->obj( new MudModuleSettings(), 'settings' );
    $this->obj( new MudConstant( 'test', 'test' ) );
    $this->obj( new MudSettings( [ 'abc' => 123 ], [ 'abc' => 789 ] ) );

    //
    // 2022-03-06 jj5 - 280-stats
    //

    $this->obj( new MudModuleStats(), 'stats' );

    //
    // 2022-03-06 jj5 - 285-url
    //

    $this->obj( new MudModuleUrl(), 'url' );
    $this->obj( new MudHref() );
    $this->obj( new MudUrl() );

    //
    // 2022-03-06 jj5 - 290-format
    //

    $this->obj( new MudModuleFormat(), 'format' );

    //
    // 2022-03-06 jj5 - 315-database
    //

    $this->obj( new MudModuleDatabase(), 'database' );
    $this->obj( new MudDatabase( MUD_CONNECTION_TYPE_RAW ) );
    // 2022-03-06 jj5 - don't meddle with this one...
    //$this->obj( new MudDatabaseStatement() );

    //
    // 2022-03-06 jj5 - 320-sqlite
    //

    $this->obj( new MudModuleSqlite(), 'sqlite' );

    //
    // 2022-03-06 jj5 - 325-schemata
    //

    $this->obj( $schemata = new MudSchemata( [ 'testdb' => intval( date( 'YmiHis' ) ) ] ) );

    $tab = $this->obj( $tab = new MudSchemaTab(
      $schemata,
      $schema = 'testdb',
      $revision = '2022-03-06-100100',
      $revision_number = 20220306100100,
      $revision_file = null,
      $file = '/whatever',
      $line = 1337,
      $tab_name = 't_test_test',
      $tab_type = 'test',
      $connection_type = MUD_CONNECTION_TYPE_RAW,
      $is_cacheable = false,
      $const = 'TEST'
    ));

    $col = $this->obj( $col = new MudSchemaCol(
      $schemata,
      $tab,
      $schema,
      $revision,
      $revision_number,
      $revision_file,
      $file,
      $line,
      $col_name = 'a_col_example',
      $col_type = DBT_BOOL,
      $is_key = false,
      $is_vrt = false,
      $is_ref = false,
      $is_flg = false,
      $is_unique = false,
      $is_fk = false,
      $min = false,
      $max = true,
      $nullable = false,
      $default = false,
      $valid = null,
      $invalid = null,
      $ref_tab_name = null,
      $ref_col_name = null,
      $ref_col = null,
      $flag = null,
      $db_datatype = MUD_DATATYPE_BOOL,
      $app_datatype = MUD_DATATYPE_BOOL,
      $prop = null,
      $const = null,
      $cast_function = 'boolval',
      $is_ascii = false,
      $is_unicode = false,
      $is_binary = false,
      $string_type = null,
      $is_interaction_id = false,
      $is_auto_inc = false,
      $is_auto = false,
      $classes = [],
      $human_name = 'test'
    ));

    $tab->col_map[ $col->col_name ] = $col;

    $this->obj( new MudSchemaIdx(
      $schemata,
      $tab,
      $schema,
      $revision,
      $revision_number,
      $revision_file,
      $file,
      $line,
      $idx_name = 'test',
      $idx_type = MUD_IDX_INDEX,
      $col_name_list = [ 'a_col_example' ]
    ));

    //
    // 2022-03-06 jj5 - 330-schemadef
    //

    $this->obj( new MudSchemaDef() );

    $tab = $this->obj( new MudSchemaTabDef(
      $file_info = [],
      $file = null,
      $line = 1,
      $tab_name = 't_about_test',
      $tab_type = MUD_TABLE_PATTERN_ABOUT
    ));

    $col = $this->obj( new MudSchemaColDef(
      $file_info = [],
      $file = null,
      $line = 1,
      $col_name = 'a_col',
      $col_type = DBT_BOOL,
      $is_key = false,
      $is_vrt = false,
      $is_ref = false,
      $is_flg = false,
      $is_unique = false,
      $is_fk = false,
      $min = false,
      $max = true,
      $nullable = false,
      $default = false,
      $valid = null,
      $invalid = null,
      $ref_tab_name = null,
      $ref_col_name = null,
      $flag = false,
      $is_interaction_id = false
    ));

    $idx = $this->obj( new MudSchemaIdxDef(
      $file_info = [],
      $file = null,
      $line = 1,
      $idx_name = 'idx_test',
      $idx_type = MUD_IDX_INDEX,
      $col_name_list = [ 'a_col' ]
    ));

    //
    // 2022-03-06 jj5 - 335-schemadecl
    //

    $this->obj( new MudModuleSchemadecl(), 'schemadecl' );

    $this->obj( new MudDatabaseUpgrader( app_dba() ) );
    $this->obj( new MudSchemaDecl(
      $info = null,
      $type = MUD_SCHEMADECL_UNIT_TAB,
      $name_spec = null,
      $attrs = [],
      $prev = null,
      $file = null,
      $line = 1
    ));

    //
    // 2022-03-06 jj5 - 340-cache
    //

    $this->obj( new MudCache( 'test' ) );
    $this->obj( new MudCacheTelemetry(
      $name = 'test',
      $container = 'test',
      $serialization_type_enum = MudSerializationType::JSON
    ));
    $this->obj( new MudCacheTelemetryData(
      $duration = 1.0,
      $row_count = 1,
      $serialization_type_enum = MudSerializationType::JSON,
      $op_count = 1,
      $op_time = 1.0,
      $read_count = 1,
      $read_time = 1,
      $write_count = 1,
      $write_time = 1,
      $hit_count = 1,
      $miss_count = 0,
      $write_race_lost_count = 0,
      $new_table_count = 1,
      $error_count = 0,
      $contenttion_count = 0,
      $reconnect_count = 0,
      $reset_count = 0
    ));
    $this->obj( new MudSerializationForJSON() );
    $this->obj( new MudSerializationForPHP() );

    //
    // 2022-03-06 jj5 - 345-interaction
    //

    $this->obj( new MudInteraction() );

    //
    // 2022-03-06 jj5 - 350-dal
    //

    $this->obj( new MudDalTrn() );
    $this->obj( new MudDalRaw() );
    $this->obj( new MudDalEmu() );
    $this->obj( new MudDalAux() );
    $this->obj( new MudDalDba() );

    //
    // 2022-03-06 jj5 - 395-host
    //

    $this->obj( new MudController() );

    //
    // 2022-03-06 jj5 - 415-http
    //

    $this->obj( new MudModuleHttp(), 'http' );

    //
    // 2022-03-06 jj5 - 420-xsrf
    //

    $this->obj( new MudModuleXsrf(), 'xsrf' );

    //
    // 2022-03-06 jj5 - 430-session
    //

    $this->obj( new MudSessionPhp() );

    //
    // 2022-03-06 jj5 - 435-html
    //

    $this->obj( new MudModuleHtml(), 'html' );

    //
    // 2022-03-06 jj5 - 440-view
    //

    $this->obj( new MudModuleView(), 'view' );

    //
    // 2022-03-06 jj5 - 445-request
    //

    $this->obj( new MudRequest(
      $verb = 'GET',
      $headers = [],
      $http_user_agent = '',
      $http_accept = '',
      $http_accept_language = '',
      $http_accept_encoding = '',
      $http_if_modified_since = '',
      $http_if_none_match = '',
      $scheme = 'https',
      $host = 'localhost',
      $port = 443,
      $controller_path = '/',
      $request_path_parts = [],
      $selector = [],
      $criteria = [],
      $submission = [],
      $files = [],
      $cookies = [],
      $state = [],
      $response = null,
      $facility = null,
    ));

    $this->obj( new MudRequestReader() );

    $this->obj( new MudSubmission() );

    //
    // 2022-03-06 jj5 - 450-response
    //

    $this->obj( new MudResponse() );

    //
    // 2022-03-06 jj5 - 460-facility
    //

    $this->obj( new MudResourceFacility() );

    //
    // 2022-03-06 jj5 - 465-webhost
    //

    $this->obj( new MudControllerWeb() );

    //
    // 2022-03-06 jj5 - 520-factory
    //

    $this->obj( new MudFactory() );

    //
    // 2022-03-06 jj5 - 615-codegen
    //

    $this->obj( $host = new MudDalGenerator() );
    $this->obj( new MudDalConstGenerator( $host ) );
    $this->obj( new MudDalValidationGenerator( $host ) );
    $this->obj( new MudDalTraitsGeneratorStandard( $host ) );
    $this->obj( new MudDalTraitsGeneratorLookup( $host ) );
    $this->obj( new MudDalTraitsGeneratorEntity( $host ) );
    $this->obj( new MudDalTraitsGeneratorLog( $host ) );
    $this->obj( new MudDalTraitsGenerator( $host ) );
    $this->obj( new MudDalClassGenerator( $host ) );
    $this->obj( new MudDalIncludeGenerator( $host ) );

    $this->obj( new MudSchemataGenerator( $host ) );

    $this->obj( new MudCountryCodeImporter() );
    $this->obj( new MudUriSchemeImporter() );

    //
    // 2022-03-06 jj5 - 620-linter
    //

    $this->obj( new MudLinter() );

    //
    // 2022-03-06 jj5 - 625-dbadmin
    //

    define( 'ADMIN', true );

    $this->obj( new MudDbadmin() );

  }

  protected function obj( $obj, $module_name = null ) {

    if ( $module_name !== null ) {

      assert( $obj->get_module_name() === $module_name );

      mud_stderr( 'created ' . get_class( $obj ) . " (module='$module_name')\n" );

    }
    else {

      mud_stderr( 'created ' . get_class( $obj ) . "\n" );

    }

    return $obj;

  }
}
