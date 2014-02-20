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
        });
    });

});
