<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - t_abinitio_std_interaction
//

add_abinitio( 'interaction', 'i' )->

  add_key( 'aid', DBT_AID )->
  add_col( 'xid', DBT_XID )->
  add_col( 'microtime', DBT_DOUBLE )->
  add_col( 'created_on', DBT_CREATED_ON )->
  add_col( 'updated_on', DBT_UPDATED_ON )->

  add_idx( [ 'xid' ], IDX_UNIQUE );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - t_lookup_std_auth_event
//

add_lookup( 'auth_event' )->

  add_key( 'enum', DBT_UINT8 )->
  add_col( 'char', DBT_ASCII_CHAR_BIN )->
  add_col( 'code', DBT_ASCII_CI )->
  add_col( 'name', DBT_UTF8_CI )->
  add_col( 'note', DBT_UTF8_CI )->
  add_col( 'created_on', DBT_CREATED_ON )->
  add_col( 'updated_on', DBT_UPDATED_ON )->

  add_idx( [ 'char' ], IDX_UNIQUE )->
  add_idx( [ 'code' ], IDX_UNIQUE )->

  add_dat(
    [
      'enum' => null,
      'char' => null,
      'code' => null,
      'name' => null,
      'note' => null,
    ],
    [
      [ 0,                          '?', '',                          '',                 ''                                                          ],
      [ MudAuthEvent::LOGIN,        'i', MUD_AUTH_EVENT_LOGIN,        'Login',            'user logged in'                                            ],
      [ MudAuthEvent::SIGNUP,       's', MUD_AUTH_EVENT_SIGNUP,       'Signup',           'user signed up; automatically logged in'                   ],
      [ MudAuthEvent::LOGOUT,       'x', MUD_AUTH_EVENT_LOGOUT,       'Logout',           'user logged out'                                           ],
      [ MudAuthEvent::DEACTIVATED,  'd', MUD_AUTH_EVENT_DEACTIVATED,  'User deactivated', 'user was logged out because of user account deactivation'  ],
      [ MudAuthEvent::FORGOT,       'f', MUD_AUTH_EVENT_FORGOT,       'Forgot password',  'user forgot their password and we sent them a reset link'  ],
      [ MudAuthEvent::RESET,        'r', MUD_AUTH_EVENT_RESET,        'Password reset',   'user successfully reset their password'                    ],
    ]
  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - t_lookup_std_connection_type
//

add_lookup( 'connection_type' )->

  add_key( 'enum', DBT_UINT8 )->
  add_col( 'char', DBT_ASCII_CHAR_BIN )->
  add_col( 'code', DBT_ASCII_CI )->
  add_col( 'name', DBT_UTF8_CI )->
  add_col( 'note', DBT_UTF8_CI )->
  add_col( 'created_on', DBT_CREATED_ON )->
  add_col( 'updated_on', DBT_UPDATED_ON )->

  add_idx( [ 'char' ], IDX_UNIQUE )->
  add_idx( [ 'code' ], IDX_UNIQUE )->

  add_dat(
    [
      'enum' => null,
      'char' => null,
      'code' => null,
      'name' => '',
      'note' => '',
    ],
    [
      [ 0,                      '?', ''                                                                                                         ],
      [ MudConnectionType::RAW, 'r', MUD_CONNECTION_TYPE_RAW, 'Raw connection (raw)',             'autocommit on'                               ],
      [ MudConnectionType::TRN, 't', MUD_CONNECTION_TYPE_TRN, 'Transaction connection (trn)',     'autocommit off'                              ],
      [ MudConnectionType::EMU, 'm', MUD_CONNECTION_TYPE_EMU, 'Emulated connection (emu)',        'autocommit on; emulated prepares'            ],
      [ MudConnectionType::AUX, 'x', MUD_CONNECTION_TYPE_AUX, 'Auxiliary connection (aux)',       'isolation level and autocommit unspecified'  ],
      [ MudConnectionType::DBA, 'a', MUD_CONNECTION_TYPE_DBA, 'Administration connection (dba)',  'for schema modification'                     ],
    ]
  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - t_lookup_std_cookie_type
//

add_lookup( 'cookie_type' )->

  add_key( 'enum', DBT_UINT8 )->
  add_col( 'char', DBT_ASCII_CHAR_BIN )->
  add_col( 'code', DBT_ASCII_CI )->
  add_col( 'name', DBT_UTF8_CI )->
  add_col( 'note', DBT_UTF8_CI )->
  add_col( 'created_on', DBT_CREATED_ON )->
  add_col( 'updated_on', DBT_UPDATED_ON )->

  add_idx( [ 'char' ], IDX_UNIQUE )->
  add_idx( [ 'code' ], IDX_UNIQUE )->

  add_dat(
    [
      'enum' => null,
      'char' => null,
      'code' => null,
      'name' => null,
      'note' => null,
    ],
    [
      [ 0,                      '?',  '',                       '',                ''                                   ],
      [ MudCookieType::SETTING, 'p',  MUD_COOKIE_TYPE_SETTING,  'Setting cookie',  'remembers user cookie preferences'  ],
      [ MudCookieType::SESSION, 's',  MUD_COOKIE_TYPE_SESSION,  'Session cookie',  'identifies a web session'           ],
      [ MudCookieType::BROWSER, 'b',  MUD_COOKIE_TYPE_BROWSER,  'Browser cookie',  'identifies a web browser'           ],
    ]
  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - t_lookup_std_country
//

// 2021-04-13 jj5 - so what you need to know about this table is that the best display order
// is sorted by a_std_country_natural_sort (which is an alias for a_std_country_item_ascii)
// and the best country label is a_std_country_item_html or the UTF-8 equivalent
// a_std_country_item.

// 2021-04-13 jj5 - SEE: List of ISO 3166 country codes:
// https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes

// 2021-04-13 jj5 - SEE: https://www.iban.com/country-codes

add_lookup( 'country' )->

  add_key( 'enum', DBT_UINT8 )->
  add_col( 'alpha_2', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 2 ] )->
  add_col( 'alpha_3', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 3 ] )->
  add_col( 'numeric_code', DBT_ASCII_CHAR_CI, [ SPEC_MAX => 3 ] )->
  add_col( 'numeric_value', DBT_UINT16 )->
  add_col( 'is_using_full_name', DBT_BOOL )->
  add_col( 'name', DBT_UTF8_CI )->
  add_col( 'name_ascii', DBT_ASCII_CI )->
  add_col( 'full_name', DBT_UTF8_CI )->
  add_col( 'full_name_ascii', DBT_ASCII_CI )->
  add_col( 'short_name', DBT_UTF8_CI )->
  add_col( 'short_name_ascii', DBT_ASCII_CI )->
  add_col( 'item', DBT_UTF8_CI )->
  add_col( 'item_ascii', DBT_ASCII_CI )->
  add_col( 'item_html', DBT_ASCII_CI )->
  add_col( 'qualifier', DBT_UTF8_CI )->
  add_col( 'qualifier_ascii', DBT_ASCII_CI )->
  add_col( 'naked_qualifier', DBT_UTF8_CI )->
  add_col( 'naked_qualifier_ascii', DBT_ASCII_CI )->
  add_col( 'natural_sort', DBT_ASCII_CI )->
  add_col( 'created_on', DBT_CREATED_ON )->
  add_col( 'updated_on', DBT_UPDATED_ON )->

  add_idx( [ 'alpha_2' ], IDX_UNIQUE )->
  add_idx( [ 'alpha_3' ], IDX_UNIQUE )->
  add_idx( [ 'numeric_code' ], IDX_UNIQUE )->
  add_idx( [ 'numeric_value' ], IDX_UNIQUE )->

  add_php( MUD_PATH . '/src/gen/country-code/country-code.php' );
