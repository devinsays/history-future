jQuery(document).ready(function($) {
	
	var now = new Date();
	var year = now.getFullYear() - 2011; //adjust variable to start at zero
	var month = now.getMonth();
	var date = now.getDate() - 1; //adjust variable to start at zero
	var day = now.getDay();
	
	var yearOffset = "left " + (year * -24) + "px"; //the offset represents height of sprite element
	var monthOffset = "left " + (month * -36) + "px"; 
	var dateOffset = "left " + (date * -64) + "px";
	var dayOffset = "left " + (day * -36) + "px";

	$('#year').css('background-position', yearOffset);
	$('#month').css('background-position', monthOffset);
	$('#date').css('background-position', dateOffset);
	$('#day').css('background-position', dayOffset);
	
	if (now.getHours() > 12) {
		$('#ampm').css('background-position', 'left -36px');
	}
	
	setInterval( function() {
	
		// Seconds
		var sec = new Date().getSeconds();
		var secOffset = "-128px " + (sec * -64) + "px";
		$('#sec').css('background-position', secOffset).show();
		
		// Minutes
		var min = new Date().getMinutes();
		var minOffset = "left " + (min * -64) + "px";
		$('#min').css('background-position', minOffset).show();
	
		var nowadjust = new Date();
		
		if (nowadjust.getHours() <12) {
			var hour = nowadjust.getHours();
		}else{
			var hour = nowadjust.getHours() - 12;
		}
		
		var hourOffset = (hour * -320);
		var minAdjust = nowadjust.getMinutes();
		
		if (minAdjust < 12) {
			var hourPosition = "-64px " + (hourOffset - 64) + "px";
		}else if (minAdjust < 24) {
			var hourPosition = "-64px " + (hourOffset - 128) + "px";
		}else if (minAdjust < 36) {
			var hourPosition = "-64px " + (hourOffset - 192) + "px";
		}else if (minAdjust < 48) {
			var hourPosition = "-64px " + (hourOffset - 256) + "px";
		}else if (minAdjust < 24) {
			var hourPosition = "-64px " + (hourOffset - 320) + "px";
		}
		
		$('#hour').css('background-position', hourPosition).show();
		
	}, 1000 );
	
});