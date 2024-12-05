<?php

// 2022-02-27 jj5 - peripheral traist are for non-entity data...

trait MudDalPeripheral {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-27 jj5 - private fields...
  //

  private $internal_id_list;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-27 jj5 - public methods...
  //

  //
  // 2022-02-27 jj5 - t_about_mud_schema_revision
  //

  public function get_a_std_schema_revision_id_latest_for_schema_name( $schema_name ) {

    static $stmt = null;

    if ( $stmt === null ) {

      $prefix = $this->get_prefix();

      $sql = "
        select
          a_std_schema_revision_id
        from
          {$prefix}t_about_mud_schema_revision
        where
          a_std_schema_revision_schema_name = :schema_name
        order by
          a_std_schema_revision_revision_number desc
        limit 1
      ";

      $stmt = $this->get_database()->prepare( $sql );

    }

    $stmt->execute( [ ':schema_name' => $schema_name ] );

    $table = $stmt->fetchAll();

    $stmt->closeCursor();

    $value = $table[ 0 ][ 'a_std_schema_revision_id' ] ?? null;

    if ( $value === null ) {

      mud_log_6_info( "schema revision ID for '$schema_name' is null." );

      return null;

    }

    $id = intval( $value );

    mud_log_6_info( "schema revision ID for '$schema_name' is '$id'." );

    return $id;

  }

  //
  // 2022-02-27 jj5 - t_ident_mud_internal_id
  //

  public function new_internal_id() {

    static $select_stmt = null, $update_stmt = null, $log_stmt = null, $pow = 2;

    if ( $select_stmt === null ) {

      $prefix = $this->get_prefix();

      $sql = "
        select
          max( a_std_internal_id ) as id
        from
          {$prefix}t_ident_mud_internal_id
      ";

      $select_stmt = $this->get_database()->prepare( $sql );

      $sql = "
        update
          {$prefix}t_ident_mud_internal_id
        set
          a_std_internal_id = a_std_internal_id + :increment
        where
          a_std_internal_id = :current_value
      ";

      $update_stmt = $this->get_database()->prepare( $sql );

      $sql = "
        insert into {$prefix}t_ident_mud_internal_id_allocation (
          a_std_internal_id_allocation_from,
          a_std_internal_id_allocation_thru,
          a_std_internal_id_allocation_range,
          a_std_internal_id_allocation_created_in
        )
        values (
          :from,
          :thru,
          :range,
          :created_in
        )
      ";

      $log_stmt = $this->get_database()->prepare( $sql );

    }

    if ( ! $this->internal_id_list ) {

      $increment = pow( 2, $pow++ );

      $try = 0;

      for ( ;; ) {

        if ( ++$try > 1000 ) {

          mud_fail( MUD_ERR_DAL_RETRIES_EXHAUSTED, [ 'try' => $try ] );

        }

        $select_stmt->execute();

        $result = $select_stmt->fetchAll();

        $select_stmt->closeCursor();

        $id = intval( $result[ 0 ][ 'id' ] );

        $update_stmt->execute( [ ':increment' => $increment, ':current_value' => $id ] );

        if ( $update_stmt->rowCount() === 1 ) {

          break;

        }
      }

      $log_stmt->execute([
        ':from' => $id,
        ':thru' => ( $id + $increment - 1 ),
        ':range' => $increment,
        ':created_in' => $this->get_interaction_id(),
      ]);

      $list = [];

      for ( $n = 0; $n < $increment; $n++ ) {

        $list[] = $id + $n;

      }

      $this->internal_id_list = $list;

    }

    return array_shift( $this->internal_id_list );

  }
}
