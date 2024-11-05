<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - class definition...
//

class MudModuleFile extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleRetry|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public functions...
  //

  public function touch( $filename, $time = null, $atime = null ) {

    if ( $atime !== null ) {

      return mud_ensure( 'touch', [ $filename, $time, $atime ] );

    }

    if ( $time !== null ) {

      return mud_ensure( 'touch', [ $filename, $time ] );

    }

    return mud_ensure( 'touch', [ $filename ] );

  }

  public function unlink( $filename, $context = null ) {

    if ( $context !== null ) {

      mud_ensure( 'unlink', [ $filename, $context ] );

    }
    else {

      mud_ensure( 'unlink', [ $filename ] );

    }
  }

  public function chown( $filename, $user, $group = null ) {

    if ( $group !== null ) { mud_chgrp( $filename, $group ); }

    return mud_ensure( 'chown', [ $filename, $user ] );

  }

  public function chgrp( $filename, $group ) {

    return mud_ensure( 'chgrp', [ $filename, $group ] );

  }

  public function chmod( $filename, $permissions ) {

    return mud_ensure( 'chmod', [ $filename, $permissions ] );

  }

  public function get_file_list( $dir, $filename_filter_regex = '/.+/' ) {

    // 2021-04-12 jj5 - SEE: The RecursiveDirectoryIterator class:
    // https://www.php.net/manual/en/class.recursivedirectoryiterator.php
    //
    // 2021-04-12 jj5 - NOTE: I searched the above for 'sort' but didn't find anything so I just
    // get the file list here then sort it myself below...

    $file_list = [];

    $dir_iterator = new_php_recursive_directory_iterator( $dir );

    $iterator = new_php_recursive_iterator_iterator( $dir_iterator, RecursiveIteratorIterator::SELF_FIRST );

    foreach ( $iterator as $file ) {

      if ( ! preg_match( $filename_filter_regex, $file ) ) { continue; }

      $file_list[] = $file;

    }

    usort( $file_list, 'strcmp' );

    return $file_list;

  }
}
