<?php

class MudActiveConfig extends MudGadget {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public fields...
  //

  public $tab_name;
  public $col_list;
  public $col_map;
  public $default;
  public $virtual_properties;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [
      'class' => get_class( $this ),
      'tab_name' => $this->tab_name,
      'col_map' => $this->col_map,
      'default' => $this->default,
    ];

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - constructor...
  //

  public function __construct(
    string $tab_name,
    array $col_list,
    array $col_map,
    array $default,
    array $virtual_properties = []
  ) {

    $this->tab_name = $tab_name;
    $this->col_list = $col_list;
    $this->col_map = $col_map;
    $this->default = $default;
    $this->virtual_properties = $virtual_properties;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-05 jj5 - public methods...
  //

  public function get_virtual_properties() { return $this->virtual_properties; }

}
