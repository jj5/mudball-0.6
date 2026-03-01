<?php

//abstract class MudSchema_mudballdb_views extends MudSchemaDef {

trait mud_mudballdb_2021_08_30_090715_view {

  public function define_views() {

    // 2020-09-15 jj5 - TEMP: skip views for now...
    //
    return;

    $select_operation = MudDatabaseOperation::SELECT;
    $insert_operation = MudDatabaseOperation::INSERT;
    $update_operation = MudDatabaseOperation::UPDATE;
    $delete_operation = MudDatabaseOperation::DELETE;

    $raw_connection = MudDatabaseConnectionType::RAW;
    $trn_connection = MudDatabaseConnectionType::TRN;

    def_view( 'v_structure_std_email_address', function ( $prefix ) {

      return "
        create view {$prefix}v_structure_std_email_address as
        select
          email_address.a_std_email_address_id,
          email_address.a_std_email_address,
          email_address.a_std_email_address_mailbox_id,
          mailbox.a_std_mailbox,
          mailbox.a_std_mailbox_ci,
          email_address.a_std_email_address_hostname_id,
          hostname.a_std_hostname,
          email_address.a_std_email_address_hash_bin
          -- email_address.a_std_email_address_created_on,
          -- email_address.a_std_email_address_updated_on
        from
          {$prefix}t_structure_std_email_address email_address
        left join
          {$prefix}t_pstring_std_mailbox mailbox
        on
          email_address.a_std_email_address_mailbox_id = mailbox.a_std_mailbox_id
        left join
          {$prefix}t_particle_std_hostname hostname
        on
          email_address.a_std_email_address_hostname_id = hostname.a_std_hostname_id
      ";

    });

  }
}
