<?
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

if (!class_exists('WP500pxjsGallery')) {

	/**
	 * main class for WP 500px jsGallery
	 *
	 */

	class WP500pxjsGallery {
	
	  public $options=array();
	  public $that;
	  public $scripts_loaded;
	  
	  const version='1.0.2';
	  
	  //Options constants
	  const _500px_user='_500px_user';
	  const _page_thumbs='_page_thumbs';
	  const _pages='_pages';
	  const _thumb_h='_thumb_h';
	  const _thumb_w='_thumb_w';
	  const _image_h='_image_h';
	  const _image_w='_image_w';
	
	  // Class Constructor
	  public function __construct() {
	    global $that;
	    $that=$this;
  	  $this->options = $this->getDefaultOptions(get_option('wp5jsgal_options'));
      add_action('admin_init', array($that,'register_settings'));
      add_action('admin_menu', array($that,'admin_add_page'));
      add_shortcode('jsg500px', array($that,'getShortcode'));
      add_filter('plugin_action_links_'.plugin_basename(___FILE___),array($that,'add_settings_link'));
      load_plugin_textdomain('wp5jsgal',false,basename(dirname(___FILE___)).'/lang/');
      $scripts_loaded=false;
	  }
	  
//Settings page
	  public function register_settings(){
	    global $that;
	    register_setting('wp5jsgal_options','wp5jsgal_options',array($that,'options_validate'));
  	  add_settings_section('wp5jsgal_main', esc_html__('Main Settings','wp5jsgal'), array($that,'main_section_text'), 'wp5jsgal_settings_page');
	    add_settings_field('wp5jsgal_user',esc_html__('500px User','wp5jsgal'),null,'wp5jsgal_settings_page','default');
	  }
	  
	  public function admin_add_page(){
	    global $that;
      add_options_page(esc_html__('WP 500px jsGallery Settings','wp5jsgal'),esc_html__('WP 500px jsGallery','wp5jsgal'), 'manage_options', 'wp5jsgal_settings_page', array($that,'output_settings_page'));
    }
	  
    public function main_section_text() {
      $output='<p>';
      $output.='<b>'.esc_html__('How to use this plugin:','wp5jsgal').'</b><br/>';
      $output.=esc_html__('1. Set the 500px username and save the changes.','wp5jsgal').'<br/>';
      $output.=esc_html__('2. Use the [jsg500px] shortcode in the page you want to show the 500px gallery on.','wp5jsgal').'<br/>';
      $output.='</p>';
      echo $output;
    }
	  
	  public function output_settings_page(){
?><div>
<h2><?_e('WP 500px jsGallery Settings','wp5jsgal');?></h2>
<?esc_html_e('Modify here the plugin\'s options.','wp5jsgal');?><br/>
<b><?esc_html_e('The only mandatory option is the 500px username.','wp5jsgal');?></b>
<br/><?esc_html_e('You can also use a custom CSS file to modify the 500px gallery look and feel. Check the instruction in the plugin readme.txt file.','wp5jsgal');?>
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
   <tr valign="top"><th scope="row"><?esc_html_e('Thumbnails dimensions','wp5jsgal');?></th>
        <td><?esc_html_e('Height','wp5jsgal');?> <input type="text" name="wp5jsgal_options[<?=self::_thumb_h?>]" value="<?php echo $this->options[self::_thumb_h]; ?>"/> <?esc_html_e('px','wp5jsgal');?><br/>
        <?esc_html_e('Width','wp5jsgal');?> <input type="text" name="wp5jsgal_options[<?=self::_thumb_w?>]" value="<?php echo $this->options[self::_thumb_w]; ?>"/> <?esc_html_e('px','wp5jsgal');?><br/>
        <?esc_html_e('The dimensions could be set with the custom css, instead of with these options.','wp5jsgal');?><br/>
        <?esc_html_e('You can also set only one dimension, the other will be proportional.','wp5jsgal');?></td>
    </tr>
   <tr valign="top"><th scope="row"><?esc_html_e('Image dimensions','wp5jsgal');?></th>
        <td><?esc_html_e('Max Height','wp5jsgal');?> <input type="text" name="wp5jsgal_options[<?=self::_image_h?>]" value="<?php echo $this->options[self::_image_h]; ?>"/> <?esc_html_e('px','wp5jsgal');?><br/>
        <?esc_html_e('Max Width','wp5jsgal');?> <input type="text" name="wp5jsgal_options[<?=self::_image_w?>]" value="<?php echo $this->options[self::_image_w]; ?>"/> <?esc_html_e('px','wp5jsgal');?><br/>
        <?esc_html_e('The dimensions could be set with the custom css, instead of with these options.','wp5jsgal');?><br/>
        <?esc_html_e('You can also set only one dimension, the other will be proportional.','wp5jsgal');?></td>
    </tr>
   <tr valign="top"><th scope="row"><?esc_html_e('Gallery page','wp5jsgal');?></th>
        <td><input type="text" name="wp5jsgal_options[<?=self::_pages?>]" value="<?php echo $this->options[self::_pages]; ?>"/>
        <br/><?esc_html_e('To optimize your website loading times, you could write here the page id or page permalink on which you have activated the 500px gallery with the shortcode.','wp5jsgal');?><br/>
        <?esc_html_e('All the styles and scripts needed by this plugin will be loaded only on that page.','wp5jsgal');?></td>
    </tr>
</table>
<input name="Submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes','wp5jsgal');?>"/>
</form></div>
	  <?}
	  
  public function options_validate($input) {
    // The username must be safe text with no HTML tags
    $newinput[self::_500px_user] = trim(wp_filter_nohtml_kses($input[self::_500px_user]));
    $newinput[self::_page_thumbs] = intval(trim($input[self::_page_thumbs]));
    $newinput[self::_pages] =  trim(wp_filter_nohtml_kses($input[self::_pages]));
    $newinput[self::_thumb_h] = intval(trim($input[self::_thumb_h]));
    if($newinput[self::_thumb_h]==0)$newinput[self::_thumb_h]='';
    $newinput[self::_thumb_w] = intval(trim($input[self::_thumb_w]));
    if($newinput[self::_thumb_w]==0)$newinput[self::_thumb_w]='';
    $newinput[self::_image_h] = intval(trim($input[self::_image_h]));
    if($newinput[self::_image_h]==0)$newinput[self::_image_h]='';
    $newinput[self::_image_w] = intval(trim($input[self::_image_w]));
    if($newinput[self::_image_w]==0)$newinput[self::_image_w]='';    
    return $newinput;
  }

  public function getDefaultOptions($options){
    if(intval($options[self::_page_thumbs])==0)$options[self::_page_thumbs]=5;
    
    return $options;
  }

function add_settings_link( $links, $file ) {
  $links[] = '<a href="options-general.php?page=wp5jsgal_settings_page">'.__('Settings','wp5jsgal').'</a>';
	return $links;
}
//Settings page - END


//Output shortcode [jsg500px]
	 public function getShortcode($atts){
	    $output='';
      if($this->scripts_loaded==false){ //the user is not loading the scripts in this page
        if(current_user_can('manage_options')){ //the current user can manage options
          return '<p><span style="color:red;font-weight:bold;">'.esc_html__('You\'ve set the wrong page id or permalink in the plugin settings, so the WP 500px jsGallery Plugin scripts are not loaded in this page!','wp5jsgal').'<span></p>';
        }else{ //the current can NOT manage options
          return '';
        }
      }
      if($this->options[self::_500px_user]==''){ //no 500px username set
        if(current_user_can('manage_options')){ //the current user can manage options
          return '<p><span style="color:red;font-weight:bold;">'.esc_html__('To use the WP 500px jsGallery Plugin shortcode, you must specify a 500px username in the plugin settings!','wp5jsgal').'<span></p>';
        }else{ //the current can NOT manage options
          return '';
        }
      }else{ //500px username set
        $output='<div id="wp500pxnojs" style="color:red;font-weight:bold;">'.esc_html__('The WP 500px jsGallery is not working because Javascript is disabled.','wp5jsgal').'</div>
        <div id="wp500pxgallery-main">
            <div id="wp500pxloading" class="loader" style="display:none;"><img src="'.plugins_url('img/loadingAnimation.gif',___FILE___).'" width="208" height="13"/><br/>'.esc_html__('Loading images...','wp5jsgal').'</div>
            <div id="wp500pxgallery" class="wp500pxcontent">
            <div id="wp500pxcontrols" class="wp500pxcontrols"></div>
            <div class="slideshow-container">
	            <div id="wp500pxslideshow" class="wp500pxslideshow"></div>
	            <div class="wp500pxgallery-footer">&nbsp;</div>
            </div>
            <div id="wp500pxcaption" class="wp500pxcaption-container"></div>
          </div>
          <div id="wp500pxthumbs" class="wp500pxnavigation"><ul class="thumbs noscript">';
        $output.='</ul><div class="wp500pxgallery-footer">&nbsp;</div></div><div class="wp500pxgallery-footer">&nbsp;</div>';
        $output.='<div id="wp500pxlinkprofile">'.esc_html__('Browse all images on 500px:','wp5jsgal').' <a href="http://500px.com/'.$this->options[self::_500px_user].'/">http://500px.com/'.$this->options[self::_500px_user].'/</a></div>';
        $output.='</div>';
      } //END if 500px username set
      return $output;
	  }
	
	 public function getJsLang(){
	    $jslang=array();
      $jslang['image_link_desc']=esc_attr__('See this image at full size on 500px:','wp5jsgal');
      $jslang['gal_playLinkText']=esc_attr__('Play','wp5jsgal');
      $jslang['gal_pauseLinkText']=esc_attr__('Pause','wp5jsgal');
      $jslang['gal_prevLinkText']=esc_attr__('Previous','wp5jsgal');
      $jslang['gal_nextLinkText']=esc_attr__('Next','wp5jsgal');
      $jslang['gal_nextPageLinkText']=esc_attr__('Next &rsaquo;','wp5jsgal');
      $jslang['gal_prevPageLinkText']=esc_attr__('&lsaquo; Prev','wp5jsgal');
      return $jslang;
	 }
	 
	 public function getJsParams(){
      $jsparams=array();
      $jsparams[(self::_500px_user)]=$this->options[(self::_500px_user)];
      $jsparams[(self::_page_thumbs)]=$this->options[(self::_page_thumbs)];
      $jsparams[(self::_thumb_h)]=$this->options[(self::_thumb_h)];
      $jsparams[(self::_thumb_w)]=$this->options[(self::_thumb_w)];
      $jsparams[(self::_image_h)]=$this->options[(self::_image_h)];
      $jsparams[(self::_image_w)]=$this->options[(self::_image_w)];
      return $jsparams;
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
