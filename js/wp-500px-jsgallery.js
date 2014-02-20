jQuery(document).ready(function(){

    wp5jsgal_rss500px('micz', function(feed){ 
        var contentimg = $(unescape($(this).find('content').text())).find("img").attr("src");
        // var title = $(this).find("title").text();
        // var link = $(this).find("link").text();
        // var imgSrc = $(this).find('description a img').attr("src");
        // var pubDate = $(this).find("pubDate").text();
        // var description = $(this).find("h2").text();
    
        var entries = feed.entries, feedList = '';
        for (var i = 0; i < entries.length; i++) {
            
            //feedList +='<li><a href="' +entries[i].link+ '">' + entries[i].title + '</a><img src="'+entries[i].contentimg+'" width="275" alt="'+entries[i].title+'"/><span>' +entries[i].contentSnippet+ '</span><div>' +entries[i].content+ '</div></li>';
            feedList +=wp5jsgal_getImage(entries[i]);
        }
        //jQuery('.feed > ul').append(feedList);
        jQuery('div#thumbs > ul').append(feedList);
    });

});
