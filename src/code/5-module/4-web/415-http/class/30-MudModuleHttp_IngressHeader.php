<?php declare(strict_types=1);

class MudModuleHttp_IngressHeader extends MudModuleHttp_IngressNormalization {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-10-24 jj5 - protected fields...
  //

  protected ?string $client_ip = null;
  protected ?string $referrer = null;
  protected ?string $user_agent = null;
  protected ?bool $is_mobile = null;
  protected ?array $trusted_proxy_list = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-10-24 jj5 - public methods....
  //

  public function get_client_ip() : string {

    if ( $this->client_ip === null ) {

      $this->client_ip = $this->read_client_ip();

    }

    return $this->client_ip;

  }

  public function get_referrer() : ?string {

    if ( $this->referrer === null ) {

      $this->referrer = mud_http_get_server( 'HTTP_REFERER' );

      if ( $this->referrer === null ) {

        $this->referrer = mud_http_get_server( 'HTTP_REFERRER' );

      }
    }

    return $this->referrer;

  }

  public function get_user_agent() : ?string {

    if ( $this->user_agent === null ) {

      $this->user_agent = mud_http_get_server( 'HTTP_USER_AGENT' );

    }

    return $this->user_agent;

  }

  public function is_mobile() : bool {

    if ( $this->is_mobile === null ) {

      $browser = (string) $this->get_user_agent();

      $this->is_mobile =
        stripos( $browser, 'ipad' ) !== false ||
        stripos( $browser, 'iphone' ) !== false ||
        stripos( $browser, 'android' ) !== false ||
        stripos( $browser, 'windows mobile' ) !== false;

    }

    return $this->is_mobile;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-10-24 jj5 - protected methods...
  //

  protected function get_canonical_ip(
    ?string $input,
    &$IPv4 = null, &$IPv4_int = null, &$IPv4_bin = null,
    &$IPv6 = null, &$IPv6_bin = null
  ) : ?string {

    // 2026-10-24 jj5 - returns null (with all out params null) if $input isn't a valid IP address. IPv4-mapped IPv6
    // addresses (e.g. '::ffff:1.2.3.4') are canonicalized to IPv4 so one client doesn't have two canonical forms.

    $IPv4 = null;
    $IPv4_int = null;
    $IPv4_bin = null;
    $IPv6 = null;
    $IPv6_bin = null;

    $ip = strtolower( trim( (string) $input ) );

    if ( $ip === '' ) { $ip = '0.0.0.0'; }

    // 2026-10-24 jj5 - strip brackets and port from '[::1]' or '[::1]:443', and port from '1.2.3.4:8080'...
    //
    if ( preg_match( '/^\[([^\]]+)\](?::\d+)?$/', $ip, $match ) ) {

      $ip = $match[ 1 ];

    }
    else if ( preg_match( '/^(\d+\.\d+\.\d+\.\d+):\d+$/', $ip, $match ) ) {

      $ip = $match[ 1 ];

    }

    // 2026-10-24 jj5 - strip IPv6 zone ID, e.g. 'fe80::1%eth0'...
    //
    $zone_pos = strpos( $ip, '%' );

    if ( $zone_pos !== false ) { $ip = substr( $ip, 0, $zone_pos ); }

    if ( filter_var( $ip, FILTER_VALIDATE_IP ) === false ) { return null; }

    $bin = inet_pton( $ip );

    if ( strlen( $bin ) === 16 && strncmp( $bin, str_repeat( "\0", 10 ) . "\xff\xff", 12 ) === 0 ) {

      $bin = substr( $bin, 12 );

    }

    if ( strlen( $bin ) === 4 ) {

      $IPv4_bin = $bin;
      $IPv4 = inet_ntop( $IPv4_bin );
      $IPv4_int = ip2long( $IPv4 );

      $IPv6_bin = str_repeat( "\0", 10 ) . "\xff\xff" . $IPv4_bin;
      $IPv6 = inet_ntop( $IPv6_bin );

      return $IPv4;

    }

    $IPv6_bin = $bin;
    $IPv6 = inet_ntop( $IPv6_bin );

    return $IPv6;

  }

  public function is_trusted_proxy( string $ip ) : bool {

    // 2026-10-24 jj5 - blank input would canonicalize to 0.0.0.0, which isn't an address we should ever trust by accident...
    //
    if ( trim( $ip ) === '' ) { return false; }

    if ( $this->get_canonical_ip( $ip, $IPv4, $IPv4_int, $IPv4_bin, $IPv6, $IPv6_bin ) === null ) { return false; }

    $ip_bin = $IPv4_bin ?? $IPv6_bin;

    if ( $ip_bin === null ) { return false; }

    foreach ( $this->get_trusted_proxy_list() as [ $net_bin, $prefix ] ) {

      if ( $this->is_in_network( $ip_bin, $net_bin, $prefix ) ) { return true; }

    }

    return false;

  }

  protected function read_client_ip() : string {

    $ip = $this->get_canonical_ip( mud_http_get_server( 'REMOTE_ADDR', '' ) ) ?? '0.0.0.0';

    // 2026-10-24 jj5 - X-Forwarded-For is client controlled, so we only honour it when the request came from one of our
    // trusted proxies...
    //
    if ( ! $this->is_trusted_proxy( $ip ) ) { return $ip; }

    $xff = mud_http_get_server( 'HTTP_X_FORWARDED_FOR', '' );

    if ( trim( $xff ) === '' ) { return $ip; }

    // 2026-10-24 jj5 - each proxy appends the address it heard from, so walk right to left and take the first address
    // that isn't one of our proxies; entries to the left of that are client supplied and can't be trusted. If we hit
    // garbage we stop at the last good address.
    //
    foreach ( array_reverse( explode( ',', $xff ) ) as $hop ) {

      if ( trim( $hop ) === '' ) { break; }

      $hop_ip = $this->get_canonical_ip( $hop );

      if ( $hop_ip === null ) { break; }

      $ip = $hop_ip;

      if ( ! $this->is_trusted_proxy( $ip ) ) { break; }

    }

    return $ip;

  }

  protected function get_trusted_proxy_list() : array {

    if ( $this->trusted_proxy_list === null ) {

      // 2026-10-24 jj5 - APP_HTTP_TRUSTED_PROXY_LIST is an array of IP addresses and/or CIDR ranges, e.g.
      // [ '127.0.0.1', '10.0.0.0/8', '::1' ]; see 9-keystone.php for the default and the CFG_ override.

      $this->trusted_proxy_list = [];

      if ( ! is_array( APP_HTTP_TRUSTED_PROXY_LIST ) ) {

        mud_fail( 'trusted proxy list must be an array.', [ 'type' => gettype( APP_HTTP_TRUSTED_PROXY_LIST ) ] );

      }

      foreach ( APP_HTTP_TRUSTED_PROXY_LIST as $entry ) {

        $this->trusted_proxy_list[] = $this->parse_network( (string) $entry );

      }
    }

    return $this->trusted_proxy_list;

  }

  protected function parse_network( string $entry ) : array {

    $parts = explode( '/', trim( $entry ), 2 );

    if ( $this->get_canonical_ip( $parts[ 0 ], $IPv4, $IPv4_int, $IPv4_bin, $IPv6, $IPv6_bin ) === null ) {

      mud_fail( 'invalid trusted proxy address.', [ 'entry' => $entry ] );

    }

    $net_bin = $IPv4_bin ?? $IPv6_bin;
    $max_prefix = strlen( (string) $net_bin ) * 8;

    if ( ! isset( $parts[ 1 ] ) ) { return [ $net_bin, $max_prefix ]; }

    if ( ! ctype_digit( $parts[ 1 ] ) ) {

      mud_fail( 'invalid trusted proxy prefix length.', [ 'entry' => $entry ] );

    }

    $prefix = (int) $parts[ 1 ];

    // 2026-10-24 jj5 - an IPv4-mapped IPv6 network (e.g. '::ffff:10.0.0.0/104') was canonicalized to IPv4 above, so its
    // prefix length needs to be adjusted from 128 bit space to 32 bit space; the first 96 bits are the fixed mapping...
    //
    if ( $IPv4_bin !== null && strpos( $parts[ 0 ], ':' ) !== false ) {

      if ( $prefix < 96 ) {

        mud_fail( 'invalid trusted proxy prefix length for IPv4-mapped address.', [ 'entry' => $entry ] );

      }

      $prefix -= 96;

    }

    if ( $prefix > $max_prefix ) {

      mud_fail( 'invalid trusted proxy prefix length.', [ 'entry' => $entry ] );

    }

    return [ $net_bin, $prefix ];

  }

  protected function is_in_network( string $ip_bin, string $net_bin, int $prefix ) : bool {

    if ( strlen( $ip_bin ) !== strlen( $net_bin ) ) { return false; }

    $bytes = intdiv( $prefix, 8 );

    if ( $bytes > 0 && strncmp( $ip_bin, $net_bin, $bytes ) !== 0 ) { return false; }

    $bits = $prefix % 8;

    if ( $bits === 0 ) { return true; }

    $mask = ( 0xff << ( 8 - $bits ) ) & 0xff;

    return ( ord( $ip_bin[ $bytes ] ) & $mask ) === ( ord( $net_bin[ $bytes ] ) & $mask );

  }
}
