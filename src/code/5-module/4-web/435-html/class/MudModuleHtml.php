<?php


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - default HTML utility functionality, can be extended...
//
//

class MudModuleHtml extends MudModuleWeb {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public fields...
  //

  // 2019-09-13 jj5 - TODO: we need to document pseudo-attributes which aren't
  // for use as HTML attributes such as 'opt-space', 'mud-label', etc.
  // Consider a prefix such as 'mud-', so 'mud-opt-space', 'mud-label', etc..?

  // 2019-09-02 jj5 - SEE: HTML5 Elements:
  // https://html.spec.whatwg.org/dev/indices.html#elements-3


  // 2017-06-01 jj5 - the 'state' variable tracks output state, it is
  // (re)initialised in mud_html_doctype().
  //
  public $html_state = [];

  // 2018-06-17 jj5 - if new documents/snippets get initialised the previous
  // states get pushed here so we can re-instate it when we're done...
  //
  public $html_state_stack = [];

  // 2019-09-02 jj5 - TODO: use the HTML5 Elements above and the 'parents'
  // spec. Then each time we add a child element validate that it's valid
  // in the current context.

  public $html_elements = [];

  public $html_attrs = [

    'accept' => [
      'type' => 'string',
      'on' => [ 'input' ],
    ],

    'accept-charset' => [
      'type' => 'string',
      'on' => [ 'form' ],
    ],

    // 2017-06-01 jj5 - TODO: check if 'accesskey' supports multiple values...
    'accesskey' => [
      'type' => 'char',
      'on' => [],
    ],

    'action' => [
      'type' => 'url',
      'on' => [ 'form' ],
    ],

    // 'align' is not supported in HTML5.

    'alt' => [
      'type' => 'string',
      'on' => [ 'area', 'img', 'input' ],
    ],

    'async' => [
      'type' => 'bool',
      'on' => [ 'script' ],
    ],

    'autocomplete' => [
      'type' => 'enum',
      'values' => [ 'on', 'off' ],
      'on' => [ 'form', 'input' ],
    ],

    'autofocus' => [
      'type' => 'bool',
      // 2017-06-01 jj5 - 'keygen' is deprecated, eliding...
      'on' => [ 'button', 'input', 'select', 'textarea' ],
    ],

    'autoplay' => [
      'type' => 'bool',
      'on' => [ 'audio', 'video' ],
    ],

    // 'bgcolor' is not supported in HTML5.

    // 'border' is not supported in HTML5.

    // 'challenge' used by <keygen>, which is deprecated

    // 2017-06-01 jj5 - THINK: maybe make this an enum..?
    'charset' => [
      'type' => 'string',
      'on' => [ 'meta', 'script' ],
    ],

    'checked' => [
      'type' => 'bool',
      'on' => [ 'input' ],
    ],

    'cite' => [
      'type' => 'url',
      'on' => [ 'blockquote', 'del', 'ins', 'q' ],
    ],

    // 2017-06-01 jj5 - I think 'subtype' = 'id' is OK for class names...
    'class' => [
      'type' => 'list',
      'subtype' => 'id',
      'separator' => ' ',
      'on' => [],
    ],

    // 'color' is not supported in HTML5.

    'cols' => [
      'type' => 'int',
      'on' => [ 'textarea' ],
    ],

    'colspan' => [
      'type' => 'int',
      'on' => [ 'td', 'th' ],
    ],

    'content' => [
      'type' => 'string',
      'on' => [ 'meta' ],
    ],

    'contenteditable' => [
      'type' => 'enum',
      'values' => [ 'true', 'false' ],
      'on' => [],
    ],

    'contextmenu' => [
      'type' => 'id',
      'on' => [],
    ],

    'controls' => [
      'type' => 'bool',
      'on' => [ 'audio', 'video' ],
    ],

    'coords' => [
      'type' => 'list',
      'subtype' => 'int',
      'separator' => ',',
      'on' => [ 'area' ],
    ],

    'data' => [
      'type' => 'url',
      'on' => [ 'object' ],
    ],

    // 2017-06-01 jj5 - THINK: do we want a 'datetime' type? Probably not
    // necessary...
    'datetime' => [
      'type' => 'string',
      'on' => [ 'del', 'ins', 'time' ],
    ],

    'default' => [
      'type' => 'bool',
      'on' => [ 'track' ],
    ],

    'defer' => [
      'type' => 'bool',
      'on' => [ 'script' ],
    ],

    'dir' => [
      'type' => 'enum',
      'values' => [ 'ltr', 'rtl', 'auto' ],
      'on' => [],
    ],

    // 2017-06-01 jj5 - SEE: HTML dirname Attribute
    // https://www.w3schools.com/tags/att_dirname.asp
    // 2017-06-01 jj5 - we could probably do some validation on these...
    'dirname' => [
      'type' => 'dirname',
      'on' => [ 'input', 'textarea' ],
    ],

    // 2017-06-01 jj5 - 'keygen' is deprecated, eliding...
    'disabled' => [
      'type' => 'bool',
      'on' => [
        'button',
        'fieldset',
        'input',
        'optgroup',
        'option',
        'select',
        'textarea',
      ],
    ],

    'download' => [
      'type' => 'string',
      'on' => [ 'a', 'area' ],
    ],

    'draggable' => [
      'type' => 'enum',
      'values' => [ 'true', 'false', 'auto' ],
      'on' => [],
    ],

    'dropzone' => [
      'type' => 'enum',
      'values' => [ 'copy', 'move', 'link' ],
      'on' => [],
    ],

    'enctype' => [
      'type' => 'enum',
      'values' => [
        'application/x-www-form-urlencoded',
        'multipart/form-data',
        'text/plain',
      ],
      'on' => [ 'form' ],
    ],

    'for' => [
      'type' => 'id',
      'on' => [ 'label', 'output' ],
    ],

    // 2017-06-01 jj5 - NOTE: 'keygen' is deprecated, eliding...
    'form' => [
      'type' => 'id',
      'on' => [
        'button',
        'fieldset',
        'input',
        'label',
        'meter',
        'object',
        'output',
        'select',
        'textarea'
      ],
    ],

    'formaction' => [
      'type' => 'url',
      'on' => [ 'button', 'input' ],
    ],

    'headers' => [
      'type' => 'list',
      'subtype' => 'id',
      'separator' => ' ',
      'on' => [ 'td', 'th' ],
    ],

    'height' => [
      'type' => 'int',
      'on' => [
        'canvas',
        'embed',
        'iframe',
        'img',
        'input',
        'object',
        'video',
      ],
    ],

    'hidden' => [
      'type' => 'bool',
      'on' => [],
    ],

    'high' => [
      'type' => 'number',
      'on' => [ 'meter' ],
    ],

    'href' => [
      'type' => 'url',
      'on' => [ 'a', 'area', 'base', 'link' ],
    ],

    'hreflang' => [
      'type' => 'lang',
      'on' => [ 'a', 'area', 'link' ],
    ],

    // 2017-06-01 jj5 - TODO: if 'http-equiv' is specified, maybe we could
    // validate the associated 'content' attribute based on the 'http-equiv'
    // value...
    'http-equiv' => [
      'type' => 'enum',
      'values' => [
        'content-type',
        'default-style',
        'refresh',
      ],
      'on' => [ 'meta' ],
    ],

    // 2017-06-01 jj5 - TODO: validate HTML ID attributes, make sure they
    // are unique in the output...
    'id' => [
      'type' => 'id',
      'on' => [],
    ],

    'ismap' => [
      'type' => 'bool',
      'on' => [ 'img' ],
    ],

    // 'keytype' used by <keygen>, which is deprecated

    'kind' => [
      'type' => 'enum',
      'values' => [
        'captions',
        'chapters',
        'descriptions',
        'metadata',
        'subtitles',
      ],
      'on' => [ 'track' ],
    ],

    'label' => [
      'type' => 'string',
      'on' => [ 'track', 'option', 'optgroup' ],
    ],

    'lang' => [
      'type' => 'lang',
      'on' => [],
    ],

    'list' => [
      'type' => 'id',
      'on' => [ 'input' ],
    ],

    'loop' => [
      'type' => 'bool',
      'on' => [ 'audio', 'video' ],
    ],

    'low' => [
      'type' => 'number',
      'on' => [ 'meter' ],
    ],

    'max' => [
      'type' => 'number-date',
      'on' => [ 'input', 'meter', 'progress' ],
    ],

    'maxlength' => [
      'type' => 'int',
      'on' => [ 'input', 'textarea' ],
    ],

    // 2017-06-01 jj5 - we could do media type validation, but not today!
    'media' => [
      'type' => 'string',
      'on' => [ 'a', 'area', 'link', 'source', 'style' ],
    ],

    // 2017-06-01 jj5 - NOTE: I think these are the only verbs supported.
    'method' => [
      'type' => 'enum',
      'values' => [ 'GET', 'POST' ],
      'on' => [ 'form' ],
    ],

    'min' => [
      'type' => 'number-date',
      'on' => [ 'input', 'meter' ],
    ],

    'multiple' => [
      'type' => 'bool',
      'on' => [ 'input', 'select' ],
    ],

    'muted' => [
      'type' => 'bool',
      'on' => [ 'video', 'audio' ],
    ],

    // 2017-06-01 jj5 - 'keygen' is deprecated, eliding...
    'name' => [
      'type' => 'string',
      'on' => [
        'button',
        'fieldset',
        'form',
        'iframe',
        'input',
        'map',
        'meta',
        'object',
        'output',
        'param',
        'select',
        'textarea',
      ],
    ],

    'novalidate' => [
      'type' => 'bool',
      'on' => [ 'form' ],
    ],

    'open' => [
      'type' => 'bool',
      'on' => [ 'details' ],
    ],

    'optimum' => [
      'type' => 'number',
      'on' => [ 'meter' ],
    ],

    // 2017-06-01 jj5 - typed as 'string', but it's a regex.
    'pattern' => [
      'type' => 'string',
      'on' => [ 'input' ],
    ],

    'placeholder' => [
      'type' => 'string',
      'on' => [ 'input', 'textarea' ],
    ],

    'poster' => [
      'type' => 'url',
      'on' => [ 'video' ],
    ],

    'preload' => [
      'type' => 'enum',
      'values' => [ 'auto', 'metadata', 'none' ],
      'on' => [ 'audio', 'video' ],
    ],

    'readonly' => [
      'type' => 'bool',
      'on' => [ 'input', 'textarea' ],
    ],

    // 2017-06-01 jj5 - a 'type-enum' is an enum whose values depend on the
    // element. Global values apply to all elements.
    'rel' => [
      'type' => 'type-enum',
      'on' => [ 'a', 'area', 'link' ],
      'values' => [

        // 2017-06-01 jj5 - the values are split out by the elements they apply
        // to. Global values (listed here) apply to all elements.
        'global' => [
          'alternate',
          'author',
          'help',
          'license',
          'next',
          'prev',
          'search',
        ],

        // 2017-06-01 jj5 - values for <a>
        // 2017-06-01 jj5 - SEE: HTML a rel Attribute:
        // https://www.w3schools.com/tags/att_a_rel.asp
        'a' => [
          'bookmark',
          'external',
          'nofollow',
          'noreferrer',
          'noopener',
          'tag',
        ],

        // 2017-06-01 jj5 - values for <area>
        // 2017-06-01 jj5 - SEE: HTML area rel Attribute:
        // https://www.w3schools.com/tags/att_area_rel.asp
        'area' => [
          'bookmark',
          'nofollow',
          'noreferrer',
          'tag',
          'prefetch',
        ],

        // 2017-06-01 jj5 - values for <link>
        // 2017-06-01 jj5 - SEE: HTML link rel Attribute:
        // https://www.w3schools.com/tags/att_link_rel.asp
        'link' => [
          'dns-prefetch',
          'icon',
          'pingback',
          'preconnect',
          'prefetch',
          'preload',
          'stylesheet',
        ],
      ],
    ],

    'required' => [
      'type' => 'bool',
      'on' => [ 'input', 'select', 'textarea' ],
    ],

    'reversed' => [
      'type' => 'bool',
      'on' => [ 'ol' ],
    ],

    'rows' => [
      'type' => 'int',
      'on' => [ 'textarea' ],
    ],

    'rowspan' => [
      'type' => 'int',
      'on' => [ 'td', 'th' ],
    ],

    // 2017-06-01 jj5 - NOTE: a 'bool-list' is either a list or a boolean.
    'sandbox' => [
      'type' => 'bool-list',
      'values' => [
        'allow-forms',
        'allow-pointer-lock',
        'allow-popups',
        'allow-same-origin',
        'allow-scripts',
        'allow-top-navigation',
      ],
      'on' => [],
    ],

    'scope' => [
      'type' => 'enum',
      'values' => [ 'col', 'row', 'colgroup', 'rowgroup' ],
      'on' => [ 'th' ],
    ],

    // 2017-06-01 jj5 - this attibute is required on <style> elements which are
    // not in the <head> element. Not sure we're going to enforce that!
    'scoped' => [
      'type' => 'bool',
      'on' => [ 'style' ],
    ],

    'selected' => [
      'type' => 'bool',
      'on' => [ 'option' ],
    ],

    'shape' => [
      'type' => 'enum',
      'values' => [
        'default',
        'rect',
        'circle',
        'poly',
      ],
      'on' => [ 'area' ],
    ],

    'size' => [
      'type' => 'int',
      'on' => [ 'input', 'select' ],
    ],

    // 2017-06-01 jj5 - the 'sizes' attribute is a space-separated list of
    // 123x456 style sizes or 'any', but I don't think we're caring about that.
    'sizes' => [
      'type' => 'string',
      'on' => [ 'img', 'link', 'source' ],
    ],

    'span' => [
      'type' => 'int',
      'on' => [ 'col', 'colgroup' ],
    ],

    'spellcheck' => [
      'type' => 'enum',
      'values' => [
        'true',
        'false',
      ],
      'on' => [],
    ],

    'src' => [
      'type' => 'url',
      'on' => [
        'audio',
        'embed',
        'iframe',
        'img',
        'input',
        'script',
        'source',
        'track',
        'video',
      ],
    ],

    'srcdoc' => [
      'type' => 'url',
      'on' => [ 'iframe' ],
    ],

    'srclang' => [
      'type' => 'lang',
      'on' => [ 'track' ],
    ],

    'srcset' => [
      'type' => 'url',
      'on' => [ 'img', 'source' ],
    ],

    'start' => [
      'type' => 'int',
      'on' => [ 'ol' ],
    ],

    'step' => [
      'type' => 'number',
      'on' => [ 'input' ],
    ],

    'style' => [
      'type' => 'style',
      'on' => [],
    ],

    'tabindex' => [
      'type' => 'int',
      'on' => [],
    ],

    // 2017-06-01 jj5 - THINK: we could do 'name' validation... or heuiristics
    // maybe... hmm. Probably overkill.
    'target' => [
      'type' => 'name-enum',
      'values' => [
        '_blank',
        '_self',
        '_parent',
        '_top',
      ],
      'on' => [ 'a', 'area', 'base', 'form' ],
    ],

    'title' => [
      'type' => 'string',
      'on' => [],
    ],

    'translate' => [
      'type' => 'enum',
      'values' => [ 'yes', 'no' ],
      'on' => [],
    ],

    // 2017-06-01 jj5 - a 'varies' type is specifed by element type in 'spec'.
    'type' => [
      'type' => 'varies',
      'on' => [
        'button',
        'embed',
        'input',
        'link',
        'menu',
        'object',
        'script',
        'source',
        'style',
      ],
      'spec' => [
        'button' => [
          'type' => 'enum',
          'values' => [ 'button', 'submit', 'reset' ],
        ],
        'embed' => [
          // 2017-06-01 jj5 - SEE: Media Types:
          // http://www.iana.org/assignments/media-types/media-types.xhtml
          'type' => 'media-type',
        ],
        'input' => [
          'type' => 'enum',
          'values' => [
            'button',
            'checkbox',
            'color',
            'date',
            'datetime-local',
            'email',
            'file',
            'hidden',
            'image',
            'month',
            'number',
            'password',
            'radio',
            'range',
            'reset',
            'search',
            'submit',
            'tel',
            'text',
            'time',
            'url',
            'week',
          ], // end 'values'
        ], // end 'input'
        'link' => [
          // 2017-06-01 jj5 - SEE: Media Types:
          // http://www.iana.org/assignments/media-types/media-types.xhtml
          'type' => 'media-type',
        ],
        'menu' => [
          'type' => 'enum',
          'values' => [ 'list', 'context', 'toolbar' ],
        ],
        'object' => [
          // 2017-06-01 jj5 - SEE: Media Types:
          // http://www.iana.org/assignments/media-types/media-types.xhtml
          'type' => 'media-type',
        ],
        'script' => [
          // 2017-06-01 jj5 - TODO: dedupe all these references to media types!
          // 2017-06-01 jj5 - SEE: Media Types:
          // http://www.iana.org/assignments/media-types/media-types.xhtml
          'type' => 'media-type',
        ],
        'source' => [
          'type' => 'media-type',
        ],
        'style' => [
          'type' => 'media-type',
        ],
      ], // end 'spec'
    ], // end 'type'

    // 2017-06-01 jj5 - the 'hash' attribute type is a '#' followed by a name
    'usemap' => [
      'type' => 'hash',
      'on' => [ 'img', 'object' ],
    ],

    // 2017-06-01 jj5 - a 'varies' type is specifed by element type in 'spec'.
    'value' => [
      'type' => 'varies',
      // 2017-06-01 jj5 - TODO: confirm all these 'on' tags are in 'spec'.
      'on' => [
        'button',
        'input',
        'li',
        'option',
        'meter',
        'progress',
        'param',
      ],
      'spec' => [
        'button' => [
          'type' => 'string',
        ],
        'input' => [
          'type' => 'string',
        ],
        'li' => [
          'type' => 'int',
        ],
        'option' => [
          'type' => 'string',
        ],
        'meter' => [
          'type' => 'number',
        ],
        'progress' => [
          'type' => 'number',
        ],
        'param' => [
          'type' => 'string',
        ],
      ],
    ], // end 'value'

    'width' => [
      'type' => 'int',
      'on' =>
        [ 'canvas', 'embed', 'iframe', 'img', 'input', 'object', 'video' ],
    ],

    'wrap' => [
      'type' => 'enum',
      'values' => [
        'soft',
        'hard',
      ],
      'on' => [ 'textarea' ],
    ], // 2017-06-01 jj5 - and that's a wrap! yes, I typed this.

  ];

  // 2017-06-01 jj5 - TODO: think about the structure of this. 'data' might
  // be the only 'prefix' in HTML5..? investigating...
  public $html_attr_prefixes = [
    'data-' => true
  ];

  public $html_events = [
    'abort' => [ 'audio', 'embed', 'img', 'object', 'video' ],
    'afterprint' => [ 'body' ],
    'beforeprint' => [ 'body' ],
    'beforeunload' => [ 'body' ],
    'blur' => [],
    'canplay' => [ 'audio', 'embed', 'object', 'video' ],
    'canplaythrough' => [ 'audio', 'video' ],
    'change' => [],
    'click' => [],
    'contextmenu' => [],
    'copy' => [],
    'cuechange' => [],
    'cut' => [],
    'dblclick' => [],
    'drag' => [],
    'dragend' => [],
    'dragenter' => [],
    'dragleave' => [],
    'dragover' => [],
    'dragstart' => [],
    'drop' => [],
    'durationchange' => [ 'audio', 'video' ],
    'emptied' => [ 'audio', 'video' ],
    'ended' => [ 'audio', 'video' ],
    'error' => [
      'audio', 'body', 'embed', 'img', 'object', 'script', 'style', 'video'
    ],
    'focus' => [],
    'hashchange' => [ 'body' ],
    'input' => [],
    'invalid' => [],
    'keydown' => [],
    'keypress' => [],
    'keyup' => [],
    'load' => [ 'body', 'iframe', 'img', 'input', 'link', 'script', 'style' ],
    'loadeddata' => [ 'audio', 'video' ],
    'loadedmetadata' => [ 'audio', 'video' ],
    'loadstart' => [ 'audio', 'video' ],
    'mousedown' => [],
    'mousemove' => [],
    'mouseout' => [],
    'mouseover' => [],
    'mouseup' => [],
    'mousewheel' => [],
    'offline' => [ 'body' ],
    'online' => [ 'body' ],
    'pagehide' => [ 'body' ],
    'pageshow' => [ 'body' ],
    'paste' => [],
    'pause' => [ 'audio', 'video' ],
    'play' => [ 'audio', 'video' ],
    'playing' => [ 'audio', 'video' ],
    'popstate' => [ 'body' ],
    'progress' => [ 'audio', 'video' ],
    'ratechange' => [ 'audio', 'video' ],
    'reset' => [ 'form' ],
    'resize' => [ 'body' ],
    'scroll' => [],
    'search' => [ 'input' ],
    'seeked' => [ 'audio', 'video' ],
    'select' => [],
    'show' => [ 'menu' ],
    'stalled' => [ 'audio', 'video' ],
    'storage' => [ 'body' ],
    'submit' => [ 'form' ],
    'suspend' => [ 'audio', 'video' ],
    'timeupdate' => [ 'audio', 'video' ],
    'toggle' => [ 'details' ],
    'unload' => [ 'body' ],
    'volumnchange' => [ 'audio', 'video' ],
    'waiting' => [ 'audio', 'video' ],
    'wheel' => [],
  ];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-12 jj5 - constructor...
  //

  public function __construct( MudModuleHtml|null $previous = null ) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function doc_open() { return count( $this->html_state ) > 0; }

  public function doc_is_initialized() {

    return $this->html_state ? true : false;

  }

  public function doc_init(
    string $doctype = MUD_HTML_DEFAULT_DOCTYPE,
    string $lang = MUD_HTML_DEFAULT_LANG,
    string $charset = MUD_HTML_DEFAULT_CHARSET,
    string $content_type = MUD_HTML_DEFAULT_CONTENT_TYPE,
  ) : MudModuleHtml {

    // 2017-06-01 jj5 - store the previous state...
    array_push( $this->html_state_stack, $this->html_state );

    $this->html_state = $this->get_initial_html_state(
      $snippet = false,
      $doctype,
      $lang,
      $charset
    );

    header( "Content-Type: $content_type; charset=$charset", $replace = true );

    mud_buffer_start();

    if ( $doctype === MUD_DOCTYPE_XML ) {

      return $this->out_html( "<?xml version=\"1.0\" encoding=\"$charset\"?>\n" );

    }

    return $this->out_html( "<!DOCTYPE $doctype>\n" );

  }

  public function doc_echo() : MudModuleHtml {

    return $this->doc_done( $html, true );

  }

  public function doc_done( &$html = null, bool $echo = true ) : MudModuleHtml {

    // 2017-06-01 jj5 - restore the previous state...
    $this->html_state = array_pop( $this->html_state_stack );

    // 2018-06-15 jj5 - THINK: trim before or after echo..?

    $html = trim( mud_buffer_clear( $length, true ) );

    if ( $echo ) { mud_stdout( $html ); }

    return $this;

  }

  // 2017-06-01 jj5 - if you fuckup your document call this function to clean
  // up after yourself...
  //
  public function doc_fail() : MudModuleHtml {

    // 2017-06-01 jj5 - restore the previous state...
    $this->html_state = array_pop( $this->html_state_stack );

    mud_buffer_clear();

    return $this;

  }


  // 2017-06-01 jj5 - if you want to create a HTML snippet, call nip_init()
  // then when you're done call nip_done() to get the output...
  // 2017-06-01 jj5 - THINK: maybe this should be done without output
  // buffering?
  //
  public function nip_init( array $options = [] ) : MudModuleHtml {

    $state = $this->get_initial_html_state();

    if ( count( $options ) ) {

      $state[ 'options' ] = $options;

    }
    else if ( $this->html_state ) {

      // 2017-06-02 jj5 - THINK: we copy options here, but maybe we don't want
      // to do that..? Perhaps a merge is more appropriate..?

      $state[ 'options' ] = $this->html_state[ 'options' ];

    }

    assert( is_array( $this->html_state_stack ) );

    // 2017-06-01 jj5 - store the old state...
    array_push( $this->html_state_stack, $this->html_state );

    $this->html_state = $state;

    mud_buffer_start();

    return $this;

  }

  public function nip_echo() : MudModuleHtml {

    return $this->nip_done( $content, true );

  }

  public function nip_done( &$snip = null, bool $echo = false ) : MudModuleHtml {

    // 2017-06-01 jj5 - restore the previous state...
    $this->html_state = array_pop( $this->html_state_stack );

    // 2018-06-15 jj5 - THINK: trim before or after echo..?

    $snip = trim( mud_buffer_clear( $length, true ) );

    if ( $echo ) { mud_stdout( $snip ); }

    return $this;

  }

  // 2017-06-01 jj5 - if you fuckup your snip call this function to clean up
  // after yourself...
  public function nip_fail() : MudModuleHtml {

    // 2017-06-01 jj5 - restore the previous state...
    $this->html_state = array_pop( $this->html_state_stack );

    mud_buffer_clear();

    return $this;

  }

  public function get_doctype() : string {

    return $this->get_setting( 'doctype' );

  }

  public function get_lang() : string {

    return $this->get_setting( 'lang' );

  }

  public function get_charset() : string {

    return $this->get_setting( 'charset' );

  }

  public function get_setting( string $setting ) {

    return $this->html_state[ $setting ];

  }

  public function get_opt_autoxsrf() : bool {

    return $this->get_opt( 'autoxsrf' );

  }

  // 2017-06-01 jj5 - set a HTML output option...
  public function set_opt( string $option, $value ) : MudModuleHtml {

    $this->html_state[ 'options' ][ $option ] = $value;

    return $this;

  }

  // 2017-06-01 jj5 - set a HTML output option...
  public function get_opt( string $option, $default = null ) {

    $options = $this->html_state[ 'options' ];

    if ( ! array_key_exists( $option, $options ) ) { return $default; }

    return $options[ $option ];

  }

  public function render_table(
    $context,
    array $table,
    array $attrs = [],
    array $column_headers = [],
    array $column_types = [],
    array $column_formatters = [],
    int $flags = MUD_HTML_DEFAULT_TABLE_FLAGS
  ) : MudModuleHtml {

    if ( count( $table ) === 0 ) {

      return tag_text( 'p', 'No data.' );

    }

    $show_counter = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_COUNTER );
    $show_help    = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_HELP    );
    $nice_table   = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_NICE_TABLE   );
    $sortable     = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SORTABLE     );
    $show_footer  = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_FOOTER  );
    $show_totals  = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_TOTALS  );
    $show_stats   = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_STATS   );
    $show_csv     = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_CSV     );
    $show_null    = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_NULL    );
    $show_true    = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_TRUE    );
    $show_false   = mud_has_flag( $flags, MUD_HTML_TABLE_FLAG_SHOW_FALSE   );

    $counter = 1;
    $totals = [];

    if ( $column_headers ) {

      $column_keys = array_keys( $column_headers );
      $column_names = $column_headers;

    }
    else {

      $column_keys = array_keys( $table[ 0 ] );
      $column_names = [];

      foreach ( $column_keys as $key ) {

        $column_names[ $key ] = $key;

      }
    }

    foreach ( $column_keys as $key ) {

      $totals[ $key ] = null;

    }

    $class = mud_get_array( $attrs[ 'class' ] ?? [], ' ' );

    if ( $nice_table ) {

      mud_add_if_missing( $class, 'nice-table' );

    }

    if ( $sortable ) {

      mud_add_if_missing( $class, 'sortable' );

    }

    $attrs[ 'class' ] = $class;

    tag_open( 'table', $attrs );

      tag_open( 'thead' );

        $this->render_table_header_row(
          $context,
          $column_keys,
          $column_names,
          $column_types,
          $show_counter,
          $show_help
        );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        foreach ( $table as $row_index => $row ) {

          tag_open( 'tr' );

            // 2019-09-12 jj5 - THINK: format counter with thousands
            // separator..?
            //
            if ( $show_counter ) {

              tag_text( 'th', $counter++, [ 'class' => 'counter' ] );

            }

            foreach ( $column_keys as $column ) {

              // 2019-09-13 jj5 - THINK: are we sure we want to default to
              // null here? Perhaps we should bail if the row doesn't have
              // a value for the column..?
              //
              $field = $row[ $column ] ?? null;
              $formatter = $column_formatters[ $column ] ?? null;
              $column_type =
                $this->infer_type( $column_types, $column, $field );

              $html = $this->field_encode(
                $field,
                $column_type,
                $show_null,
                $show_true,
                $show_false
              );

              if ( is_callable( $formatter ) ) {

                $html = $formatter(
                  $html,
                  $field,
                  $column_type,
                  $column,
                  $row,
                  $row_index,
                  $table
                );

              }

              $color_class =
                $this->get_color_class( $field, $column_type, $column );

              tag_html(
                'td',
                $html,
                [ 'class' => [ $column, $column_type, $color_class ] ]
              );

            }

          tag_shut( 'tr' );

        }

      tag_shut( 'tbody' );

      if ( $show_footer ) {

        tag_open( 'tfoot' );

          if ( $show_totals ) {

            // 2019-09-13 jj5 - TODO: show totals...

          }

          $this->render_table_header_row(
            $context,
            $column_keys,
            $column_names,
            $column_types,
            $show_counter,
            $show_help
          );

        tag_shut( 'tfoot' );

      }

      if ( $show_stats ) {

        // 2019-09-13 jj5 - TODO: show table stats...

      }

      if ( $show_csv ) {

        // 2019-09-13 jj5 - TODO: show CSV in <textarea> (with heading?)

      }

    tag_shut( 'table' );

    return $this;

  }

  public function render_open_form_table( $context, array $attrs ) : MudModuleHtml {

    $errors = $this->get_unset( $attrs, 'mud-errors', [] );

    $legend = $this->get_unset( $attrs, 'mud-legend', 'Form' );

    assert( is_array( $this->html_state[ 'stack-form-errors' ] ) );

    array_push( $this->html_state[ 'stack-form-errors' ], $errors );

    $this->fix_attrs( 'form', $attrs );

    $error = $this->get_form_error( $attrs[ 'name' ] );

    if ( $error ) {

      tag_open( 'div', [ 'class' => 'error' ] );

        tag_text( 'span', $error );

      tag_shut( 'div', [ 'class' => 'error' ] );

    }

    tag_open( 'form', $attrs );

      tag_open( 'fieldset' );

        tag_text( 'legend', $legend );

        tag_open( 'div', [ 'class' => 'table' ] );

          tag_open( 'div', [ 'class' => 'tbody' ] );

    return $this;

  }

  public function render_shut_form_table( $context, array $attrs = [] ) : MudModuleHtml {

          tag_shut( 'div', [ 'class' => 'tbody' ] );

        tag_shut( 'div', [ 'class' => 'table' ] );

      tag_shut( 'fieldset' );

    tag_shut( 'form', $attrs );

    return $this;

  }

  public function render_input_row_text( $context, array $attrs ) : MudModuleHtml {

    $attrs[ 'type' ] = 'text';

    return $this->render_input_row_item( $context, $attrs );

  }

  public function render_input_row_password( $context, array $attrs ) : MudModuleHtml {

    $attrs[ 'type' ] = 'password';

    return $this->render_input_row_item( $context, $attrs );

  }

  public function render_input_row_submit( $context, array $attrs ) : MudModuleHtml {

    $attrs[ 'type' ] = 'submit';

    return $this->render_input_row_item( $context, $attrs );

  }

  public function render_input_row_button( $context, array $attrs ) : MudModuleHtml {

    $label = $this->get_unset( $attrs, 'mud-label', '' );
    $text = $this->get_unset( $attrs, 'mud-text', '' );

    if ( ! isset( $attrs[ 'id' ] ) ) {

      $attrs[ 'id' ] = $attrs[ 'name' ] . '-input';

    }

    $this->fix_attrs( 'button', $attrs );

    $error = $this->get_form_error( $attrs[ 'name' ] );

    tag_open( 'div', [ 'class' => 'tr' ] );

      tag_open( 'span', [ 'class' => 'td' ] );

        tag_text( 'label', $label, [ 'for' => $attrs[ 'id' ] ] );

      tag_shut( 'span', [ 'class' => 'td' ] );

      $class = 'td right';

      tag_open( 'span', [ 'class' => $class ] );

        tag_text( 'button', $text, $attrs );

      tag_shut( 'span', [ 'class' => $class ] );

      tag_open( 'div', [ 'class' => 'td' ] );

        $error = $this->get_form_error( $attrs[ 'name' ] );

        if ( $error ) {

          tag_text( 'span', $error, [ 'class' => 'error' ] );

        }

      tag_shut( 'div', [ 'class' => 'td' ] );

    tag_shut( 'div', [ 'class' => 'tr' ] );

    return $this;

  }

  public function put_note( string $note ) : MudModuleHtml {

    $note = str_replace( '-->', '-/-/>', $note );

    return $this->put_html( "<!-- $note -->" );

  }

  public function put_html(
    string $tag_or_html,
    $html_for_tag = null,
    array $attrs = []
  ) : MudModuleHtml {

    if ( $html_for_tag === null ) {

      $tag = null;
      $html = $tag_or_html;

    }
    else {

      $tag = $tag_or_html;
      $html = $html_for_tag;

    }

    if ( $tag ) {

      $this->tag_open( $tag, $attrs );

    }

    $this->out_html( $html );

    if ( $tag ) {

      $this->tag_shut( $tag );

    }

    return $this;

  }

  public function put_text(
    string $tag_or_text,
    $text_for_tag = null,
    array $attrs = []
  ) : MudModuleHtml {

    if ( $text_for_tag === null ) {

      $tag = null;
      $text = $tag_or_text;

    }
    else {

      $tag = $tag_or_text;
      $text = $text_for_tag;

    }

    if ( $tag ) {

      $this->tag_open( $tag, $attrs );

    }

    $this->out_text( $text );

    if ( $tag ) {

      $this->tag_shut( $tag );

    }

    return $this;

  }

  public function tag_meta( $name, $content ) : MudModuleHtml {

    return $this->tag_bare(
      'meta',
      [ 'name' => $name, 'content' => $content ]
    );

  }

  public function tag_link( $type, $rel, $href, $sizes = null ) : MudModuleHtml {

    $attrs = [
      'rel' => $rel,
      'type' => $type,
      'href' => $href,
    ];

    if ( $sizes ) {

      $attrs[ 'sizes' ] = $sizes;

    }

    return $this->tag_bare( 'link', $attrs );

  }

  function tag_cell( string $tag, $value, array $attrs = [] ) : MudModuleHtml {

    if ( $value === 0 ) { $value = ''; }

    if ( $value === null ) { $value = ''; }

    if ( ! is_string( $value ) ) { $value = mud_json_encode( $value ); }

    return $this->tag_text( $tag, $value, $attrs );

  }

  // 2017-06-02 jj5 - THINK: maybe we could come up with a better name for
  // put_bare()..? it puts a "bare" element with no content. So, whatevs.
  // 2018-05-31 jj5 - DONE: renamed put_bare() to tag_bare()...
  //
  public function tag_bare( string $tag, array $attrs = [] ) : MudModuleHtml {

    return $this->tag_open( $tag, $attrs, $bare = true )->tag_shut( $tag, $attrs, $bare = true );

  }

  public function tag_text(
    string $tag,
    $text,
    array $attrs = []
  ) : MudModuleHtml {

    // 2020-03-11 jj5 - OLD: this was moved into tag_cell()...
    //
    //if ( ! is_string( $text ) ) { $text = mud_json_encode( $text ); }

    return $this->tag_html( $tag, mud_henc( $text ), $attrs );

  }

  public function tag_html(
    string $tag,
    string $html,
    array $attrs = []
  ) : MudModuleHtml {

    return $this->
      tag_open( $tag, $attrs )->
        out_html( $html )->
      tag_shut( $tag );

  }

  // 2017-06-01 jj5 - TODO: think about validating whether elements are allowed
  // as sub-elements...
  public function tag_open( string $tag, array $attrs = [], $bare = false ) : MudModuleHtml {

    if ( ! $this->html_state ) {

      mud_fail(
        MUD_ERR_HTML_DOCUMENT_UNINITIALIZED,
        [ 'state' => $this->html_state ]
      );

    }

    if ( $tag !== trim( $tag ) ) {

      mud_fail(
        MUD_ERR_HTML_TAG_INVALID,
        [ 'tag' => $tag ]
      );

    }

    assert( is_array( $this->html_state[ 'stack-tags' ] ) );
    assert( is_array( $this->html_state[ 'stack-attrs' ] ) );

    $this->fix_attrs( $tag, $attrs );

    array_push( $this->html_state[ 'stack-tags' ], $tag );
    array_push( $this->html_state[ 'stack-attrs' ], $attrs );

    $this->debug_note();

    $attrs_html = $this->attrs_to_html( $attrs, $tag );

    if ( $this->get_attr( $attrs, 'opt-space', true ) ) {

      $this->out_line();

      $depth = count( $this->html_state[ 'stack-tags' ] ) - 1;

      // 2019-09-02 jj5 - OLD: we used to use two spaces:
      //$pad = str_repeat( '  ', $depth );
      // 2019-09-02 jj5 - NEW: but now we use a single tab:
      $pad = str_repeat( "\t", $depth );
      // 2019-09-02 jj5 - END

      $this->out_html( $pad );

    }

    if ( $bare && $this->html_state[ 'doctype' ] === MUD_DOCTYPE_XML ) {

      $this->put_html( "<{$tag}{$attrs_html} />" );

    }
    else {

      $this->put_html( "<{$tag}{$attrs_html}>" );

    }

    switch ( $tag ) :

      case 'form' :

        // 2017-06-02 jj5 - check for 'POST' (upper case). We don't want to
        // accidentally lead an XSRF token in a GET request. This library
        // should ensure that the form method is upper case, but if it's not
        // the XSRF check will just fail, which is safe.
        if (
          $this->get_opt_autoxsrf() &&
          $this->get_attr( $attrs, 'method' ) === 'POST'
        ) {

          $this->tag_bare(
            'input',
            [
              'type' => 'hidden',
              'name' => mud_xsrf_get_token_name(),
              'value' => mud_xsrf_get_token_hash()
            ]
          );

        }

        break;

      default :

    endswitch;

    return $this;

  }

  public function tag_shut( string $tag, array $attrs = [], bool $bare = false ) : MudModuleHtml {

    if ( $tag !== trim( $tag ) ) {

      mud_fail(
        MUD_ERR_HTML_TAG_INVALID,
        [ 'tag' => $tag ]
      );

    }

    // 2017-06-01 jj5 - TODO: get the elements which don't need to be (or can't
    // be) closed...
    static $optional_close = [
      'meta' => true,
      'link' => true,
      'img' => true,
      'br' => true,
      'hr' => true,
      'input' => true,
    ];

    switch ( $tag ) {

      case 'body' :

        // 2019-09-13 jj5 - before we close the <body> element output some
        // JavaScript that describes our environment.

        $this->tag_html(
          'script',
          'window.g_mud_html_options = ' .
          json_encode(
            $this->html_state[ 'options' ],
            JSON_UNESCAPED_SLASHES
          ) . ';'
        );

        break;

    }

    $init_stack_tags = $this->html_state[ 'stack-tags' ];
    //$init_stack_attrs = $this->html_state[ 'stack-attrs' ];

    $open_tag = array_pop( $this->html_state[ 'stack-tags' ] );
    $open_attrs = array_pop( $this->html_state[ 'stack-attrs' ] );

    $this->debug_note();

    if ( $tag !== $open_tag ) {

      mud_fail(
        MUD_ERR_HTML_CLOSE_TAG_INVALID,
        [
          'close_tag' => $tag,
          'open_tag' => $open_tag,
          'stack' => $this->html_state[ 'stack-tags' ],
          'init_stack' => $init_stack_tags,
        ]
      );

    }

    foreach ( $attrs as $shut_attr => $value ) {

      if ( $open_attrs[ $shut_attr ] !== $value ) {

        mud_fail(
          MUD_ERR_HTML_CLOSE_TAG_INVALID,
          [
            'open_tag' => $open_tag,
            'open_attrs' => $open_attrs,
            'shut_tag' => $tag,
            'shut_attrs' => $attrs,
          ]
        );

      }
    }

    if ( $this->html_state[ 'doctype' ] === MUD_DOCTYPE_XML ) {

      if ( ! $bare ) {

        $this->put_html( "</{$tag}>" );

      }
    }
    elseif ( ! array_key_exists( $tag, $optional_close ) ) {

      // 2017-06-01 jj5 - TODO: in our tags/elements spec indicate if a new-line
      // is appropraite after the close tag. Then apply it here.
      //
      $this->put_html( "</{$tag}>" );

    }

    switch ( $tag ) :

      case 'head' :

        if ( ! $this->html_state[ 'is_title_set' ] ) {

          mud_fail( MUD_ERR_HTML_TITLE_UNSET );

        }

        break;

      case 'html' :

        $this->out_line();

        break;

      case 'title' :

        $this->html_state[ 'is_title_set' ] = true;

        if ( $this->html_state[ 'doctype' ] === MUD_DOCTYPE_HTML5 ) {

          // 2017-06-01 jj5 - we automatically output some meta data after
          // <title>

          $this->tag_bare( 'meta', [ 'charset' => $this->get_charset() ] );

          // 2019-07-15 jj5 - the above meta charset will do, we don't need this
          /*
          $this->tag_bare(
            'meta',
            [
              'http-equiv' => 'Content-Type',
              'content' => 'text/html; charset=' . $this->get_charset()
            ]
          );
          */

        }

        break;

    endswitch;

    return $this;

  }

  public function out_line( int $lines = 1 ) : MudModuleHtml {

    if ( $lines < 0 ) { $lines = 0; }

    while ( $lines-- ) { $this->out_html( "\n" ); }

    return $this;

  }

  public function out_html( $html ) : MudModuleHtml {

    mud_stdout( $html );

    return $this;

  }

  public function out_text( $text ) : MudModuleHtml {

    mud_stdout( mud_henc( $text ) );

    return $this;

  }

  // 2020-03-21 jj5 - note that the intended use of out_code() is for
  // <style> and <script> content. The out_code() function adjusts code
  // indentation for nicer looking output...
  //
  public function out_code( $code ) : MudModuleHtml {

    $lines = explode( "\n", $code );

    $min_space_count = PHP_INT_MAX;

    foreach ( $lines as $line ) {

      if ( trim( $line ) === '' ) { continue; }

      $space_len = 0;

      for ( $i = 0; $i < strlen( $line ); $i++ ) {

        if ( $line[ $i ] === ' ' ) {

          $space_len++;

        }
        else {

          break;

        }
      }

      $min_space_count = min( [ $min_space_count, $space_len ] );

    }

    if ( $min_space_count === PHP_INT_MAX ) {

      $min_space = '';

    }
    else {

      $min_space = str_repeat( ' ', $min_space_count );

    }

    mud_stdout( "\n" );

    $indent = count( $this->html_state[ 'stack-tags' ] );

    $pad = str_repeat( "\t", $indent );

    foreach ( $lines as $line ) {

      $trimmed = trim( $line );

      if ( ! $trimmed ) { continue; }

      if ( strpos( $line, $min_space ) === 0 ) {

        $line = substr( $line, $min_space_count );

      }

      mud_stdout( "$pad$line\n" );

    }

    mud_stdout( str_repeat( "\t", $indent - 1 ) );

    return $this;

  }

  public function attr_id( $col ) {

    $key = $this->col_to_attr( $col );

    if ( ! array_key_exists( 'id-map', $this->html_state ) ) {

      $this->html_state[ 'id-map' ] = [];

    }

    if ( array_key_exists( $key, $this->html_state[ 'id-map' ] ) ) {

      $this->html_state[ 'id-map' ][ $key ]++;

      return $key . '-' . $this->html_state[ 'id-map' ][ $key ];

    }

    $this->html_state[ 'id-map' ][ $key ] = 1;

    return $key;

  }

  // 2022-03-19 jj5 - OLD:
  //
  /*
  public function attr_for( $col ) {

    return $this->col_to_attr( $col );

  }

  public function attr_key( $col ) {

    return $this->col_to_attr( $col );

  }

  public function attr_name( $col ) {

    return $this->col_to_attr( $col );

  }
  */

  public function tab_index( $set = false ) {

    if ( $set !== false ) {

      $this->html_state[ 'tab-index' ] = $set;

    }

    if ( ! is_int( $this->html_state[ 'tab-index' ] ?? null ) ) {

      $this->html_state[ 'tab-index' ] = 1;

    }

    return $this->html_state[ 'tab-index' ]++;

  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-19 jj5 - protected methods...
  //

  protected function col_to_attr( $col ) {

    // 2022-02-19 jj5 - this function takes a column name in the form 'a_{mud,app}_whatever' and
    // returns just 'whatever'.

    $parts = explode( '_', $col, 3 );

    if ( count( $parts ) !== 3 ) { return $col; }

    assert( $parts[ 0 ] === 'a' );

    assert( in_array( $parts[ 1 ], [ 'mud', 'app' ] ) );

    return $parts[ 2 ];

  }

  protected function get_form_attrs() {

    $tags = $this->html_state[ 'stack-tags' ];
    $attrs = $this->html_state[ 'stack-attrs' ];

    assert( count( $tags ) === count( $attrs ) );

    for ( $i = count( $tags ) - 1; $i >= 0; $i-- ) {

      if ( $tags[ $i ] === 'form' ) { return $attrs[ $i ]; }

    }

    return null;

  }

  // 2019-09-13 jj5 - get_attr() used to be public, but now it's not...
  //
  protected function get_attr( array $attrs, string $name, $default = null ) {

    // 2019-09-13 jj5 - this function was implemented before PHP had the
    // null coalescing operator but we've kept it (reimplemented) for
    // compatibility...

    return $attrs[ $name ] ?? $default;

  }

  // 2019-09-13 jj5 - attrs_to_html() used to be public, but now it's not...
  //
  protected function attrs_to_html( array $attrs, string $tag ) : string {

    if ( DEBUG ) {

      foreach ( $attrs as $key => $val ) {

        switch ( $key ) {

          default :

            if ( is_string( $val ) && strpos( $val, 'a_' ) === 0 ) {

              assert( false, "Please don't expose implementation details." );

            }

            break;

        }
      }
    }

    switch ( $tag ) :

      case 'html' :

        if ( ! isset( $attrs[ 'lang' ] ) ) {

          $attrs[ 'lang' ] = $this->get_lang();

        }

        break;

      case 'script' :

        // 2024-06-29 jj5 - NOTE: we don't do this, it's superfluos...
        /*
        if ( ! isset( $attrs[ 'type' ] ) ) {

          $attrs[ 'type' ] = 'text/javascript';

        }
        */

        break;

      case 'img' :

        if ( ! isset( $attrs[ 'alt' ] ) ) {

          $attrs[ 'alt' ] = '';

        }

        break;

      case 'input' :

        if ( ! isset( $attrs[ 'type' ] ) ) {

          $attrs[ 'type' ] = 'text';

        }

        if (
          $attrs[ 'type' ] !== 'hidden' &&
          ! isset( $attrs[ 'placeholder' ] ) &&
          isset( $attrs[ 'name' ] )
        ) {

          $placeholder = $attrs[ 'name' ];

          $placeholder = preg_replace( '/^a_(std|web|geo|app)_/', '', $placeholder );
          $placeholder = preg_replace( '/_/', ' ', $placeholder );

          $attrs[ 'placeholder' ] = $placeholder;

        }

        break;

      case 'a' :

        if ( ! isset( $attrs[ 'rel' ] ) ) {

          $href = strval( $attrs[ 'href' ] ?? '' );

          if ( $href ) {

            if ( $href[ 0 ] === '/' && strpos( $href, '?' ) ) {

              $attrs[ 'rel' ] = 'nofollow';

            }
          }
        }

        break;

    endswitch;

    // 2017-06-01 jj5 - TODO: implement this function!

    $result = '';
    $quote = $this->get_attr( $attrs, 'opt-quote', '"' );

    // 2017-06-02 jj5 - TEMP: just for now...
    foreach ( $attrs as $name => $spec ) {

      if ( is_bool( $spec ) ) {

        if ( $spec ) { $result .= ' ' . mud_henc( $name ); }

      }
      else if ( is_array( $spec ) ) {

        //mud_pre_dump( $spec ); exit;

        $default_join = ':';
        $default_glue = ';';

        // 2018-05-30 jj5 - TODO: default join/glue should be comprehensive...

        switch ( $name ) {

          case 'accept' :

            $default_glue = ',';

            break;

          case 'class' :

            $default_glue = ' ';

            break;

          case 'content' :

            $default_join = '=';
            $default_glue = ', ';

            break;

        }

        $html = $this->get_attr( $spec, 'html', false );
        $join = mud_henc( $this->get_attr( $spec, 'join', $default_join ) );
        $glue = mud_henc( $this->get_attr( $spec, 'glue', $default_glue ) );
        $item = $this->get_attr( $spec, 'item' );
        $list = $this->get_attr( $spec, 'list' );
        $data = $this->get_attr( $spec, 'spec', $spec );
        $parts = [];

        if ( $item !== null ) {

          $parts[] = $html ? $item : mud_henc( $item );

        }
        else if ( $list !== null ) {

          foreach ( $list as $index => $value ) {

            $parts[] = $html ? $value : mud_henc( $value );

          }
        }
        else {

          foreach ( $data as $key => $val ) {

            if ( $name === 'style' && is_int( $val ) ) {

              $val .= 'px';

            }

            if ( $name === 'class' && is_bool( $val ) ) {

              if ( $val ) {

                $parts[] = mud_henc( $key );

              }
            }
            else if ( is_numeric( $key ) ) {

              $parts[] = $html ? $val : mud_henc( $val );

            }
            else {

              $parts[] = mud_henc( $key ) . $join . ( $html ? $val : mud_henc( $val ) );

            }
          }
        }

        if ( count( $parts ) ) {

          $result .= ' ' . mud_henc( $name ) . '=' . $quote . implode( $glue, $parts ) . $quote;

        }
      }
      else {

        $result .= ' ' . mud_henc( $name ) . '=' . $quote . mud_henc( $spec ) . $quote;

      }
    }

    return $result;

  }

  protected function get_unset( array &$attrs, string $key, $default = null ) {

    $result = $attrs[ $key ] ?? $default;

    unset( $attrs[ $key ] );

    return $result;

  }

  protected function get_form_error( string $name ) {

    $errors = mud_last( $this->html_state[ 'stack-form-errors' ] );

    return $errors[ $name ] ?? null;

  }

  protected function fix_attrs( string $tag, array &$attrs ) {

    static $auto_name = [ 'input', 'select', 'textarea', ];

    // 2021-10-20 jj5 - I don't think we need this...
    /*
    foreach ( $attrs as $key => $val ) {

      if ( ! is_string( $val ) ) { continue; }

      // 2021-10-20 jj5 - NOTE: the prefixes a_{mud,app}_ are a database implementation detail
      // and should not leak into the user interface, this code makes sure they don't. It's
      // conceivable this creates a problem at some point, and if it does we will address the
      // problem as may be necessary when/if we know what the problem is... if we need to we
      // can add a special option to $attrs to skip these replacements if necessary.

      if ( strpos( $val, 'a_std_' ) === 0 ) { $val = substr( $val, 6 ); $attrs[ $key ] = $val; }
      else
      if ( strpos( $val, 'a_app_' ) === 0 ) { $val = substr( $val, 6 ); $attrs[ $key ] = $val; }

    }
    */

    if ( in_array( $tag, $auto_name, $strict = true ) ) {

      if ( isset( $attrs[ 'id' ] ) && ! isset( $attrs[ 'name' ] ) ) {

        $attrs[ 'name' ] = $attrs[ 'id' ];

      }
    }

    $id = $attrs[ 'id' ] ?? null;

    if ( $id !== null ) {

      if ( array_key_exists( $id, $this->html_state[ 'id_map' ] ) ) {

        mud_fail( MUD_ERR_HTML_DUPLICATE_ID, [ 'id' => $id ] );

      }

      $this->html_state[ 'id_map' ][ $id ] = true;

    }
  }

  // 2017-06-01 jj5 - this function generates the initial HTML state object...
  protected function get_initial_html_state(
    $snippet = true,
    $doctype = MUD_HTML_DEFAULT_DOCTYPE,
    $lang = MUD_HTML_DEFAULT_LANG,
    $charset = MUD_HTML_DEFAULT_CHARSET
  ) {

    // 2017-06-02 jj5 - NOTE: if this is a snippet we lie about the flags so
    // that we don't get errors...

    return [
      'doctype' => $doctype,
      'lang' => $lang,
      'charset' => $charset,
      'is_title_set' => $snippet,
      'stack-tags' => [],
      'stack-attrs' => [],
      'stack-form-errors' => [],
      'options' => [
        'autoxsrf' => true,
        'max-length' => 32,
      ],
      'id_map' => [],
    ];

  }

  protected function render_input_row_item( $context, array $attrs ) : MudModuleHtml {

    $label = $this->get_unset( $attrs, 'mud-label', '' );

    if ( ! isset( $attrs[ 'id' ] ) ) {

      $attrs[ 'id' ] = $attrs[ 'name' ] . '-input';

    }

    $this->fix_attrs( 'input', $attrs );

    $error = $this->get_form_error( $attrs[ 'name' ] );

    tag_open( 'div', [ 'class' => 'tr' ] );

      tag_open( 'span', [ 'class' => 'td' ] );

        tag_text( 'label', $label, [ 'for' => $attrs[ 'id' ] ] );

      tag_shut( 'span', [ 'class' => 'td' ] );

      $class = 'td';

      if ( $attrs[ 'type' ] === 'submit' ) {

        $class = 'td right';

      }

      tag_open( 'span', [ 'class' => $class ] );

        tag_bare( 'input', $attrs );

      tag_shut( 'span', [ 'class' => $class ] );

      tag_open( 'div', [ 'class' => 'td' ] );

        $error = $this->get_form_error( $attrs[ 'name' ] );

        if ( $error ) {

          tag_text( 'span', $error, [ 'class' => 'error' ] );

        }

      tag_shut( 'div', [ 'class' => 'td' ] );

    tag_shut( 'div', [ 'class' => 'tr' ] );

    return $this;

  }

  protected function get_sort_type( string $type ) : string {

    // 2018-03-28 jj5 - SEE: table sort doco:
    // http://javascripttoolbox.com/lib/table/documentation.php

    // 2018-03-28 jj5 - built-in sort types are:
    //* alphanumeric
    //* numeric
    //* numeric_comma (for countries that use 1.234.567,89)
    //* ignorecase
    //* currency
    //* currency_comma
    //* date

    // 2018-03-28 jj5 - TODO: these need testing...

    switch ( $type ) {

      case MUD_HTML_COL_TYPE_HTML :
      case MUD_HTML_COL_TYPE_YES :
      case MUD_HTML_COL_TYPE_NO :
      case MUD_HTML_COL_TYPE_YESNO :
      case MUD_HTML_COL_TYPE_TEXT :
      case MUD_HTML_COL_TYPE_STRING :
      case MUD_HTML_COL_TYPE_EMAIL :
      case MUD_HTML_COL_TYPE_IP :
      case MUD_HTML_COL_TYPE_URL :
      case MUD_HTML_COL_TYPE_LINK :
      case MUD_HTML_COL_TYPE_URLENCODED :
      case MUD_HTML_COL_TYPE_HTTP_VERB :

        return 'ignorecase';

      case MUD_HTML_COL_TYPE_ID :
      case MUD_HTML_COL_TYPE_INT :
      case MUD_HTML_COL_TYPE_FLOAT :
      case MUD_HTML_COL_TYPE_COUNT :
      case MUD_HTML_COL_TYPE_AVERAGE :
      case MUD_HTML_COL_TYPE_PERCENT :
      case MUD_HTML_COL_TYPE_HTTP_CODE :

        return 'numeric';

      case MUD_HTML_COL_TYPE_CURRENCY :
      case MUD_HTML_COL_TYPE_DOLLARS :

        return 'currency';

      case MUD_HTML_COL_TYPE_DATE :
      case MUD_HTML_COL_TYPE_TIME :
      case MUD_HTML_COL_TYPE_DATETIME :

        return 'date';

      default :

        mud_not_supported( [ 'type' => $type ] );

    }
  }

  function get_color_class( $value, string $column_type, $column ) {

    // 2019-09-13 jj5 - THINK: this color thing needs to be more extensively
    // thought through... this is just a simple beginning...

    switch ( $column_type ) {

      case MUD_HTML_COL_TYPE_HTTP_VERB :

        return henc( $value );

      case MUD_HTML_COL_TYPE_HTTP_CODE :

        if ( $value < 200 ) { return 'standard'; }
        if ( $value < 300 ) { return 'green'; }
        if ( $value < 400 ) { return 'blue'; }

        return 'red';

      default :

        return 'standard';

    }
  }

  // 2019-09-13 jj5 - field_encode() returns the $field encoded as HTML
  // depending on its $type...
  //
  function field_encode(
    $field,
    string $type,
    bool $show_null = true,
    bool $show_true = true,
    bool $show_false = true
  ) : string {

    if ( $field === null ) {

      if ( $show_null ) {

        return '<i class="null">NULL</i>';

      }

      return '<i class="null"></i>';

    }

    switch ( $type ) {

      case MUD_HTML_COL_TYPE_HTML : return $field;

      case MUD_HTML_COL_TYPE_BOOL :

        if ( $field ) {

          if ( $show_true ) {

            return '<i class="true">TRUE</i>';

          }

          return '<i class="true"></i>';

        }

        if ( $show_false ) {

          return '<i class="false">FALSE</i>';

        }

        return '<i class="false"></i>';

      case MUD_HTML_COL_TYPE_YES : return $field ? 'Yes' : '';

      case MUD_HTML_COL_TYPE_NO : return $field ? '' : 'No';

      case MUD_HTML_COL_TYPE_YESNO : return $field ? 'Yes' : 'No';

      case MUD_HTML_COL_TYPE_ID :
      case MUD_HTML_COL_TYPE_HTTP_CODE :

        return mud_henc( $field );

      case MUD_HTML_COL_TYPE_INT :
      case MUD_HTML_COL_TYPE_COUNT :
      case MUD_HTML_COL_TYPE_AVERAGE :

        return $field ? mud_henc( number_format( $field, 0 ) ) : '';

      case MUD_HTML_COL_TYPE_FLOAT :

        return mud_henc( number_format( $field, 2 ) );

      case MUD_HTML_COL_TYPE_PERCENT :

        return mud_henc( number_format( $field * 100, 1 ) ) . '%';

      case MUD_HTML_COL_TYPE_CURRENCY :

        // 2019-09-13 jj5 - THINK: do we really want this 'currency' support?
        //
        mud_not_supported( [ 'type' => $type, 'field' => $field ] );

        return $field ? mud_henc( format_currency( $field ) ) : '';

      case MUD_HTML_COL_TYPE_DOLLARS :

        // 2019-09-13 jj5 - THINK: do we really want this 'dollars' support?
        //
        mud_not_supported( [ 'type' => $type, 'field' => $field ] );

        return $field ? henc( format_currency( round( $field ) ) ) : '';

      case MUD_HTML_COL_TYPE_TEXT :

        nip_init();

          tag_text( 'textarea', $field );

        nip_done( $html );

        return $html;

      case MUD_HTML_COL_TYPE_STRING :

        $max_length = $this->get_opt( 'max-length', 32 );
        $ondblclick =
          $this->get_opt( 'ondblclick', 'mud_show_long(this,event)' );

        $value = strval( $field );
        $len = mb_strlen( $value );
        $attrs = [ 'title' => $value ];

        if ( $len > $max_length ) {

          $attrs[ 'ondblclick' ] = $ondblclick;

          $value = mb_substr( $value, 0, $max_length - 3 ) . '...';

        }

        nip_init();

          tag_text( 'span', $value, $attrs );

        nip_done( $html );

        return $html;

      case MUD_HTML_COL_TYPE_HTTP_VERB :

        return mud_nbsp( mud_henc( $field ) );

      case MUD_HTML_COL_TYPE_DATE :

        return mud_nbsp( mud_henc( date( 'D, d M Y', strtotime( $field ) ) ) );

      case MUD_HTML_COL_TYPE_TIME :

        return mud_nbsp( mud_henc( date( 'H:i:s', strtotime( $field ) ) ) );

      case MUD_HTML_COL_TYPE_DATETIME :

        $date = date( DateTime::RFC2822, strtotime( $field ) );

        return mud_nbsp( mud_henc( $date ) );

      case MUD_HTML_COL_TYPE_EMAIL :

        if ( ! $field ) { return ''; }

        $email = $field;

        nip_init();

          tag_text(
            'a',
            $email,
            [
              'href' => "mailto:$email",
            ]
          );

        nip_done( $html );

        return $html;

      case MUD_HTML_COL_TYPE_IP :

        // 2019-09-13 jj5 - THINK: do we want to support links to services
        // such as this one?
        //
        //$link = "https://www.infobyip.com/ip-{$field}.html";

        // 2019-09-13 jj5 - for now just treat as string...
        //
        return mud_nbsp( mud_henc( $field ) );

      // 2019-09-13 jj5 - NOTE: 'URL' and 'LINK' are the same thing... I guess
      // the reason for having both is an accident of history...
      //
      case MUD_HTML_COL_TYPE_URL :
      case MUD_HTML_COL_TYPE_LINK :

        if ( ! $field ) { return ''; }

        $url = $field;

        nip_init();

          tag_text(
            'a',
            // 2019-09-13 jj5 - THINK: do we want a max-length for the URL..?
            //
            $url,
            [
              'href' => $url,
              'target' => '_blank',
            ]
          );

        nip_done( $html );

        return $html;

      case MUD_HTML_COL_TYPE_URLENCODED :

        // 2019-09-13 jj5 - TODO: need to think about whether we support
        // this data-type or not. See x_www_form_urldecode() in RBAdmin.
        //
        mud_not_supported( [ 'type' => $type, 'field' => $field ] );

        return
          '<textarea>' .
            henc( x_www_form_urldecode( $field ) ) .
          '</textarea>';

      default :

        mud_not_supported( [ 'type' => $type, 'field' => $field ] );

    }
  }

  protected function infer_type(
    array $column_types,
    $column,
    $field
  ) : string {

    $column_type = $column_types[ $column ] ?? MUD_HTML_COL_TYPE_STRING;

    if ( $column_type !== MUD_HTML_COL_TYPE_INFER ) { return $column_type; }

    switch ( gettype( $field ) ) {

      case 'boolean' : return MUD_HTML_COL_TYPE_BOOL;

      case 'integer' : return MUD_HTML_COL_TYPE_INT;

      case 'double' : return MUD_HTML_COL_TYPE_FLOAT;

      default :

        // 2019-09-13 jj5 - THINK: we could use a regex here to look for
        // dates and times, etc.

        return MUD_HTML_COL_TYPE_STRING;

    }
  }

  protected function render_table_header_row(
    $context,
    array $column_keys,
    array $column_names,
    array $column_types,
    bool $show_counter,
    bool $show_help
  ) {

    tag_open( 'tr' );

      if ( $show_counter ) {

        tag_text(
          'th',
          '#',
          [ 'class' => [ 'counter', 'table-sortable:numeric' ], ]
        );

      }

      foreach ( $column_keys as $field ) {

        $column_name = $column_names[ $field ] ?? $field;
        $column_type = $column_types[ $field ] ?? MUD_HTML_COL_TYPE_STRING;
        $column_sort = $this->get_sort_type( $column_type );

        $heading_html = mud_henc( $column_name );
        $heading_html = str_replace( ' ', '&nbsp;', $heading_html );

        tag_open(
          'th',
          [ 'class' => [ $column_type, "table-sortable:$column_sort" ], ]
        );

          out_html( $heading_html );

          if ( $show_help ) {

            out_html( '&nbsp;' );

            tag_html(
              'a',
              '(&#x2139;)',
              [
                'opt-space' => false,
                'class' => 'help',
                'href' => "#help-field-$field",
                'onclick' => 'event.stopPropagation()',
              ]
            );

          }

        tag_shut( 'th' );

      }

    tag_shut( 'tr' );

  }

  protected function debug_note() {

    static $note = null;

    if ( ! DEBUG ) { return; }

    $backtrace = debug_backtrace();

    foreach ( $backtrace as $call ) {

      $class = $call[ 'class' ] ?? null;

      if ( $class && $class !== get_called_class() ) { break; }

    }

    if ( ! $call ) { return; }

    $file = $call[ 'file' ] ?? null;
    $line = $call[ 'line' ] ?? null;
    $function = $call[ 'function' ] ?? null;
    $class = $call[ 'class' ] ?? null;

    $new_note = "$file:$line $class::$function()";

    if ( $new_note !== $note ) {

      $this->out_line();
      $depth = count( $this->html_state[ 'stack-tags' ] ) - 1;
      if ( $depth > 0 ) {
        $pad = str_repeat( "\t", $depth );
        $this->out_html( $pad );
      }

      put_note( $new_note );

    }

    $note = $new_note;

  }
}

// 2018-05-30 jj5 - THINK: add support for 'virtual' tags 'note' and 'skip'.
// Notes go inside HTML comments, and anything between <skip> doesn't get
// output.
