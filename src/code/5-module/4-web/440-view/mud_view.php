<?php


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2021-08-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../435-html/mud_html.php';


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/trait/1-MudViewMixin.php';
require_once __DIR__ . '/trait/2-MudViewTemplate.php';
require_once __DIR__ . '/trait/3-MudViewForms.php';

require_once __DIR__ . '/class/MudModuleView.php';


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - functional interface...
//

function mud_render_head( $context = null, $args = [] ) {
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - functional interface...
//

function mud_render_head( $context, $args = [] ) {
>>>>>>> e3a066e (Work, work...)

  return mud_module_view()->render_head( $context, $args );

}

<<<<<<< HEAD
function mud_render_foot( $context = null, $args = [] ) {
=======
function mud_render_foot( $context, $args = [] ) {
>>>>>>> e3a066e (Work, work...)

  return mud_module_view()->render_foot( $context, $args );

}

function mud_render_form_open(
    $context,
    $name = null,
    $default_action = null,
    $method = 'POST',
    $id = null,
    $attrs = []
  ) {

  return mud_module_view()->render_form_open( $context, $name, $default_action, $method, $id, $attrs );

}

function mud_render_form_shut( $context ) {

  return mud_module_view()->render_form_shut( $context );

}

function mud_render_form_login( $context ) {

  return mud_module_view()->render_form_login( $context );

}

function mud_render_form_credential_forgot( $context ) {

  return mud_module_view()->render_form_credential_forgot( $context );

}

function mud_render_form_signup( $context ) {

  return mud_module_view()->render_form_signup( $context );

}

function mud_render_form_complex_idea( $context ) {

  return mud_module_view()->render_form_complex_idea( $context );

}


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_view() : MudModuleView {

  return mud_locator()->get_module( MudModuleView::class );

}
