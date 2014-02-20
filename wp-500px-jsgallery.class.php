<?
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

if (!class_exists('WP500pxjsGallery')) {

	/**
	 * main class for WP 500px jsGallery
	 *
	 */
	class WP500pxjsGallery {
	
	  // Class Constructor
	  function __construct() {
	  
	  //TODO: options handling
	    
	  }
	  
	  //Output shortcode
	  function getShortcode($atts){
	    $output='<div id="controls"></div>
<div id="loading">Image loading...</div>
<div id="slideshow"></div>
<div id="caption"></div>
<div id="thumbs"><ul class="thumbs noscript">';
      //Print images
      
      $output.='</ul></div>';
      return $output;
	   // return 'testme!!';
	  }
	
	  function getImageHTML($imgData){
	    $output='<li>
            <a class="thumb" name="optionalCustomIdentifier" href="'.$imgData['thumb_url'].'" title="'.$imgData['title'].'">
                <img src="'.$imgData['thumb_url'].'" alt="'.$imgData['title'].'" />
            </a>
            <div class="caption">'.$imgData['caption'].'</div>
        </li>';
      return $output;
	  }
	
	
	} //END WP500pxjsGallery
	
} //END if class_exists('WP500pxjsGallery')
?>
