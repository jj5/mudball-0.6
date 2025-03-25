<?php

function mud_specific_table_pattern() {

  return mud_new_thing( MudSpecificTablePattern::class, func_get_args() );

}

class MudSpecificTablePattern extends MudThing {


}

class MudNullSpecificTablePattern extends MudSpecificTablePattern {

  use MudNullObjectMixin;

}
