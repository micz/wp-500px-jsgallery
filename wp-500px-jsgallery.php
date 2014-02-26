<?php
/*
Plugin Name: WP 500px jsGallery
Plugin URI: http://micz.it/wordpress-500px-jsgallery/
Description: .
Author: Mic (m@micz.it)
Version: 0.1
Text Domain: wp5jsgal
Author URI: http://micz.it
License: GPL2
*/

/* Copyright 2014 Mic (email: m@micz.it)
Plugin Info: http://micz.it

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
    if ( is_page() ) :
        wp_enqueue_style(
            'wp5jsgal-main-style',
            plugins_url( 'css/wp-500px-jsgallery.css' , ___FILE___ )
        );
        if (file_exists(get_stylesheet_directory().'/wp-500px-jsgallery.css')){ //Conditionally loading a theme css
          wp_enqueue_style(
              'wp5jsgal-theme-style',
              get_stylesheet_directory_uri().'/wp-500px-jsgallery.css'
          );
        }
        wp_enqueue_script(
            'galleriffic',
            plugins_url( 'js/jquery.galleriffic.js' , ___FILE___ ),
            array('jquery'),
            WP500pxjsGallery::version
        );
        wp_enqueue_script(
            'history',
            plugins_url( 'js/jquery.history.js' , ___FILE___ ),
            array('jquery'),
            WP500pxjsGallery::version
        );
        wp_enqueue_script(
            'opacityrollover',
            plugins_url( 'js/jquery.opacityrollover.js' , ___FILE___ ),
            array('jquery'),
            WP500pxjsGallery::version
        );
        wp_enqueue_script(
            'wp5jsgal-rss500px',
            plugins_url( 'js/rss500px.js' , ___FILE___ ),
            array('jquery'),
            WP500pxjsGallery::version
        );
        if($wp500pxjsgallery->options[WP500pxjsGallery::_500px_user]!=''){
          wp_enqueue_script(
              'wp5jsgal-main',
              plugins_url( 'js/wp-500px-jsgallery.js' , ___FILE___ ),
              array('jquery','wp5jsgal-rss500px'),
              WP500pxjsGallery::version, //script version
              true //loaded before the body closing tag
          );
        }
        //passing js params
        $jsparams=array();
        $jsparams[(WP500pxjsGallery::_500px_user)]=$wp500pxjsgallery->options[(WP500pxjsGallery::_500px_user)];
        $jsparams[(WP500pxjsGallery::_page_thumbs)]=$wp500pxjsgallery->options[(WP500pxjsGallery::_page_thumbs)];
        wp_localize_script('wp5jsgal-rss500px','wp5jsgal_options',$jsparams);
        //localizing js scripts
        wp_localize_script('wp5jsgal-rss500px','wp5jsgal_langs',$wp500pxjsgallery->getJsLang());
    endif;
}


add_action('wp_enqueue_scripts', 'wp5jsgal_enqueue_scripts');
add_action('init', 'wp5jsgal_plugin_init');
?>
