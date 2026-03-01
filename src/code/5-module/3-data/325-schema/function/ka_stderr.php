<?php

function ka_stderr( $output ) {

  fwrite( STDERR, $output );

}
