<?php

require_once __DIR__ . '/3-enum.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-24 jj5 - t_lookup_std_crud_flags
//

define( 'FLAG_IS_CRUD_CREATE',    pow( 2, 0 ) );
define( 'FLAG_IS_CRUD_RETRIEVE',  pow( 2, 1 ) );
define( 'FLAG_IS_CRUD_UPDATE',    pow( 2, 2 ) );
define( 'FLAG_IS_CRUD_DELETE',    pow( 2, 3 ) );
define( 'FLAG_IS_CRUD_UNDELETE',  pow( 2, 4 ) );
define( 'FLAG_IS_CRUD_SHRED',     pow( 2, 5 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - t_lookup_std_server_flags
//

define( 'FLAG_IS_WEB_SERVER',       pow( 2, 0 ) );
define( 'FLAG_IS_DATABASE_SERVER',  pow( 2, 1 ) );
define( 'FLAG_IS_FILE_SERVER',      pow( 2, 2 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_user_flags
//

define( 'FLAG_IS_USER_ACTIVE',            pow( 2, 0 ) );
define( 'FLAG_IS_USER_EMAIL_VERIFIED',    pow( 2, 1 ) );
define( 'FLAG_IS_USER_USERNAME_VERIFIED', pow( 2, 2 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - t_lookup_std_record_flags
//

define( 'FLAG_IS_RECORD_NEW',     pow( 2, 0 ) );
define( 'FLAG_IS_RECORD_DELETED', pow( 2, 1 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_browser_flags
//

define( 'FLAG_IS_BROWSER_VERIFIED', pow( 2, 0 ) );
define( 'FLAG_IS_BROWSER_SPAMMER',  pow( 2, 1 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_session_flags
//

define( 'FLAG_IS_SESSION_VERIFIED', pow( 2, 0 ) );
define( 'FLAG_IS_SESSION_SPAMMER',  pow( 2, 1 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_cookie_flags
//

define( 'FLAG_IS_COOKIE_SECURE',    pow( 2, 0 ) );
define( 'FLAG_IS_COOKIE_HTTP_ONLY', pow( 2, 1 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_web_response_flags
//

// 2020-09-21 jj5 - NOTE: we are compatible with the PHP connection_status() flags...
//
define( 'FLAG_IS_WEB_RESPONSE_CONNECTION_ABORT',    CONNECTION_ABORTED ); // pow( 2, 0 )
define( 'FLAG_IS_WEB_RESPONSE_CONNECTION_TIMEOUT',  CONNECTION_TIMEOUT ); // pow( 2, 1 )


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-22 jj5 - t_lookup_std_prefspec_flags
//

define( 'FLAG_IS_PREF_NULL_ALLOWED',    pow( 2, 0 ) );
define( 'FLAG_IS_PREF_BOOL_ALLOWED',    pow( 2, 1 ) );
define( 'FLAG_IS_PREF_INT_ALLOWED',     pow( 2, 2 ) );
define( 'FLAG_IS_PREF_FLOAT_ALLOWED',   pow( 2, 3 ) );
define( 'FLAG_IS_PREF_STRING_ALLOWED',  pow( 2, 4 ) );
define( 'FLAG_IS_PREF_OTHER_ALLOWED',   pow( 2, 5 ) );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-29 jj5 - t_lookup_std_interaction_flags
//

define( 'FLAG_IS_INTERACTION_LIVE', 0 );
define( 'FLAG_IS_INTERACTION_DONE', pow( 2, 0 ) );
define( 'FLAG_IS_INTERACTION_FAIL', pow( 2, 1 ) );
