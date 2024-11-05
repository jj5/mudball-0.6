<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_controller.php';


//////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - declare test hosts...
//

class TestWebController extends MudWebController {

  public function get_is_valid_selector( $selector ) {

    return $this->is_valid_selector( $selector );

  }
}


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - is_valid_selector test...
  //

  'is_valid_selector' => function() {

    $host = new TestWebController();

    assert( $host->get_is_valid_selector( [ 'this is okay' ] ) );

    assert( ! $host->get_is_valid_selector( [ "this\nis\nnot\nokay" ] ) );

    assert( ! $host->get_is_valid_selector( [ ' not okay' ] ) );

    assert( ! $host->get_is_valid_selector( [ 'also not okay ' ] ) );

    assert( ! $host->get_is_valid_selector( [ '..' ] ) );

    assert( ! $host->get_is_valid_selector( [ "\x00" ] ) );

    for ( $chr = 0; $chr <= 31; $chr++ ) {

      assert( ! $host->get_is_valid_selector( [ chr( $chr ) ] ) );

    }

    assert( ! $host->get_is_valid_selector( [ "\x7f" ] ) );

    return 0;

  },

]);
