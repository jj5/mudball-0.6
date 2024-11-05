<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include dependencies...
//

require_once __DIR__ . '/../370-reader/mud_reader.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_ORM_INVALID_FUNCTION', 'invalid function.' );
mud_define_error( 'MUD_ERR_ORM_INVALID_ARG', 'invalid argument.' );
mud_define_error( 'MUD_ERR_ORM_TABLE_CONST_MISSING', 'table const missing.' );
mud_define_error( 'MUD_ERR_ORM_CLASS_MISSING', 'class missing.' );
mud_define_error( 'MUD_ERR_ORM_NO_SUCH_PROPERTY', 'no such property.' );
mud_define_error( 'MUD_ERR_ORM_CANNOT_SAVE_DELETED_RECORD', 'cannot save deleted record.' );
mud_define_error( 'MUD_ERR_ORM_DELETE_FAILED', 'delete failed.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - include components...
//

require_once __DIR__ . '/class/MudActiveConfig.php';
require_once __DIR__ . '/class/MudActiveRecord.php';
require_once __DIR__ . '/class/MudOrm.php';
require_once __DIR__ . '/class/MudModuleOrm.php';

mud_load_files( __DIR__ . '/config' );
mud_load_files( __DIR__ . '/record' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - functional interface...
//


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locator...
//

function mud_module_orm() : MudModuleOrm {

  return mud_locator()->get_module( MudModuleOrm::class );

}
