<?php
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
	  public $that_wp5js;
	  public $scripts_loaded;

	  const version='2.1.2';
	  const db_version=2;

	  //URL constants
	  const url_custom_css_info='http://micz.it/wordpress-plugin-500px-jsgallery/custom-css/';
	  const url_force_css_v1=' http://micz.it/wordpress-plugin-500px-jsgallery/css-versions-explained/';
	  const url_donate='http://micz.it/wordpress-plugin-500px-jsgallery/donate/';

	  //Options constants
	  const _500px_user='_500px_user';
	  const _page_thumbs='_page_thumbs';
	  const _pages='_pages';
	  const _thumb_h='_thumb_h';
	  const _thumb_w='_thumb_w';
	  const _image_h='_image_h';
	  const _image_w='_image_w';
	  const _only_custom_css='_only_custom_css';
	  const _force_css_v1='_force_css_v1';
	  const _db_ver='wp5jsgal_option_db_ver';
	  //const _plugin_img_path='_plugin_img_path';

	  // Class Constructor
	  public function __construct(){
	    global $that_wp5js;
	    $that_wp5js=$this;
  	    $this->options = $this->sanitizeOptions(get_option('wp5jsgal_options'));
        add_action('admin_init', array($that_wp5js,'register_settings'));
        add_action('admin_menu', array($that_wp5js,'admin_add_page'));
        add_shortcode('jsg500px', array($that_wp5js,'getShortcode'));
        add_filter('plugin_action_links_'.plugin_basename(___FILE_wp5js___),array($that_wp5js,'add_settings_link'));
        add_filter('plugin_row_meta',array($that_wp5js,'add_plugin_desc_links'),10,2);
        load_plugin_textdomain('wp-500px-jsgallery',false,basename(dirname(___FILE_wp5js___)).'/lang/');
        $this->scripts_loaded=false;
	  }

	  public function activate() {
		//From v2.0 on plugin activation, we need to check if it's a new install or an upgrade
		//On updrage we force the use of CSS v1 to not be disruptive for the gallery layout
		$db_ver_opt=intval(get_option('wp5jsgal_option_db_ver'));
		if($db_ver_opt<self::db_version){	//It's upgrading, update db_version!
			update_option('wp5jsgal_option_db_ver',self::db_version);
			if((get_option('wp5jsgal_options',-1)!=-1)&&($db_ver_opt==0)){ //We need to force CSS v1, coming from plugin version <2.0
				$this->options[self::_force_css_v1]=1;
				update_option('wp5jsgal_options',$this->options);
			}
		}
	  }

	  //Settings page
	  public function register_settings(){
	    global $that_wp5js;
	    register_setting('wp5jsgal_options','wp5jsgal_options',array($that_wp5js,'options_validate'));
  	  	add_settings_section('wp5jsgal_main', esc_html__('Main Settings','wp-500px-jsgallery'), array($that_wp5js,'main_section_text'), 'wp5jsgal_settings_page');
	    add_settings_field('wp5jsgal_user',esc_html__('500px User','wp-500px-jsgallery'),null,'wp5jsgal_settings_page','default');
	  }

	  public function admin_add_page(){
	    global $that_wp5js;
      add_options_page(esc_html__('WP 500px jsGallery Settings','wp-500px-jsgallery'),esc_html__('WP 500px jsGallery','wp-500px-jsgallery'), 'manage_options', 'wp5jsgal_settings_page', array($that_wp5js,'output_settings_page'));
    }

    public function main_section_text() {
      $output='<p>';
      $output.='<b>'.esc_html__('How to use this plugin:','wp-500px-jsgallery').'</b><br/>';
      $output.=esc_html__('1. Set the 500px username and save the changes.','wp-500px-jsgallery').'<br/>';
      $output.=esc_html__('2. Use the [jsg500px] shortcode in the page you want to show the 500px gallery on.','wp-500px-jsgallery').'<br/>';
      $output.=esc_html__('3. (Optional) Use the "user500px" shortcode param to set a different username for a single page.','wp-500px-jsgallery').'<br/>';
      $output.='</p>';
      echo $output;
    }

	  public function output_settings_page(){
?><div>
<h2><?php _e('WP 500px jsGallery Settings','wp-500px-jsgallery');?>&nbsp;&nbsp;&nbsp;<span style="font-size:12px;font-weight:normal;">v<?php echo self::version;?></span></h2>
<?php esc_html_e('Modify here the plugin\'s options.','wp-500px-jsgallery');?><br/>
<b><?php esc_html_e('The only mandatory option is the 500px username.','wp-500px-jsgallery');?></b>
<br/><?php esc_html_e('You can also use a custom CSS file to modify the 500px gallery look and feel.','wp-500px-jsgallery');?> (<a href="<?php =self::url_custom_css_info;?>" target="_blank"><?php esc_html_e('More info on custom CSS','wp-500px-jsgallery');?></a>)
<form action="options.php" method="post">
<?php settings_fields('wp5jsgal_options');?>
<?php //$options = get_option('wp5jsgal_options'); // Using $this->options?>
<?php do_settings_sections('wp5jsgal_settings_page');?>
<table class="form-table">
    <tr valign="top"><th scope="row"><?php esc_html_e('500px Username','wp-500px-jsgallery');?></th>
        <td><input name="wp5jsgal_options[<?php =self::_500px_user?>]" type="text" value="<?php echo $this->options[self::_500px_user]; ?>"<?php if($this->options[self::_500px_user]==''){echo 'style="border:2px solid red;"';}?>/>
        <br/><?php if($this->options[self::_500px_user]==''){echo '<span style="color:red;font-weight:bold;">'.esc_html__('You must specify a 500px username here or using the "user500px" shortcode param directly on the page!','wp-500px-jsgallery').'<span>';
        }else{
          esc_html__('You can also specify a 500px username using the "user500px" shortcode param directly on the page.','wp-500px-jsgallery');
        }?></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Number of thumbnails per page','wp-500px-jsgallery');?></th>
        <td><input type="text" name="wp5jsgal_options[<?php =self::_page_thumbs?>]" value="<?php echo $this->options[self::_page_thumbs]; ?>"/></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Thumbnails dimensions','wp-500px-jsgallery');?></th>
        <td><?php esc_html_e('Height','wp-500px-jsgallery');?> <input type="text" name="wp5jsgal_options[<?php =self::_thumb_h?>]" value="<?php echo $this->options[self::_thumb_h]; ?>"/> <?php esc_html_e('px','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('Width','wp-500px-jsgallery');?> <input type="text" name="wp5jsgal_options[<?php =self::_thumb_w?>]" value="<?php echo $this->options[self::_thumb_w]; ?>"/> <?php esc_html_e('px','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('The dimensions could be set with the custom CSS, instead of with these options.','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('You can also set only one dimension, the other will be proportional.','wp-500px-jsgallery');?></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Image dimensions','wp-500px-jsgallery');?></th>
        <td><?php esc_html_e('Max Height','wp-500px-jsgallery');?> <input type="text" name="wp5jsgal_options[<?php =self::_image_h?>]" value="<?php echo $this->options[self::_image_h]; ?>"/> <?php esc_html_e('px','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('Max Width','wp-500px-jsgallery');?> <input type="text" name="wp5jsgal_options[<?php =self::_image_w?>]" value="<?php echo $this->options[self::_image_w]; ?>"/> <?php esc_html_e('px','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('The dimensions could be set with the custom CSS, instead of with these options.','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('You can also set only one dimension, the other will be proportional.','wp-500px-jsgallery');?></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Gallery page','wp-500px-jsgallery');?></th>
        <td><input type="text" name="wp5jsgal_options[<?php =self::_pages?>]" value="<?php echo $this->options[self::_pages]; ?>"/>
        <br/><?php esc_html_e('To optimize your website loading times, you could write here the pages id or permalink on which you have activated the 500px gallery with the shortcode.','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('The ids or permalinks must be comma separated and can be mixed.','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('All the styles and scripts needed by this plugin will be loaded only on those pages.','wp-500px-jsgallery');?></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Use CSS version 1','wp-500px-jsgallery');?></th>
        <td><input type="checkbox" name="wp5jsgal_options[<?php =self::_force_css_v1?>]" value="1"<?php if($this->options[self::_force_css_v1]==1){echo ' checked="checked"';} ?>"/> <?php esc_html_e('Check this option if you want to use the old CSS version 1.','wp-500px-jsgallery');?><br/>
        <?php esc_html_e('From version 2.0 the CSS is responsive and the thumbnails are displayed under the image.','wp-500px-jsgallery');?><br/>
        <a href="<?php =self::url_force_css_v1;?>" target="_blank"><?php esc_html_e('More info on the old CSS version 1','wp-500px-jsgallery');?></a></td>
    </tr>
   <tr valign="top"><th scope="row"><?php esc_html_e('Exclusive custom CSS','wp-500px-jsgallery');?></th>
        <td><input type="checkbox" name="wp5jsgal_options[<?php =self::_only_custom_css?>]" value="1"<?php if($this->options[self::_only_custom_css]==1){echo ' checked="checked"';} ?>"/> <?php esc_html_e('Check this option if you want to load only your custom CSS and not the default one before your one.','wp-500px-jsgallery');?><br/>
        <a href="<?php =self::url_custom_css_info;?>" target="_blank"><?php esc_html_e('More info on custom CSS','wp-500px-jsgallery');?></a></td>
    </tr>
</table>
<input name="Submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes','wp-500px-jsgallery');?>"/>
</form></div>
	  <?php }

  public function options_validate($input) {
    // The username must be safe text with no HTML tags
    $newinput[self::_500px_user] = trim(wp_filter_nohtml_kses($input[self::_500px_user]));
    $newinput[self::_page_thumbs] = intval(trim($input[self::_page_thumbs]));
    $newinput[self::_pages] = trim(wp_filter_nohtml_kses($input[self::_pages]));
    $newinput[self::_thumb_h] = intval(trim($input[self::_thumb_h]));
    if($newinput[self::_thumb_h]==0)$newinput[self::_thumb_h]='';
    $newinput[self::_thumb_w] = intval(trim($input[self::_thumb_w]));
    if($newinput[self::_thumb_w]==0)$newinput[self::_thumb_w]='';
    $newinput[self::_image_h] = intval(trim($input[self::_image_h]));
    if($newinput[self::_image_h]==0)$newinput[self::_image_h]='';
    $newinput[self::_image_w] = intval(trim($input[self::_image_w]));
    if($newinput[self::_image_w]==0)$newinput[self::_image_w]='';
    $newinput[self::_force_css_v1]=intval(trim($input[self::_force_css_v1]));
    if($newinput[self::_force_css_v1]!=1)$newinput[self::_force_css_v1]=0;
    $newinput[self::_only_custom_css]=intval(trim($input[self::_only_custom_css]));
    if($newinput[self::_only_custom_css]!=1)$newinput[self::_only_custom_css]=0;
    return $newinput;
  }

  public function sanitizeOptions($options){
    if(intval($options[self::_page_thumbs])==0)$options[self::_page_thumbs]=5;
    return $options;
  }

//Settings page - END

//Plugin admin page
  function add_settings_link($links){
    $links[] = '<a href="options-general.php?page=wp5jsgal_settings_page">'.__('Settings','wp-500px-jsgallery').'</a>';
	  return $links;
  }

  function add_plugin_desc_links($links,$file){
    if(strpos($file,plugin_basename(___FILE_wp5js___))!==false){
      $links = array_merge($links,array('<a href="'.self::url_donate.'">'.__('Donate','wp-500px-jsgallery').'</a>'));
    }
    return $links;
  }
//Plugin admin page - END

//Output shortcode [jsg500px] - param 'user500px'
	 public function getShortcode($atts){
	    $output='';
	    //get user param
	    extract(shortcode_atts(array('user500px'=>$this->options[self::_500px_user]),$atts));
	    $user500px=trim(wp_filter_nohtml_kses($user500px));
      if($this->scripts_loaded==false){ //the user is not loading the scripts in this page
        if(current_user_can('manage_options')){ //the current user can manage options
          return '<p><span style="color:red;font-weight:bold;">'.esc_html__('You\'ve set the wrong page id or permalink in the plugin settings, so the WP 500px jsGallery Plugin scripts are not loaded in this page!','wp-500px-jsgallery').'<span></p>';
        }else{ //the current can NOT manage options
          return '';
        }
      }
      if($user500px==''){ //no 500px username set
        if(current_user_can('manage_options')){ //the current user can manage options
          return '<p><span style="color:red;font-weight:bold;">'.esc_html__('To use the WP 500px jsGallery Plugin shortcode, you must specify a 500px username in the plugin settings or using the "user500px" shortcode param!','wp-500px-jsgallery').'<span></p>';
        }else{ //the current can NOT manage options
          return '';
        }
      }else{ //500px username set
        if($this->options[self::_500px_user]!=$user500px){
          $this->options[self::_500px_user]=$user500px;
          $output.='<script type="text/javascript">
/* <![CDATA[ */
wp5jsgal_options["_500px_user"]="'.$user500px.'";
/* ]]> */
</script>';
        }
        $output.='<div id="wp500pxnojs" style="color:red;font-weight:bold;">'.esc_html__('The WP 500px jsGallery is not working because Javascript is disabled.','wp-500px-jsgallery').'</div>
        <div id="wp500pxgallery-main">
            <div id="wp500pxloading" class="loader" style="display:none;"><img src="'.plugins_url('img/loadingAnimation.gif',___FILE_wp5js___).'" width="208" height="13"/><br/>'.esc_html__('Loading images...','wp-500px-jsgallery').'</div>
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
        $output.='<div id="wp500pxlinkprofile">'.esc_html__('Browse all images on 500px:','wp-500px-jsgallery').' <a href="http://500px.com/'.$user500px.'/" target="_blank">http://500px.com/'.$user500px.'/</a></div>';
        $output.='</div>';
      } //END if 500px username set
      return $output;
	  }
//Output shortcode [jsg500px] - END

	 public function getJsLang(){
	    $jslang=array();
      $jslang['image_link_desc']=esc_attr__('See this image at full size on 500px','wp-500px-jsgallery');
      $jslang['gal_playLinkText']=esc_attr__('Play','wp-500px-jsgallery');
      $jslang['gal_pauseLinkText']=esc_attr__('Pause','wp-500px-jsgallery');
      $jslang['gal_prevLinkText']=esc_attr__('Previous','wp-500px-jsgallery');
      $jslang['gal_nextLinkText']=esc_attr__('Next','wp-500px-jsgallery');
      $jslang['gal_nextPageLinkText']=esc_attr__('Next &rsaquo;','wp-500px-jsgallery');
      $jslang['gal_prevPageLinkText']=esc_attr__('&lsaquo; Prev','wp-500px-jsgallery');
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
      //$jsparams[(self::_plugin_img_path)]=plugins_url('img/',___FILE_wp5js___);
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
