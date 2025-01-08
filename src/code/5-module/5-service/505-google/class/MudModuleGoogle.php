<?php

use Google\Client as GoogleClient;
use Google\Service\YouTube;

class MudModuleGoogle extends MudModuleService {

  /**
  * Returns an authorized API client.
  * (Will prompt for authorization if no valid token is stored locally)
  */
  public function new_google_client( string $application_name ) : GoogleClient {

    $client = new GoogleClient();
    $client->setApplicationName( $application_name );
    $client->setScopes([
        // We only need read-only access to YouTube here
        YouTube::YOUTUBE_UPLOAD,
        YouTube::YOUTUBE_FORCE_SSL,
    ]);
    // For command line, you can set this as an "Other" or "Desktop" app
    $client->setAuthConfig([
        'client_id' => APP_GOOGLE_CLIENT_ID,
        'client_secret' => APP_GOOGLE_CLIENT_SECRET,
        'redirect_uris' => ['urn:ietf:wg:oauth:2.0:oob', APP_GOOGLE_CLIENT_URL],
    ]);

    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    $client->setIncludeGrantedScopes(true);

    // Load previously authorized credentials from a file.
    if (file_exists(APP_GOOGLE_CREDENTIALS_PATH)) {
        $accessToken = json_decode(file_get_contents(APP_GOOGLE_CREDENTIALS_PATH), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired, prompt the user
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print "Enter verification code: ";
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            // Check for errors
            if (isset($accessToken['error'])) {
                throw new Exception("Error fetching OAuth tokens: " . $accessToken['error']);
            }
        }
        // Save the token to a file
        file_put_contents(APP_GOOGLE_CREDENTIALS_PATH, json_encode($client->getAccessToken()));
    }

    return $client;

  }

  public function get_youtube_playlist_list( YouTube $youtube ) : array {

    $result = [];

    $response = $youtube->playlists->listPlaylists( 'snippet,contentDetails', [
      'mine' => true,
      'maxResults' => 50,
    ]);

    $result = $response->getItems();

    $nextPageToken = $response->getNextPageToken();

    while ( $nextPageToken !== null ) {

      $response = $youtube->playlists->listPlaylists('snippet,contentDetails', [
          'mine'       => true,
          'maxResults' => 50,
          'pageToken'  => $nextPageToken,
      ]);

      $result = array_merge( $result, $response->getItems() );

      $nextPageToken = $response->getNextPageToken();

    }

    return $this->sort_playlist_list( $result );

  }

  public function get_youtube_playlist_video_list( YouTube $youtube, $playlist ) : array {

    $result = [];

    $response = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails,status', [
        'playlistId' => $playlist[ 'id' ],
        'maxResults' => 50  // Maximum allowed by YouTube Data API
    ]);

    $result = $response->getItems();

    $nextPageToken = $response->getNextPageToken();

    while ( $nextPageToken !== null ) {

      $response = $youtube->playlistItems->listPlaylistItems( 'snippet,contentDetails,status', [
          'playlistId' => $playlist[ 'id' ],
          'maxResults' => 50,
          'pageToken'  => $nextPageToken,
      ]);

      $result = array_merge( $result, $response->getItems() );

      $nextPageToken = $response->getNextPageToken();

    }

    return $this->sort_video_list( $this->filter_public_video( $result ), $playlist );

  }

  public function filter_public_playlist( $playlist_list ) {

    return array_filter( $playlist_list, function( $playlist ) {

      return $playlist->getStatus()->getPrivacyStatus() === 'public';

    });

  }

  public function filter_public_video( $video_list ) {

    return array_filter( $video_list, function( $video ) {

      return $video->getStatus()->getPrivacyStatus() === 'public';

    });

  }

  public function sort_playlist_list( $playlist_list ) {

    usort( $playlist_list, function( $a, $b ) {

      return strcmp( $a->getSnippet()->getTitle(), $b->getSnippet()->getTitle() );

    });

    return $playlist_list;

  }

  public function sort_video_list( $video_list, $playlist ) {

    $sort_type = $this->get_sort_type( $playlist );

    switch ( $sort_type ) {

      case 'by-number':

        return $this->sort_video_list_by_number( $video_list );

      case 'by-number-reverse':

        return $this->sort_video_list_by_number_reverse( $video_list );

      case 'newest-first':

        return $this->sort_video_list_newest_first( $video_list );

      default:

        return $video_list;

    }
  }

  public function sort_video_list_by_number( $video_list ) {

    usort( $video_list, function( $a, $b ) {

      return $this->get_video_number( $a ) - $this->get_video_number( $b );

    });

    return $video_list;

  }

  public function sort_video_list_by_number_reverse( $video_list ) {

    usort( $video_list, function( $a, $b ) {

      return $this->get_video_number( $b ) - $this->get_video_number( $a );

    });

    return $video_list;

  }

  public function sort_video_list_newest_first( $video_list ) {

    usort( $video_list, function( $a, $b ) {

      return $this->get_video_timestamp( $b ) - $this->get_video_timestamp( $a );

    });

    return $video_list;

  }

  public function get_sort_type( $playlist ) {

    static $by_number = [
      'Maxitronix',
    ];

    static $by_number_reverse = [
      'Channel News', 'Demo', 'Early Content', 'Electronics Project', 'Interlude', 'Mail Call', 'Mini Project',
      'New Book Teardown', 'Old Book Teardown', 'Unboxing',
    ];

    $title = $playlist->getSnippet()->getTitle();

    foreach ( $by_number as $prefix ) {

      if ( strpos( $title, $prefix ) === 0 ) { return 'by-number'; }

    }

    foreach ( $by_number_reverse as $prefix ) {

      if ( strpos( $title, $prefix ) === 0 ) { return 'by-number-reverse'; }

    }

    return 'newest-first';

  }

  public function get_video_number( $video ) {

    $title = $video->getSnippet()->getTitle();

    if ( preg_match( '|#(\d+):|', $title, $matches ) ) {

      return (int) $matches[ 1 ];

    }

    if ( preg_match( '| (\d+)/(\d+) |', $title, $matches ) ) {

      return (int) $matches[ 1 ];

    }

    if ( preg_match( '| JMP(\d+) |', $title, $matches ) ) {

      return (int) ltrim( $matches[ 1 ], '0' );

    }

    if ( preg_match( '|Introducing |', $title, $matches ) ) {

      return 0;

    }

    if ( preg_match( '|Concluding Maxitronix (\d+)in1|', $title, $matches ) ) {

      return $matches[ 1 ] + 1;

    }

    $datetime = new DateTime( $video->getSnippet()->getPublishedAt() );

    return $datetime->getTimestamp();

  }

  public function get_video_timestamp( $video ) {

    $datetime = new DateTime( $video->getSnippet()->getPublishedAt() );

    return $datetime->getTimestamp();

  }
}
