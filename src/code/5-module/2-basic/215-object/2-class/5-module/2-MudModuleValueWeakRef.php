<?php

// 2024-07-01 jj5 - NOTE: this was just a reference implementation. I wrote this before I decided to make IMudThings be
// linked lists... that change will complicate the code below, so I'm going to leave it as is for now...

class MudModuleValueWeakRef extends MudModuleValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public instance methods...
  //

   public function get_atom( string $class, mixed $value ) : IMudAtom {

    if ( $value === null ) { return $this->get_null(); }

    $key = $this->get_atom_key( $value );

    $ref = $this->atom_map[ $class ][ $key ] ?? null;

    if ( ! $ref || $ref->get() === null ) {

      $ref = $this->new_atom( $class, $value );

      $this->atom_map[ $class ][ $key ] = $ref;

    }

    return $this->atom_map[ $class ][ $key ]->get();

  }

  public function get_composite( string $class, array $value_list ) : IMudComposite {

    if ( count( $value_list ) === 0 ) {
      
       $is_null = true;
       
    }
    else {

      $is_null = false;

      foreach ( $value_list as $value ) { if ( $value === null ) { $is_null = true; break; } }

    }

    if ( $is_null ) { return $this->get_null(); }

    $key = $this->get_composite_key( $value_list );

    $ref = $this->composite_map[ $class ][ $key ] ?? null;

    if ( ! $ref || $ref->get() === null ) {

      $ref = $this->new_atom( $class, $value );

      $this->composite_map[ $class ][ $key ] = $ref;

    }

    return $this->composite_map[ $class ][ $key ]->get();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - protected instance methods...
  //

  protected function new_atom( string $class, mixed $value ) : WeakReference {

    $new_value = new $class( $value );

    $this->atom_count += 1;

    if ( DEBUG ) { $this->atom_size += $this->get_size( $new_value ); }

    return $this->new_weak_ref( $new_value );

  }

  protected function new_composite( string $class, array $value_list ) : WeakReference {

    $new_value = new $class( $value_list );

    $this->composite_count += 1;

    if ( DEBUG ) { $this->composite_size += $this->get_size( $new_value ); }

    return $this->new_weak_ref( $new_value );

  }

  protected function new_weak_ref( $value ) : WeakReference {

    return WeakReference::create( $value );

  }
}
