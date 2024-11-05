<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: the MudFactory isn't the only factory object in the system. Often a module will define factory
// methods too, for the types of objects that it defines and manages. The MudFactory is a special factory object that is
// used to create modules, services, and PHP objects. It is used by the MudLocator to create the objects that it manages.

class MudFactory extends MudService {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudFactory|null $previous = null ) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods for modules and services...
  //

  public function create_module( string $module_name ) : MudModule {

    return $this->create_service( $module_name );;

  }

  public function create_service( string $service_name ) : MudService {

    $app_class = 'App' . $service_name;

    if ( class_exists( $app_class ) ) { return $this->create_object( $app_class ); }

    $mud_class = 'Mud' . $service_name;

    return $this->create_object( $mud_class );

  }

  public function create_object( string $class ) {

    return new $class();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods for PHP classes...
  //

  public function new_php_std_class() : stdClass {

    return new stdClass();

  }

  public function new_php_exception(
    string|null $message = '',
    int|null $code = 0,
    Throwable|null $previous = null,
  )
  : Exception {

    return new Exception( $message, $code, $previous );

  }

  public function new_php_error_exception(
    string|null $message = '',
    int|null $code = 0,
    int|null $severity = E_ERROR,
    string|null $filename = null,
    int|null $lineno = null,
    Throwable|null $previous = null,
  )
  : ErrorException {

    return new ErrorException( $message, $code, $severity, $filename, $lineno, $previous );

  }

  public function new_php_reflection_class( object|string|null $objectOrClass ) : ReflectionClass {

    return new ReflectionClass( $objectOrClass );

  }

  public function new_php_date_time_immutable(
    string|null $datetime = 'now',
    DateTimeZone|null $timezone = null,
  )
  : DateTimeImmutable {

    return new DateTimeImmutable( $datetime, $timezone );

  }

  public function new_php_date_time(
    string|null $datetime = 'now',
    DateTimeZone|null $timezone = null,
  )
  : DateTime {

    return new DateTime( $datetime, $timezone );

  }

  public function new_php_date_time_zone( string $timezone ) : DateTimeZone {

    return new DateTimeZone( $timezone );

  }

  public function new_php_recursive_directory_iterator(
    string $path,
    int|null $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO,
  )
  : RecursiveDirectoryIterator {

    return new RecursiveDirectoryIterator( $path, $flags );

  }

  public function new_php_recursive_iterator_iterator(
    Traversable $dir_iterator,
    int|null $mode = RecursiveIteratorIterator::LEAVES_ONLY,
    int|null $flags = 0,
  )
  : RecursiveIteratorIterator {

    return new RecursiveIteratorIterator( $dir_iterator, $mode, $flags );

  }

  public function new_php_spl_object_storage() : SplObjectStorage {

    return new SplObjectStorage;

  }

  public function new_php_pdo(
    string $dsn,
    string|null $username = null,
    string|null $passwd = null,
    array|null $options = null,
  )
  : PDO {

    return new PDO( $dsn, $username, $passwd, $options );

  }
}
