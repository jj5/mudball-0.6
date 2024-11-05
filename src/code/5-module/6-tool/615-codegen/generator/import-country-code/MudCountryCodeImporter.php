<?php

// 2021-04-13 jj5 - SEE: List of ISO 3166 country codes:
// https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes


// 2021-04-13 jj5 - we pinch our list of country codes from the list maintained here:
//
define( 'MUD_CODEGEN_COUNTRY_CODE_HTML_URL', 'https://www.iban.com/country-codes' );

define( 'MUD_CODEGEN_COUNTRY_CODE_DATA_DIR', realpath( __DIR__ . '/dat' ) );

define( 'MUD_CODEGEN_COUNTRY_CODE_HTML_FILE', MUD_CODEGEN_COUNTRY_CODE_DATA_DIR . '/country-codes.html' );
define( 'MUD_CODEGEN_COUNTRY_CODE_JSON_FILE', MUD_CODEGEN_COUNTRY_CODE_DATA_DIR . '/country-codes.json' );

// 2021-03-21 jj5 - these are the output PHP files generated by this script...
//
define( 'MUD_CODEGEN_COUNTRY_CODE_CONSTS_FILE',  'country-code-consts.php' );
define( 'MUD_CODEGEN_COUNTRY_CODE_ENUM_FILE',    'country-code-enum.php' );
define( 'MUD_CODEGEN_COUNTRY_CODE_SCHEMA_FILE',  'country-code-schema.php' );

class MudCountryCodeImporter extends MudGenerator {

  protected $verbose = true, $debug = false, $script_path = null, $target = null;

  public function run( $argv ) {


    //
    // 2021-03-22 jj5 - set up and check our environemnt...
    //

    if ( ! is_array( $argv ) ) {

      die( 'This is a command-line app, not a web app.' );

    }


    //
    // 2021-03-22 jj5 - parse our command-line...
    //

    if ( ! file_exists( basename( $this->script_path = array_shift( $argv ) ) ) ) {

      $this->error( 'not in script directory.', MUD_TOOL_EXIT_WRONG_DIR );

    }

    $this->target = array_shift( $argv );

    if ( ! is_dir( $this->target ) ) {

      $this->error( 'invalid target.', MUD_TOOL_EXIT_INVALID_TARGET );

    }

    $this->script_path = realpath( $this->script_path );

    while ( $arg = array_shift( $argv ) ) {

      switch ( $arg ) {

        case '--debug'    : $this->debug    = true;   break;
        case '--verbose'  : $this->verbose  = true;   break;
        case '--quiet'    : $this->verbose  = false;  break;

        default :

          $this->value_error( 'unsupported argument', $arg, MUD_TOOL_EXIT_UNKNOWN_ARG );

      }
    }


    //
    // 2021-03-22 jj5 - set up our file system...
    //

    if ( ! is_dir( MUD_CODEGEN_COUNTRY_CODE_DATA_DIR ) ) {

      mkdir( MUD_CODEGEN_COUNTRY_CODE_DATA_DIR );

    }


    //
    // 2021-03-22 jj5 - get our CSV file, either we already have one we can use or we download...
    //

    if ( $this->debug && file_exists( MUD_CODEGEN_COUNTRY_CODE_HTML_FILE ) ) {

      // 2021-03-21 jj5 - if we're debugging and the file exists don't download a new file...

      $this->report( 'loading data from ' . MUD_CODEGEN_COUNTRY_CODE_HTML_FILE );

    }
    else {

      // 2021-03-21 jj5 - we're not debugging or the CSV file is missing so get the latest data
      // from the web...

      $this->report( 'downloading data from ' . MUD_CODEGEN_COUNTRY_CODE_HTML_URL );

      $user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:86.0) Gecko/20100101 Firefox/86.0';

      $options = [
        'http' => [
          'method' => 'GET',
          'header' =>
            //"Accept-language: en\r\n" .
            //"Cookie: foo=bar\r\n" .
            "User-Agent: $user_agent\r\n"
        ]
      ];

      $context = stream_context_create( $options );

      $csv = file_get_contents( MUD_CODEGEN_COUNTRY_CODE_HTML_URL, false, $context );

      file_put_contents( MUD_CODEGEN_COUNTRY_CODE_HTML_FILE, $csv );

    }

    if ( file_exists( MUD_CODEGEN_COUNTRY_CODE_JSON_FILE ) ) {

      $data = json_decode( file_get_contents( MUD_CODEGEN_COUNTRY_CODE_JSON_FILE ), $assoc = true );

    }
    else {

      $data = [];

    }

    $html = file_get_contents( MUD_CODEGEN_COUNTRY_CODE_HTML_FILE );

    $regex = '|<tr>\s+<td>(.*)</td>\s+<td>(.*)</td>\s+<td>(.*)</td>\s+<td>(.*)</td>\s+</tr>|m';

    preg_match_all( $regex, $html, $all_matches );

    $country_list = [];

    $country_item_map = [];
    $country_name_map = [];
    $alpha_2_code_map = [];
    $alpha_3_code_map = [];
    $numeric_code_map = [];

    for ( $i = 0; $i < count( $all_matches[ 0 ] ); $i++ ) {

      $country_name = $all_matches[ 1 ][ $i ];
      $alpha_2_code = $all_matches[ 2 ][ $i ];
      $alpha_3_code = $all_matches[ 3 ][ $i ];
      $numeric_code = $all_matches[ 4 ][ $i ];

      if ( ! preg_match( '/([^\(]*)([^\)]*\)?)/', $country_name, $matches ) ) {

        $this->fail( 'invalid country name' );

      }

      $country_item_html = trim( $matches[ 0 ] );
      $country_name_html = trim( $matches[ 1 ] );
      $qualifier_html = trim( $matches[ 2 ] );

      // 2021-04-13 jj5 - these are special characters we assume won't be in our input...
      //
      if ( strpos( $country_item_html, '$' ) !== false ) { $this->fail( 'invalid country.' ); }
      if ( strpos( $country_item_html, '"' ) !== false ) { $this->fail( 'invalid country.' ); }


      $country_item = html_entity_decode( $country_item_html, ENT_HTML5 );
      $country_name = html_entity_decode( $country_name_html, ENT_HTML5 );
      $qualifier = html_entity_decode( $qualifier_html, ENT_HTML5 );

      $naked_qualifier = trim( $qualifier, '()' );

      if ( $naked_qualifier ) {

        $full_country_name = ucfirst( $naked_qualifier ) . ' ' . $country_name;

      }
      else {

        $full_country_name = $country_name;

      }

      if ( $country_name === 'United Kingdom of Great Britain and Northern Ireland' ) {

        $country_name = 'United Kingdom';

      }

      if ( $country_name === 'Palestine, State of' ) {

        $country_name = 'Palestine';

      }

      if ( $country_name === 'Tanzania, United Republic of' ) {

        $country_name = 'Tanzania';

      }

      $country_item_ascii = $this->convert_to_ascii( $country_item );
      $country_name_ascii = $this->convert_to_ascii( $country_name );
      $full_country_name_ascii = $this->convert_to_ascii( $full_country_name );
      $qualifier_ascii = $this->convert_to_ascii( $qualifier );
      $naked_qualifier_ascii = $this->convert_to_ascii( $naked_qualifier );

      $numeric_value = intval( ltrim( $numeric_code, '0' ) );

      $country_list[] = [
        'item' => $country_item,
        'item_ascii' => $country_item_ascii,
        'item_html' => $country_item_html,
        'name' => $country_name,
        'name_ascii' => $country_name_ascii,
        'qualifier' => $qualifier,
        'qualifier_ascii' => $qualifier_ascii,
        'naked_qualifier' => $naked_qualifier,
        'naked_qualifier_ascii' => $naked_qualifier_ascii,
        'alpha_2' => $alpha_2_code,
        'alpha_3' => $alpha_3_code,
        'numeric_code' => $numeric_code,
        'numeric_value' => $numeric_value,
        'full_name' => $full_country_name,
        'full_name_ascii' => $full_country_name_ascii,
      ];

      $this->map_inc( $country_item_map, $country_item );
      $this->map_inc( $country_name_map, $country_name );
      $this->map_inc( $alpha_2_code_map, $alpha_2_code );
      $this->map_inc( $alpha_3_code_map, $alpha_3_code );
      $this->map_inc( $numeric_code_map, $numeric_code );

    }

    /*
    report_not_one( 'country name', $country_name_map );
    report_not_one( 'alpha 2 code', $alpha_2_code_map );
    report_not_one( 'alpha 3 code', $alpha_3_code_map );
    report_not_one( 'numeric code', $numeric_code_map );
    */

    $country_data = [];

    foreach ( $country_list as $spec ) {

      $alpha_2 = $spec[ 'alpha_2' ];

      $enum = $data[ $alpha_2 ] ?? count( $data ) + 1;

      $data[ $alpha_2 ] = $enum;

      $is_using_full_name = false;
      $name = $spec[ 'name' ];
      $name_ascii = $spec[ 'name_ascii' ];
      $number = $spec[ 'numeric_value' ];

      if ( $country_name_map[ $name ] > 1 ) {

        $is_using_full_name = true;

        $short_name = $name;
        $short_name_ascii = $name_ascii;

        $name = $spec[ 'full_name' ];
        $name_ascii = $spec[ 'full_name_ascii' ];

      }
      else {

        $short_name = $name;
        $short_name_ascii = $name_ascii;

      }

      $code = $this->get_code( $name_ascii );

      //echo "$name_ascii [$code:$number]\n";

      $country_data[] = [
        'enum' => $enum,
        // 2021-04-13 jj5 - we generate this code but it's not really useful...
        //'code' => $code,
        'alpha_2' => $spec[ 'alpha_2' ],
        'alpha_3' => $spec[ 'alpha_3' ],
        'numeric_code' => $spec[ 'numeric_code' ],
        'numeric_value' => $spec[ 'numeric_value' ],
        'is_using_full_name' => $is_using_full_name,
        'name' => $name,
        'name_ascii' => $name_ascii,
        'full_name' => $spec[ 'full_name' ],
        'full_name_ascii' => $spec[ 'full_name_ascii' ],
        'short_name' => $short_name,
        'short_name_ascii' => $short_name_ascii,
        'item' => $spec[ 'item' ],
        'item_ascii' => $spec[ 'item_ascii' ],
        'item_html' => $spec[ 'item_html' ],
        'qualifier' => $spec[ 'qualifier' ],
        'qualifier_ascii' => $spec[ 'qualifier_ascii' ],
        'naked_qualifier' => $spec[ 'naked_qualifier' ],
        'naked_qualifier_ascii' => $spec[ 'naked_qualifier_ascii' ],
      ];

    }


    //var_dump( count( $country_list ) );

    //var_dump( $country_data );


    //
    // 2021-04-13 jj5 - save our enum data to JSON for posterity...
    //

    $count = count( $data );

    $this->report( "writing $count records to " . MUD_CODEGEN_COUNTRY_CODE_JSON_FILE );

    file_put_contents( MUD_CODEGEN_COUNTRY_CODE_JSON_FILE, json_encode( $data, JSON_PRETTY_PRINT ) );


    //
    // 2021-04-13 jj5 - do our code generation...
    //

    $this->gen_consts( $country_data );
    $this->gen_enum( $country_data );
    $this->gen_schema( $country_data );


    //
    // 2021-03-22 jj5 - we're done, warn user if there are changes...
    //

    if ( count( $data ) === count( $country_data ) ) { return; }


    // 2021-04-13 jj5 - THINK: there is probably a better way to send this alert... maybe we
    // should email someone..? In theory this script gets run manually so there should be an
    // operator reading this output...
    //
    mud_stderr( "**********************************************************************" );
    mud_stderr( "*** NEW ITEMS DETECTED, YOU MUST UPDATE THE SCHEMA REVISION NUMBER ***" );
    mud_stderr( "**********************************************************************" );

  }

  protected function get_code( $ascii ) {

    return strtoupper( preg_replace( "/\,|'|\.|-/", '', preg_replace( '/\s|-/', '_', $ascii ) ) );

  }

  protected function convert_to_ascii( $input ) {

    $value = str_replace( 'Å', 'A', $input );
    $value = str_replace( 'ô', 'o', $value );
    $value = str_replace( 'ç', 'c', $value );
    $value = str_replace( 'é', 'e', $value );

    $result = mb_convert_encoding( $value, 'ASCII' );

    if ( strpos( $result, '?' ) !== false ) {

      var_dump( $input );

      assert( false );

    }

    return $result;

  }

  protected function report_not_one( $type, $map ) {

    echo "$type:\n";

    foreach ( $map as $key => $count ) {

      if ( $count === 1 ) { continue; }

      echo "$key: $count\n";

    }

    echo "\n";

  }

  protected function map_inc( &$map, $key ) {

    $count = $map[ $key ] ?? 0;

    $map[ $key ] = $count + 1;

  }

  protected function gen_consts( $country_data ) {

    $file = $this->target . '/' . MUD_CODEGEN_COUNTRY_CODE_CONSTS_FILE;

    $this->report( "generating $file" );

    ob_start();

    $this->print_consts( $country_data );

    $code = ob_get_clean();

    file_put_contents( $file, $code );

  }

  protected function gen_enum( $country_data ) {

    $file = $this->target . '/' . MUD_CODEGEN_COUNTRY_CODE_ENUM_FILE;

    $this->report( "generating $file" );

    ob_start();

    $this->print_enum( $country_data );

    $code = ob_get_clean();

    file_put_contents( $file, $code );

  }

  protected function gen_schema( $country_data ) {

    $file = $this->target . '/' . MUD_CODEGEN_COUNTRY_CODE_SCHEMA_FILE;

    $this->report( "generating $file" );

    ob_start();

    $this->print_schema( $country_data );

    $code = ob_get_clean();

    file_put_contents( $file, $code );

  }

  protected function print_consts( $country_data ) {

    $this->print_header();

    foreach ( $country_data as $spec ) :

      $name = "'MUD_COUNTRY_" . $spec[ 'alpha_2' ] . "'";
      $string = "'" . $spec[ 'alpha_2' ] . "'"

  ?>
  define( <?= $name ?>, <?= $string ?> );
<?php

    endforeach;

  }

  protected function print_enum( $country_data ) {

    $this->print_header();

  ?>
  abstract class MudCountry extends MudEnum {

    use MudEnumTraits;

<?php

    foreach ( $country_data as $spec ) :

      $name = $spec[ 'alpha_2' ];
      $id = $spec[ 'enum' ];

  ?>
    const <?= $name ?> = <?= $id ?>; // '<?= $spec[ 'full_name' ] ?>'
<?php

    endforeach;

  ?>

    static $map = [
<?php

    foreach ( $country_data as $spec ) :

      $name = $spec[ 'alpha_2' ];

  ?>
      MUD_COUNTRY_<?= $name ?> => self::<?= $name ?>,
<?php

    endforeach;

  ?>
    ];

  }
<?php

  }

  protected function print_schema( $country_data ) {

    $this->print_header();

  ?>

      def_dat( 't_lookup_std_country',
        [
          'a_std_country_enum' => null,
          'a_std_country_alpha_2' => null,
          'a_std_country_alpha_3' => null,
          'a_std_country_numeric_code' => null,
          'a_std_country_numeric_value' => null,
          'a_std_country_is_using_full_name' => null,
          'a_std_country_name' => null,
          'a_std_country_name_ascii' => null,
          'a_std_country_full_name' => null,
          'a_std_country_full_name_ascii' => null,
          'a_std_country_short_name' => null,
          'a_std_country_short_name_ascii' => null,
          'a_std_country_item' => null,
          'a_std_country_item_ascii' => null,
          'a_std_country_item_html' => null,
          'a_std_country_qualifier' => null,
          'a_std_country_qualifier_ascii' => null,
          'a_std_country_naked_qualifier' => null,
          'a_std_country_naked_qualifier_ascii' => null,
          'a_std_country_natural_sort' => null,
        ], [

<?php

    foreach ( $country_data as $spec ) :

      $name = null;
      $port = null;
      $scheme = null;

  ?>

        // <?= $spec[ 'full_name' ] ?>...
        [
          MudCountry::<?= $spec[ 'alpha_2' ] ?>,
          MUD_COUNTRY_<?= $spec[ 'alpha_2' ] ?>,
          "<?= $spec[ 'alpha_3' ] ?>",
          "<?= $spec[ 'numeric_code' ] ?>",
          <?= $spec[ 'numeric_value' ] ?>,
          <?= $spec[ 'is_using_full_name' ] ? 1 : 0 ?>,
          "<?= $spec[ 'name' ] ?>",
          "<?= $spec[ 'name_ascii' ] ?>",
          "<?= $spec[ 'full_name' ] ?>",
          "<?= $spec[ 'full_name_ascii' ] ?>",
          "<?= $spec[ 'short_name' ] ?>",
          "<?= $spec[ 'short_name_ascii' ] ?>",
          "<?= $spec[ 'item' ] ?>",
          "<?= $spec[ 'item_ascii' ] ?>",
          "<?= $spec[ 'item_html' ] ?>",
          "<?= $spec[ 'qualifier' ] ?>",
          "<?= $spec[ 'qualifier_ascii' ] ?>",
          "<?= $spec[ 'naked_qualifier' ] ?>",
          "<?= $spec[ 'naked_qualifier_ascii' ] ?>",
          "<?= $spec[ 'item_ascii' ] ?>",
        ],
<?php

    endforeach;

  ?>
      ]);

<?php

  }

  protected function print_header() {

    static $path = null;

    if ( $path === null ) {

      $path = preg_replace( '|.*/bin/|', 'bin/', $this->script_path );

    }

    echo "<?php\n";

  ?>

  //
  // this file generated by <?= "$path\n" ?>
  //

<?php

  }
}
