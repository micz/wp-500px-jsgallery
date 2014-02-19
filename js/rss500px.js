function(user,callback) {
  jQuery.ajax({
      url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=10&callback=?&q=' + encodeURIComponent('http://500px.com/'+user+'/rss.json'),
      dataType: 'json',
      success: function(data) {
          callback(data.responseData.feed);
      }
  });
}


/*
$(document).ready(function(){

    (function(url, callback) {
        jQuery.ajax({
            url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=10&callback=?&q=' + encodeURIComponent(url),
            dataType: 'json',
            success: function(data) {
                callback(data.responseData.feed);
            }
        });
    })('http://500px.com/boons/rss.json', function(feed){ 
        var contentimg = $(unescape($(this).find('content').text())).find("img").attr("src");
        // var title = $(this).find("title").text();
        // var link = $(this).find("link").text();
        // var imgSrc = $(this).find('description a img').attr("src");
        // var pubDate = $(this).find("pubDate").text();
        // var description = $(this).find("h2").text();
    
        var entries = feed.entries, feedList = '';
        for (var i = 0; i < entries.length; i++) {
            
            feedList +='<li><a href="' +entries[i].link+ '">' + entries[i].title + '</a><img src="'+entries[i].contentimg+'" width="275" alt="'+entries[i].title+'"/><span>' +entries[i].contentSnippet+ '</span><div>' +entries[i].content+ '</div></li>';
        }
        jQuery('.feed > ul').append(feedList);
    });

});*/
