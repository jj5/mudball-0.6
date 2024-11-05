<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_database.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - happy path
  //

  'happy path' => function() {

    return 0;

  },

  'lock contention' => function() {

    $a = new MudDatabase( MUD_CONNECTION_TYPE_TRN );
    $b = new MudDatabase( MUD_CONNECTION_TYPE_TRN );

    for ( $attempt = 1; $attempt <= 3; $attempt++ ) {

      if ( $attempt !== 1 ) {

        $a->random_delay();

      }

      $a->begin();
      $b->begin();

      try {

        $prefix = $a->get_prefix();

        //$a_stmt = $a->query( "select * from {$prefix}t_entity_mud_user for update" );
        //$b_stmt = $b->query( "select * from {$prefix}t_entity_mud_user for update" );

        $a_stmt = $a->prepare( "update {$prefix}t_entity_mud_user set a_std_user_flags = 1 where a_std_user_id = 1337" );
        $b_stmt = $b->prepare( "update {$prefix}t_entity_mud_user set a_std_user_flags = 2 where a_std_user_id = 1337" );

        $a_stmt->execute();
        $b_stmt->execute();

        $data = $a->get_table( "select * from {$prefix}t_entity_mud_user" );

        var_dump( $data );

      }
      catch ( MudDatabaseException $ex ) {

        echo $ex->getMessage() . "...\n";

        $last_exception = $ex;

        $a->rollback();
        $b->rollback();

        if ( ! $ex->is_retryable() ) { break; }

      }
    }

    return 0;

  },

]);
