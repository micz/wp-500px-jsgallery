=== WP 500px jsGallery ===
Contributors: micz
Donate link: http://micz.it/wordpress-plugin-500px-jsgallery/
Tags: gallery, 500px, jquery, javascript, galleriffic, photos, photo, 500px.com
Requires at least: 3.8.1
Tested up to: 3.8.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add your 500px.com photo gallery to a page using the [jsg500px] shortcode.

== Description ==

This is plugin lets you add your 500px.com gallery to a page in your blog using the [jsg500px] shortcode.
The gallery is made with galleriffic and the images are retrieved from 500px.com using the user feed.

It's possible also to define a custom css in your template folder to customize completely the gallery.


== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Put your 500px.com username in the plugin settings page.


== Frequently Asked Questions ==

= Can I add the gallery to a post? =

No. The gallery can be added only on a page using the [jsg500px] shortcode.

= Can I add the gallery to more than one page? =

Yes, but it will be the same 500px.com user gallery and you'll need to let WordPress load the scripts on every page.
If you use the gallery on only one page, you can load the needed scripts only on that page (there is an option for this in the settings page).
In a future relaese is planned to pass the 500px.com username also as a shortcode parameter and let you configure more than one page to load the scripts on.

= Why I didn't see all my 500px photos? =

The photos displayed are only the last ones, as published in the user feed by 500px.com.


== Screenshots ==

1. See the gallery in action.
2. Plugin settings page.

== Changelog ==

= 1.0 =
* First release.

== Upgrade Notice ==

= 1.0 =
First release.


== Using a custom CSS file ==

You can customize the look of the gallery using a custom CSS file.
The file must be named 'wp-500px-jsgallery.css' and copied in your theme root folder, the same where is stored the theme 'style.css' file.
This custom file will be loaded after the standard plugin css file, so you can modify only the elements you need, the other elements will be displayed as usual.
You can check the standard 'wp-500px-jsgallery.css' to see which css elements the gallery is composed of.

If you need to modify only the thumbnails or image dimensions, you could do this via a custom css or using the dedicated options in the plugin settings page.

