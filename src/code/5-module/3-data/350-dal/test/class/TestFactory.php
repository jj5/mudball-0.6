<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-29 jj5 - helper classes...
//

class TestFactory {

  /*
 public function get_mudballdb() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudSchema_mudballdb(); }

   return $instance;

 }

 public function get_bomapp() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudSchema_bomapp(); }

   return $instance;

 }
  */

 public function get_trn() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudDatabase( MUD_CONNECTION_TYPE_TRN ); }

   return $instance;

 }

 public function get_raw() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudDatabase( MUD_CONNECTION_TYPE_RAW ); }

   return $instance;

 }

 public function get_emu() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudDatabase( MUD_CONNECTION_TYPE_EMU ); }

   return $instance;

 }

 public function get_dba() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudDatabase( MUD_CONNECTION_TYPE_DBA ); }

   return $instance;

 }

 public function get_cache( string $name ) {

   static $cache = [];

   if ( ! array_key_exists( $name, $cache ) ) {

     $cache[ $name ] = new MudCache( $name );

   }

   return $cache[ $name ];

 }

 /*
 public function get_schema_manager() {

   static $instance = null;

   if ( $instance === null ) { $instance = new MudSchemaManager(); }

   return $instance;

 }
 */

 public function new_database_upgrader( $schema_list, $dba ) {

   return MudDatabaseUpgrader::Create( $schema_list, $dba );

 }

 public function new_schema_loader() {

   return MudSchemaLoader::Create();

 }
}
