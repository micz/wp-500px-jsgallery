function wp5jsgal_rss500px(user,callback){
  jQuery.ajax({
      url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=-1&callback=?&q=' + encodeURIComponent('http://500px.com/'+user+'/rss.json'),
      dataType: 'json',
      success: function(data) {
          callback(data.responseData.feed);
      }
  });
}

function wp5jsgal_extractImageURL(contentimg){
  var dummy_el = jQuery('<div></div>');
  dummy_el.html('<html><head><title>dummyhtml</title></head><body>'+contentimg+'</body>');
  return jQuery('img',dummy_el).attr('src'); 
}

function wp5jsgal_getThumbURL(image_url){
  return image_url.replace('4.jpg','2.jpg');
}

function wp5jsgal_getImageCaption(img){
  return wp5jsgal_langs.image_link_desc+' <a href="'+img.link+'">'+img.link+'</a>';
}

function wp5jsgal_getImage(img){
  var image_url=wp5jsgal_extractImageURL(img.content);
  var thumb_url=wp5jsgal_getThumbURL(image_url);
  var image_caption=wp5jsgal_getImageCaption(img);
  return  '<li><a class="thumb" href="'+image_url+'" title="' + img.title + '"><img src="'+thumb_url+'" alt="' + img.title + '"/></a><div class="caption">'+image_caption+'</div></li>';
}

