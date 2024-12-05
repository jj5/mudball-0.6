<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../../1-bootstrap/4-config.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include components...
//

require_once __DIR__ . '/trait/MudCreationMixin.php';
require_once __DIR__ . '/trait/MudMixin.php';

require_once __DIR__ . '/class/0-MudGadgetBase.php';

if ( DEBUG ) {

  require_once __DIR__ . '/class/1-MudGadget-Debug.php';

}
else {

  require_once __DIR__ . '/class/1-MudGadget-Prod.php';

}


require_once __DIR__ . '/class/2-MudService.php';
require_once __DIR__ . '/class/3-MudModule.php';
require_once __DIR__ . '/class/6-MudFactory.php';
require_once __DIR__ . '/class/7-MudLocator.php';
require_once __DIR__ . '/class/9-MudModuleStandard.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - functional interface...
//

// 2024-07-30 jj5 - this improves performance...

function mud_is_debug() : bool {

  return DEBUG;

  //return mud_module_standard()->is_debug();

}

function mud_is_dev() : bool {

  return DEV;

  //return mud_module_standard()->is_dev();

}

function mud_is_beta() : bool {

  return BETA;

  //return mud_module_standard()->is_beta();

}

function mud_is_prod() : bool {

  return PROD;

  //return mud_module_standard()->is_prod();

}

function mud_format_string( string $format, mixed $arg ) : string {

  return mud_module_standard()->format_string( $format, $arg );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - PHP factory methods...
//

function new_php_std_class() : stdClass {

  return mud_factory()->new_php_std_class();

}

function new_php_exception(
  string|null $message = '',
  int|null $code = 0,
  Throwable|null $previous = null,
)
: Exception {

  return mud_factory()->new_php_exception( $message, $code, $previous );

}

function new_php_error_exception(
    string|null $message = '',
    int|null $code = 0,
    int|null $severity = E_ERROR,
    string|null $filename = null,
    int|null $lineno = null,
    Throwable|null $previous = null,
)
: ErrorException {

  return mud_factory()->new_php_error_exception( $message, $code, $severity, $filename, $lineno, $previous );

}

function new_php_reflection_class( object|string|null $objectOrClass ) : ReflectionClass {

  return mud_factory()->new_php_reflection_class( $objectOrClass );

}

function new_php_date_time_immutable(
  string|null $datetime = 'now',
  DateTimeZone|null $timezone = null,
)
: DateTimeImmutable {

  return mud_factory()->new_php_date_time_immutable( $datetime, $timezone );

}

function new_php_date_time(
  string|null $datetime = 'now',
  DateTimeZone|null $timezone = null,
)
: DateTime {

  return mud_factory()->new_php_date_time( $datetime, $timezone );

}

function new_php_date_time_zone( string $timezone ) : DateTimeZone {

  return mud_factory()->new_php_date_time_zone( $timezone );

}

function new_php_recursive_directory_iterator(
  string $path,
  int|null $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO,
)
: RecursiveDirectoryIterator {

  return mud_factory()->new_php_recursive_directory_iterator( $path, $flags );

}

function new_php_recursive_iterator_iterator(
  Traversable $dir_iterator,
  int|null $mode = RecursiveIteratorIterator::LEAVES_ONLY,
  int|null $flags = 0,
)
: RecursiveIteratorIterator {

  return mud_factory()->new_php_recursive_iterator_iterator( $dir_iterator, $mode, $flags );

}

function new_php_spl_object_storage() : SplObjectStorage {

  return mud_factory()->new_php_spl_object_storage();

}

function new_php_pdo(
  string $dsn,
  string|null $username = null,
  string|null $passwd = null,
  array|null $options = null,
)
: PDO {

  return mud_factory()->new_php_pdo( $dsn, $username, $passwd, $options );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locators...
//

function mud_factory( MudFactory|false $set = false ) : MudFactory {

  static $instance = false;

  if ( $set !== false ) {

    $instance = $set;

  }
  else if ( $instance === false ) {

    $instance = new MudFactory();

  }

  return $instance;

}

function mud_locator( MudLocator|false $set = false ) : MudLocator {

  static $instance = false;

  if ( $set !== false ) {

    $instance = $set;

  }
  else if ( $instance === false ) {

    $instance = mud_factory()->create_object( MudLocator::class );

  }

  return $instance;

}

function mud_module_standard( MudModuleStandard|false $set = false ) : MudModuleStandard {

  return mud_locator()->manage_module( MudModuleStandard::class, $set );

}
