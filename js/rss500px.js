function wp5jsgal_rss500px(user,callback){
  jQuery.ajax({
      url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=10&callback=?&q=' + encodeURIComponent('http://500px.com/'+user+'/rss.json'),
      dataType: 'json',
      success: function(data) {
          callback(data.responseData.feed);
      }
  });
}

function wp5jsgal_getImage(img){
  img.contentimg='http://en.gravatar.com/avatar/6072f5dbcf8438bf469e4270a22723ca';
  return  '<li><a class="thumb" name="optionalCustomIdentifier" href="'+img.contentimg+'" title="' + img.title + '"><img src="'+img.contentimg+'" alt="' + img.title + '" /></a><div class="caption">' +img.contentSnippet+ '</div></li>';
}
