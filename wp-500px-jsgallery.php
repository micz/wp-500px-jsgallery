<?php
/*
Plugin Name: 500px jsGallery
Plugin URI: http://micz.it
Description: .
Author: Mic
Version: 0.1
Author URI: http://micz.it
License: GPL2
*/

/* Copyright 2012 Mic (email: m@micz.it)

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






/**
 * ENQUEUE SCRIPTS
 */
function wp5jsgal_enqueue_scripts() {
    if ( !is_admin() ) :
        wp_enqueue_script(
            'galleriffic',
            plugins_url( 'js/jquery.galleriffic.js' , __FILE__ ),
            array('jquery')
        );
        wp_enqueue_script(
            'history',
            plugins_url( 'js/jquery.history.js' , __FILE__ ),
            array('jquery')
        );
    endif;
}


add_action('wp_enqueue_scripts', 'wp5jsgal_enqueue_scripts');


?>
