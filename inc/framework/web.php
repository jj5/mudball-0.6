<?php

require_once __DIR__ . '/../module.php';

<<<<<<< HEAD
if ( function_exists( 'app_render' ) ) {

  // 2024-10-21 jj5 - TODO: think about how app_submit() might work...

  app_render();

}
else {

  $controller = new MudControllerWeb();

  $controller->run();
=======
function run( $controller ) {

  //var_dump( $controller ); exit;

  return $controller->run();
>>>>>>> e3a066e (Work, work...)

}
