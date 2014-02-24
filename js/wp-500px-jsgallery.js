jQuery(document).ready(function(){

    wp5jsgal_rss500px('micz', function(feed){ 
        var contentimg = jQuery(unescape(jQuery(this).find('content').text())).find("img").attr("src");
    
        var entries = feed.entries, feedList = '';
        for (var i = 0; i < entries.length; i++) {

            feedList +=wp5jsgal_getImage(entries[i]);
        }

        jQuery('div#wp500pxthumbs > ul.thumbs').append(feedList);
        var gallery = jQuery('div#wp500pxthumbs').galleriffic({
            imageContainerSel:         '#wp500pxslideshow',
		        captionContainerSel:       '#wp500pxcaption',
		        controlsContainerSel:      '#wp500pxcontrols',
		        loadingContainerSel:       '#wp500pxloading',
		        enableHistory:             true,
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
					  }
        });

       	// We only want these styles applied when javascript is enabled
		  	jQuery('div.wp500pxnavigation').css({'width' : '315px', 'float' : 'left'});
				jQuery('div.wp500pxcontent').css({'display':'block','float':'right','width': '64%'});
				
				jQuery('div.entry-content').css('max-width', '1000px');

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
