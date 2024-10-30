'use strict';



function cbfc_box_size(ref, classname) {
	var element_width = ref.width();

	ref.removeClass(classname);

	if (element_width >= 480) {
		ref.removeClass(classname);
	}
	else if (element_width < 480) {
		ref.addClass(classname);

	}
}

function cbfc_run($){

	//light countdown
	$('.cbfc-light-countdown').each( function(index, element) {
		var $element = $( element );

		cbfc_box_size($element, 'cbfc-light-countdown-480');
		$( window).on('resize', function () {
			cbfc_box_size($element, 'cbfc-light-countdown-480');
		});

		var cbfcDate = $element.data('date').split('/'),
			cbfcHour = $element.data('hour'),
			cbfcMinute = $element.data('min');

		$element.countDown({
			targetDate: {
				'day':      cbfcDate[1],
				'month':    cbfcDate[0],
				'year':     cbfcDate[2],
				'hour':     cbfcHour,
				'min':      cbfcMinute,
				'sec':      0
			},
			omitWeeks: true
		});
	} );
	//end light countdown


	//kk countdown
	$('.cbfc-kkcountdown').each( function(index, element) {
		var $element = $( element );

		$element.kkcountdown({
			dayText		: ' ' + cbfc_strings.kkc_day + ' ',
			daysText 	: ' ' + cbfc_strings.kkc_days + ' ',
			hoursText	: ' ' + cbfc_strings.kkc_hr + ' ',
			minutesText	: ' ' + cbfc_strings.kkc_min + ' ',
			secondsText	: ' ' + cbfc_strings.kkc_sec,
			displayZeroDays : true,
			rusNumbers  :   false
		});
	} );
	//end kk countdown


	//circular countdown
	$('.cbfc-circular-countdown').each( function(index, element) {

		var $element = $( element );

		cbfc_box_size($element, 'cbfc-circular-countdown-480');

		var cbfcDate = $element.data('date').split('/'),
			cbfcHour = $element.data('hour'),
			cbfcMinute = $element.data('min'),
			cbfcSecBorderClr = $element.data('sec-border-clr'),
			cbfcMinBorderClr = $element.data('min-border-clr'),
			cbfcHourBorderClr = $element.data('hour-border-clr'),
			cbfcDaysBorderClr = $element.data('days-border-clr'),
			cbfcBorderw = parseInt($element.data('borderw'));


		// Place your public-facing JavaScript here
		$element.final_countdown({
			start: Date.now()/1000,
			end: new Date(cbfcDate[2], cbfcDate[0]-1, cbfcDate[1], cbfcHour, cbfcMinute, 0).getTime()/1000,
			now: Date.now()/1000,
			selectors: {
				value_seconds: '.cbfc-circular-clock-seconds .cbfc-circular-val',
				canvas_seconds: 'cbfc-circular-canvas-seconds' + ( index + 1 ),
				value_minutes: '.cbfc-circular-clock-minutes .cbfc-circular-val',
				canvas_minutes: 'cbfc-circular-canvas-minutes' + ( index + 1 ),
				value_hours: '.cbfc-circular-clock-hours .cbfc-circular-val',
				canvas_hours: 'cbfc-circular-canvas-hours' + ( index + 1 ),
				value_days: '.cbfc-circular-clock-days .cbfc-circular-val',
				canvas_days: 'cbfc-circular-canvas-days' + ( index + 1 )
			},
			seconds: {
				borderColor: cbfcSecBorderClr,
				borderWidth: cbfcBorderw
			},
			minutes: {
				borderColor: cbfcMinBorderClr,
				borderWidth: cbfcBorderw
			},
			hours: {
				borderColor: cbfcHourBorderClr,
				borderWidth: cbfcBorderw
			},
			days: {
				borderColor: cbfcDaysBorderClr,
				borderWidth: cbfcBorderw
			}
		});
	} );
	//end circular countdown
}


(function( $ ) {
	//'use strict';

	$(document.body).ready(function () {
		cbfc_run($);
	});

	//for elementor widget render
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/cbfc_elemwidget.default', function($scope, $){
			cbfc_run($);
		});
	});//end for elementor widget render

})( jQuery );