<?php declare(strict_types=1);

trait MudHttpOutputCache {

  public function cache_forever() {

    $expiry_time = strtotime( '+10 years' );
    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', $expiry_time ) . ' GMT' );
    header( 'Cache-Control: max-age=' . ( 10 * 365 * 24 * 60 * 60 ) . ', public' ); // 10 years in seconds
    header( 'Pragma: cache' );

  }
}
