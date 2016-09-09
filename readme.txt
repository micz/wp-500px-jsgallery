=== WP 500px jsGallery ===
Contributors: micz
Donate link: http://micz.it/wordpress-plugin-500px-jsgallery/donate/
Tags: gallery, 500px, jquery, javascript, galleriffic, photos, photo, 500px.com
Requires at least: 3.8.1
Tested up to: 4.6
Stable tag: 2.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add your 500px.com photo gallery to a page using the [jsg500px] shortcode.

== Description ==

This is plugin lets you add your 500px.com gallery to a page in your blog using the [jsg500px] shortcode.
The gallery is made with galleriffic and the images are retrieved from 500px.com using the user feed.

It's possible also to define a custom CSS in your template folder to customize completely the gallery.

See the plugin in action here: http://micz.it/fotografia/500px/


== Installation ==

1. Upload the folder `wp-500px-jsgallery` and all its files to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Put your 500px.com username in the plugin settings page.
1. Insert the shortcode [jsg500px] in the page you want to show the gallery.
1. (Optional) Use the "user500px" shortcode param to set a different username for a single page.


== Frequently Asked Questions ==

= Can I add the gallery to a post? =

No. The gallery can be added only on a page using the [jsg500px] shortcode.

= Can I add the gallery to more than one page? =

Yes, and you can specify different 500px.com usernames with the "user500px" shortcode param.
To optimize your website loading times, with the "Gallery page" option you can also specify all the ids or permalinks pages on which the needed scripts must be loaded.

= Why I didn't see all my 500px photos? =

The photos displayed are only the latest ones, as published in the user feed by 500px.com.


== Screenshots ==

1. The gallery in action, see it live here: http://micz.it/fotografia/500px/ .
2. Plugin settings page.

== Changelog ==

= 2.0.2 =
* Minor bug fixed.

= 2.0.1 =
* CSS improvements.
* Links to 500px.com are now opened in a new window.
* Link to the image on 500px is now on the image title.

= 2.0 =
* 500px link is no more explicitly displayed. Now the "See this image at full size on 500px" statement is a link itself.
* New responsive CSS added. To be not disruptive only for upgrade, the "Use CSS version 1" option must be deselected to use the new gallery layout.

= 1.1.1 =
* CSS fix to show the thumbnails in the correct size in Firefox.

= 1.1 =
* Added an option to load exclusively the custom css file and not the default one.
* Is now possible to use the "user500px" shortcode param to set a different 500px username on a page.
* The styles and scripts can be loaded selectively on more than one page.

= 1.0.3 =
* Fixed missing argument 2 error for settings link in plugins admin page.

= 1.0.2 =
* Added css z-index to prev/next navigation controls that were not clickable.

= 1.0.1 =
* Better installing instruction and descriptions.
* Fixed a bug with the settings link in the plugin admin page.

= 1.0 =
* First release.

== Upgrade Notice ==

= 2.0.2 =
* Minor bug fixed.

= 2.0.1 =
* CSS improvements.
* Links to 500px.com are now opened in a new window.
* Link to the image on 500px is now on the image title.

= 2.0 =
* 500px link is no more explicitly displayed. Now the "See this image at full size on 500px" statement is a link itself.
* New responsive CSS added. To be not disruptive the "Use CSS version 1" option must be deselected to use the new gallery layout.

= 1.1.1 =
* CSS fix to show the thumbnails in the correct size in Firefox.

= 1.1 =
* Added an option to load exclusively the custom css file and not the default one.
* Is now possible to use the "user500px" shortcode param to set a different 500px username on a page.
* The styles and scripts can be loaded selectively on more than one page.

= 1.0.3 =
* Fixed missing argument 2 error for settings link in plugins admin page.

= 1.0.2 =
* Added css z-index to prev/next navigation controls that were not clickable.

= 1.0.1 =
* Better installing instruction and descriptions.
* Fixed a bug with the settings link in the plugin admin page.

= 1.0 =
First release.


== Using a custom CSS file ==

You can customize the look of the gallery using a custom CSS file.
The file must be named `wp-500px-jsgallery.css` and copied in your theme root folder, the same where is stored the theme `style.css` file.
This custom file will be loaded after the standard plugin css file, so you can modify only the elements you need, the other elements will be displayed as usual.
You can check the standard `wp-500px-jsgallery.css` to see which css elements the gallery is composed of.
If you check the "Exclusive custom CSS" option in the plugin settings page, will be loaded only your custom CSS file and not the plugin default one.

If you need to modify only the thumbnails or image dimensions, you could do this via a custom css or using the dedicated options in the plugin settings page.

== Plugin source files ==

The source files repository is available at https://github.com/micz/wp-500px-jsgallery/
