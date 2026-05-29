<?php

class mud_action_admin_user_create extends MudAction {

  public function process( $request, $response ) {

    $username = $request->get_input( APP_INPUT_USERNAME );
    $email_address = $request->get_input( APP_INPUT_EMAIL_ADDRESS );
    $password = $request->get_input( APP_INPUT_PASSWORD );
    $password_confirm = $request->get_input( APP_INPUT_PASSWORD_CONFIRM );

    if ( $password !== $password_confirm ) {

      $response->set_error( APP_INPUT_PASSWORD_CONFIRM, 'passwords do not match.' );

    }

    // 2026-05-28 jj5 - TODO: validate contact method details...
    //$response->set_list_error( 'contact-method-detail', 2, 'contact method details are required.' );

    if ( $response->has_errors() ) {

      return $request->get_submission();

    }

    $user_iid = mud_new_iid();

    $password_hash = password_hash( $password, PASSWORD_DEFAULT );

    $sql = "
      insert into t_entity__std_user ( a_std_user_iid, a_std_user_password_hash )
      values ( :iid, :password_hash )
    ";

    mud_trn()->execute(
      $sql,
      [
        ':iid' => $user_iid,
        ':password_hash' => $password_hash,
      ]
    );

    $sql = "
      insert into t_entity__std_user_pii ( a_std_user_pii_iid, a_std_user_pii_username, a_std_user_pii_email )
      values ( :iid, :username, :email )
    ";

    mud_trn()->execute(
      $sql,
      [
        ':iid' => $user_iid,
        ':username' => $username,
        ':email' => $email_address,
      ]
    );

    mud_trn()->commit();

    $user_xid = mud_xid_from_iid( $user_iid );

    $response->redirect( APP_URL_BASE . '/admin/user/list' );

    return true;

  }
}

return new mud_action_admin_user_create();
