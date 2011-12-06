jQuery(document).ready(function($) {
	
	// Establish Variables
	var
		History = window.History, // Note: We are using a capital H instead of a lower h
		State = History.getState(),
		$log = $('#log');
					
	$('a[rel=ajax]').live('click', function(e) {
		e.preventDefault();
		var path = $(this).attr('href');
		var title = $(this).attr('title');
		History.pushState('ajax',title,path);
	});
	
	// Bind to State Change
	History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
		State = History.getState(); // Note: We are using History.getState() instead of event.state
		// History.log('statechange:', State.data, State.title, State.url);
		// console.log(History.Adapter.extractEventData);
		// console.log(event);
		var selected = $('#issues').find('a[href="' + State.url + '"]');
		if ( ! ( selected.parent('li').hasClass('selected') ) ) {
			$("#primary").prepend('<div id="ajax-loader">Loading...</div>');
			$("#ajax-loader").fadeIn();
			$('#content .year-meta').fadeOut();
			$("#primary").load(State.url + ' #primary', function(){
				// Twitter
				$("#tweet .twitter-share-button").attr('data-url', State.url);
				twttr.widgets.load();
				// Facebook
				FB.XFBML.parse();
				// Google +1
				$("#plusone .g-plus").attr('href', State.url);
				gapi.plusone.go("#primary");
			});
		}
	});
	
	$(window).bind("popstate", function() {
		var selected = $('#issues').find('a[href="' + State.url + '"]');
		if ( ! ( selected.parent('li').hasClass('selected') ) ) {
			selected.trigger('click');
		}
	});
	
	jQuery(document).ready(function() {
		jQuery().timelinr({ issuesSpeed: 500 })
	});
	
});

// Homebrewed lazy load
jQuery(window).load(function() {

	// Lazy load images
	jQuery('#issues img').each( function(index) {
		if (jQuery(this).attr("data-src")) {
			jQuery(this).hide().attr("src",jQuery(this).attr("data-src")).fadeIn();
		}
	});
	
	// Post load social scripts
	jQuery.getScript("http://apis.google.com/js/plusone.js");
	jQuery.getScript("http://platform.twitter.com/widgets.js");
});