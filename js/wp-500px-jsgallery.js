jQuery(document).ready(function(){
/*Marcus-Jooste*/
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
            playLinkText:              wp5jsgal_langs.playLinkText,
            pauseLinkText:             wp5jsgal_langs.pauseLinkText,
            prevLinkText:              wp5jsgal_langs.prevLinkText,
            nextLinkText:              wp5jsgal_langs.nextLinkText,
            nextPageLinkText:          wp5jsgal_langs.nextPageLinkText,
            prevPageLinkText:          wp5jsgal_langs.prevPageLinkText,
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
