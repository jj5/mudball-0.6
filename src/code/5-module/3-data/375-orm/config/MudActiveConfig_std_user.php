<?php

class MudActiveConfig_std_user extends MudActiveConfig {

  public function __construct(
    string $tab_name,
    array $col_list,
    array $col_map,
    array $default,
    array $virtual_properties = []
  ) {

    static $custom_properties = null;

    if ( $custom_properties === null ) {

      $custom_properties = [

        A_STD_USER_PASSWORD_HASH => [

          'get' => function( $self, $property ) {

            return mud_raw()->get_a_std_password_hash( $self[ A_STD_USER_PASSWORD_HASH_ID ] );

          },

          'set' => function( $self, $property, $value ) {

            $password_hash_id = mud_raw()->add_row_t_particle_std_password_hash( $value );

            $self[ A_STD_USER_PASSWORD_HASH_ID ] = $password_hash_id;

          },
        ],
      ];
    }

    parent::__construct( $tab_name, $col_list, $col_map, $default, $custom_properties + $virtual_properties );

  }
}
