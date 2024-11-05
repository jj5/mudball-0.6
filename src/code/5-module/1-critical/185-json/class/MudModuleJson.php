<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleJson extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  public function json_canonical( $data ) : string {

    return $this->get_json( $data, MUD_JSON_CANONICAL );

  }

  public function json_pretty( $data, int $opts = 0 ) : string {

    return $this->get_json( $data, MUD_JSON_PRETTY | $opts );

  }

  public function json_compact( $data, int $opts = 0 ) : string {

    return $this->get_json( $data, MUD_JSON_COMPACT | $opts );

  }

  public function json_ascii( $data, int $opts = 0 ) : string {

    return $this->get_json( $data, MUD_JSON_ASCII | $opts );

  }

  public function json_embed( $data, int $opts = 0 ) : string {

    return $this->get_json( $data, MUD_JSON_EMBED | $opts );

  }

  public function json_decode( string $json, $ignore_error = false, $default = null ) {

    $data = json_decode( $json, $assoc = true );

    $error = json_last_error();

    if ( ! $error ) { return $data; }

    if ( $ignore_error ) { return $default; }

    mud_fail(
      MUD_ERR_JSON_DECODING_ERROR,
      [
        'error' => $error,
        'error_msg' => json_last_error_msg(),
      ]
    );

  }

  public function jzon_encode( $data, &$json = null, int $level = 9, $redact = false ) {

    if ( $redact ) {

      $data = mud_redact_secrets( $data );

    }
    else if ( DEBUG && $data !== mud_redact_secrets( $data ) ) {

      mud_log_4_warning( 'secret data may have been encoded.' );

    }

    return $this->json_gzip_encode( $data, $level, $json );

  }

  public function jzon_decode( string $jzon ) {

    return $this->json_gzip_decode( $jzon );

  }

  public function json_gzip_encode( $data, int $level = 9, &$json = null ) {

    // 2019-12-30 jj5 - SEE: Which compression method to use in PHP?:
    // https://stackoverflow.com/q/621976

    $json = mud_json_canonical( $data );

    // 2022-04-09 jj5 - NEW: this uses more data... but it's compatible with gzip and has
    // checksums and such...
    //
    $blob = gzencode( $json, $level );
    // 2019-12-30 jj5 - OLD: this is more compact... but shit.
    //$blob = gzdeflate( $json, $level );

    if ( $blob === false ) {

      mud_fail( MUD_ERR_JSON_GZDEFLATE_ERROR );

    }

    return $blob;

  }

  public function json_gzip_decode_pretty( string $blob, &$json = null ) {

    $data = $this->json_gzip_decode( $blob );

    $json = mud_json_pretty( $data );

    return $data;

  }

  public function json_gzip_decode( string $compressed, &$json = null ) {

    $json = gzdecode( $compressed );

    if ( $json === false ) {

      mud_fail( MUD_ERR_JSON_GZINFLATE_ERROR );

    }

    $data = mud_json_decode( $json );

    return $data;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - protected functions...
  //

  protected function get_json( $data, int $opts ) : string {

    // 2021-03-04 jj5 - NOTE: we have to do error checking the manual way because
    // JSON_THROW_ON_ERROR is not defined until PHP 7.3 (and we're still supporting 7.2).

    $json = json_encode( $data, $opts );

    $error = json_last_error();

    if ( ! $error ) { return $json; }

    if ( mud_has_flag( $opts, JSON_PARTIAL_OUTPUT_ON_ERROR ) ) {

      return $json;

    }

    mud_fail(
      MUD_ERR_JSON_ENCODING_ERROR,
      [
        'error' => $error,
        'error_msg' => json_last_error_msg(),
      ]
    );

  }
}
