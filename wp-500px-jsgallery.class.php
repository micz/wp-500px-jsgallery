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
	    $output='<div id="wp500pxgallery-main"><div id="wp500pxgallery" class="wp500pxcontent">
					<div id="wp500pxcontrols" class="500pxcontrols"></div>
					<div class="slideshow-container">
						<div id="wp500pxloading" class="loader"></div>
						<div id="wp500pxslideshow" class="wp500pxslideshow"></div>
						<div class="wp500pxgallery-footer"></div>
					</div>
					<div id="wp500pxcaption" class="wp500pxcaption-container"></div>
				</div>
				<div id="wp500pxthumbs" class="wp500pxnavigation"><ul class="thumbs noscript">';
      $output.='</ul><div class="wp500pxgallery-footer"></div></div><div class="wp500pxgallery-footer"></div></div>';
      return $output;
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
