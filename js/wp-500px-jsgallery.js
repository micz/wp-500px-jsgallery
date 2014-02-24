jQuery(document).ready(function(){

    wp5jsgal_rss500px('micz', function(feed){ 
        var contentimg = jQuery(unescape(jQuery(this).find('content').text())).find("img").attr("src");
    
        var entries = feed.entries, feedList = '';
        for (var i = 0; i < entries.length; i++) {

            feedList +=wp5jsgal_getImage(entries[i]);
        }
        //jQuery('.feed > ul').append(feedList);
        jQuery('div#500pxthumbs > ul.thumbs').append(feedList);
        var gallery = jQuery('#500pxthumbs').galleriffic({
            imageContainerSel:         '#500pxslideshow',
		        captionContainerSel:       '#500pxcaption',
		        controlsContainerSel:      '#500pxcontrols',
		        loadingContainerSel:       '#500pxloading',
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
		  	jQuery('div.500pxnavigation').css({'width' : '300px', 'float' : 'left'});
				jQuery('div.500pxcontent').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				jQuery('#500pxthumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected',
				});
    });
});
