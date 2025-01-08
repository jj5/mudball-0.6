<?php

// 2025-01-08 jj5 - you will need to include the Google API client library in your project...
//
// $ composer require google/apiclient


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-01-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../500-service/mud_service.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-01-08 jj5 - module errors...
//



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-01-08 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleGoogle.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-01-08 jj5 - service interface...
//

use Google\Client as GoogleClient;
use Google\Service\YouTube;

function new_mud_google_client( string $application_name ) : GoogleClient {

  return mud_module_google()->new_google_client( $application_name );

}

function mud_get_youtube_playlist_list( YouTube $youtube ) : array {

  return mud_module_google()->get_youtube_playlist_list( $youtube );

}

function mud_get_youtube_playlist_video_list( YouTube $youtube, $playlist ) : array {

  return mud_module_google()->get_youtube_playlist_video_list( $youtube, $playlist );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-01-08 jj5 - service locator...
//

function mud_module_google() : MudModuleGoogle {

  return mud_locator()->get_module( MudModuleGoogle::class );

}
