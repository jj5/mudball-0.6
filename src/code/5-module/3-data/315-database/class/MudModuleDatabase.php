<?php

class MudModuleDatabase extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-03-01 jj5 - public methods...
  //

  function is_dcl( $sql ) {

      // 2026-01-28 jj5 - NOTE: DCL = Data Control Language, these statements affect permissions
      // and user accounts, and cannot be rolled back via transaction... also they cause
      // implicit commits.

      static $prefix_list = [
        'GRANT ',
        'REVOKE ',
        'CREATE USER ',
        'DROP USER ',
        'ALTER USER ',
        'SET PASSWORD ',
        'RENAME USER ',
      ];

      $test_string = strtoupper( preg_replace( '/\s+/', ' ', trim( substr( $sql, 0, 64 ) ) ) );

      foreach ( $prefix_list as $prefix ) {
        if ( str_starts_with( $test_string, $prefix ) ) {
          return true;
        }
      }

      return false;

  }

  function is_ddl( $sql ) {

      // 2026-01-28 jj5 - NOTE: DDL = Data Definition Language, these statements affect
      // the structure of the database and cannot be rolled back via transaction... also they
      // cause implicit commits.

      static $prefix_list = [
        'CREATE TABLE ',
        'DROP TABLE ',
        'ALTER TABLE ',
        'RENAME TABLE ',
        'CREATE INDEX ',
        'DROP INDEX ',
        'CREATE VIEW ',
        'DROP VIEW ',
        'CREATE TRIGGER ',
        'DROP TRIGGER ',
        'CREATE PROCEDURE ',
        'DROP PROCEDURE ',
        'CREATE FUNCTION ',
        'DROP FUNCTION ',
        'CREATE EVENT ',
        'DROP EVENT ',
        'CREATE DATABASE ',
        'DROP DATABASE ',
        'ALTER DATABASE ',
        // 2026-01-28 jj5 - NOTE: TRUNCATE is DDL in MySQL it is not transactional like DELETE
        'TRUNCATE TABLE ',
        // 2026-01-28 jj5 - NOTE: this causes implicit commit in MySQL
        'ALTER TEMPORARY TABLE ',
      ];

      // 2026-01-28 jj5 - NOTE: these don't count as DDL even though they look like it, they
      // don't cause implicit commits:
      //* 'CREATE TEMPORARY TABLE ',
      //* 'DROP TEMPORARY TABLE ',

      $test_string = strtoupper( preg_replace( '/\s+/', ' ', trim( substr( $sql, 0, 64 ) ) ) );

      foreach ( $prefix_list as $prefix ) {
        if ( str_starts_with( $test_string, $prefix ) ) {
          return true;
        }
      }

      return false;

  }

  function is_dml( $sql ) {

      // 2026-01-28 jj5 - NOTE: DML = Data Manipulation Language, but the real question is
      // whether this operation can be rolled back via transaction or not...

      static $prefix_list = [
        'SELECT ',
        'INSERT ',
        'UPDATE ',
        'DELETE ',
        'REPLACE ',
        // 2026-01-28 jj5 - for transactional tables
        'LOAD DATA INFILE ',
        // 2026-01-28 jj5 - most session variables
        'SET ',
        'DO ',
        'CALL ',
        // 2026-01-28 jj5 - NOTE: these don't count as DDL even though they look like it, they
        // don't cause implicit commits.
        'CREATE TEMPORARY TABLE ',
        'DROP TEMPORARY TABLE ',
      ];

      $test_string = strtoupper( preg_replace( '/\s+/', ' ', trim( substr( $sql, 0, 64 ) ) ) );

      foreach ( $prefix_list as $prefix ) {
        if ( str_starts_with( $test_string, $prefix ) ) {
          return true;
        }
      }

      return false;

  }
}
