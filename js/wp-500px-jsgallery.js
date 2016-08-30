/* Copyright 2014 Mic (email: m@micz.it)
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

jQuery(document).ready(function(){

    jQuery('div#wp500pxnojs').remove();

    if(wp5jsgal_options._500px_user==''){
      return;
    }

    jQuery('div#wp500pxloading').show();

    wp5jsgal_rss500px(wp5jsgal_options._500px_user, function(feed){
        var contentimg = jQuery(unescape(jQuery(this).find('content').text())).find("img").attr("src");

        var entries = feed.entries, feedList = '';
        for (var i = 0; i < entries.length; i++) {

            feedList +=wp5jsgal_getImage(entries[i]);
        }

        jQuery('div#wp500pxthumbs > ul.thumbs').append(feedList);

        var gallery = jQuery('div#wp500pxthumbs').galleriffic({
            numThumbs:                 +wp5jsgal_options._page_thumbs,
            enableTopPager:            true,
            imageContainerSel:         '#wp500pxslideshow',
		    captionContainerSel:       '#wp500pxcaption',
		    controlsContainerSel:      '#wp500pxcontrols',
		    loadingContainerSel:       '#wp500pxloading',
		    enableHistory:             true,
            playLinkText:              wp5jsgal_langs.gal_playLinkText,
            pauseLinkText:             wp5jsgal_langs.gal_pauseLinkText,
            prevLinkText:              wp5jsgal_langs.gal_prevLinkText,
            nextLinkText:              wp5jsgal_langs.gal_nextLinkText,
            nextPageLinkText:          wp5jsgal_langs.gal_nextPageLinkText,
            prevPageLinkText:          wp5jsgal_langs.gal_prevPageLinkText,
		    onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
					  	this.find('ul.thumbs').children()
							  .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							  .eq(nextIndex).fadeTo('fast', 1.0);
					  },
					  onPageTransitionOut:       function(callback) {
						  this.fadeTo('fast', 0.0, callback);
					  },
					  onPageTransitionIn:        function() {
						  this.fadeTo('fast', 1.0);
					  },
					  onTransitionOut:           function(slide, caption, isSync, callback) {
						  slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
						  caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
					  },
					  onTransitionIn:            function(slide, caption, isSync) {
						  var duration = this.getDefaultTransitionDuration(isSync);
						  slide.fadeTo(duration, 1.0);
						  caption.fadeTo(duration, 1.0);

						  var slideImage = slide.find('img');
						  jQuery('div.slideshow-container').css('min-height',slideImage.height()+'px');
						  jQuery('div.wp500pxcontrols').css('width',slideImage.width()+'px');

						          //Eventually set thumbs and image h & w
              if((wp5jsgal_options._thumb_h!='')&&(wp5jsgal_options._thumb_h!=0))jQuery('ul.thumbs img').css('height',wp5jsgal_options._thumb_h+'px');
              if((wp5jsgal_options._thumb_w!='')&&(wp5jsgal_options._thumb_w!=0))jQuery('ul.thumbs img').css('width',wp5jsgal_options._thumb_w+'px');
              if((wp5jsgal_options._image_h!='')&&(wp5jsgal_options._image_h!=0))jQuery('div.wp500pxslideshow img').css('max-height',wp5jsgal_options._image_h+'px');
              if((wp5jsgal_options._image_w!='')&&(wp5jsgal_options._image_w!=0))jQuery('div.wp500pxslideshow img').css('max-width',wp5jsgal_options._image_w+'px');
					  },
        });

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				jQuery('#wp500pxthumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected',
				});

/**** Functions to support integration of galleriffic with the jquery.history plugin ****/
				// PageLoad function
				// This function is called when:
				// 1. after calling $.historyInit();
				// 2. after calling $.historyLoad();
				// 3. after pushing "Go Back" button of a browser
				function pageload(hash) {
					// alert("pageload: " + hash);
					// hash doesn't contain the first # character.
					if(hash) {
						jQuery.galleriffic.gotoImage(hash);
					} else {
						gallery.gotoIndex(0);
					}
				}

				// Initialize history plugin.
				// The callback is called at once by present location.hash.
				jQuery.historyInit(pageload, "advanced.html");

				// set onlick event for buttons using the jQuery 1.3 live method
				jQuery("a[rel='history']").live('click', function(e) {
					if (e.button != 0) return true;

					var hash = this.href;
					hash = hash.replace(/^.*#/, '');

					// moves to a new page.
					// pageload is called at once.
					// hash don't contain "#", "?"
					jQuery.historyLoad(hash);

					return false;
				});
/****************************************************************************************/
    });
});
