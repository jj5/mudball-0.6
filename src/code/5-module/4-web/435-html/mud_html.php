<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../430-session/mud_session.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - module error definitions...
//

mud_define_error( 'MUD_ERR_HTML_DOCUMENT_UNINITIALIZED', 'HTML document uninitialized.' );
mud_define_error( 'MUD_ERR_HTML_CLOSE_TAG_INVALID', 'close tag invalid.' );
mud_define_error( 'MUD_ERR_HTML_TITLE_UNSET', 'title unset.' );
mud_define_error( 'MUD_ERR_HTML_DUPLICATE_ID', 'duplicate ID.' );
mud_define_error( 'MUD_ERR_HTML_TAG_INVALID', 'invalid tag.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleHtml.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - functional interface...
//

function doc_open() {

  return mud_module_html()->doc_open();

}

function doc_is_initialized() {

  return mud_module_html()->doc_is_initialized();
  
}

function doc_init(
  string $doctype = MUD_HTML_DEFAULT_DOCTYPE,
  string $lang = MUD_HTML_DEFAULT_LANG,
  string $charset = MUD_HTML_DEFAULT_CHARSET,
  string $content_type = MUD_HTML_DEFAULT_CONTENT_TYPE,
) : MudModuleHtml {

  return mud_module_html()->doc_init( $doctype, $lang, $charset, $content_type );

}

function doc_echo() : MudModuleHtml {

  return mud_module_html()->doc_echo();

}

function doc_done( &$html = null, bool $echo = true ) : MudModuleHtml {

  return mud_module_html()->doc_done( $html, $echo );

}

function doc_fail() : MudModuleHtml {

  return mud_module_html()->doc_fail();

}

// 2017-06-01 jj5 - if you want to create a HTML snippet, call nip_init() then
// when you're done call nip_done() to get the output...
// 2017-06-01 jj5 - THINK: maybe this should be done without output buffering?
function nip_init( array $options = [] ) : MudModuleHtml {

  return mud_module_html()->nip_init( $options );

}

function nip_echo() : MudModuleHtml {

  return mud_module_html()->nip_echo();

}

function nip_done( &$snip = null, bool $echo = false ) : MudModuleHtml {

  return mud_module_html()->nip_done( $snip, $echo );

}

function nip_fail() : MudModuleHtml {

  return mud_module_html()->nip_fail();

}

function mud_html_get_doctype() : string {

  return mud_module_html()->get_doctype();

}

function mud_html_get_lang() : string {

  return mud_module_html()->get_lang();

}

function mud_html_get_charset() : string {

  return mud_module_html()->get_charset();

}

function mud_html_get_setting( string $setting ) {

  return mud_module_html()->get_setting( $setting );

}

function mud_html_get_opt_autoxsrf() : bool {

  return mud_module_html()->get_opt_autoxsrf();

}

function mud_html_set_opt( string $option, $value ) : MudModuleHtml {

  return mud_module_html()->set_opt( $option, $value );

}

function mud_html_get_opt( string $option, $default = null ) {

  return mud_module_html()->get_opt( $option, $default );

}

function mud_html_render_table(
  $context,
  array $table,
  array $attrs = [],
  array $column_headers = [],
  array $column_types = [],
  array $column_formatters = [],
  int $flags = MUD_HTML_DEFAULT_TABLE_FLAGS
) : MudModuleHtml {

  return mud_module_html()->render_table(
    $context,
    $table,
    $attrs,
    $column_headers,
    $column_types,
    $column_formatters,
    $flags
  );
}

function mud_html_render_open_form_table( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_open_form_table( $context, $attrs );

}

function mud_html_render_shut_form_table( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_shut_form_table( $context, $attrs );

}

function mud_html_render_input_row_text( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_input_row_text( $context, $attrs );

}

function mud_html_render_input_row_password( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_input_row_password( $context, $attrs );

}

function mud_html_render_input_row_submit( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_input_row_submit( $context, $attrs );

}

function mud_html_render_input_row_button( $context, array $attrs ) : MudModuleHtml {

  return mud_module_html()->render_input_row_button( $context, $attrs );

}

function put_note( string $content ) : MudModuleHtml {

  return mud_module_html()->put_note( $content );

}

function put_html(
  string $tag_or_html,
  $html_for_tag = null,
  array $attrs = []
) : MudModuleHtml {

  return mud_module_html()->put_html( $tag_or_html, $html_for_tag, $attrs );

}

function put_text(
  string $tag_or_text,
  $text_for_tag = null,
  array $attrs = []
) : MudModuleHtml {

  return mud_module_html()->put_text( $tag_or_text, $text_for_tag, $attrs );

}

function tag_meta( $name, $content ) : MudModuleHtml {

  return mud_module_html()->tag_meta( $name, $content );

}

function tag_link( $type, $rel, $href, $sizes = null ) : MudModuleHtml {

  return mud_module_html()->tag_link( $type, $rel, $href, $sizes );

}

function tag_cell( string $tag, $value, array $attrs = [] ) : MudModuleHtml {

  return mud_module_html()->tag_cell( $tag, $value, $attrs );

}

function tag_bare( string $tag, array $attrs = [] ) : MudModuleHtml {

  return mud_module_html()->tag_bare( $tag, $attrs );

}

function tag_text(
  string $tag,
  $text,
  array $attrs = []
) : MudModuleHtml {

  return mud_module_html()->tag_text( $tag, $text, $attrs );

}

function tag_html(
  string $tag,
  string $html,
  array $attrs = []
) : MudModuleHtml {

  return mud_module_html()->tag_html( $tag, $html, $attrs );

}

function tag_open( string $tag, array $attrs = [] ) : MudModuleHtml {

  return mud_module_html()->tag_open( $tag, $attrs );

}

function tag_shut( string $tag, array $attrs = [] ) : MudModuleHtml {

  return mud_module_html()->tag_shut( $tag, $attrs );

}

// 2019-09-13 jj5 - I'm not happy with the unprefixed names get_attr() and
// attrs_to_html() and as these functions probably don't need to be available
// in the global namespace I have removed them for now...
//
/*
function get_attr( array $attrs, string $name, $default = null ) {

  return mud_module_html()->get_attr( $attrs, $name, $default );

}

function attrs_to_html( array $attrs, string $tag ) : string {

  return mud_module_html()->attrs_to_html( $attrs, $tag );

}
*/

function out_line( int $lines = 1 ) : MudModuleHtml {

  return mud_module_html()->out_line( $lines );

}

function out_html( $html ) :MudModuleHtml {

  return mud_module_html()->out_html( $html );

}

function out_text( $text ) : MudModuleHtml {

  return mud_module_html()->out_text( $text );

}

function out_code( $code ) : MudModuleHtml {

  return mud_module_html()->out_code( $code );

}

// 2022-02-19 jj5 - these new functions are for getting {id,for,name} attribute values from a
// column name constant. Column name constants are in the form 'a_{mud,app}_whatever'...

function mud_attr_id( $col ) {

  return mud_module_html()->attr_id( $col );

}

// 2022-02-19 jj5 - we keep a running tab index as a convenience...

function mud_tab_index( $set = false ) { return mud_module_html()->tab_index( $set ); }


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_html() : MudModuleHtml {

  return mud_locator()->get_module( MudModuleHtml::class );

}
