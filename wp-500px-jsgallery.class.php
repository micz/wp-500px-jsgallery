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
	  public $that;
	  
	  const version='1.0.0alpha';
	  
	  //Options constants
	  const _500px_user='_500px_user';
	  const _page_thumbs='_page_thumbs';
	
	  // Class Constructor
	  public function __construct() {
	    global $that;
	    $that=$this;
  	  $this->options = $this->getDefaultOptions(get_option('wp5jsgal_options'));
      add_action('admin_init', array($that,'register_settings'));
      add_action('admin_menu', array($that,'admin_add_page'));
      add_shortcode('jsg500px', array($that,'getShortcode'));
      add_filter('plugin_action_links',array($that,'add_settings_link'));
      load_plugin_textdomain('wp5jsgal',false,basename(dirname( __FILE__ )).'/lang/');
	  }
	  
//Settings page
	  public function register_settings(){
	    global $that;
	    register_setting('wp5jsgal_options','wp5jsgal_options',array($that,'options_validate'));
  	  add_settings_section('wp5jsgal_main', 'Main Settings', array($that,'main_section_text'), 'wp5jsgal_settings_page');
	    add_settings_field('wp5jsgal_user','500px User',null,'wp5jsgal_settings_page','default');
	  }
	  
	  public function admin_add_page(){
	    global $that;
      add_options_page(esc_html__('WP 500px jsGallery Settings','wp5jsgal'),esc_html__('WP 500px jsGallery','wp5jsgal'), 'manage_options', 'wp5jsgal_settings_page', array($that,'output_settings_page'));
    }
	  
    public function main_section_text() {
      echo '<p>'.esc_html__('Main description of this section here.','wp5jsgal').'</p>';
    }
	  
	  public function output_settings_page(){
?><div>
<h2><?_e('WP 500px jsGallery Settings','wp5jsgal');?></h2>
<?esc_html_e('Options relating to the WP 500px jsGallery Plugin.','wp5jsgal');?>
<form action="options.php" method="post">
<?php settings_fields('wp5jsgal_options');?>
<?php //$options = get_option('wp5jsgal_options'); // Using $this->options?>
<?php do_settings_sections('wp5jsgal_settings_page');?>
<table class="form-table">
    <tr valign="top"><th scope="row"><?esc_html_e('500px Username','wp5jsgal');?></th>
        <td><input name="wp5jsgal_options[<?=self::_500px_user?>]" type="text" value="<?php echo $this->options[self::_500px_user]; ?>"<?if($this->options[self::_500px_user]==''){echo 'style="border:2px solid red;"';}?>/>
        <?if($this->options[self::_500px_user]==''){echo '<br/><span style="color:red;font-weight:bold;">'.esc_html__('You must specify a 500px username!','wp5jsgal').'<span>';}?></td>
    </tr>
   <tr valign="top"><th scope="row"><?esc_html_e('Number of thumbnails per page','wp5jsgal');?></th>
        <td><input type="text" name="wp5jsgal_options[<?=self::_page_thumbs?>]" value="<?php echo $this->options[self::_page_thumbs]; ?>"/></td>
    </tr>
</table>
<input name="Submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes','wp5jsgal');?>"/>
</form></div>
	  <?}
	  
  public function options_validate($input) {
    // The username must be safe text with no HTML tags
    $newinput[self::_500px_user] =  trim(wp_filter_nohtml_kses($input[self::_500px_user]));
    $newinput[self::_page_thumbs] =  intval(trim($input[self::_page_thumbs]));
    
    return $newinput;
  }

  public function getDefaultOptions($options){
    if(intval($options[self::_page_thumbs])==0)$options[self::_page_thumbs]=10;
    
    return $options;
  }

  public function add_settings_link($links){
    $settings_link = '<a href="options-general.php?page=wp5jsgal_settings_page">'.__('Settings','wp5jsgal').'</a>';
  	array_push($links,$settings_link);
  	return $links;
}
//Settings page - END


//Output shortcode [jsg500px]
	 public function getShortcode($atts){
	    $output='';
      if($this->options[self::_500px_user]==''){ //no 500px username set
        if(current_user_can('manage_options')){ //the current user can manage options
          return '<p><span style="color:red;font-weight:bold;">'.esc_html__('To use the WP 500px jsGallery Plugin shortcode, you must specify a 500px username in the plugin settings!','wp5jsgal').'<span></p>';
        }else{ //the current can NOT manage options
          return '';
        }
      }else{ //500px username set
        $output='<div id="wp500pxgallery-main">
            <div id="wp500pxloading" class="loader"><img src="'.plugins_url('img/loadingAnimation.gif',___FILE___).'" width="208" height="13"/><br/>'.esc_html__('Loading images...','wp5jsgal').'</div>
            <div id="wp500pxgallery" class="wp500pxcontent">
            <div id="wp500pxcontrols" class="500pxcontrols"></div>
            <div class="slideshow-container">
	            <div id="wp500pxslideshow" class="wp500pxslideshow"></div>
	            <div class="wp500pxgallery-footer"></div>
            </div>
            <div id="wp500pxcaption" class="wp500pxcaption-container"></div>
          </div>
          <div id="wp500pxthumbs" class="wp500pxnavigation"><ul class="thumbs noscript">';
        $output.='</ul><div class="wp500pxgallery-footer"></div></div><div class="wp500pxgallery-footer"></div>';
        $output.='<div id="wp500pxlinkprofile">'.esc_html__('Browse all images on 500px:','wp5jsgal').' <a href="http://500px.com/'.$this->options[self::_500px_user].'/">http://500px.com/'.$this->options[self::_500px_user].'/</a></div>';
        $output.='</div>';
      } //END if 500px username set
      return $output;
	  }
	
	 public function getJsLang(){
	    $jslang=array();
      $jslang['image_link_desc']=esc_attr__('See at full size on 500px:','wp5jsgal');
      $jslang['gal_playLinkText']=esc_attr__('Play','wp5jsgal');
      $jslang['gal_pauseLinkText']=esc_attr__('Pause','wp5jsgal');
      $jslang['gal_prevLinkText']=esc_attr__('Previous','wp5jsgal');
      $jslang['gal_nextLinkText']=esc_attr__('Next','wp5jsgal');
      $jslang['gal_nextPageLinkText']=esc_attr__('Next &rsaquo;','wp5jsgal');
      $jslang['gal_prevPageLinkText']=esc_attr__('&lsaquo; Prev','wp5jsgal');
      return $jslang;
	 }
	
	  /*public function getImageHTML($imgData){
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
