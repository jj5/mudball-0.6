<?php

if ( ! defined( 'DBT_ID' ) ) {

  define( 'DBT_ID', DBT_ID64 );

}

if ( ! defined( 'DBT_IDREF' ) ) {

  define( 'DBT_IDREF', DBT_INT64 );

}

require_once __DIR__ . '/2021-08-30-090715/11-mudballdb-abinitio.php';
require_once __DIR__ . '/2021-08-30-090715/21-mudballdb-lookup-flags.php';
require_once __DIR__ . '/2021-08-30-090715/21-mudballdb-lookup.php';
require_once __DIR__ . '/2021-08-30-090715/22-mudballdb-static.php';
require_once __DIR__ . '/2021-08-30-090715/31-mudballdb-about.php';
require_once __DIR__ . '/2021-08-30-090715/32-mudballdb-config.php';
require_once __DIR__ . '/2021-08-30-090715/41-mudballdb-detail.php';
require_once __DIR__ . '/2021-08-30-090715/51-mudballdb-ident.php';
require_once __DIR__ . '/2021-08-30-090715/61-mudballdb-particle.php';
require_once __DIR__ . '/2021-08-30-090715/62-mudballdb-piece.php';
require_once __DIR__ . '/2021-08-30-090715/63-mudballdb-pot.php';
require_once __DIR__ . '/2021-08-30-090715/64-mudballdb-product.php';
require_once __DIR__ . '/2021-08-30-090715/71-mudballdb-entity.php';
require_once __DIR__ . '/2021-08-30-090715/73-mudballdb-ephemeral.php';
require_once __DIR__ . '/2021-08-30-090715/74-mudballdb-event.php';
require_once __DIR__ . '/2021-08-30-090715/81-mudballdb-log.php';
require_once __DIR__ . '/2021-08-30-090715/91-mudballdb-view.php';
require_once __DIR__ . '/2021-08-30-090715/99-mudballdb-procedure.php';

class mud_mudballdb_2021_08_30_090715 {

  use mud_mudballdb_2021_08_30_090715_abinitio;
  use mud_mudballdb_2021_08_30_090715_lookup_flags;
  use mud_mudballdb_2021_08_30_090715_lookup;
  use mud_mudballdb_2021_08_30_090715_static;
  use mud_mudballdb_2021_08_30_090715_about;
  use mud_mudballdb_2021_08_30_090715_config;
  use mud_mudballdb_2021_08_30_090715_detail;
  use mud_mudballdb_2021_08_30_090715_ident;
  use mud_mudballdb_2021_08_30_090715_particle;
  use mud_mudballdb_2021_08_30_090715_piece;
  use mud_mudballdb_2021_08_30_090715_pot;
  use mud_mudballdb_2021_08_30_090715_product;
  use mud_mudballdb_2021_08_30_090715_entity;
  use mud_mudballdb_2021_08_30_090715_ephemeral;
  use mud_mudballdb_2021_08_30_090715_event;
  use mud_mudballdb_2021_08_30_090715_log;
  use mud_mudballdb_2021_08_30_090715_view;
  use mud_mudballdb_2021_08_30_090715_procedure;


  public function define() {


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2023-02-22 jj5 - define the interaction table
    //

    $this->define_t_abinitio_std_interaction();

    def_job( 'create-interaction-id', function() {

      app_interaction()->init();

    });


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - schema revision about tables are loaded early...
    //

    $this->define_t_about_std_schema();

    $this->define_t_about_std_schema_revision();

    $this->define_t_about_std_schema_upgrade();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-25 jj5 - flags lookup tables...
    //

    $this->define_t_lookup_std_crud_flags();

    $this->define_t_lookup_std_interaction_flags();

    $this->define_t_lookup_std_browser_flags();

    $this->define_t_lookup_std_cookie_flags();

    $this->define_t_lookup_std_prefspec_flags();


    // 2021-04-13 jj5 - there are flags constants defined for these but no flags lookup because
    // these are bools defined on t_about_std_server...
    //
    //$this->define_t_lookup_std_server_flags();

    $this->define_t_lookup_std_session_flags();

    $this->define_t_lookup_std_user_flags();

    $this->define_t_lookup_std_record_flags();

    $this->define_t_lookup_std_web_response_flags();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - lookup tables...
    //

    $this->define_t_lookup_std_auth_event();

    $this->define_t_lookup_std_cookie_type();

    $this->define_t_lookup_std_country();

    $this->define_t_lookup_std_crud();

    $this->define_t_lookup_std_connection_type();

    $this->define_t_lookup_std_database_operation();

    $this->define_t_lookup_std_facility_type();

    $this->define_t_lookup_std_media_type();

    $this->define_t_lookup_std_file_type();

    $this->define_t_lookup_std_gender();

    $this->define_t_lookup_std_http_verb();

    $this->define_t_lookup_std_membership_status();

    $this->define_t_lookup_std_process_status();

    $this->define_t_lookup_std_rectangle_type();

    $this->define_t_lookup_std_role();

    $this->define_t_lookup_std_table_pattern();

    $this->define_t_lookup_std_token_status();

    $this->define_t_lookup_std_token_type();

    $this->define_t_lookup_std_uri_scheme();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - static tables...
    //

    // 2021-03-22 jj5 - NOTE: no static tables at this time.

    // 2021-03-22 jj5 - THINK: maybe the config system uses ref tables?



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - about tables...
    //

    $this->define_t_about_std_software();

    $this->define_t_about_std_software_version();

    $this->define_t_about_std_server();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - config tables...
    //

    $this->define_t_config_std_application_status();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - interaction tables...
    //

    $this->define_t_detail_std_interaction_info();

    $this->define_t_detail_std_interaction_schema();

    $this->define_t_detail_std_interaction_software();

    $this->define_t_detail_std_interaction_connection();

    $this->define_t_detail_std_interaction_data();

    $this->define_t_detail_std_interaction_status_live();

    $this->define_t_detail_std_interaction_status_fail();

    $this->define_t_detail_std_interaction_status_done();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - ident tables...
    //

    $this->define_t_ident_std_internal_id();

    $this->define_t_ident_std_internal_id_allocation();

    $this->define_t_ident_std_external_id();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-22 jj5 - particle tables...
    //

    $this->define_t_particle_std_action();

    $this->define_t_particle_std_cache_name();

    $this->define_t_particle_std_cache_type();

    $this->define_t_particle_std_content_type();

    $this->define_t_particle_std_hostname();

    $this->define_t_particle_std_ip_address();

    $this->define_t_particle_std_password_hash();

    $this->define_t_particle_std_slug();

    $this->define_t_particle_std_table_full_name();

    $this->define_t_particle_std_table_short_name();

    $this->define_t_particle_std_table_name();

    $this->define_t_particle_std_timezone();

    $this->define_t_particle_std_token();

    $this->define_t_particle_std_username();

    $this->define_t_particle_std_cookie_name();

    $this->define_t_particle_std_cookie_value();

    $this->define_t_particle_std_facility();

    //$this->define_t_particle_std_facility_mode();

    $this->define_t_particle_std_facility_path();

    $this->define_t_particle_std_input_field();

    $this->define_t_particle_std_input_problem();

    $this->define_t_particle_std_http_powered_by();

    $this->define_t_particle_std_prefname();

    $this->define_t_particle_std_file_name();

    $this->define_t_particle_std_mailbox();

    $this->define_t_particle_std_email_address();

    $this->define_t_particle_std_proper_name();

    $this->define_t_particle_std_expiry();

    $this->define_t_particle_std_validation_scope();

    $this->define_t_particle_std_validation_issue();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  2021-03-22 jj5 - piece tables...
    //

    $this->define_t_piece_std_asset();

    //$this->define_t_piece_std_http_headers();

    $this->define_t_piece_std_http_accept();

    $this->define_t_piece_std_http_accept_encoding();

    $this->define_t_piece_std_http_accept_language();

    $this->define_t_piece_std_http_user_agent();

    $this->define_t_piece_std_jsonval();

    $this->define_t_piece_std_jzon();

    $this->define_t_piece_std_state();

    $this->define_t_piece_std_url_path();

    $this->define_t_piece_std_url_query();

    $this->define_t_piece_std_url_fragment();

    $this->define_t_piece_std_url();

    $this->define_t_piece_std_validation_value();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2022-07-05 jj5 - pot tables...
    //


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2022-07-05 jj5 - product tables...
    //

    $this->define_t_product_std_address();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-25 jj5 - ephemeral tables...
    //

    // 2021-03-25 jj5 - NOTE: no ephemeral tables at this time.


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-25 jj5 - entity tables...
    //

    $this->define_t_entity_std_user();

    $this->define_t_entity_std_user_credential_reset();

    $this->define_t_entity_std_user_role();

    $this->define_t_entity_std_ticket();

    $this->define_t_entity_std_browser();

    $this->define_t_entity_std_session();

    $this->define_t_entity_std_prefspec();

    $this->define_t_entity_std_pref_session();

    $this->define_t_entity_std_pref_user();

    $this->define_t_entity_std_pref_browser();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-25 jj5 - audit tables...
    //

    // 2021-03-25 jj5 - NOTE: no audit tables at this time.


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-03-25 jj5 - log tables...
    //

    $this->define_t_log_std_email();

    $this->define_t_log_std_web_auth();

    $this->define_t_log_std_cache_usage();

    $this->define_t_log_std_database_access();

    $this->define_t_log_std_database_access_count();

    $this->define_t_log_std_database_operation_count();

    $this->define_t_log_std_database_transaction_count();

    $this->define_t_log_std_missing_token();

    $this->define_t_log_std_web_submission();

    $this->define_t_log_std_cookie();

    $this->define_t_log_std_facility_access();

    $this->define_t_log_std_input_error();

    $this->define_t_log_std_web_request();

    $this->define_t_log_std_web_response();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-08-30 jj5 - views
    //

    $this->define_views();


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 2021-08-30 jj5 - procedures...
    //

    $this->define_procedures();

  }
}

(new mud_mudballdb_2021_08_30_090715)->define();
