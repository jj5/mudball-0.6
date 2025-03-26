<?php

function add_lookup( string $name ) : MudModelObjectAddition {

  return mud_model_version()->add_lookup( $name );

}

class mud_model_lookup extends MudModelObject {

}

class mud_model_lookup_add extends MudModelObjectAddition {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::LOOKUP;

  }

  public function create_object( MudModel $model ) : MudModelObject {

    return new mud_model_lookup( $this->name, $this->type_code, $this->get_specific_type() );

  }
}

class mud_model_lookup_mod extends MudModelObjectModification {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::LOOKUP;

  }

  public function apply_model( MudModel $model ) {

    mud_not_implemented();

  }
}

class mud_model_lookup_del extends MudModelObjectDeletion {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::LOOKUP;

  }

  public function apply_model( MudModel $model ) {

    mud_not_implemented();

  }
}
