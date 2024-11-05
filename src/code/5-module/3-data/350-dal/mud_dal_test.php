<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-29 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_dal.php';
require_once __DIR__ . '/test/class/TestFactory.php';
//require_once __DIR__ . '/../../../4-schema/mudballdb.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - declare tests...
//

declare_tests([

  'dal test' => function() {

    mud_define_app( 'MUDBALL' );

    mud_factory( new TestFactory );

    $loader = new_mud_schema_loader();
    $schemata = $loader->load_schemata();

    schemata( $schemata );

    //$dal = new MudDataAccessLayer();



    //
    // 2021-03-29 jj5 - t_about_mud_schema
    //

    $schema_name = 'mudballdb';

    $schema_info = $dal->get_a_std_schema_info_by_name( $schema_name );
    $created_on = $dal->get_a_std_schema_created_on_by_name( $schema_name );
    $updated_on = $dal->get_a_std_schema_updated_on_by_name( $schema_name );


    //
    // 2021-03-29 jj5 - t_about_mud_schema_revision
    //

    $revision = $dal->get_a_std_schema_revision( $schema_name );
    $created_on = $dal->get_a_std_schema_revision_created_on( $schema_name );
    $updated_on = $dal->get_a_std_schema_revision_updated_on( $schema_name );


    //
    // 2021-03-29 jj5 - t_about_mud_schema_upgrade
    //

    $upgrade_id = 1;

    $schema_name = $dal->get_a_std_schema_upgrade_schema_name( $upgrade_id );
    $revision = $dal->get_a_std_schema_upgrade_revision( $upgrade_id );
    $step = $dal->get_a_std_schema_upgrade_step( $upgrade_id );
    $initiated_by = $dal->get_a_std_schema_upgrade_initiated_by( $upgrade_id );
    $initiated_from = $dal->get_a_std_schema_upgrade_initiated_from( $upgrade_id );
    $initiated_on = $dal->get_a_std_schema_upgrade_initiated_on( $upgrade_id );
    $initiated_tz = $dal->get_a_std_schema_upgrade_initiated_tz( $upgrade_id );
    $completed_on = $dal->get_a_std_schema_upgrade_completed_on( $upgrade_id );
    $completed_tz = $dal->get_a_std_schema_upgrade_completed_tz( $upgrade_id );
    $sql = $dal->get_a_std_schema_upgrade_sql( $upgrade_id );
    $created_on = $dal->get_a_std_schema_upgrade_created_on( $upgrade_id );
    $updated_on = $dal->get_a_std_schema_upgrade_updated_on( $upgrade_id );

    assert( $schema_name === 'mudballdb' );

    $upgrade_id = $dal->get_a_std_schema_upgrade_id_by_schema_name_and_revision_and_step(
      $schema_name, $revision, $step
    );

    assert( $upgrade_id === 1 );

    $initiated_by = $dal->get_a_std_schema_upgrade_initiated_by_by_schema_name_and_revision_and_step(
      $schema_name, $revision, $step
    );

    assert( $initiated_by === 'jj5' );

    $initiated_from = $dal->get_a_std_schema_upgrade_initiated_from_by_schema_name_and_revision_and_step(
      $schema_name, $revision, $step
    );

    assert( $initiated_from === 'tact' );

    $initiated_on = $dal->get_a_std_schema_upgrade_initiated_on_by_schema_name_and_revision_and_step(
      $schema_name, $revision, $step
    );

    //var_dump( $initiated_on );

    $initiated_tz = $dal->get_a_std_schema_upgrade_initiated_tz_by_schema_name_and_revision_and_step(
      $schema_name, $revision, $step
    );

    assert( $initiated_tz === 'Australia/Sydney' );


    //
    // 2021-03-29 jj5 - t_lookup_std_auth_event
    //

    $char = $dal->get_a_std_auth_event_char( MudAuthEvent::LOGIN );

    assert( $char === 'i' );

    $code = $dal->get_a_std_auth_event_code( MudAuthEvent::LOGIN );

    assert( $code === 'login' );

    $name = $dal->get_a_std_auth_event_name( MudAuthEvent::LOGIN );

    assert( $name === 'Login' );

    $enum = $dal->get_a_std_auth_event_enum( 'i' );

    assert( $enum === MudAuthEvent::LOGIN );

    $enum = $dal->get_a_std_auth_event_enum( 'login' );

    assert( $enum === MudAuthEvent::LOGIN );


    //
    // 2021-03-29 jj5 - t_lookup_std_browser_flags
    //

    $is_set = $dal->get_a_std_browser_is_verified( FLAG_IS_BROWSER_VERIFIED );

    assert( $is_set === 1 );

    $is_set = $dal->get_a_std_browser_is_verified( FLAG_IS_BROWSER_SPAMMER );

    assert( $is_set === 0 );


    //
    // 2021-03-29 jj5 - t_lookup_std_file_type
    //

    $enum = $dal->get_a_std_file_type_enum_by_file_extension( 'html' );

    assert( $enum === MudFileType::HTML );


    //
    // 2021-03-30 jj5 - t_ident_mud_entity
    //

    $entity_id = $dal->add_row_t_ident_mud_entity();

    var_dump( $entity_id );

    $entity_id_list = $dal->run_p_gen_mud_entity_id();

    var_dump( $entity_id_list );

    $entity_id_list = $dal->run_p_gen_mud_entity_id();

    var_dump( $entity_id_list );

    $entity_id_list = $dal->run_p_gen_mud_entity_id();

    var_dump( $entity_id_list );

    for ( $i = 0; $i < 12; $i++ ) {

      var_dump( $dal->new_entity_id() );

    }


    //
    // 2021-03-31 jj5 - just checking cord validation...
    //

    foreach ( [ ' wrong', 'wr  ong', 'wrong ' ] as $wrong ) {

      try {

        $dal->add_row_t_about_mud_schema( 'testdb', 'ex', $wrong );

        assert( false );

      }
      catch( Exception $ex ) {

        assert( $ex->getMessage() === 'error while processing: invalid value.' );

      }
    }

    $http_user_agent = 'test user agent ' . mud_new_token();
    $http_user_agent_hash_bin = mud_hash_bin( $http_user_agent );
    $http_user_agent_id = $dal->add_row_t_piece_mud_http_user_agent($http_user_agent, $http_user_agent_hash_bin );

    $password = md5( uniqid( time(), $more_entropy = true ) );
    $password_hash = mud_password_hash( $password );
    $password_hash_id = $dal->add_row_t_particle_mud_password_hash( $password_hash );

    $proper_name = 'John Doe' . mud_new_token( 8 );
    $proper_name_id = $dal->add_row_t_particle_mud_proper_name( $proper_name, $proper_name );

    $dal->begin();

    $user_id = $dal->new_entity_id();
    $email_address = 'test-' . mud_get_sydtime() . '@progclub.org';
    $username = 'test' . mud_new_token( 8 );
    $user_flags = 0;
    $dal->add_row_t_entity_mud_user( $user_id, $email_address, $username, $password_hash_id, $user_flags, $proper_name_id );

    //$ticket_id = $dal->add_row_t_entity_mud_tick

    //$browser_id = $dal->new_entity_id();

    //$dal->add_row_t_entity_mud_browser($id, $http_user_agent_id, $user_id, $ticket_id, $seed, $flags );

    $dal->commit();

    //
    // 2021-03-30 jj5 - complete successfully...
    //

    $dal->complete_as_success();

    return 0;

  },

]);
