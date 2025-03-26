<?php

function add_abinitio( string $name, ?string $type_code = null ) : MudModelObjectAddition {

  return mud_model_version()->add_abinitio( $name, $type_code );

}

class mud_model_abinitio extends MudModelObject {

}

class mud_model_abinitio_add extends MudModelObjectAddition {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::ABINITIO;

  }

  public function create_object( MudModel $model ) : MudModelObject {

    return new mud_model_abinitio( $this->name, $this->type_code, $this->get_specific_type() );

  }
}

class mud_model_abinitio_mod extends MudModelObjectModification {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::ABINITIO;

  }

  public function apply_model( MudModel $model ) {

    mud_not_implemented();

  }
}

class mud_model_abinitio_del extends MudModelObjectDeletion {

  public function get_specific_type() : MudModelSpecificType {

    return MudModelSpecificType::ABINITIO;

  }

  public function apply_model( MudModel $model ) {

    mud_not_implemented();

  }
}
