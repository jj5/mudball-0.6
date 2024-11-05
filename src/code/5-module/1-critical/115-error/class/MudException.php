<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - class definition...
//

// 2024-02-07 jj5 - NOTE: an instance of the MudException class may contain sensitive data which can be returned from the
// $ex->getTraceAsString() and $ex->getTrace() functions. To make sure you don't log such data make sure you serialize
// instances of this class to JSON which will do the appropriate redaction.

class MudException extends Exception implements JsonSerializable {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - traits...
  //

  use MudMixin;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - private fields...
  //

  private DateTimeImmutable $date;

  private string $name;

  private string $hint;

  private mixed $data;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - constructor...
  //

  public function __construct(
    string|null $message,
    int|null $code,
    Throwable|null $previous,
    string $name,
    string $hint,
    mixed $data,
  ) {

    $this->date = function_exists( 'new_php_date_time_immutable' ) ? new_php_date_time_immutable() : new DateTimeImmutable();
    $this->name = $name;
    $this->hint = $hint;
    $this->data = function_exists( 'mud_redact_secrets' ) ? mud_redact_secrets( $data ) : '**REDACTED**';

    parent::__construct( $message, $code, $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [

      'class' => get_class( $this ),
      'file' => $this->getFile(),
      'line' => $this->getLine(),
      'date' => $this->getDate(),
      'name' => $this->getName(),
      'code' => $this->getCode(),
      'message' => $this->getMessage(),
      'hint' => $this->getHint(),

      // 2021-02-27 jj5 - NOTE: the 'data' is safe because we redacted it before assigning the field in the constructor
      // below...
      //
      'data' => $this->getData(),

      'previous' => $this->encode_previous( $this->getPrevious() ),

    ];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - public methods...
  //

  public function getDate() : DateTimeImmutable { return $this->date; }

  public function getName() : string { return $this->name; }

  public function getHint() : string { return $this->hint; }

  public function getData() : mixed { return $this->data; }

  public function get_date() : DateTimeImmutable { return $this->date; }

  public function get_name() : string { return $this->name; }

  public function get_hint() : string { return $this->hint; }

  public function get_data() : mixed { return $this->data; }

  public function get_file() : string { return $this->getFile(); }

  public function get_line() : int { return $this->getLine(); }

  public function get_code() : int { return $this->getCode(); }

  public function get_message() : string { return $this->getMessage(); }

  public function get_previous() : Throwable|null { return $this->getPrevious(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - protected instance methods...
  //

  protected function encode_previous( Throwable|null $previous ) : mixed {

    if ( $previous === null ) { return null; }

    return [
      'class' => get_class( $previous ),
      'file' => $previous->getFile(),
      'line' => $previous->getLine(),
      'code' => $previous->getCode(),
      'message' => $previous->getMessage(),
      'previous' => $this->encode_previous( $previous->getPrevious() ),
    ];

  }
}
