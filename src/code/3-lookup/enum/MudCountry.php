<?php

(function( $include ) {

  if ( is_file( $include ) ) { require_once $include; }

})( __DIR__ . '/../../../gen/country-code/country-code-enum.php' );
