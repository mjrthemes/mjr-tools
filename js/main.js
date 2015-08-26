jQuery(document).ready(function($) {

	"use strict";

	// Generate social images widget if exists
	$('.social_images_widget_content').each( function() {
		var user = $(this).data('user');
		var limit = $(this).data('limit');
		var network = $(this).data('network');

		$(this).mjr_social_images_widget({ user: user, limit: limit, social_network: network });
		$('img', this).each(function() {
			var src = $(this).attr('src');
			alert(src);
			$(this).parent().css('background-image', 'url(' + src + ')');
		});
	});
	
	// Generate twitter widget if exists
	$('.twitter-widget').each( function() {

		var title = $(this).data('twittertitle');
		var number = $(this).data('twitternumber');
		var widget_name = $(this).data('widgettitle');
		var instance = $(this);

		if(!localStorage['mjr-twitter-cache-date'] || !localStorage[title + '.' + number]) {
			// No cache
			get_tweets(title, number, instance, widget_name);

		} else {
			// Check cache
			var user_date = new Date();
			var twitter_cache_date = new Date(Date.parse(localStorage['mjr-twitter-cache-date']));
			var diff = Math.floor((user_date - twitter_cache_date) / 1000);

			if (diff <= 2400) {
				// Cache OK
				$(instance).html(localStorage[title + '.' + number]);
			} else {
				// Cache old
				get_tweets(title, number, instance, widget_name);
			}
		}
	}); // end twitter

	// For twitter widget
	function parseTwitterDate(tdate) {
		var system_date = new Date(Date.parse(tdate));
		var user_date = new Date();
		var diff = Math.floor((user_date - system_date) / 1000);
		if (diff <= 10) {return "a few seconds ago";}
		if (diff < 40) {return "" + diff + " Seconds ago";}
		if (diff < 60) {return "Less than a minute ago";}
		if (diff <= 90) {return "Minute ago";}
		if (diff <= 3540) {return "" + Math.round(diff / 60) + " Minutes ago";}
		if (diff <= 5400) {return "About an hour ago";}
		if (diff <= 86400) {return "" + Math.round(diff / 3600) + " Hours ago";}
		if (diff <= 129600) {return "One day ago";}
		if (diff < 604800) {return "" + Math.round(diff / 86400) + " Days ago";}
		if (diff <= 777600) {return "One week ago";}
		if(diff <= 2678400) {return "One month ago"}
		if(diff > 2678400) {return "More than a month ago"}
		return "";
	}

	// For twitter widget
	function urlToLink(text) {
		var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		return text.replace(exp,"<a href='$1'>$1</a>"); 
	}

	// Twitter widget function
	function get_tweets(title, number, instance, widget_name) {
		$.getJSON(mjr_theme_directory + '/mjr-twitter-proxy.php?url='+encodeURIComponent('statuses/user_timeline/user_timeline.json?screen_name=' + title + '&count=' + number + ''), function(data) {
			var twitter_data = '<h2><a href="http://twitter.com/' + title + '">' + widget_name + '</a></h2><ul>';
			for (var i=0;i<data.length;i++) {
				twitter_data += '<li><p>' + urlToLink(data[i].text) + '</p><em>' + parseTwitterDate(data[i].created_at) + '</em></li>';
			}
			twitter_data +=  '</ul>';
			var user_date = new Date();
			localStorage['mjr-twitter-cache-date'] = user_date;
			$(instance).append(twitter_data);
			localStorage[title + '.' + number] = twitter_data;
		});
	}
});

/* social images widget */
(function(e) {
	e.fn.extend({
		mjr_social_images_widget: function(t) {
			function r(t, n) {
				var r = t.feed;
				if (!r) {
					return false
				}
				var i = "";
				i += "<ul>";
				for (var s = 0; s < r.entries.length; s++) {
					var o = r.entries[s];
					var u = o.content;
					i += "<li>" + u + "</li>"
				}
				i += "</ul>";
				e(n).html(i);
				e(n).find("li").each(function() {
					pin_img_src = e(this).find("img").attr("src");
					pin_url = "http://www.pinterest.com" + e(this).find("a").attr("href");
					pin_desc = e(this).find("p:nth-child(2)").html();
					pin_desc = pin_desc.replace("'", "`");
					e(this).empty();
				  e(this).append("<a target='_blank' href='" + pin_url + "' title='" + pin_desc + "' style='background-image: url(" + pin_img_src + ");'></a>");
					var t = e(this).find("img").width();
					var n = e(this).find("img").height();
					if (t < n) {
						e(this).find("img").addClass("portrait")
					} else {
						e(this).find("img").addClass("landscape")
					}
				})
			}
			var n = {
				user: "kaverzniy",
				limit: 9,
				social_network: "pinterest"
			};
			var t = e.extend(n, t);
			return this.each(function() {
				var n = t;
				var i = e(this);
				if (n.social_network == "dribbble") {
					i.append("<ul></ul>");
					e.getJSON("http://dribbble.com/" + n.user + "/shots.json?callback=?", function(t) {
						e.each(t.shots, function(t, r) {
							if (t < n.limit) {
								var s = r.title;
								s = s.replace("'", "`");
								var u = e("<a/>").attr({
									href: r.url,
									target: "_blank",
									style: "background-image: url(" + r.image_teaser_url + ");",
									title: s
								});
								var a = e(u);
								var f = e("<li/>").append(a);
								e("ul", i).append(f)
							}
						});
						e("li img", i).each(function() {
							var t = e(this).width();
							var n = e(this).height();
							if (t < n) {
								e(this).addClass("portrait")
							} else {
								e(this).addClass("landscape")
							}
						});
					})
				}
				if (n.social_network == "pinterest") {
					var s = "http://pinterest.com/" + n.user + "/feed.rss";
					var o = "http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&callback=?&q=" + encodeURIComponent(s);
					o += "&num=" + n.limit;
					o += "&output=json_xml";
					e.getJSON(o, function(e) {
						if (e.responseStatus == 200) {
							r(e.responseData, i)
						} else {
							alert("User not found!")
						}
					})
				}
				if (n.social_network == "flickr") {
					i.append("<ul></ul>");
					e.getJSON("https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&username=" + n.user + "&format=json&api_key=f5b9ebc795592ed7dc3a1b673db827c4&jsoncallback=?", function(t) {
						var r = t.user.nsid;
						e.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.search&user_id=" + r + "&format=json&api_key=f5b9ebc795592ed7dc3a1b673db827c4&per_page=" + n.limit + "&page=1&extras=url_sq&jsoncallback=?", function(t) {
							e.each(t.photos.photo, function(t, n) {
								var r = n.owner;
								var s = n.title;
								var o = n.url_sq;
								var u = n.id;
								var a = "http://www.flickr.com/photos/" + r + "/" + u;
								var l = e("<a/>").attr({
									href: a,
									target: "_blank",
									style: "background-image: url(" + o + ");",
									title: s
								});
								var c = e(l);
								var h = e("<li/>").append(c);
								e("ul", i).append(h)
							});
						})
					})
				}
				if (n.social_network == "instagram") {
					i.append("<ul></ul>");
					var u = "1765484717.99d847a.76f2359cce30400d8685e8b4d79075fa";
					s = "https://api.instagram.com/v1/users/search?q=" + n.user + "&access_token=" + u + "&count=10&callback=?";
					e.getJSON(s, function(t) {
						e.each(t.data, function(t, r) {
							var o = r.username;
							if (o == n.user) {
								var a = r.id;
								if (a != "") {
									s = "https://api.instagram.com/v1/users/" + a + "/media/recent/?access_token=" + u + "&count=" + n.limit + "&callback=?";
									e.getJSON(s, function(t) {
										e.each(t.data, function(t, n) {
											var r = n.images.thumbnail.url;
											var s = n.link;
											var o = "";
											if (n.caption != null) {
												o = n.caption.text
											}
											var a = e("<a/>").attr({
												href: s,
												target: "_blank",
												style: "background-image: url(" + r + ");",
												title: o
											});
											var f = e(a);
											var l = e("<li/>").append(f);
											e("ul", i).append(l)
										});
									})
								}
							}
						})
					})
				}
			})
		}
	})
})(jQuery);