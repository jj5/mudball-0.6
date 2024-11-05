<?php

trait mud_mudballdb_2021_08_30_090715_procedure {

  public function define_procedures() {

    def_proc( 'p_gen_std_entity_id', function ( $prefix ) {

      return "
        CREATE PROCEDURE {$prefix}p_gen_std_entity_id (
            IN a_std_interaction_id INT,
            IN n INT
        )
        BEGIN

            DROP TEMPORARY TABLE IF EXISTS {$prefix}t_tmp_entity_id;

            CREATE TEMPORARY TABLE {$prefix}t_tmp_entity_id (
                a_std_entity_id INT NOT NULL PRIMARY KEY
            )
            ENGINE=MEMORY MIN_ROWS=32 MAX_ROWS=1024;

            SET @i = 0;
            SET @limit = 1024;
            SET @old_autocommit = ( SELECT @@autocommit );

            SET autocommit = 0;

            REPEAT

                INSERT
                    INTO {$prefix}t_ident_std_entity ( a_std_entity_created_in )
                    VALUES ( a_std_interaction_id );

                INSERT
                    INTO {$prefix}t_tmp_entity_id
                    VALUES ( LAST_INSERT_ID() );

                SET @i = @i + 1;

                UNTIL @i >= n OR @i >= @limit

            END REPEAT;

            COMMIT WORK;

            SET autocommit = @old_autocommit;

            SELECT a_std_entity_id FROM {$prefix}t_tmp_entity_id;

            DROP TEMPORARY TABLE {$prefix}t_tmp_entity_id;

        END
      ";

    });

  }
}
