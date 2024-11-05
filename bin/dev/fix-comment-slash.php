#!/usr/bin/env php
<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - this is for fixing comment banners...
//

function main( $argv ) {

  // 2024-08-07 jj5 - define the directory to search...
  //
  $directory = $argv[ 1 ] ?? '.';

  $dir_iterator = new RecursiveDirectoryIterator( $directory );

  $iterator = new RecursiveIteratorIterator( $dir_iterator );

  // 2024-08-07 jj5 - filter out only the PHP files...
  //
  $regex_iterator = new RegexIterator( $iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH );

  foreach ( $regex_iterator as $matches ) {

    $file_path = $matches[ 0 ];

    process_file( $file_path );

  }
}

function process_file( string $file_path ) {

  //echo "$file_path\n";

  $lines = file( $file_path );

  $result = [];

  foreach ( $lines as $line ) {

    $result[] = fix_comment_slash( $line );

  }

  $last_line = end( $result );

  if ( $last_line ) {

    $last_char = $last_line[ strlen( $last_line ) - 1 ];

    if ( $last_char !== "\n" ) { $result[] = "\n"; }

  }

  $output = implode( '', $result );

  //echo $output;

  file_put_contents( $file_path, $output );

}

function fix_comment_slash( string $line ) {

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - make this one longer than $limit and it should be fixed...
  //

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - make this one shorter than $limit and it should be fixed...
  //

  static $limit = 124;
  static $find = '/////////////////////////////////////////////////////////////////////////////';
  static $match = '|[^/]|';

  if ( strpos( $line, $find ) === false ) { return $line; }

  $string = rtrim( $line );

  $padding = rtrim( $string, '/' );

  $slashes = substr( $string, strlen( $padding ) );

  if ( ! $slashes ) { return $line; }

  /*
  var_dump([
    'padding' => $padding,
    'slashes' => $slashes,
  ]);
  */

  if ( preg_match( $match, $slashes ) ) { return $line; }

  if ( strlen( $string ) >= $limit ) {
    
    $new_line = $padding . str_repeat( '/', $limit - strlen( $padding ) );
    
  }
  else {

    $new_line = $string . str_repeat( '/', $limit - strlen( $string ) );

  }

  return "$new_line\n";

}

main( $argv );
