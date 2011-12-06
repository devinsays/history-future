/*
 * smartresize: debounced resize event for jQuery
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery.smartresize.js
 *
 * Copyright 2011 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work? 
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
 
(function($) {

var event = $.event,
	resizeTimeout;

event.special[ "smartresize" ] = {
	setup: function() {
		$( this ).bind( "resize", event.special.smartresize.handler );
	},
	teardown: function() {
		$( this ).unbind( "resize", event.special.smartresize.handler );
	},
	handler: function( event, execAsap ) {
		// Save the context
		var context = this,
			args = arguments;

		// set correct event type
        event.type = "smartresize";

		if(resizeTimeout)
			clearTimeout(resizeTimeout);
		resizeTimeout = setTimeout(function() {
			jQuery.event.handle.apply( context, args );
		}, execAsap === "execAsap"? 0 : 100);
	}
}

$.fn.smartresize = function( fn ) {
	return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
};

})(jQuery);

/* ----------------------------------
jQuery Byron Timelinr

Original jQuery Timelinr by:
http://www.csslab.cl/2011/08/18/jquery-timelinr/
---------------------------------- */

jQuery.fn.timelinr = function(options){
	// Default plugin settings
	settings = jQuery.extend({
		containerDiv: 				'#timeline',		// value: any HTML tag or #id, default to #timeline
		datesDiv: 					'#dates',			// value: any HTML tag or #id, default to #dates
		issuesDiv: 					'#issues',			// value: any HTML tag or #id, default to #issues
		issuesSelectedClass: 		'selected',			// value: any class, default to selected
		issuesSpeed: 				3000,				// value: integer between 100 and 1000 (recommended), default to 200 (fast)
		issuesTransparency: 		0.2,				// value: integer between 0 and 1 (recommended), default to 0.2
		issuesTransparencySpeed: 	500,				// value: integer between 100 and 1000 (recommended), default to 500 (normal)
		prevButton: 				'#prev',			// value: any HTML tag or #id, default to #prev
		nextButton: 				'#next',			// value: any HTML tag or #id, default to #next
		arrowKeys: 					'true'				// value: true | false, default to false
	}, options);

	jQuery(function($){
		// Setting variables
		var amountIssues = $(settings.issuesDiv+' li').length;
		var widthContainer = $(settings.containerDiv).width();
		var widthIssues = 0;
		var widthIssue = 0;
		var pathname = window.location.pathname;
		var currentIndex = false;
		var offset = [];
		if ( pathname != window.location.host ) {
			$('#issues li a').each(function() {
    			if ($(this).attr('href')  === window.location.href ) {
      				currentIndex = $(this).closest('li').index();
      			}
    		});
		}
		if ( !(currentIndex) ) {
			currentIndex = $('#issues li').index($('#yearNow'));
		}

		$(settings.nextButton).bind('click', function(event){
			event.preventDefault();
			if ( currentIndex < ( amountIssues -1 ) ) {
				currentIndex = currentIndex+1;
				$(settings.issuesDiv+' li').eq(currentIndex).find('a').click();
			}
		});

		$(settings.prevButton).click(function(event){
			event.preventDefault();
			if ( currentIndex > 0 ) {
				currentIndex = currentIndex-1;
				$(settings.issuesDiv+' li').eq(currentIndex).find('a').click();
			}
		});
		
		$(settings.issuesDiv + ' li a').click(function(event){
			// event.preventDefault();
			currentIndex = $(settings.issuesDiv + ' li a').index(this);
			animateTimeline();
			if ( $(window).scrollTop() < 80 ) {
				$.scrollTo("#timeline", 400);
			}
			
		});
		
		// Keyboard navigation
		if(settings.arrowKeys=='true') {
			$(document).keydown(function(event){
				if (event.keyCode == 39) { 
			       $(settings.nextButton).click();
			    }
				if (event.keyCode == 37) { 
			       $(settings.prevButton).click();
			    }
			});
		}
		
		function animateTimeline(e) {
			widthContainer = $(settings.containerDiv).width();
			widthIssue = $(settings.issuesDiv+' li').eq(currentIndex).outerWidth();
			var issuesMargin = (-(offset[currentIndex]) + (widthContainer - widthIssue)/2 );
			$(settings.issuesDiv).animate({'marginLeft': issuesMargin},{queue:false, duration:settings.issuesSpeed});
			$(settings.issuesDiv+' li').removeClass(settings.issuesSelectedClass).eq(currentIndex).addClass(settings.issuesSelectedClass);
			var sliderval = ((-issuesMargin + (widthContainer/2)) / (widthIssues/100));
			$( "#slider-ui" ).slider({'value':sliderval, animate:true});
		}
		
		function timelinr_alignment() {
			widthContainer = $(settings.containerDiv).width();
			var issuesMargin = (-(offset[currentIndex]) + (widthContainer - widthIssue)/2 );
			$(settings.issuesDiv).animate({'marginLeft': issuesMargin },{queue:false, duration:settings.issuesSpeed});
			widthDates = $(settings.datesDiv).width();
			$(settings.datesDiv).animate({'marginLeft': ((widthContainer - widthDates)/2)},{queue:false, duration:settings.datesSpeed});
			var sliderval = ((-issuesMargin + (widthContainer/2)) / (widthIssues/100));
			$( "#slider-ui" ).slider({'value':sliderval, animate:true});
		}
	
	    $(window).smartresize(function() {
	        timelinr_alignment();
	    });
	    
	    // Set the width for the parent li of each item in the timeline
	    $(settings.issuesDiv + ' li').each(function() {
	    	if ( $(this).attr('id') != 'yearNow' ) {
				var width = $(this).find('img').outerWidth();
				$(this).width(width);
			}
			else {
				width = 253 + 40;
				$(this).width(width);
			}
			// Image + border + li padding
			widthIssues += width + 100; 
    	});
    	
    	// Set the width of #issues to fit all the items
    	$(settings.issuesDiv).width(widthIssues);
    	
    	// Put the left offset for each item into an array
    	var i = 0;
    	$(settings.issuesDiv + ' li').each(function() {
			offset[i] = $(this).position().left;
			i++;
    	});
		
		// Set inital positions on load
		$("#slider-ui").slider({ animate: true });
		animateTimeline();
		timelinr_alignment();
		
		$( "#slider-ui" ).bind( "slide", function(event, ui) {
			var marginval = -( ( widthIssues/100 * ui.value) - (widthContainer/2) );
			$(settings.issuesDiv).animate({'marginLeft': marginval},{queue:false, duration:settings.issuesSpeed});
		});
		
	});

};