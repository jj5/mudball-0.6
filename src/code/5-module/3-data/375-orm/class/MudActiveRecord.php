<?php

class MudActiveRecord extends MudGadget implements ArrayAccess {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - protected fields...
  //

  protected $row_curr;
  protected $row_init;
  protected $key;
  protected $flags;

  protected $config;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [
      'class' => get_class( $this ),
      'row_curr' => mud_redact_secrets( $this->row_curr ),
      'row_init' => mud_redact_secrets( $this->row_init ),
      'key' => $this->key,
      'flags' => $this->flags,
      'config' => $this->config,
    ];

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - constructor...
  //

  public function __construct( $config ) {

    $this->config = $config;

    $this->reset();

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - ArrayAccess interface...
  //

  public function offsetExists( mixed $property ): bool {

    return $this->has_property_wrapper( $property );

  }

  public function offsetGet( mixed $property ): mixed {

    return $this->get_property_wrapper( $property );

  }

  public function offsetSet( mixed $property, mixed $app_value ): void {

    $this->set_property_wrapper( $property, $app_value );

  }

  public function offsetUnset( mixed $property ): void {

    // 2020-03-23 jj5 - I don't think we have a usecase for this so it's
    // not implemented for now...
    //
    mud_not_supported();

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function is_deleted() {

    return mud_has_flag( $this->flags, FLAG_IS_RECORD_DELETED );

  }

  public function is_new() {

    if ( $this->is_deleted() ) { return false; }

    return mud_has_flag( $this->flags, FLAG_IS_RECORD_NEW );

  }

  public function is_dirty() {

    if ( $this->is_deleted() ) { return false; }

    $is_dirty = ( $this->row_curr !== $this->row_init );

    return $is_dirty;

  }

  public function is_missing() {

    return count( $this->row_curr ) === 0;

  }

  public function get_id() {

    return $this[ $this->config->col_list[ 0 ]->col_name ] ?? null;

  }

  public function get_key() {

    return $this->key;

  }

  public function init( ?int $id = null ) {

    if ( ! $id ) { $id = app_raw()->new_internal_id(); }

    assert( is_int( $id ) );
    assert( $id > 0 );

    $this->reset();

    $id_col_name = $this->config->col_list[ 0 ]->col_name;

    $this[ $id_col_name ] = $id;

    $this->key = [ $id_col_name => $id ];

    return $this;

  }

  public function load( $spec ) {

    if ( is_array( $spec ) ) {

      return $this->load_by_key( $spec );

    }

    return $this->load_by_id( $spec );

  }

  public function load_by_id( $id ) {

    return $this->load_by_key( [ $this->config->col_list[ 0 ]->col_name => $id ] );

  }

  public function load_by_key( $key ) {

    $row = app_trn()->load( $this->config->tab_name, $key );

    $this->row_init = $row;
    $this->row_curr = $row;

    $this->key = $key;

    $this->flags = 0;

    return $this;

  }

  public function read( $row, $key ) {

    $this->row_init = $row;
    $this->row_curr = $row;

    $this->key = $key;

    $this->flags = 0;

    return $this;

  }

  public function save_if_dirty() {

    if ( ! $this->is_dirty() ) { return false; }

    return $this->save();

  }

  public function save() {

    if ( $this->is_deleted() ) {

      mud_fail(
        MUD_ERR_ORM_CANNOT_SAVE_DELETED_RECORD,
        [
          'record' => $this,
        ]
      );

    }

    $this->on_before_save();

    $a_interaction_id = app()->get_interaction_id();
    $col_count = count( $this->config->col_list );
    $col_id = $this->config->col_list[ 0 ];
    $col_rowversion = $this->config->col_list[ 1 ];

    $crud_enum = $this->is_new() ? MudCrud::CREATE : MudCrud::UPDATE;

    $rowversion = app_trn()->log_history(
      $this->config->tab_name,
      $crud_enum,
      $this->row_curr
    );

    $this->row_curr[ $col_rowversion->col_name ] = $rowversion;

    if ( $this->is_new() ) {

      app_trn()->insert( $this->config->tab_name, $this->row_curr );

    }
    else {

      app_trn()->update( $this->config->tab_name, $this->row_curr );

    }

    $id = $this->row_curr[ $col_id->col_name ];

    $this->load_by_id( $id );

    $this->on_after_save();

    return $crud_enum;

  }

  public function delete() {

    $tab_name = $this->config->tab_name;

    $records_affected = app_trn()->delete( $tab_name, $this->row_curr );

    if ( $records_affected !== 1 ) {

      mud_fail(
        MUD_ERR_ORM_DELETE_FAILED,
        [
          'tab_name' => $tab_name,
          'records_affected' => $records_affected,
          'row' => $this->row_curr,
        ]
      );

    }

    //$this->is_deleted = true;
    $this->flags |= FLAG_IS_RECORD_DELETED;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - protected methods...
  //

  protected function reset() {

    $default = $this->config->default;

    $this->row_init = $default;
    $this->row_curr = $default;

    $this->key  = null;

    $this->flags = FLAG_IS_RECORD_NEW;

    return $this;

  }

  protected function get_property_name( $property ) {

    if ( strpos( $property, 'a_' ) === 0 ) { return $property; }

    $prop = "a_app_$property";

    if ( array_key_exists( $prop, $this->row_curr ) ) { return $prop; }

    $prop = "a_std_$property";

    if ( array_key_exists( $prop, $this->row_curr ) ) { return $prop; }

    return null;

  }

  protected function get_virtual_properties() {

    return $this->config->get_virtual_properties();

  }

  protected function has_property( $property ) {

    $properties = $this->get_virtual_properties();

    if ( array_key_exists( $property, $properties ) ) { return true; }

    return array_key_exists( $property, $this->row_curr );

  }
  // 2020-03-22 jj5 - get_property() should return a value in database
  // format... (it will be converted to application format by a wrapper)...
  //
  // 2020-03-23 jj5 - note that $default is assumed to be in database
  // format...
  //
  protected function get_property( $property, $allow_missing = false, $default = null ) {

    $properties = $this->get_virtual_properties();

    if ( array_key_exists( $property, $properties ) ) {

      $getter = $properties[ $property ][ 'get' ] ?? null;

      if ( $getter ) { return $getter( $this, $property ); }

    }

    $col = $this->config->col_map[ $property ] ?? null;

    if ( $col ) {

      if ( $col->is_flg ) {

        $flags = $this->get_property( $col->flags_col_name );

        return mud_has_flag( $flags, $col->col_flag );

      }
    }

    if ( ! $allow_missing ) { $this->require_property( $property ); }

    return $this->row_curr[ $property ] ?? $default;

  }

  // 2020-03-22 jj5 - set_property() is called with a value in database
  // format...
  //
  protected function set_property( $property, $db_value ) {

    $properties = $this->get_virtual_properties();

    if ( array_key_exists( $property, $properties ) ) {

      $setter = $properties[ $property ][ 'set' ] ?? null;

      if ( $setter ) { return $setter( $this, $property, $db_value ); }

    }

    $col = $this->config->col_map[ $property ] ?? null;

    if ( $col ) {

      if ( $col->is_flg ) {

        $flags = $this->get_property( $col->flags_col_name );

        $flags = mud_set_flag( $flags, $col->col_flag, boolval( $db_value ) );

        return $this->set_property( $col->flags_col_name, $flags );

      }
    }

    $this->require_property( $property );

    mud_schemata()->validate( $property, $db_value );

    $this->row_curr[ $property ] = $db_value;

    return $this;

  }

  protected function require_property( $property ) {

    if ( array_key_exists( $property, $this->row_curr ) ) { return; }

    mud_fail(
      MUD_ERR_ORM_NO_SUCH_PROPERTY,
      [ 'property' => $property, 'record' => $this ]
    );

  }

  protected function get_db_value( $property, $value ) {

    $col = $this->config->col_map[ $property ] ?? null;

    if ( ! $col ) {

      if ( is_bool( $value ) ) { return $value ? 1 : 0; }

      return $value;

    }

    return $col->get_db_value( $value );

  }

  protected function get_app_value( $property, $value ) {

    $col = $this->config->col_map[ $property ] ?? null;

    if ( ! $col ) {

      // 2020-03-23 jj5 - note that we don't have enough information here
      // to convert integers to bools, because not all integers should be
      // converted. So we fall back on a naming convention...
      //
      if ( mud_is_bool_name( $property ) ) { return $value ? true : false; }

      return $value;

    }

    return $col->get_app_value( $value );

  }

  protected function on_before_save() { ; }
  protected function on_after_save() { ; }

  protected function on_before_set_property( $property, &$db_value ) { ; }
  protected function on_after_set_property( $property, $db_value ) { ; }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - private methods...
  //

  private function has_property_wrapper( string $property ) {

    $property = $this->get_property_name( $property );

    return $this->has_property( $property );

  }

  private function get_property_wrapper(
    string $property,
    bool $allow_missing = false,
    $default = null
  ) {

    $property = $this->get_property_name( $property );

    $db_value = $this->get_property( $property, $allow_missing, $default );

    return $this->get_app_value( $property, $db_value );

  }

  private function set_property_wrapper( $property, $app_value ) {

    $property = $this->get_property_name( $property );

    $db_value = $this->get_db_value( $property, $app_value );

    // 2020-10-12 jj5 - we don't do this any more. Not only does it slow things down it's
    // problematic when properties haven't been initialized. If you need the previous value
    // use the on_before_set_property() hook and query for the old value before it gets
    // changed.
    /*
    //$prev_app_value = $this[ $property ];
    $prev_app_value = $this->get_property( $property, $allow_missing = true, $default = null );
    $prev_db_value = $this->get_db_value( $property, $prev_app_value );
    */

    $this->on_before_set_property( $property, $db_value );

    $this->set_property( $property, $db_value );

    $this->on_after_set_property( $property, $db_value );

    return $this;

  }

}
