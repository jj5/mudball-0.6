<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - class definition...
//

class MudModuleDirectory extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - private fields...
  //

  private $dir_stack = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public functions...
  //

  public function mkdir( $pathname, $mode = 0777, $recursive = false, $context = null ) {

    if ( $context !== null ) {

      return mud_ensure( 'mkdir', [ $pathname, $mode, $recursive, $context ] );

    }

    return mud_ensure( 'mkdir', [ $pathname, $mode, $recursive ] );

  }

  public function rmdir( $dir ) {

    return mud_ensure( 'rmdir', [ $dir ] );

  }

  public function is_dir( string $dir ) : bool {

    return is_dir( $dir );

  }

  public function is_dir_empty( $dir ) {

    if ( ! is_dir( $dir ) ) { return false; }

    $files = scandir( $dir, SCANDIR_SORT_NONE );

    return ( count( $files ) === 2 );

  }

  public function pushd( $dir ) {

    if ( ! is_dir( $dir ) ) { mud_fail( MUD_ERR_DIRECTORY_IS_INVALID, [ 'dir' => $dir ] ); }

    array_push( $this->dir_stack, $this->getcwd() );

    $this->chdir( $dir );

    return $this->getcwd();

  }

  public function popd() {

    $dir = array_pop( $this->dir_stack );

    if ( ! $dir ) { mud_fail( MUD_ERR_DIRECTORY_IS_INVALID, [ 'dir' => $dir ] ); }

    if ( ! is_dir( $dir ) ) { mud_fail( MUD_ERR_DIRECTORY_IS_INVALID, [ 'dir' => $dir ] ); }

    $this->chdir( $dir );

    return $this->getcwd();

  }

  public function chdir( $dir ) {

    assert( is_dir( $dir ) );

    return mud_ensure( 'chdir', [ $dir ] );

  }

  public function getcwd() {

    return getcwd();

  }
}
