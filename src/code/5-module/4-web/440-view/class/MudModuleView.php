<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - class definition...
//

class MudModuleView extends MudModuleWeb {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - triats...
  //

  use MudViewMixin;
  use MudViewForms;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - protected fields...
  //

  protected $container_id;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-12 jj5 - constructor...
  //

  public function __construct( MudModuleView|null $previous = null ) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function render_head( $context, $args = [] ) {

    $iframe = $args[ 'iframe' ] ?? false;

    // 2019-07-12 jj5 - SEE: Getting started with schema.org using Microdata:
    // https://schema.org/docs/gs.html
    //
    // 2019-07-12 jj5 - SEE: Optimize Tweets with Cards:
    // https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/abouts-cards.html
    //
    // 2019-07-12 jj5 - SEE: Cards Markup Tag Reference:
    // https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/markup
    //
    // 2019-07-12 jj5 - SEE: Validate your Twitter card settings here:
    // https://cards-dev.twitter.com/validator
    //

    //$default_url_link = bom_get_current_url();
    //$logo_image = bom_get_res_link( 'logo.png' );
    //$background_image = bom_get_res_link( 'background.jpg', [] );

    /*
    if ( defined( 'APP_CDN' ) ) {

      $logo_image = APP_CDN . $logo_image;
      $background_image = APP_CDN . $background_image;

    }
    */


    //$url_link   = $args[ 'url' ]    ?? $default_url_link;
    //$image_link = $args[ 'image' ]  ?? $logo_image;

    doc_init();

    tag_open( 'html' );

      tag_open( 'head' );

        $title = $args[ 'title' ] ?? null;

        tag_text( 'title', $title );

        tag_meta(
          'viewport',
          [
            'width' => 'device-width',
            'initial-scale' => 1,
          ]
        );

        $private = $args[ 'private' ] ?? false;

        if ( $private || DEBUG || DEV || BETA ) {

          tag_meta( 'referrer', 'same-origin' );

          tag_meta( 'robots', [ 'noindex', 'nofollow', 'noarchive' ] );

        }
        else {

          tag_meta( 'robots', $args[ 'robots' ] ?? [ 'index', 'follow' ] );

        }

        $description = $args[ 'description' ] ?? null;

        if ( $description ) {

          tag_meta( 'description', $description );

        }

        $keywords = $args[ 'keywords' ] ?? null;

        if ( $keywords ) {

          tag_meta( 'keywords', $keywords );

        }

        //tag_link( 'image/png', 'icon', bom_get_favicon_url() );

        tag_link( 'image/x-icon', 'icon', app_url()->res( '/res/image/favicon.ico' ) );


        $copyright_url = $args[ 'copyright' ] ?? null;

        if ( $copyright_url ) {

          tag_link( 'text/html', 'copyright', $copyright_url );

        }

        /*
        $menu_visibility = $_GET[ 'menu' ] ?? 'show';
        $search_visibility = $_GET[ 'search' ] ?? 'show';

        tag_bare(
          'link',
          [
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => web()->get_style_url(),
          ]
        );

        $search_action = $args[ 'search_action' ] ?? bom_get_utility_link( 'search' );
        */

        foreach ( $args[ 'stylesheets' ] ?? [] as $url ) {

          tag_link( 'text/css', 'stylesheet', $url );

        }

        //tag_link( 'text/css', 'stylesheet', 'https://www.staticmagic.net/global/table.css' );
        tag_link( 'text/css', 'stylesheet', 'https://d27cckvuinr11o.cloudfront.net/global/table.css' );

        tag_link( 'text/css', 'stylesheet', app_url()->res( '/res/style' ) );

        tag_link( 'text/css', 'stylesheet', app_url()->res( '/res/debug/style.css' ) );

        foreach ( $args[ 'scripts' ] ?? [] as $url ) {

          tag_bare( 'script', [ 'src' => $url ] );

        }

        tag_shut( 'head' );

        tag_open( 'body' );

          if ( BETA ) {

            tag_text(
              'div',
              'BETA',
              [
                'style' =>
                [
                  'color' => 'red',
                  'text-align' => 'center',
                ]
              ]
            );

          }

          $this->container_id = $args[ 'container_id' ] ?? 'main';

          tag_open( 'div', [ 'id' => $this->container_id ] );

            if ( ! $iframe ) {

              $this->render_nav_header( $context, $args );

              if ( $flash = app_session()->flash() ) {

                tag_text( 'p', $flash, [ 'class' => 'flash' ] );

              }
            }

            if ( $context->has_errors() ) {

              $errors = $context->get_errors();

              if ( count( $errors ) === 1 ) {

                foreach ( $errors as $error ) {

                  tag_text( 'p', $error, [ 'class' => 'error' ] );

                }
              }
              else {

                tag_open( 'ul' );

                  foreach ( $errors as $error ) {

                    tag_text( 'li', $error, [ 'class' => 'error' ] );

                  }

                tag_shut( 'ul' );

              }
            }

  }

  public function render_foot( $context, $args = [] ) {

        $iframe = $args[ 'iframe' ] ?? false;

        tag_shut( 'div', [ 'id' => $this->container_id ] );

        if ( ! $iframe ) {

          tag_open( 'p' );

            tag_text( 'span', APP_SLUG . ' with ' . MUDBALL_SLUG );

          tag_shut( 'p' );

        }

        if ( DEBUG ) {

          //var_dump( app_request() );

        }

        foreach ( $args[ 'scripts' ] ?? [] as $url ) {

          tag_bare( 'script', [ 'src' => $url ] );

        }

        tag_bare( 'script', [ 'src' => app_url()->res( '/res/script' ) ] );

      tag_shut( 'body' );

    tag_shut( 'html' );

  }

  public function render_nav_header( $context, $args = [] ) {

  }

  public function render_form_open(
    $context,
    $name = null,
    $default_action = null,
    $method = 'POST',
    $id = null,
    $attrs = []
  ) {

    if ( ! $name ) { $name = 'form'; }
    if ( ! $id ) { $id = $this->get_auto_html_id( $name ); }

    $attrs += [ 'id' => $id, 'name' => $name, 'class' => $name, 'method' => $method ];

    /*
    $debug = defined( 'DEBUG' ) && DEBUG;

    if ( $debug ) {

      tag_text( 'h2', $name );

    }
    */

    tag_open( 'form', $attrs );

      if ( $default_action ) {

        tag_bare(
          'input',
          [
            'type' => 'submit',
            'name' => APP_INPUT_ACTION_DEFAULT,
            'value' => $default_action,
            'style' => 'display:none',
          ]
        );

      }

  }

  public function render_form_shut( $context ) {

    //$debug = defined( 'DEBUG' ) && DEBUG;

    tag_shut( 'form' );

  }
}
