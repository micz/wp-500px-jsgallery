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
	
	  public $options=array();
	
	  // Class Constructor
	  function __construct() {
  	  $this->options = get_option('wp5jsgal_options');
      add_action('admin_init', array('WP500pxjsGallery','register_settings'));
      add_action('admin_menu', array('WP500pxjsGallery','admin_add_page'));
      add_shortcode( 'jsg500px', array('WP500pxjsGallery','getShortcode'));
	  }
	  
  
//Settings page
	  static function register_settings(){
	    register_setting('wp5jsgal_options','wp5jsgal_options',array('WP500pxjsGallery','options_validate'));
  	  add_settings_section('wp5jsgal_main', 'Main Settings', array('WP500pxjsGallery','main_section_text'), 'wp5jsgal_settings_page');
	    add_settings_field('wp5jsgal_user','500px User',null,'wp5jsgal_settings_page','default');
	  }
	  
	  static function admin_add_page(){
      add_options_page('WP 500px jsGallery Settings', 'WP 500px jsGallery', 'manage_options', 'wp5jsgal_settings_page', array('WP500pxjsGallery','output_settings_page'));
    }
	  
    static function main_section_text() {
      echo '<p>Main description of this section here.</p>';
    }
	  
	  static function output_settings_page(){
?><div>
<h2>WP 500px jsGallery Settings</h2>
Options relating to the WP 500px jsGallery Plugin.
<form action="options.php" method="post">
<?php settings_fields('wp5jsgal_options');?>
<?php $options = get_option('wp5jsgal_options'); ?>
<?php do_settings_sections('wp5jsgal_settings_page');?>
<table class="form-table">
    <tr valign="top"><th scope="row">500px Username</th>
        <td><input name="wp5jsgal_options[500px_user]" type="text" value="<?php echo $options['500px_user']; ?>"/></td>
    </tr>
   <?/*?> <tr valign="top"><th scope="row">Some text</th>
        <td><input type="text" name="ozh_sample[500px_user]" value="<?php echo $options['500px_user']; ?>" /></td>
    </tr><?*/?>
</table>
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes');?>"/>
</form></div>
	  <?}
	  
  static function options_validate($input) {
    // The username must be safe text with no HTML tags
    $newinput['500px_user'] =  trim(wp_filter_nohtml_kses($input['500px_user']));
   
    return $newinput;
  }
//Settings page - END


	  //Output shortcode [jsg500px]
	  static function getShortcode($atts){
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
	
	  /*function getImageHTML($imgData){
	    $output='<li>
            <a class="thumb" name="optionalCustomIdentifier" href="'.$imgData['thumb_url'].'" title="'.$imgData['title'].'">
                <img src="'.$imgData['thumb_url'].'" alt="'.$imgData['title'].'" />
            </a>
            <div class="caption">'.$imgData['caption'].'</div>
        </li>';
      return $output;
	  }*/
	
	
	} //END WP500pxjsGallery
	
} //END if class_exists('WP500pxjsGallery')
?>
