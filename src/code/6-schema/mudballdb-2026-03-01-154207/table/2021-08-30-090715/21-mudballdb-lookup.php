<?php

trait mud_mudballdb_2021_08_30_090715_lookup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-03-09 jj5 - t_lookup_std_auth_event
  //

  protected function define_t_lookup_std_auth_event() {

    def_tab( 't_lookup_std_auth_event' );

    def_key( 'a_std_auth_event_enum', DBT_UINT8 );
    def_col( 'a_std_auth_event_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_auth_event_code', DBT_ASCII_CI );
    def_col( 'a_std_auth_event_name', DBT_UTF8_CI );
    def_col( 'a_std_auth_event_note', DBT_UTF8_CI );
    def_col( 'a_std_auth_event_created_on', DBT_CREATED_ON );
    def_col( 'a_std_auth_event_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_auth_event_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_auth_event_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_auth_event',
      [
        'a_std_auth_event_enum' => null,
        'a_std_auth_event_char' => null,
        'a_std_auth_event_code' => null,
        'a_std_auth_event_name' => null,
        'a_std_auth_event_note' => null,
      ], [
      [ 0,                          '?', '',                          '',                 '' ],
      [ MudAuthEvent::LOGIN,        'i', MUD_AUTH_EVENT_LOGIN,        'Login',            'User logged in' ],
      [ MudAuthEvent::SIGNUP,       's', MUD_AUTH_EVENT_SIGNUP,       'Signup',           'User signed up, automatically logged in' ],
      [ MudAuthEvent::LOGOUT,       'x', MUD_AUTH_EVENT_LOGOUT,       'Logout',           'User logged out' ],
      [ MudAuthEvent::DEACTIVATED,  'd', MUD_AUTH_EVENT_DEACTIVATED,  'User deactivated', 'User was logged out because of deactivation' ],
      [ MudAuthEvent::FORGOT,       'f', MUD_AUTH_EVENT_FORGOT,       'Forgot password',  'User forgot their password and we sent them a reset link' ],
      [ MudAuthEvent::RESET,        'r', MUD_AUTH_EVENT_RESET,        'Password reset',   'User successfully reset their password' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_cookie_type
  //

  protected function define_t_lookup_std_cookie_type() {

    def_tab( 't_lookup_std_cookie_type' );

    def_key( 'a_std_cookie_type_enum', DBT_UINT8 );
    def_col( 'a_std_cookie_type_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_cookie_type_code', DBT_ASCII_CI );
    def_col( 'a_std_cookie_type_name', DBT_UTF8_CI );
    def_col( 'a_std_cookie_type_note', DBT_UTF8_CI );
    def_col( 'a_std_cookie_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cookie_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_cookie_type_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cookie_type_code' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cookie_type_name' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_cookie_type',
      [
        'a_std_cookie_type_enum' => null,
        'a_std_cookie_type_char' => null,
        'a_std_cookie_type_code' => null,
        'a_std_cookie_type_name' => null,
        'a_std_cookie_type_note' => null,
      ], [
      [ 0,                      '?',  '',                       '',                 ''                        ],
      [ MudCookieType::BROWSER, 'b',  MUD_COOKIE_TYPE_BROWSER,  'Browser cookie',  'Identifies a web browser' ],
      [ MudCookieType::SESSION, 's',  MUD_COOKIE_TYPE_SESSION,  'Session cookie',  'Identifies a web session' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_lookup_std_country
  //

  protected function define_t_lookup_std_country() {

    // 2021-04-13 jj5 - so what you need to know about this table is that the best display order
    // is sorted by a_std_country_natural_sort (which is an alias for a_std_country_item_ascii)
    // and the best country label is a_std_country_item_html or the UTF-8 equivalent
    // a_std_country_item.

    // 2021-04-13 jj5 - SEE: List of ISO 3166 country codes:
    // https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes

    // 2021-04-13 jj5 - SEE: https://www.iban.com/country-codes

    def_tab( 't_lookup_std_country' );

    def_key( 'a_std_country_enum', DBT_UINT8 );
    def_col( 'a_std_country_alpha_2', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 2 ] );
    def_col( 'a_std_country_alpha_3', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 3 ] );
    def_col( 'a_std_country_numeric_code', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 3 ] );
    def_col( 'a_std_country_numeric_value', DBT_UINT16 );
    def_col( 'a_std_country_is_using_full_name', DBT_BOOL );
    def_col( 'a_std_country_name', DBT_UTF8_CI );
    def_col( 'a_std_country_name_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_full_name', DBT_UTF8_CI );
    def_col( 'a_std_country_full_name_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_short_name', DBT_UTF8_CI );
    def_col( 'a_std_country_short_name_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_item', DBT_UTF8_CI );
    def_col( 'a_std_country_item_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_item_html', DBT_ASCII_CI );
    def_col( 'a_std_country_qualifier', DBT_UTF8_CI );
    def_col( 'a_std_country_qualifier_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_naked_qualifier', DBT_UTF8_CI );
    def_col( 'a_std_country_naked_qualifier_ascii', DBT_ASCII_CI );
    def_col( 'a_std_country_natural_sort', DBT_ASCII_CI );
    def_col( 'a_std_country_created_on', DBT_CREATED_ON );
    def_col( 'a_std_country_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_country_alpha_2' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_country_alpha_3' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_country_numeric_code' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_country_numeric_value' ], MUD_IDX_UNIQUE );

    require_once __DIR__ . '/../../../../../gen/country-code/country-code-schema.php';

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-03-09 jj5 - t_lookup_std_crud
  //

  protected function define_t_lookup_std_crud() {

    def_tab( 't_lookup_std_crud' );

    def_key( 'a_std_crud_enum', DBT_UINT8 );
    def_col( 'a_std_crud_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_crud_code', DBT_ASCII_CI );
    def_col( 'a_std_crud_name', DBT_UTF8_CI );
    def_col( 'a_std_crud_note', DBT_UTF8_CI );
    def_col( 'a_std_crud_created_on', DBT_CREATED_ON );
    def_col( 'a_std_crud_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_crud_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_crud_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_crud',
      [
        'a_std_crud_enum' => null,
        'a_std_crud_char' => null,
        'a_std_crud_code' => null,
        'a_std_crud_name' => null,
        'a_std_crud_note' => null,
      ], [
      [ 0,                  '?', '',                '',         ''                                          ],
      [ MudCrud::CREATE,    'c', MUD_CRUD_CREATE,   'Create',   'Record created/inserted'                   ],
      [ MudCrud::RETRIEVE,  'r', MUD_CRUD_RETRIEVE, 'Retrieve', 'Record retrieved/selected'                 ],
      [ MudCrud::UPDATE,    'u', MUD_CRUD_UPDATE,   'Update',   'Record updated'                            ],
      [ MudCrud::DELETE,    'd', MUD_CRUD_DELETE,   'Delete',   'Record deleted'                            ],
      [ MudCrud::UNDELETE,  'b', MUD_CRUD_UNDELETE, 'Undelete', 'Record undeleted/restored'                 ],
      [ MudCrud::SHRED,     's', MUD_CRUD_SHRED,    'Shred',    'Record deleted including history and logs' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-03-09 jj5 - t_lookup_std_connection_type
  //

  protected function define_t_lookup_std_connection_type() {

    def_tab( 't_lookup_std_connection_type' );

    def_key( 'a_std_connection_type_enum', DBT_UINT8 );
    def_col( 'a_std_connection_type_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_connection_type_code', DBT_ASCII_CI );
    def_col( 'a_std_connection_type_name', DBT_UTF8_CI );
    def_col( 'a_std_connection_type_note', DBT_UTF8_CI );
    def_col( 'a_std_connection_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_connection_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_connection_type_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_connection_type_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_connection_type',
      [
        'a_std_connection_type_enum' => null,
        'a_std_connection_type_char' => null,
        'a_std_connection_type_code' => null,
        'a_std_connection_type_name' => '',
        'a_std_connection_type_note' => '',
      ], [
      [ 0,                      '?', ''                                                                                                 ],
      [ MudConnectionType::TRN, 't', MUD_CONNECTION_TYPE_TRN, 'Transaction connection (trn)',     'autocommit off'                              ],
      [ MudConnectionType::RAW, 'r', MUD_CONNECTION_TYPE_RAW, 'Raw connection (raw)',             'autocommit on'                               ],
      [ MudConnectionType::EMU, 'm', MUD_CONNECTION_TYPE_EMU, 'Emulated connection (emu)',        'autocommit on'                               ],
      [ MudConnectionType::AUX, 'a', MUD_CONNECTION_TYPE_AUX, 'Auxiliary connection (aux)',       'isolation level and autocommit unspecified'  ],
      [ MudConnectionType::DBA, 'b', MUD_CONNECTION_TYPE_DBA, 'Administration connection (dba)',  'for schema modification'                     ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-14 jj5 - t_lookup_std_database_operation
  //

  protected function define_t_lookup_std_database_operation() {

    def_tab( 't_lookup_std_database_operation' );

    def_key( 'a_std_database_operation_enum', DBT_UINT8 );
    def_col( 'a_std_database_operation_code', DBT_ASCII_CI );
    def_col( 'a_std_database_operation_created_on', DBT_CREATED_ON );
    def_col( 'a_std_database_operation_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_database_operation_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_database_operation',
      [
        'a_std_database_operation_enum' => null,
        'a_std_database_operation_code' => null,
      ], [

      [ 0, '' ],

      [ MudDatabaseOperation::INSERT,           MUD_DATABASE_OPERATION_INSERT           ],
      [ MudDatabaseOperation::CREATE_TABLE,     MUD_DATABASE_OPERATION_CREATE_TABLE     ],
      [ MudDatabaseOperation::CREATE_VIEW,      MUD_DATABASE_OPERATION_CREATE_VIEW      ],
      [ MudDatabaseOperation::CREATE_INDEX,     MUD_DATABASE_OPERATION_CREATE_INDEX     ],
      [ MudDatabaseOperation::CREATE_PROCEDURE, MUD_DATABASE_OPERATION_CREATE_PROCEDURE ],
      [ MudDatabaseOperation::CREATE_FUNCTION,  MUD_DATABASE_OPERATION_CREATE_FUNCTION  ],
      [ MudDatabaseOperation::CREATE_OTHER,     MUD_DATABASE_OPERATION_CREATE_OTHER     ],

      [ MudDatabaseOperation::SELECT,           MUD_DATABASE_OPERATION_SELECT           ],

      [ MudDatabaseOperation::UPDATE,           MUD_DATABASE_OPERATION_UPDATE           ],
      [ MudDatabaseOperation::ALTER_TABLE,      MUD_DATABASE_OPERATION_ALTER_TABLE      ],
      [ MudDatabaseOperation::REPLACE,          MUD_DATABASE_OPERATION_REPLACE          ],

      [ MudDatabaseOperation::DELETE,           MUD_DATABASE_OPERATION_DELETE           ],
      [ MudDatabaseOperation::DROP_TABLE,       MUD_DATABASE_OPERATION_DROP_TABLE       ],
      [ MudDatabaseOperation::DROP_VIEW,        MUD_DATABASE_OPERATION_DROP_VIEW        ],
      [ MudDatabaseOperation::DROP_INDEX,       MUD_DATABASE_OPERATION_DROP_INDEX       ],
      [ MudDatabaseOperation::DROP_PROCEDURE,   MUD_DATABASE_OPERATION_DROP_PROCEDURE   ],
      [ MudDatabaseOperation::DROP_FUNCTION,    MUD_DATABASE_OPERATION_DROP_FUNCTION    ],
      [ MudDatabaseOperation::DROP_OTHER,       MUD_DATABASE_OPERATION_DROP_OTHER       ],

      [ MudDatabaseOperation::CALL,             MUD_DATABASE_OPERATION_CALL             ],

    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_facility_type
  //

  protected function define_t_lookup_std_facility_type() {

    def_tab( 't_lookup_std_facility_type' );

    def_key( 'a_std_facility_type_enum', DBT_UINT8 );
    def_col( 'a_std_facility_type_code', DBT_ASCII_CI );
    def_col( 'a_std_facility_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_facility_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_facility_type_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_facility_type',
      [
        'a_std_facility_type_enum' => null,
        'a_std_facility_type_code' => null,
      ], [
      [ 0,                          ''                          ],
      [ MudFacilityType::API,       MUD_FACILITY_TYPE_API       ],
      [ MudFacilityType::ADMIN,     MUD_FACILITY_TYPE_ADMIN     ],
      [ MudFacilityType::UTILITY,   MUD_FACILITY_TYPE_UTILITY   ],
      [ MudFacilityType::CONTENT,   MUD_FACILITY_TYPE_CONTENT   ],
      [ MudFacilityType::IMAGE,     MUD_FACILITY_TYPE_IMAGE     ],
      [ MudFacilityType::STYLE,     MUD_FACILITY_TYPE_STYLE     ],
      [ MudFacilityType::SCRIPT,    MUD_FACILITY_TYPE_SCRIPT    ],
      [ MudFacilityType::RESOURCE,  MUD_FACILITY_TYPE_RESOURCE  ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_media_type
  //

  // 2020-03-25 jj5 - SEE: https://tools.ietf.org/html/rfc2046

  protected function define_t_lookup_std_media_type() {

    def_tab( 't_lookup_std_media_type' );

    def_key( 'a_std_media_type_enum', DBT_UINT8 );
    def_col( 'a_std_media_type_code', DBT_ASCII_CI );
    def_col( 'a_std_media_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_media_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_media_type_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_media_type',
      [
        'a_std_media_type_enum' => null,
        'a_std_media_type_code' => null,
      ], [
      [ 0,                          ''                          ],
      [ MudMediaType::TEXT,         MUD_MEDIA_TYPE_TEXT         ],
      [ MudMediaType::IMAGE,        MUD_MEDIA_TYPE_IMAGE        ],
      [ MudMediaType::AUDIO,        MUD_MEDIA_TYPE_AUDIO        ],
      [ MudMediaType::VIDEO,        MUD_MEDIA_TYPE_VIDEO        ],
      [ MudMediaType::FONT,         MUD_MEDIA_TYPE_FONT         ],
      [ MudMediaType::APPLICATION,  MUD_MEDIA_TYPE_APPLICATION  ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_file_type
  //

  protected function define_t_lookup_std_file_type() {

    def_tab( 't_lookup_std_file_type' );

    def_key( 'a_std_file_type_enum', DBT_UINT16 );
    def_col( 'a_std_file_type_file_extension', DBT_ASCII_CI );
    def_col( 'a_std_file_type_file_extension_short', DBT_ASCII_CI );
    def_ref( 'a_std_file_type_media_type_enum', 't_lookup_std_media_type', 'a_std_media_type_enum' );
    def_col( 'a_std_file_type_media_subtype', DBT_ASCII_CI );
    def_col( 'a_std_file_type_mime_type', DBT_ASCII_CI );
    def_ref( 'a_std_file_type_aux_media_type_enum', 't_lookup_std_media_type', 'a_std_media_type_enum' );
    def_col( 'a_std_file_type_aux_media_subtype', DBT_ASCII_CI );
    def_col( 'a_std_file_type_aux_mime_type', DBT_ASCII_CI );
    def_col( 'a_std_file_type_note', DBT_UTF8_CI );
    def_col( 'a_std_file_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_file_type_updated_on', DBT_UPDATED_ON );

    // 2020-03-25 jj5 - TODO: fix this index. I think file extensions are
    // unique per primary media type, check the data...
    //
    def_idx( [ 'a_std_file_type_file_extension' ], MUD_IDX_UNIQUE );

    // 2020-03-25 jj5 - if you want to add your own file types start from
    // enum value 9000...

    // 2021-03-21 jj5 - TODO: remove the call to dal() in the code below, pass in a $dal
    // instead.

    def_dat( 't_lookup_std_file_type',
      [
        'a_std_file_type_enum' => null,
        'a_std_file_type_file_extension' => null,
        'a_std_file_type_file_extension_short' => null,
        'a_std_file_type_note' => null,
        'a_std_file_type_media_type_enum' => null,
        'a_std_file_type_media_subtype' => null,
        'a_std_file_type_aux_media_type_enum' => 0,
        'a_std_file_type_aux_media_subtype' => '',
        'a_std_file_type_mime_type' => function( $row, $upgrader ) {
          $media_type_enum = $row[ 4 ];
          $subtype = $row[ 5 ];
          $media_type_code = $upgrader->get_a_std_media_type_code( $media_type_enum );
          if ( $media_type_code && $subtype ) { return "$media_type_code/$subtype"; }
          return '';
        },
        'a_std_file_type_aux_mime_type' => function( $row, $upgrader ) {
          $media_type_enum = $row[ 6 ] ?? null;
          $subtype = $row[ 7 ] ?? null;
          if ( ! $media_type_enum || ! $subtype ) { return ''; }
          $media_type_code = $upgrader->get_a_std_media_type_code( $media_type_enum );
          if ( $media_type_code && $subtype ) { return "$media_type_code/$subtype"; }
          return '';
        },
      ], [

      [  0, '', '', '', 0, '' ],

      //
      // 2020-03-25 jj5 - these are the 'text' file types...
      //

      [
        MudFileType::CSS,
        MUD_FILE_EXT_CSS,
        MUD_FILE_EXT_CSS,
        'Cascading Style Sheets (CSS)',
        MudMediaType::TEXT,
        'css',
      ],

      [
        MudFileType::CSV,
        MUD_FILE_EXT_CSV,
        MUD_FILE_EXT_CSV,
        'Comma-separated values (CSV)',
        MudMediaType::TEXT,
        'csv',
      ],

      [
        MudFileType::HTML,
        MUD_FILE_EXT_HTML,
        MUD_FILE_EXT_HTM,
        'HyperText Markup Language (HTML)',
        MudMediaType::TEXT,
        'html',
      ],

      [
        MudFileType::ICS,
        MUD_FILE_EXT_ICS,
        MUD_FILE_EXT_ICS,
        'iCalendar format',
        MudMediaType::TEXT,
        'calendar',
      ],

      [
        MudFileType::TXT,
        MUD_FILE_EXT_TXT,
        MUD_FILE_EXT_TXT,
        'Text, generally ASCII or UTF-8',
        MudMediaType::TEXT,
        'plain',
      ],

      //
      // 2020-03-25 jj5 - these are the 'image' file types...
      //

      [
        MudFileType::BMP,
        MUD_FILE_EXT_BMP,
        MUD_FILE_EXT_BMP,
        'Windows OS/2 Bitmap Graphics',
        MudMediaType::IMAGE,
        'bmp',
      ],

      [
        MudFileType::GIF,
        MUD_FILE_EXT_GIF,
        MUD_FILE_EXT_GIF,
        'Graphics Interchange Format (GIF)',
        MudMediaType::IMAGE,
        'gif',
      ],

      [
        MudFileType::ICO,
        MUD_FILE_EXT_ICO,
        MUD_FILE_EXT_ICO,
        'Icon format',
        MudMediaType::IMAGE,
        'vnd.microsoft.icon',
      ],

      [
        MudFileType::JPEG,
        MUD_FILE_EXT_JPEG,
        MUD_FILE_EXT_JPG,
        'JPEG images',
        MudMediaType::IMAGE,
        'jpeg',
      ],

      [
        MudFileType::PNG,
        MUD_FILE_EXT_PNG,
        MUD_FILE_EXT_PNG,
        'Portable Network Graphics',
        MudMediaType::IMAGE,
        'png',
      ],

      [
        MudFileType::SVG,
        MUD_FILE_EXT_SVG,
        MUD_FILE_EXT_SVG,
        'Scalable Vector Graphics (SVG)',
        MudMediaType::IMAGE,
        'svg+xml',
      ],

      [
        MudFileType::TIFF,
        MUD_FILE_EXT_TIFF,
        MUD_FILE_EXT_TIF,
        'Tagged Image File Format (TIFF)',
        MudMediaType::IMAGE,
        'tiff',
      ],

      [
        MudFileType::WEBP,
        MUD_FILE_EXT_WEBP,
        MUD_FILE_EXT_WEBP,
        'WEBP image',
        MudMediaType::IMAGE,
        'webp',
      ],

      //
      // 2020-03-25 jj5 - these are the 'audio' file types...
      //

      [
        MudFileType::AAC,
        MUD_FILE_EXT_AAC,
        MUD_FILE_EXT_AAC,
        'AAC audio',
        MudMediaType::AUDIO,
        'aac',
      ],

      [
        MudFileType::MIDI,
        MUD_FILE_EXT_MIDI,
        MUD_FILE_EXT_MID,
        'Musical Instrument Digital Interface (MIDI)',
        MudMediaType::AUDIO,
        'midi',
        MudMediaType::AUDIO,
        'x-midi',
      ],

      [
        MudFileType::MP3,
        MUD_FILE_EXT_MP3,
        MUD_FILE_EXT_MP3,
        'MP3 audio',
        MudMediaType::AUDIO,
        'mpeg',
      ],

      [
        MudFileType::OGA,
        MUD_FILE_EXT_OGA,
        MUD_FILE_EXT_OGA,
        'OGG audio',
        MudMediaType::AUDIO,
        'ogg',
      ],

      [
        MudFileType::OPUS,
        MUD_FILE_EXT_OPUS,
        MUD_FILE_EXT_OPUS,
        'Opus audio',
        MudMediaType::AUDIO,
        'opus',
      ],

      [
        MudFileType::WAV,
        MUD_FILE_EXT_WAV,
        MUD_FILE_EXT_WAV,
        'Waveform Audio Format',
        MudMediaType::AUDIO,
        'wav',
      ],

      [
        MudFileType::WEBA,
        MUD_FILE_EXT_WEBA,
        MUD_FILE_EXT_WEBA,
        'WEBM audio',
        MudMediaType::AUDIO,
        'webm',
      ],

      //
      // 2020-03-25 jj5 - these are the 'video' file types...
      //

      [
        MudFileType::AVI,
        MUD_FILE_EXT_AVI,
        MUD_FILE_EXT_AVI,
        'AVI: Audio Video Interleave',
        MudMediaType::VIDEO,
        'x-msvideo',
      ],

      [
        MudFileType::MPEG,
        MUD_FILE_EXT_MPEG,
        MUD_FILE_EXT_MPEG,
        'MPEG Video',
        MudMediaType::VIDEO,
        'mpeg',
      ],

      [
        MudFileType::OGV,
        MUD_FILE_EXT_OGV,
        MUD_FILE_EXT_OGV,
        'OGG video',
        MudMediaType::VIDEO,
        'ogg',
      ],

      [
        MudFileType::TS,
        MUD_FILE_EXT_TS,
        MUD_FILE_EXT_TS,
        'MPEG transport stream',
        MudMediaType::VIDEO,
        'mp2t',
      ],

      [
        MudFileType::WEBM,
        MUD_FILE_EXT_WEBM,
        MUD_FILE_EXT_WEBM,
        'WEBM video',
        MudMediaType::VIDEO,
        'webm',
      ],

      [
        MudFileType::_3GP,
        MUD_FILE_EXT_3GP,
        MUD_FILE_EXT_3GP,
        '3GPP audio/video container',
        MudMediaType::VIDEO,
        '3gpp',
        MudMediaType::AUDIO,
        '3gpp',
      ],

      [
        MudFileType::_3G2,
        MUD_FILE_EXT_3G2,
        MUD_FILE_EXT_3G2,
        '3GPP2 audio/video container',
        MudMediaType::VIDEO,
        '3gpp2',
        MudMediaType::AUDIO,
        '3gpp2',
      ],

      //
      // 2020-03-25 jj5 - these are the 'font' file types...
      //

      [
        MudFileType::OTF,
        MUD_FILE_EXT_OTF,
        MUD_FILE_EXT_OTF,
        'OpenType font',
        MudMediaType::FONT,
        'otf',
      ],

      [
        MudFileType::TTF,
        MUD_FILE_EXT_TTF,
        MUD_FILE_EXT_TTF,
        'TrueType Font',
        MudMediaType::FONT,
        'ttf',
      ],

      [
        MudFileType::WOFF,
        MUD_FILE_EXT_WOFF,
        MUD_FILE_EXT_WOFF,
        'Web Open Font Format (WOFF)',
        MudMediaType::FONT,
        'woff',
      ],

      [
        MudFileType::WOFF2,
        MUD_FILE_EXT_WOFF2,
        MUD_FILE_EXT_WOFF2,
        'Web Open Font Format (WOFF2)',
        MudMediaType::FONT,
        'woff2',
      ],

      //
      // 2020-03-25 jj5 - these are the 'application' file types...
      //

      [
        MudFileType::ABW,
        MUD_FILE_EXT_ABW,
        MUD_FILE_EXT_ABW,
        'AbiWord document',
        MudMediaType::APPLICATION,
        'x-abiword',
      ],

      [
        MudFileType::ARC,
        MUD_FILE_EXT_ARC,
        MUD_FILE_EXT_ARC,
        'Archive document (multiple files embedded)',
        MudMediaType::APPLICATION,
        'x-freearc',
      ],

      [
        MudFileType::AZW,
        MUD_FILE_EXT_AZW,
        MUD_FILE_EXT_AZW,
        'Amazon Kindle eBook format',
        MudMediaType::APPLICATION,
        'vnd.amazon.ebook',
      ],

      [
        MudFileType::BIN,
        MUD_FILE_EXT_BIN,
        MUD_FILE_EXT_BIN,
        'Any kind of binary data',
        MudMediaType::APPLICATION,
        'octet-stream',
      ],

      [
        MudFileType::BZ,
        MUD_FILE_EXT_BZ,
        MUD_FILE_EXT_BZ,
        'BZip archive',
        MudMediaType::APPLICATION,
        'x-bzip',
      ],

      [
        MudFileType::BZ2,
        MUD_FILE_EXT_BZ2,
        MUD_FILE_EXT_BZ2,
        'BZip2 archive',
        MudMediaType::APPLICATION,
        'x-bzip2',
      ],

      [
        MudFileType::CSH,
        MUD_FILE_EXT_CSH,
        MUD_FILE_EXT_CSH,
        'C-Shell script',
        MudMediaType::APPLICATION,
        'x-csh',
      ],

      [
        MudFileType::DOC,
        MUD_FILE_EXT_DOC,
        MUD_FILE_EXT_DOC,
        'Microsoft Word',
        MudMediaType::APPLICATION,
        'msword',
      ],

      [
        MudFileType::DOCX,
        MUD_FILE_EXT_DOCX,
        MUD_FILE_EXT_DOCX,
        'Microsoft Word (OpenXML)',
        MudMediaType::APPLICATION,
        'vnd.openxmlformats-officedocument.wordprocessingml.document',
      ],

      [
        MudFileType::EOT,
        MUD_FILE_EXT_EOT,
        MUD_FILE_EXT_EOT,
        'MS Embedded OpenType fonts',
        MudMediaType::APPLICATION,
        'vnd.ms-fontobject'
      ],

      [
        MudFileType::EPUB,
        MUD_FILE_EXT_EPUB,
        MUD_FILE_EXT_EPUB,
        'Electronic publication (EPUB)',
        MudMediaType::APPLICATION,
        'epub+zip'
      ],

      [
        MudFileType::GZ,
        MUD_FILE_EXT_GZ,
        MUD_FILE_EXT_GZ,
        'GZip Compressed Archive',
        MudMediaType::APPLICATION,
        'gzip',
      ],

      [
        MudFileType::JAR,
        MUD_FILE_EXT_JAR,
        MUD_FILE_EXT_JAR,
        'Java Archive (JAR)',
        MudMediaType::APPLICATION,
        'java-archive',
      ],

      [
        MudFileType::JS,
        MUD_FILE_EXT_JS,
        MUD_FILE_EXT_JS,
        'JavaScript',
        MudMediaType::APPLICATION,
        'javascript',
        MudMediaType::TEXT,
        'javascript'
      ],

      [
        MudFileType::JSON,
        MUD_FILE_EXT_JSON,
        MUD_FILE_EXT_JSON,
        'JSON format',
        MudMediaType::APPLICATION,
        'json',
      ],

      [
        MudFileType::JSONLD,
        MUD_FILE_EXT_JSONLD,
        MUD_FILE_EXT_JSONLD,
        'JSON-LD format',
        MudMediaType::APPLICATION,
        'ld+json',
      ],

      [
        MudFileType::MJS,
        MUD_FILE_EXT_MJS,
        MUD_FILE_EXT_MJS,
        'JavaScript module',
        MudMediaType::APPLICATION,
        'javascript',
        MudMediaType::TEXT,
        'javascript'
      ],

      [
        MudFileType::MPKG,
        MUD_FILE_EXT_MPKG,
        MUD_FILE_EXT_MPKG,
        'Apple Installer Package',
        MudMediaType::APPLICATION,
        'vnd.apple.installer+xml',
      ],

      [
        MudFileType::ODP,
        MUD_FILE_EXT_ODP,
        MUD_FILE_EXT_ODP,
        'OpenDocument presentation document',
        MudMediaType::APPLICATION,
        'vnd.oasis.opendocument.presentation',
      ],

      [
        MudFileType::ODS,
        MUD_FILE_EXT_ODS,
        MUD_FILE_EXT_ODS,
        'OpenDocument spreadsheet document',
        MudMediaType::APPLICATION,
        'vnd.oasis.opendocument.spreadsheet',
      ],

      [
        MudFileType::ODT,
        MUD_FILE_EXT_ODT,
        MUD_FILE_EXT_ODT,
        'OpenDocument text document',
        MudMediaType::APPLICATION,
        'vnd.oasis.opendocument.text',
      ],

      [
        MudFileType::OGX,
        MUD_FILE_EXT_OGX,
        MUD_FILE_EXT_OGX,
        'OGG',
        MudMediaType::APPLICATION,
        'ogg',
      ],

      [
        MudFileType::PDF,
        MUD_FILE_EXT_PDF,
        MUD_FILE_EXT_PDF,
        'Adobe Portable Document Format (PDF)',
        MudMediaType::APPLICATION,
        'pdf',
      ],

      [
        MudFileType::PHP,
        MUD_FILE_EXT_PHP,
        MUD_FILE_EXT_PHP,
        'PHP Hypertext Preprocessor',
        MudMediaType::APPLICATION,
        'php',
      ],

      [
        MudFileType::PPT,
        MUD_FILE_EXT_PPT,
        MUD_FILE_EXT_PPT,
        'Microsoft PowerPoint',
        MudMediaType::APPLICATION,
        'vnd.ms-powerpoint',
      ],

      [
        MudFileType::PPTX,
        MUD_FILE_EXT_PPTX,
        MUD_FILE_EXT_PPTX,
        'Microsoft PowerPoint (OpenXML)',
        MudMediaType::APPLICATION,
        'vnd.openxmlformats-officedocument.presentationml.presentation',
      ],

      [
        MudFileType::RAR,
        MUD_FILE_EXT_RAR,
        MUD_FILE_EXT_RAR,
        'RAR archive',
        MudMediaType::APPLICATION,
        'x-rar-compressed',
      ],

      [
        MudFileType::RTF,
        MUD_FILE_EXT_RTF,
        MUD_FILE_EXT_RTF,
        'Rich Text Format (RTF)',
        MudMediaType::APPLICATION,
        'rtf',
      ],

      [
        MudFileType::SH,
        MUD_FILE_EXT_SH,
        MUD_FILE_EXT_SH,
        'Bourne shell script',
        MudMediaType::APPLICATION,
        'x-sh',
      ],

      [
        MudFileType::SWF,
        MUD_FILE_EXT_SWF,
        MUD_FILE_EXT_SWF,
        'Small web format (SWF) or Adobe Flash document',
        MudMediaType::APPLICATION,
        'x-shockwave-flash',
      ],

      [
        MudFileType::TAR,
        MUD_FILE_EXT_TAR,
        MUD_FILE_EXT_TAR,
        'Tape Archive (TAR)',
        MudMediaType::APPLICATION,
        'x-tar',
      ],

      [
        MudFileType::VSD,
        MUD_FILE_EXT_VSD,
        MUD_FILE_EXT_VSD,
        'Microsoft Visio',
        MudMediaType::APPLICATION,
        'vnd.visio',
      ],

      [
        MudFileType::XHTML,
        MUD_FILE_EXT_XHTML,
        MUD_FILE_EXT_XHTML,
        'XHTML',
        MudMediaType::APPLICATION,
        'xhtml+xml',
      ],

      [
        MudFileType::XLS,
        MUD_FILE_EXT_XLS,
        MUD_FILE_EXT_XLS,
        'Microsoft Excel',
        MudMediaType::APPLICATION,
        'vnd.ms-excel',
      ],

      [
        MudFileType::XLSX,
        MUD_FILE_EXT_XLSX,
        MUD_FILE_EXT_XLSX,
        'Microsoft Excel (OpenXML)',
        MudMediaType::APPLICATION,
        'vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      ],

      [
        MudFileType::XML,
        MUD_FILE_EXT_XML,
        MUD_FILE_EXT_XML,
        'XML',
        MudMediaType::APPLICATION,
        'xml',
        MudMediaType::TEXT,
        'xml',
      ],

      [
        MudFileType::XUL,
        MUD_FILE_EXT_XUL,
        MUD_FILE_EXT_XUL,
        'XUL',
        MudMediaType::APPLICATION,
        'vnd.mozilla.xul+xml',
      ],

      [
        MudFileType::ZIP,
        MUD_FILE_EXT_ZIP,
        MUD_FILE_EXT_ZIP,
        'ZIP archive',
        MudMediaType::APPLICATION,
        'zip',
      ],

      [
        MudFileType::_7Z,
        MUD_FILE_EXT_7Z,
        MUD_FILE_EXT_7Z,
        '7-zip archive',
        MudMediaType::APPLICATION,
        'x-7z-compressed',
      ],

    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_gender
  //

  protected function define_t_lookup_std_gender() {

    def_tab( 't_lookup_std_gender' );

    def_key( 'a_std_gender_enum', DBT_UINT8 );
    def_col( 'a_std_gender_char', DBT_ASCII_CHAR_CI );
    def_col( 'a_std_gender_code', DBT_ASCII_CI );
    def_col( 'a_std_gender_name', DBT_UTF8_CI );
    def_col( 'a_std_gender_note', DBT_UTF8_CI );
    def_col( 'a_std_gender_created_on', DBT_CREATED_ON );
    def_col( 'a_std_gender_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_gender_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_gender_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_gender',
      [
        'a_std_gender_enum' => null,
        'a_std_gender_char' => null,
        'a_std_gender_code' => null,
        'a_std_gender_name' => null,
        'a_std_gender_note' => null,
      ], [
      [ 0,                      '?', '',                      '',             ''            ],
      [ MudGender::FEMALE,      'f', MUD_GENDER_FEMALE,       'Female',       'Female'      ],
      [ MudGender::MALE,        'm', MUD_GENDER_MALE,         'Male',         'Male'        ],
      [ MudGender::OTHER,       'o', MUD_GENDER_OTHER,        'Other',        'Other'       ],
      [ MudGender::UNSPECIFIED, 'u', MUD_GENDER_UNSPECIFIED,  'Unspecified',  'Unspecified' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_http_verb
  //

  protected function define_t_lookup_std_http_verb() {

    // 2020-03-25 jj5 - SEE: https://annevankesteren.nl/2007/10/http-methods

    def_tab( 't_lookup_std_http_verb' );

    def_key( 'a_std_http_verb_enum', DBT_UINT8 );
    def_col( 'a_std_http_verb_code', DBT_ASCII_CI );
    def_col( 'a_std_http_verb_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_verb_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_verb_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_http_verb',
      [
        'a_std_http_verb_enum' => null,
        'a_std_http_verb_code' => null,
      ], [
      [ 0, '' ],
      [ MudHttpVerb::GET,               MUD_HTTP_VERB_GET               ],
      [ MudHttpVerb::POST,              MUD_HTTP_VERB_POST              ],
      [ MudHttpVerb::PUT,               MUD_HTTP_VERB_PUT               ],
      [ MudHttpVerb::DELETE,            MUD_HTTP_VERB_DELETE            ],
      [ MudHttpVerb::TRACE,             MUD_HTTP_VERB_TRACE             ],
      [ MudHttpVerb::CONNECT,           MUD_HTTP_VERB_CONNECT           ],
      [ MudHttpVerb::OPTIONS,           MUD_HTTP_VERB_OPTIONS           ],
      [ MudHttpVerb::HEAD,              MUD_HTTP_VERB_HEAD              ],
      [ MudHttpVerb::PROPFIND,          MUD_HTTP_VERB_PROPFIND          ],
      [ MudHttpVerb::PROPPATCH,         MUD_HTTP_VERB_PROPPATCH         ],
      [ MudHttpVerb::MKCOL,             MUD_HTTP_VERB_MKCOL             ],
      [ MudHttpVerb::COPY,              MUD_HTTP_VERB_COPY              ],
      [ MudHttpVerb::MOVE,              MUD_HTTP_VERB_MOVE              ],
      [ MudHttpVerb::LOCK,              MUD_HTTP_VERB_LOCK              ],
      [ MudHttpVerb::UNLOCK,            MUD_HTTP_VERB_UNLOCK            ],
      [ MudHttpVerb::VERSION_CONTROL,   MUD_HTTP_VERB_VERSION_CONTROL   ],
      [ MudHttpVerb::REPORT,            MUD_HTTP_VERB_REPORT            ],
      [ MudHttpVerb::CHECKOUT,          MUD_HTTP_VERB_CHECKOUT          ],
      [ MudHttpVerb::CHECKIN,           MUD_HTTP_VERB_CHECKIN           ],
      [ MudHttpVerb::UNCHECKOUT,        MUD_HTTP_VERB_UNCHECKOUT        ],
      [ MudHttpVerb::MKWORKSPACE,       MUD_HTTP_VERB_MKWORKSPACE       ],
      [ MudHttpVerb::UPDATE,            MUD_HTTP_VERB_UPDATE            ],
      [ MudHttpVerb::LABEL,             MUD_HTTP_VERB_LABEL             ],
      [ MudHttpVerb::MERGE,             MUD_HTTP_VERB_MERGE             ],
      [ MudHttpVerb::BASELINE_CONTROL,  MUD_HTTP_VERB_BASELINE_CONTROL  ],
      [ MudHttpVerb::MKACTIVITY,        MUD_HTTP_VERB_MKACTIVITY        ],
      [ MudHttpVerb::ORDERPATCH,        MUD_HTTP_VERB_ORDERPATCH        ],
      [ MudHttpVerb::ACL,               MUD_HTTP_VERB_ACL               ],
      [ MudHttpVerb::PATCH,             MUD_HTTP_VERB_PATCH             ],
      [ MudHttpVerb::SEARCH,            MUD_HTTP_VERB_SEARCH            ],
      [ MudHttpVerb::BCOPY,             MUD_HTTP_VERB_BCOPY             ],
      [ MudHttpVerb::BDELETE,           MUD_HTTP_VERB_BDELETE           ],
      [ MudHttpVerb::BMOVE,             MUD_HTTP_VERB_BMOVE             ],
      [ MudHttpVerb::BPROPFIND,         MUD_HTTP_VERB_BPROPFIND         ],
      [ MudHttpVerb::BPROPPATCH,        MUD_HTTP_VERB_BPROPPATCH        ],
      [ MudHttpVerb::NOTIFY,            MUD_HTTP_VERB_NOTIFY            ],
      [ MudHttpVerb::POLL,              MUD_HTTP_VERB_POLL              ],
      [ MudHttpVerb::SUBSCRIBE,         MUD_HTTP_VERB_SUBSCRIBE         ],
      [ MudHttpVerb::UNSUBSCRIBE,       MUD_HTTP_VERB_UNSUBSCRIBE       ],
      [ MudHttpVerb::X_MS_ENUMATTS,     MUD_HTTP_VERB_X_MS_ENUMATTS     ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_membership_status
  //

  protected function define_t_lookup_std_membership_status() {

    def_tab( 't_lookup_std_membership_status' );

    def_key( 'a_std_membership_status_enum', DBT_UINT8 );
    def_col( 'a_std_membership_status_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_membership_status_code', DBT_ASCII_CI );
    def_col( 'a_std_membership_status_name', DBT_UTF8_CI );
    def_col( 'a_std_membership_status_note', DBT_UTF8_CI );
    def_col( 'a_std_membership_status_created_on', DBT_CREATED_ON );
    def_col( 'a_std_membership_status_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_membership_status_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_membership_status_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_membership_status',
      [
        'a_std_membership_status_enum' => null,
        'a_std_membership_status_char' => null,
        'a_std_membership_status_code' => null,
        'a_std_membership_status_name' => null,
        'a_std_membership_status_note' => null,
      ], [
      [ 0,                              '?', '',                              '',           ''                                    ],
      [ MudMembershipStatus::UNSET,     'u', MUD_MEMBERSHIP_STATUS_UNSET,     'Unset',      'Membership has not been configured'  ],
      [ MudMembershipStatus::NONMEMBER, 'n', MUD_MEMBERSHIP_STATUS_NONMEMBER, 'Non-member', 'Item is not a member of group'       ],
      [ MudMembershipStatus::MEMBER,    'm', MUD_MEMBERSHIP_STATUS_MEMBER,    'Member',     'Item is a member of group'           ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-30 jj5 - t_lookup_std_process_status
  //

  protected function define_t_lookup_std_process_status() {

    def_tab( 't_lookup_std_process_status' );

    def_key( 'a_std_process_status_enum', DBT_UINT8 );
    def_col( 'a_std_process_status_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_process_status_code', DBT_ASCII_CI );
    def_col( 'a_std_process_status_name', DBT_UTF8_CI );
    def_col( 'a_std_process_status_note', DBT_UTF8_CI );
    def_col( 'a_std_process_status_created_on', DBT_CREATED_ON );
    def_col( 'a_std_process_status_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_process_status_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_process_status_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_process_status',
      [
        'a_std_process_status_enum' => null,
        'a_std_process_status_char' => null,
        'a_std_process_status_code' => null,
        'a_std_process_status_name' => null,
        'a_std_process_status_note' => null,
      ], [
      [ 0,                        '?',  '',                       '',     ''                    ],
      [ MudProcessStatus::LIVE,   'v',  MUD_PROCESS_STATUS_LIVE,  'Live', 'Process is running'  ],
      [ MudProcessStatus::DONE,   'd',  MUD_PROCESS_STATUS_DONE,  'Done', 'Process is finished' ],
      [ MudProcessStatus::FAIL,   'f',  MUD_PROCESS_STATUS_FAIL,  'Fail', 'Process failed'      ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_rectangle_type
  //

  protected function define_t_lookup_std_rectangle_type() {

    def_tab( 't_lookup_std_rectangle_type' );

    def_key( 'a_std_rectangle_type_enum', DBT_UINT8 );
    def_col( 'a_std_rectangle_type_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_rectangle_type_code', DBT_ASCII_BIN );
    def_col( 'a_std_rectangle_type_name', DBT_UTF8_CI );
    def_col( 'a_std_rectangle_type_note', DBT_UTF8_CI );
    def_col( 'a_std_rectangle_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_rectangle_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_rectangle_type_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_rectangle_type_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_rectangle_type',
      [
        'a_std_rectangle_type_enum' => null,
        'a_std_rectangle_type_char' => null,
        'a_std_rectangle_type_code' => null,
        'a_std_rectangle_type_name' => null,
        'a_std_rectangle_type_note' => null,
      ], [
      [ 0,                        '?', '',                        '',             ''                                  ],
      [ MudRectangleType::TABLE,  't', MUD_RECTANGLE_TYPE_TABLE,  'Table',        'Database tables'                   ],
      [ MudRectangleType::VIEW,   'v', MUD_RECTANGLE_TYPE_VIEW,   'View',         'Database view'                     ],
      [ MudRectangleType::PRETTY, 'p', MUD_RECTANGLE_TYPE_PRETTY, 'Pretty view',  'Database view (pretty, readable)'  ],
      [ MudRectangleType::OTHER,  'o', MUD_RECTANGLE_TYPE_OTHER,  'Other',        'Non-standard table/view'           ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_role
  //

  protected function define_t_lookup_std_role() {

    // 2019-10-16 jj5 - NOTE: if you need extra data for a role
    // create a app_role_info table in the app database schema
    //
    // 2019-10-20 jj5 - NOTE: because roles have semantics in the application
    // regarding permissions for particular operations and so on the roles
    // are managed as a lookup table packaged with the software and are thus
    // not editable, even by the administrators. Role membership on the other
    // hand can be configured by administrators.
    //
    // 2020-03-09 jj5 - if you need to add roles for your application, start
    // with enum value = 255 and count down from there, and use uppercase
    // a_role_char and a_role_code values.

    def_tab( 't_lookup_std_role' );

    def_key( 'a_std_role_enum', DBT_UINT8 );
    def_col( 'a_std_role_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_role_code', DBT_ASCII_BIN );
    def_col( 'a_std_role_name', DBT_UTF8_CI );
    def_col( 'a_std_role_note', DBT_UTF8_CI );
    def_col( 'a_std_role_created_on', DBT_CREATED_ON );
    def_col( 'a_std_role_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_role_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_role_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_role',
      [
        'a_std_role_enum' => null,
        'a_std_role_char' => null,
        'a_std_role_code' => null,
        'a_std_role_name' => null,
        'a_std_role_note' => null,
      ], [
      [ 0,                      '?', '',                      '',               ''                                    ],
      [ MudRole::USER,          'u', MUD_ROLE_USER,           'User',           'Users of the system; everyone'       ],
      [ MudRole::ADMINISTRATOR, 'a', MUD_ROLE_ADMINISTRATOR,  'Administrator',  'Users who can administer the system' ],
      [ MudRole::PROGRAMMER,    'p', MUD_ROLE_PROGRAMMER,     'Programmer',     'Programmers of the system software'  ],
      [ MudRole::TESTER,        't', MUD_ROLE_TESTER,         'Tester',         'Testers of the system software'      ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_table_pattern
  //

  protected function define_t_lookup_std_table_pattern() {

    def_tab( 't_lookup_std_table_pattern' );

    def_key( 'a_std_table_pattern_enum', DBT_UINT8 );
    def_col( 'a_std_table_pattern_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_table_pattern_code', DBT_ASCII_CI );
    def_col( 'a_std_table_pattern_link', DBT_ASCII_CI );
    def_col( 'a_std_table_pattern_created_on', DBT_CREATED_ON );
    def_col( 'a_std_table_pattern_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_table_pattern_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_table_pattern_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_table_pattern',
      [
        'a_std_table_pattern_enum' => null,
        'a_std_table_pattern_char' => null,
        'a_std_table_pattern_code' => null,
        'a_std_table_pattern_link' => '',
      ], [
      /*
      [ 0,                          '?', '' ],
      [ MudTablePattern::ABOUT,     'a', MUD_TABLE_PATTERN_ABOUT,     'https://www.progclub.org/wiki/database_patterns#about'     ],
      [ MudTablePattern::LOOKUP,    'k', MUD_TABLE_PATTERN_LOOKUP,    'https://www.progclub.org/wiki/database_patterns#lookup'    ],
      //[ MudTablePattern::MFLAGS,    'f', MUD_TABLE_PATTERN_MFLAGS,    'https://www.progclub.org/wiki/database_patterns#mflags'    ],
      [ MudTablePattern::IDENT,     'i', MUD_TABLE_PATTERN_IDENT,     'https://www.progclub.org/wiki/database_patterns#ident'     ],
      [ MudTablePattern::PARTICLE,  'p', MUD_TABLE_PATTERN_PARTICLE,  'https://www.progclub.org/wiki/database_patterns#particle'  ],
      [ MudTablePattern::PSTRING,   's', MUD_TABLE_PATTERN_PSTRING,   'https://www.progclub.org/wiki/database_patterns#pstring'   ],
      [ MudTablePattern::TEXTDATA,  't', MUD_TABLE_PATTERN_TEXTDATA,  'https://www.progclub.org/wiki/database_patterns#textdata'  ],
      [ MudTablePattern::UPLOAD,    'u', MUD_TABLE_PATTERN_UPLOAD,    'https://www.progclub.org/wiki/database_patterns#upload'    ],
      [ MudTablePattern::ZBLOB,     'b', MUD_TABLE_PATTERN_ZBLOB,     'https://www.progclub.org/wiki/database_patterns#zblob'     ],
      [ MudTablePattern::ZTEXT,     'z', MUD_TABLE_PATTERN_ZTEXT,     'https://www.progclub.org/wiki/database_patterns#ztext'     ],
      [ MudTablePattern::ZJSON,     'j', MUD_TABLE_PATTERN_ZJSON,     'https://www.progclub.org/wiki/database_patterns#jzon'     ],
      [ MudTablePattern::STRUCTURE, 'r', MUD_TABLE_PATTERN_STRUCTURE, 'https://www.progclub.org/wiki/database_patterns#structure' ],
      [ MudTablePattern::ENTITY,    'e', MUD_TABLE_PATTERN_ENTITY,    'https://www.progclub.org/wiki/database_patterns#entity'    ],
      [ MudTablePattern::HISTORY,   'h', MUD_TABLE_PATTERN_HISTORY,   'https://www.progclub.org/wiki/database_patterns#history'   ],
      [ MudTablePattern::LOG,       'l', MUD_TABLE_PATTERN_LOG,       'https://www.progclub.org/wiki/database_patterns#log'       ],
      [ MudTablePattern::OTHER,     'o', MUD_TABLE_PATTERN_OTHER,     'https://www.progclub.org/wiki/database_patterns#other'     ],
      */
      [ 0,                            '?', '' ],
      [ MudTablePattern::LOOKUP,      'k', MUD_TABLE_PATTERN_LOOKUP,      'https://www.progclub.org/wiki/database_patterns#lookup'      ],
      [ MudTablePattern::STATIC,      's', MUD_TABLE_PATTERN_STATIC,      'https://www.progclub.org/wiki/database_patterns#static'      ],
      [ MudTablePattern::ABOUT,       'b', MUD_TABLE_PATTERN_ABOUT,       'https://www.progclub.org/wiki/database_patterns#about'       ],
      [ MudTablePattern::CONFIG,      'c', MUD_TABLE_PATTERN_CONFIG,      'https://www.progclub.org/wiki/database_patterns#config'      ],
      [ MudTablePattern::DETAIL,      'd', MUD_TABLE_PATTERN_DETAIL,      'https://www.progclub.org/wiki/database_patterns#detail'      ],
      [ MudTablePattern::IDENT,       't', MUD_TABLE_PATTERN_IDENT,       'https://www.progclub.org/wiki/database_patterns#ident'       ],
      [ MudTablePattern::PARTICLE,    'a', MUD_TABLE_PATTERN_PARTICLE,    'https://www.progclub.org/wiki/database_patterns#particle'    ],
      [ MudTablePattern::PIECE,       'i', MUD_TABLE_PATTERN_PIECE,       'https://www.progclub.org/wiki/database_patterns#piece'       ],
      [ MudTablePattern::POT,         'o', MUD_TABLE_PATTERN_POT,         'https://www.progclub.org/wiki/database_patterns#pot'         ],
      [ MudTablePattern::PRODUCT,     'r', MUD_TABLE_PATTERN_PRODUCT,     'https://www.progclub.org/wiki/database_patterns#product'     ],
      //[ MudTablePattern::VALUE,     'v', MUD_TABLE_PATTERN_VALUE,       'https://www.progclub.org/wiki/database_patterns#value'       ],
      //[ MudTablePattern::DOMAIN,    'd', MUD_TABLE_PATTERN_DOMAIN,      'https://www.progclub.org/wiki/database_patterns#domain'      ],
      [ MudTablePattern::ENTITY,      'e', MUD_TABLE_PATTERN_ENTITY,      'https://www.progclub.org/wiki/database_patterns#entity'      ],
      [ MudTablePattern::HISTORY,     'h', MUD_TABLE_PATTERN_HISTORY,     'https://www.progclub.org/wiki/database_patterns#history'     ],
      [ MudTablePattern::EPHEMERAL,   'm', MUD_TABLE_PATTERN_EPHEMERAL,   'https://www.progclub.org/wiki/database_patterns#ephemeral'   ],
      [ MudTablePattern::EVENT,       'v', MUD_TABLE_PATTERN_EVENT,       'https://www.progclub.org/wiki/database_patterns#event'       ],
      [ MudTablePattern::LOG,         'l', MUD_TABLE_PATTERN_LOG,         'https://www.progclub.org/wiki/database_patterns#log'         ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_token_status
  //

  protected function define_t_lookup_std_token_status() {

    def_tab( 't_lookup_std_token_status' );

    def_key( 'a_std_token_status_enum', DBT_UINT8 );
    def_col( 'a_std_token_status_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_token_status_code', DBT_ASCII_CI );
    def_col( 'a_std_token_status_name', DBT_UTF8_CI );
    def_col( 'a_std_token_status_note', DBT_UTF8_CI );
    def_col( 'a_std_token_status_created_on', DBT_CREATED_ON );
    def_col( 'a_std_token_status_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_token_status_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_token_status_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_token_status',
      [
        'a_std_token_status_enum' => null,
        'a_std_token_status_char' => null,
        'a_std_token_status_code' => null,
        'a_std_token_status_name' => null,
        'a_std_token_status_note' => null,
      ], [
      [ 0,                        '?',  '',                       '',                   ''                                  ],
      [ MudTokenStatus::OPEN,     'o',  MUD_TOKEN_STATUS_OPEN,    'Token is open',      'Token is active, but check expiry' ],
      [ MudTokenStatus::USED,     'u',  MUD_TOKEN_STATUS_USED,    'Token is used',      'Token has been used'               ],
      [ MudTokenStatus::EXPIRED,  'x',  MUD_TOKEN_STATUS_EXPIRED, 'Token has expired',  'Token was accessed after expiry'   ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_token_type
  //

  protected function define_t_lookup_std_token_type() {

    def_tab( 't_lookup_std_token_type' );

    def_key( 'a_std_token_type_enum', DBT_UINT8 );
    def_col( 'a_std_token_type_char', DBT_ASCII_CHAR_BIN );
    def_col( 'a_std_token_type_code', DBT_ASCII_CI );
    def_col( 'a_std_token_type_name', DBT_UTF8_CI );
    def_col( 'a_std_token_type_note', DBT_UTF8_CI );
    def_col( 'a_std_token_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_token_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_token_type_char' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_token_type_code' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_token_type_name' ], MUD_IDX_UNIQUE );

    def_dat( 't_lookup_std_token_type',
      [
        'a_std_token_type_enum' => null,
        'a_std_token_type_char' => null,
        'a_std_token_type_code' => null,
        'a_std_token_type_name' => null,
        'a_std_token_type_note' => null,
      ], [
      [ 0,                              '?', '',                              '',                   '' ],
      [ MudTokenType::BROWSER,          'b', MUD_TOKEN_TYPE_BROWSER,          'Browser Token',      'Identifies a web browser' ],
      [ MudTokenType::SESSION,          's', MUD_TOKEN_TYPE_SESSION,          'Session Token',      'Identifies a web session' ],
      [ MudTokenType::XSRF,             'x', MUD_TOKEN_TYPE_XSRF,             'XSRF Token',         'Protects a web session' ],
      [ MudTokenType::CREDENTIAL_RESET, 'r', MUD_TOKEN_TYPE_CREDENTIAL_RESET, 'Credential reset',     'Authorises a user password reset' ],
      [ MudTokenType::EMAIL_VERIFY,     'e', MUD_TOKEN_TYPE_EMAIL_VERIFY,     'Email verification', 'Authorises a user email verification' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_lookup_std_uri_scheme
  //

  protected function define_t_lookup_std_uri_scheme() {

    def_tab( 't_lookup_std_uri_scheme' );

    def_key( 'a_std_uri_scheme_enum', DBT_UINT16 );
    def_col( 'a_std_uri_scheme_code', DBT_ASCII_CI );
    def_col( 'a_std_uri_scheme_standard_port', DBT_UINT16 );
    def_col( 'a_std_uri_scheme_created_on', DBT_CREATED_ON );
    def_col( 'a_std_uri_scheme_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_uri_scheme_code' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_uri_scheme_standard_port' ], MUD_IDX_INDEX );

    require_once __DIR__ . '/../../../../../gen/uri-scheme/uri-scheme-schema.php';

  }
}
