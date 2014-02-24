<?php
/*
Plugin Name: WP 500px jsGallery
Plugin URI: http://micz.it
Description: .
Author: Mic
Version: 0.1
Author URI: http://micz.it
License: GPL2
*/

/* Copyright 2012 Mic (email: m@micz.it)
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

$wp500pxjsgallery=new WP500pxjsGallery();

/**
 * ENQUEUE SCRIPTS
 */
function wp5jsgal_enqueue_scripts() {
    if ( is_page() ) :
        wp_enqueue_style(
            'wp5jsgal-css',
            plugins_url( 'css/wp-500px-jsgallery.css' , ___FILE___ )
        );
        wp_enqueue_script(
            'galleriffic',
            plugins_url( 'js/jquery.galleriffic.js' , ___FILE___ ),
            array('jquery')
        );
        wp_enqueue_script(
            'history',
            plugins_url( 'js/jquery.history.js' , ___FILE___ ),
            array('jquery')
        );
        wp_enqueue_script(
            'opacityrollover',
            plugins_url( 'js/jquery.opacityrollover.js' , ___FILE___ ),
            array('jquery')
        );
        wp_enqueue_script(
            'wp5jsgal-rss500px',
            plugins_url( 'js/rss500px.js' , ___FILE___ ),
            array('jquery')
        );
        wp_enqueue_script(
            'wp5jsgal-main',
            plugins_url( 'js/wp-500px-jsgallery.js' , ___FILE___ ),
            array('jquery','wp5jsgal-rss500px'),
            false, //script version
            true //loaded before the body closing tag
        );
    endif;
}


add_action('wp_enqueue_scripts', 'wp5jsgal_enqueue_scripts');
?>
