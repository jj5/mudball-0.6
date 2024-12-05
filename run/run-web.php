<?php

require_once __DIR__ . '/../inc/module.php';

if ( function_exists( 'app_render' ) ) {

  // 2024-10-21 jj5 - TODO: think about how app_submit() might work...

  // 2024-09-29 jj5 - TODO: handle app_submit() for HTTP POST requests...

  $path_info = explode( '/', $_SERVER['PATH_INFO'] ?? '' );

  return app_render( $path_info );

}
else {

  app()->run();

}
