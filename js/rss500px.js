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
  //return wp5jsgal_langs.image_link_desc+' <a href="'+img.link+'">'+img.link+'</a>';
  return '[<a href="'+img.link+'">'+wp5jsgal_langs.image_link_desc+'</a>]';
}

function wp5jsgal_getImage(img){
  var image_url=wp5jsgal_extractImageURL(img.content);
  var thumb_url=wp5jsgal_getThumbURL(image_url);
  var image_caption=wp5jsgal_getImageCaption(img);
  return  '<li><a class="thumb" href="'+image_url+'" title="' + img.title + '"><img src="'+thumb_url+'" alt="' + img.title + '"/></a><div class="caption"><span class="wp500pxisg_img_title">' + img.title + '</span><span class="wp500pxisg_img_caption">'+image_caption+'</span></div></li>';
}

