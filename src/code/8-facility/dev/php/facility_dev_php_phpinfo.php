<?php

class mud_facility_dev_php_phpinfo extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    phpinfo();

  }
}

return new mud_facility_dev_php_phpinfo();
