<?php
/*
Plugin Name: WP 500px jsGallery
Plugin URI: http://micz.it/wordpress-plugin-500px-jsgallery/
Description: Add your 500px.com photo gallery to a page using the [jsg500px] shortcode. Read the <a href="http://micz.it/wordpress-plugin-500px-jsgallery/faq/" target="_blank">FAQ</a> and see how to customize the look with a <a href="http://micz.it/wordpress-plugin-500px-jsgallery/custom-css/" target="_blank">custom CSS</a>.
Author: Mic [m@micz.it]
Version: 2.0alpha
Text Domain: wp5jsgal
Author URI: http://micz.it
License: GPLv2 or later
*/

/* Copyright 2014 Mic (email: m@micz.it)
Plugin Info: http://micz.it/wordpress-plugin-500px-jsgallery/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

// Fix the __FILE__ problem with symlinks.
// Now just use ___FILE___ instead of __FILE__

$___FILE___ = __FILE__;

if ( isset( $plugin ) ) {
$___FILE___ = $plugin;
}
else if ( isset( $mu_plugin ) ) {
$___FILE___ = $mu_plugin;
}
else if ( isset( $network_plugin ) ) {
$___FILE___ = $network_plugin;
}

define( '___FILE___', $___FILE___ );

include_once('wp-500px-jsgallery.class.php');
$wp500pxjsgallery='';

function wp5jsgal_plugin_init(){
  global $wp500pxjsgallery;
  $wp500pxjsgallery=new WP500pxjsGallery();
}

/**
 * ENQUEUE SCRIPTS
 */
function wp5jsgal_enqueue_scripts() {
  global $wp500pxjsgallery;
  $wp5jsgal_enqueue_scripts=false;
  if($wp500pxjsgallery->options[WP500pxjsGallery::_pages]!=''){ //if the user has set a single page, enqueue only on that page
    $wp5jsgal_enqueue_scripts=is_page(explode(',',$wp500pxjsgallery->options[WP500pxjsGallery::_pages]));
  }else{
    $wp5jsgal_enqueue_scripts=is_page();
  }
    if($wp5jsgal_enqueue_scripts):
      //Gallery CSS
      $custom_css_exists=file_exists(get_stylesheet_directory().'/wp-500px-jsgallery.css'); //check if a custom css exists in the current theme directory
      if(!(($custom_css_exists)&&($wp500pxjsgallery->options[WP500pxjsGallery::_only_custom_css]==1))){
          wp_enqueue_style(
              'wp5jsgal-main-style',
              plugins_url( 'css/wp-500px-jsgallery.css' , ___FILE___ ),
              array(),
              WP500pxjsGallery::version
          );
        }
        if($custom_css_exists){ //Conditionally loading a theme css
          wp_enqueue_style(
              'wp5jsgal-theme-style',
              get_stylesheet_directory_uri().'/wp-500px-jsgallery.css',
              array(),
              WP500pxjsGallery::version
          );
          true;
        }
        wp_enqueue_script(
            'galleriffic',
            plugins_url( 'js/jquery.galleriffic.js' , ___FILE___ ),
            array('jquery'),
            '2.0.1micz'
        );
        wp_enqueue_script(
            'history',
            plugins_url( 'js/jquery.history.js' , ___FILE___ ),
            array('jquery'),
            '1.0.0'
        );
        wp_enqueue_script(
            'opacityrollover',
            plugins_url( 'js/jquery.opacityrollover.js' , ___FILE___ ),
            array('jquery'),
            '1.0.0'
        );
        wp_enqueue_script(
            'wp5jsgal-rss500px',
            plugins_url( 'js/rss500px.js' , ___FILE___ ),
            array('jquery'),
            WP500pxjsGallery::version
        );
        wp_enqueue_script(
            'wp5jsgal-main',
            plugins_url( 'js/wp-500px-jsgallery.js' , ___FILE___ ),
            array('jquery','wp5jsgal-rss500px'),
            WP500pxjsGallery::version, //script version
            true //loaded before the body closing tag
        );
        //passing js params
        wp_localize_script('wp5jsgal-rss500px','wp5jsgal_options',$wp500pxjsgallery->getJsParams());
        //localizing js scripts
        wp_localize_script('wp5jsgal-rss500px','wp5jsgal_langs',$wp500pxjsgallery->getJsLang());
        $wp500pxjsgallery->scripts_loaded=true;
    endif;
}


add_action('wp_enqueue_scripts', 'wp5jsgal_enqueue_scripts');
add_action('init', 'wp5jsgal_plugin_init');
?>
