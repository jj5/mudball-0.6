<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - class definition...
//

class MudModuleBuffer extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - buffer private fields...
  //

  private $flushed = 0;
  private $cleared = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - public instance methods...
  //

  public function get_total_flushed_bytes() { return $this->flushed; }
  public function get_total_cleared_bytes() { return $this->cleared; }

  public function reset() : int {

    $this->clear_all();

    return $this->start();

  }

  public function start() : int {

    ob_start();

    return ob_get_level();

  }

  public function flush( &$length = null, bool $return = false ) {

    $length = ob_get_length();

    $this->flushed += $length;

    $result = null;

    if ( ob_get_level() ) {

      if ( $return ) {

        $result = ob_get_flush();

      }
      else {

        ob_end_flush();

      }
    }

    flush();

    return $result;

  }

  public function clear( &$length = null, bool $return = false ) {

    $length = ob_get_length();

    $this->cleared += $length;

    if ( $return ) { return ob_get_clean(); }

    ob_end_clean();

    return null;

  }

  public function clear_all( &$length = null, bool $return = false ) {

    $length = 0;

    if ( $return ) {

      $result = '';

      while ( ob_get_level() ) {

        $length += ob_get_length();

        $result .= ob_get_clean();

      }

      $this->cleared += $length;

      return $result;

    }

    while ( ob_get_level() ) {

      $length += ob_get_length();

      ob_end_clean();

    }

    $this->cleared += $length;

    return null;

  }
}
