<?php

class mud_facility_admin_user_list extends AppFacility {

  public function get_selector_spec() { return []; }

  public function query( $context ) {

    $user_list = mud_raw()->query( "select * from v_entity__std_user" );

    return [
      'user-list' => $user_list,
    ];

  }

  public function render( $context ) {

    $args = [
      'title' => 'User List',
      'description' => 'See a list of all users.',
      'keywords' => [ 'user', 'list', ],
    ];

    $this->render_head( $context, $args );

      $this->render_nav_header( $context );

      tag_open( 'main' );

        tag_text( 'h1', 'User List' );

        $user_list = $context->get_value( 'user-list' );

        tag_open( 'table', [ 'class' => 'nice-table' ] );

          tag_open( 'thead' );

            tag_open( 'tr' );

              tag_text( 'th', '#' );
              tag_text( 'th', 'User ID' );
              tag_text( 'th', 'Username' );
              tag_text( 'th', 'Email' );

            tag_shut( 'tr' );

          tag_shut( 'thead' );

          tag_open( 'tbody' );

            $counter = 0;

            foreach ( $user_list as $user ) {

              $counter++;

              tag_open( 'tr' );

                tag_text( 'td', $counter );
                tag_text( 'td', $user[ 'a_std_user_xid' ] );
                tag_text( 'td', $user[ 'a_std_user_pii_username' ] );
                tag_text( 'td', $user[ 'a_std_user_pii_email' ] );

              tag_shut( 'tr' );

            }

          tag_shut( 'tbody' );

        tag_shut( 'table' );

      tag_shut( 'main' );

    $this->render_foot( $context );

  }
}

return new mud_facility_admin_user_list();
