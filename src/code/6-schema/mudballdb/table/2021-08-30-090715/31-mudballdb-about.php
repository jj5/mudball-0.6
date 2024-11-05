<?php

trait mud_mudballdb_2021_08_30_090715_about {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-14 jj5 - t_about_std_schema
  //

  protected function define_t_about_std_schema() {

    def_tab( 't_about_std_schema' );

    //def_key( 'a_std_schema_id', DBT_ID8 );
    def_key( 'a_std_schema_name', DBT_ASCII_CI );
    def_col( 'a_std_schema_created_on', DBT_CREATED_ON );
    def_col( 'a_std_schema_updated_on', DBT_UPDATED_ON );

    //def_idx( [ 'a_std_schema_name' ], MUD_IDX_UNIQUE );

    def_dat( 't_about_std_schema',
      [
        'a_std_schema_name' => null,
      ], [
      [
        'mudballdb',
      ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-14 jj5 - t_about_std_schema_revision
  //

  protected function define_t_about_std_schema_revision() {

    def_tab( 't_about_std_schema_revision' );

    def_key( 'a_std_schema_revision_id', DBT_ID );
    def_ref( 'a_std_schema_revision_schema_name', 't_about_std_schema', 'a_std_schema_name' );
    def_col( 'a_std_schema_revision_revision_number', DBT_UINT64 );
    def_col( 'a_std_schema_revision_revision_code', DBT_ASCII_CI );
    def_col( 'a_std_schema_revision_created_on', DBT_CREATED_ON );
    def_col( 'a_std_schema_revision_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_schema_revision_schema_name', 'a_std_schema_revision_revision_number' ], MUD_IDX_UNIQUE );

    def_idx( [ 'a_std_schema_revision_schema_name', 'a_std_schema_revision_revision_code' ], MUD_IDX_UNIQUE );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-14 jj5 - t_about_std_schema_upgrade
  //

  protected function define_t_about_std_schema_upgrade() {

    def_tab( 't_about_std_schema_upgrade' );

    def_key( 'a_std_schema_upgrade_id', DBT_ID );
    def_ref( 'a_std_schema_upgrade_schema_name', 't_about_std_schema', 'a_std_schema_name' );
    def_ref( 'a_std_schema_upgrade_revision_number', 't_about_std_schema_revision', 'a_std_schema_revision_revision_number' );
    def_col( 'a_std_schema_upgrade_step', DBT_UINT16 );
    def_col( 'a_std_schema_upgrade_conducted_by', DBT_ASCII_CI );
    def_col( 'a_std_schema_upgrade_conducted_from', DBT_ASCII_CI );
    def_col( 'a_std_schema_upgrade_conducted_on', DBT_DATETIME );
    def_col( 'a_std_schema_upgrade_conducted_tz', DBT_TIMEZONE );
    def_col( 'a_std_schema_upgrade_sql', DBT_ASCII_CI, [ SPEC_MAX => MUD_SIZE_ASCII_60000, SPEC_NULLABLE => true ] );
    def_col( 'a_std_schema_upgrade_created_on', DBT_CREATED_ON );
    def_col( 'a_std_schema_upgrade_updated_on', DBT_UPDATED_ON );

    def_idx(
      [
        'a_std_schema_upgrade_schema_name',
        'a_std_schema_upgrade_revision_number',
        'a_std_schema_upgrade_step'
      ],
      MUD_IDX_UNIQUE
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-07 jj5 - t_about_std_software
  //

  protected function define_t_about_std_software() {

    def_tab( 't_about_std_software' );

    //def_key( 'a_std_software_id', DBT_ID8 );
    def_key( 'a_std_software_code', DBT_ASCII_CI, [ SPEC_MAX => 16, SPEC_VALID => MUD_REGEX_VALID_APP_CODE ] );
    def_col( 'a_std_software_created_on', DBT_CREATED_ON );
    def_col( 'a_std_software_updated_on', DBT_UPDATED_ON );

    //def_idx( [ 'a_std_software_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_about_std_software',
      [
        'a_std_software_code' => null,
      ], [
      [
        'mudball',
      ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-07 jj5 - t_about_std_software_version
  //

  protected function define_t_about_std_software_version() {

    $build_types = [
      'dev',
      'beta',
      'rc1', 'rc2', 'rc3', 'rc4', 'rc5', 'rc6', 'rc7', 'rc8', 'rc9',
      'prod',
    ];

    def_tab( 't_about_std_software_version' );

    def_key( 'a_std_software_version_id', DBT_ID );
    def_ref( 'a_std_software_version_software_code', 't_about_std_software', 'a_std_software_code' );
    def_col( 'a_std_software_version_software_version', DBT_ASCII_CI );
    def_col( 'a_std_software_version_software_slug', DBT_ASCII_CI );
    def_col( 'a_std_software_version_basic_version', DBT_ASCII_CI );
    def_col( 'a_std_software_version_major_version', DBT_UINT16 );
    def_col( 'a_std_software_version_minor_version', DBT_UINT16 );
    def_col( 'a_std_software_version_patch_version', DBT_UINT16 );
    def_col( 'a_std_software_version_build', DBT_ENUM, [ SPEC_ENUM => $build_types ] );
    def_col( 'a_std_software_version_vcs_revision', DBT_ASCII_CI, [ SPEC_NULLABLE => true ] );
    def_col( 'a_std_software_version_vcs_date', DBT_ASCII_CI, [ SPEC_NULLABLE => true ] );
    def_col( 'a_std_software_version_created_on', DBT_CREATED_ON );
    def_col( 'a_std_software_version_updated_on', DBT_UPDATED_ON );

    def_idx(
      [
        'a_std_software_version_software_code',
        'a_std_software_version_software_version'
      ],
      MUD_IDX_UNIQUE
    );

    def_idx(
      [
        'a_std_software_version_software_slug',
      ],
      MUD_IDX_UNIQUE
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_about_std_server
  //

  protected function define_t_about_std_server() {

    //
    // 2021-04-13 jj5 - t_about_std_server
    //

    def_tab( 't_about_std_server' );

    def_key( 'a_std_server_id', DBT_ID );

    def_col( 'a_std_server_hostname', DBT_ASCII_CI );

    def_col( 'a_std_server_is_web_server', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_server_is_database_server', DBT_BOOL, [ SPEC_DEFAULT => 0 ] );
    def_col( 'a_std_server_is_file_server', DBT_BOOL, [ SPEC_DEFAULT => 0 ] );

    def_col( 'a_std_server_created_on', DBT_CREATED_ON );
    def_col( 'a_std_server_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_server_hostname' ], MUD_IDX_UNIQUE );

  }
}
