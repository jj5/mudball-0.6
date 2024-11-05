<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_cache.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - declare examples...
//

declare_examples([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - cache example...
  //

  'cache example' => function() {

    mud_init();

    // 2021-04-11 jj5 - create a new cache, the cache name is used in the file name for the
    // SQLite database for this cache...
    //
    $cache = new_mud_cache( $cache_name = 'example-' . md5( microtime() ) );

    // 2021-04-11 jj5 - a cache container is just a scope for particular types of key/value pairs
    // stored in the cache...
    //
    $container = 'example-container';

    // 2021-04-11 jj5 - the $id is the key and the $value is the associated value... note that
    // complex types are supported for both the $id and the $value...
    //
    $id = [ 'example' => md5( microtime() ) ];
    $value = [ 'some value' => 123 ];

    // 2021-04-11 jj5 - first determine that there is no value for this $id in our cache...
    //
    if ( $cache->read( $container, $id, $cache_key, $stored_value ) ) {

      assert( false );

    }
    else {

      assert( $stored_value === null );

    }

    // 2021-04-11 jj5 - now write the value to the cache using the $cache_key that was
    // generated in the previous step...
    //
    $cache->write( $container, $cache_key, $value );

    // 2021-04-11 jj5 - now determine that there is a $stored_value for this $id and it's the
    // correct value...
    //
    if ( $cache->read( $container, $id, $cache_key, $stored_value ) ) {

      assert( $stored_value === $value );

    }
    else {

      assert( false );

    }

    // 2021-04-11 jj5 - let's peek into the database for our value...
    //
    $pdo = MudCache::CreatePDO( $cache->get_path(), PDO::FETCH_ASSOC );
    $table_name = $cache->get_table_name( $container );
    $sql = "select value from $table_name where key = :key";
    $params = [ ':key' => $cache_key ];
    $stmt = $pdo->prepare( $sql );
    $stmt->execute( $params );
    $row = $stmt->fetch();

    // 2021-04-11 jj5 - this is what $value will look like when serialized as JSON...
    //
    assert( $row[ 'value' ] === '{"some value":123}' );

    // 2021-04-11 jj5 - we're done with our example cache so let's destroy its SQLite database...
    //
    $cache->destroy();

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - cache example with JSON serialization...
  //

  'cache example with JSON serialization' => function() {

    mud_init();

    // 2021-04-11 jj5 - create a new cache, the cache name is used in the file name for the
    // SQLite database for this cache...
    //
    $cache = new_mud_cache( $cache_name = 'example-' . md5( microtime() ) );

    // 2021-04-11 jj5 - a cache container is just a scope for particular types of key/value pairs
    // stored in the cache...
    //
    $container = 'example-container';

    // 2021-04-11 jj5 - set up our example container to use JSON serialization instead of
    // default PHP serialization...
    //
    $cache->register_serializer( $container, $cache->get_json_serializer() );

    // 2021-04-11 jj5 - the $id is the key and the $value is the associated value... note that
    // complex types are supported for both the $id and the $value...
    //
    $id = [ 'example' => md5( microtime() ) ];
    $value = [ 'some value' => 123 ];

    // 2021-04-11 jj5 - first determine that there is no value for this $id in our cache...
    //
    if ( $cache->read( $container, $id, $cache_key, $stored_value ) ) {

      assert( false );

    }
    else {

      assert( $stored_value === null );

    }

    // 2021-04-11 jj5 - now write the value to the cache using the $cache_key that was
    // generated in the previous step...
    //
    $cache->write( $container, $cache_key, $value );

    // 2021-04-11 jj5 - now determine that there is a $stored_value for this $id and it's the
    // correct value...
    //
    if ( $cache->read( $container, $id, $cache_key, $stored_value ) ) {

      assert( $stored_value === $value );

    }
    else {

      assert( false );

    }

    // 2021-04-11 jj5 - let's peek into the database for our value...
    //
    $pdo = MudCache::CreatePDO( $cache->get_path(), PDO::FETCH_ASSOC );
    $table_name = $cache->get_table_name( $container );
    $sql = "select value from $table_name where key = :key";
    $params = [ ':key' => $cache_key ];
    $stmt = $pdo->prepare( $sql );
    $stmt->execute( $params );
    $row = $stmt->fetch();

    // 2021-04-11 jj5 - this is what $value will look like when serialized as PHP...
    //
    assert( $row[ 'value' ] === 'a:1:{s:10:"some value";i:123;}' );

    // 2021-04-11 jj5 - we're done with our example cache so let's destroy its SQLite database...
    //
    $cache->destroy();

    return 0;

  },

]);
