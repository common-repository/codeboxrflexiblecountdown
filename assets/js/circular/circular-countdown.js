/*!
 * jQuery Final Countdown
 *
 * @author Pragmatic Mates, http://pragmaticmates.com
 * @version 1.1.1
 * @license GPL 2
 * @link https://github.com/PragmaticMates/jquery-final-countdown
 */
function cbfc_final_countdown_box_size(ref, classname) {
	var element_width = ref.width();

	ref.removeClass(classname);

	if (element_width >= 480) {
		ref.removeClass(classname);
	}
	else if (element_width < 480) {
		ref.addClass(classname);

	}
}

(function ($) {
    var settings;
    var timer;

    var circleSeconds;
    var circleMinutes;
    var circleHours;
    var circleDays;

	var layerSeconds;
	var layerMinutes;
	var layerHours;
	var layerDays;

    var element;
    var callbackFunction;
    var interval;

    

    $.fn.final_countdown = function(options, callback) {

		element = $(this);

		// Element is not visibile
		if ( ! element.is(':visible') ) {
			return;
		}

        var defaults = $.extend({
			start: undefined,
			end: undefined,
			now: undefined,
            selectors: {
                value_seconds: '.clock-seconds .val',
                canvas_seconds: 'canvas_seconds',
                value_minutes: '.clock-minutes .val',
                canvas_minutes: 'canvas_minutes',
                value_hours: '.clock-hours .val',
                canvas_hours: 'canvas_hours',
                value_days: '.clock-days .val',
                canvas_days: 'canvas_days'
            },
            seconds: {
                borderColor: '#ff6386',
                borderWidth: '6'
            },
            minutes: {
                borderColor: '#00c1c1',
                borderWidth: '6'
            },
            hours: {
                borderColor: '#ffcf4a',
                borderWidth: '6'
            },
            days: {
                borderColor: '#00a3ee',
                borderWidth: '6'
            }
        }, options);

        this.settings = $.extend({}, defaults, options);


		if (this.settings.start === undefined) {
			this.settings.start = element.data('start');
		}

		if (this.settings.end === undefined) {
			this.settings.end = element.data('end');
		}

		if (this.settings.now === undefined) {
			this.settings.now = element.data('now');
		}

		if (element.data('border-color')) {
			this.settings.seconds.borderColor = this.settings.minutes.borderColor = this.settings.hours.borderColor = this.settings.days.borderColor = element.data('border-color');
		}

		if (this.settings.now < this.settings.start ) {
			this.settings.start = this.settings.now;
			this.settings.end = this.settings.now;
		}

		if (this.settings.now > this.settings.end) {
			this.settings.start = this.settings.now;
			this.settings.end = this.settings.now;
		}


		if (typeof callback === 'function') { // make sure the callback is a function
			this.callbackFunction = callback;
        }     

		dispatchTimer(this);
		prepareCounters(this);
		startCounters(this);
		responsive(this);
    };

    function responsive(ref) {

    	$(window).on('load', function () {
			updateCircles(ref);
		});

        $(window).on('redraw', function() { 
            //var switched = false;
            updateCircles(ref);
        });

        $(window).on('resize', updateCircles(ref));
    }

    function updateCircles(ref) {

        ref.layerSeconds.draw();
        ref.layerMinutes.draw();
        ref.layerHours.draw();
        ref.layerDays.draw();
    }

    function convertToDeg(degree) {
        return (Math.PI/180)*degree - (Math.PI/180)*90
    }

    function dispatchTimer(ref) {
        ref.timer = {
            total: Math.floor((ref.settings.end - ref.settings.start) / 86400),
            days: Math.floor((ref.settings.end - ref.settings.now ) / 86400),
            hours: 24 - Math.floor(((ref.settings.end - ref.settings.now) % 86400) / 3600),
            minutes: 60 - Math.floor((((ref.settings.end - ref.settings.now) % 86400) % 3600) / 60),
            seconds: 60 - Math.floor((((ref.settings.end - ref.settings.now) % 86400) % 3600) % 60 )
        };
    }

    function prepareCounters(ref) {
        var seconds_width = $('#' + ref.settings.selectors.canvas_seconds).width();
        var secondsStage = new Kinetic.Stage({
            container: ref.settings.selectors.canvas_seconds,
            width: seconds_width,
            height: seconds_width,
        });        

        circleSeconds = new Kinetic.Shape({
            drawFunc: function(context) {
            	var seconds_width = $('#' + ref.settings.selectors.canvas_seconds).width();
                var radius = Math.abs(seconds_width / 2 - ref.settings.seconds.borderWidth / 2);
                var x = seconds_width / 2;
                var y = seconds_width / 2;     

                context.beginPath();
                context.arc(x, y, radius, convertToDeg(0), convertToDeg(ref.timer.seconds * 6));                                
                context.fillStrokeShape(this);

                //$(ref.settings.selectors.value_seconds).html(60 - ref.timer.seconds);
                ref.find(ref.settings.selectors.value_seconds).html(60 - ref.timer.seconds);
            },
            stroke: ref.settings.seconds.borderColor,
            strokeWidth: ref.settings.seconds.borderWidth            
        });

        ref.layerSeconds = new Kinetic.Layer();
        ref.layerSeconds.add(circleSeconds);
        secondsStage.add(ref.layerSeconds);

        // Minutes
        var minutes_width = $('#' + ref.settings.selectors.canvas_minutes).width();        
        var minutesStage = new Kinetic.Stage({
            container: ref.settings.selectors.canvas_minutes,
            width: minutes_width,
            height: minutes_width
        });

        circleMinutes = new Kinetic.Shape({
            drawFunc: function(context) {     
            	var minutes_width = $('#' + ref.settings.selectors.canvas_minutes).width();        
                var radius = Math.abs(minutes_width / 2 - ref.settings.minutes.borderWidth / 2);
                var x = minutes_width / 2;
                var y = minutes_width / 2;

                context.beginPath();
                context.arc(x, y, radius, convertToDeg(0), convertToDeg(ref.timer.minutes * 6));
                context.fillStrokeShape(this);

                //$(ref.settings.selectors.value_minutes).html(60 - ref.timer.minutes);
                ref.find(ref.settings.selectors.value_minutes).html(60 - ref.timer.minutes);

            },
            stroke: ref.settings.minutes.borderColor,
            strokeWidth: ref.settings.minutes.borderWidth
        });

        ref.layerMinutes = new Kinetic.Layer();
        ref.layerMinutes.add(circleMinutes);
        minutesStage.add(ref.layerMinutes);

        // Hours
        var hours_width = $('#' + ref.settings.selectors.canvas_hours).width();
        var hoursStage = new Kinetic.Stage({
            container: ref.settings.selectors.canvas_hours,
            width: hours_width,
            height: hours_width
        });

        circleHours = new Kinetic.Shape({
            drawFunc: function(context) {
            	var hours_width = $('#' + ref.settings.selectors.canvas_hours).width();
                var radius = Math.abs(hours_width / 2 - ref.settings.hours.borderWidth/2);
                var x = hours_width / 2;
                var y = hours_width / 2;

                context.beginPath();                
                context.arc(x, y, radius, convertToDeg(0), convertToDeg(ref.timer.hours * 360 / 24));
                context.fillStrokeShape(this);

                //$(ref.settings.selectors.value_hours).html(24 - ref.timer.hours);
                ref.find(ref.settings.selectors.value_hours).html(24 - ref.timer.hours);

            },
            stroke: ref.settings.hours.borderColor,
            strokeWidth: ref.settings.hours.borderWidth
        });

        ref.layerHours = new Kinetic.Layer();
        ref.layerHours.add(circleHours);
        hoursStage.add(ref.layerHours);

        // Days
        var days_width = $('#' + ref.settings.selectors.canvas_days).width();
        var daysStage = new Kinetic.Stage({
            container: ref.settings.selectors.canvas_days,
            width: days_width,
            height: days_width
        });

        circleDays = new Kinetic.Shape({
            drawFunc: function(context) {                
            	var days_width = $('#' + ref.settings.selectors.canvas_days).width();
                var radius = Math.abs(days_width/2 - ref.settings.days.borderWidth/2);
                var x = days_width / 2;
                var y = days_width / 2;                
                

                context.beginPath();
                
                if (ref.timer.total === 0) {
                    context.arc(x, y, radius, convertToDeg(0), convertToDeg(360));
                } else {
                    context.arc(x, y, radius, convertToDeg(0), convertToDeg((360 / ref.timer.total) * (ref.timer.total - ref.timer.days)));
                }
                context.fillStrokeShape(this);
                ref.find(ref.settings.selectors.value_days).html(ref.timer.days);

            },
            stroke: ref.settings.days.borderColor,
            strokeWidth: ref.settings.days.borderWidth
        });

        ref.layerDays = new Kinetic.Layer();
        ref.layerDays.add(circleDays);
        daysStage.add(ref.layerDays);
    }

    function startCounters(ref) {
		cbfc_final_countdown_box_size(ref, 'cbfc-circular-countdown-container-480');
		if ( ref.interval != null ) {
			clearInterval(ref.interval);
		}

		ref.interval = setInterval( function() {
			$(window).on('resize', function (event) {
				cbfc_final_countdown_box_size(ref, 'cbfc-circular-countdown-container-480');
				updateCircles(ref);
			});

			if (ref.timer.seconds > 59 ) {
				if (60 - ref.timer.minutes === 0 && 24 - ref.timer.hours === 0 && ref.timer.days === 0) {
					clearInterval(ref.interval);
					if (ref.callbackFunction !== undefined) {
						ref.callbackFunction.call(this); // brings the scope to the callback
					}
					return;
				}

				ref.timer.seconds = 1;

				if (ref.timer.minutes > 59) {
					ref.timer.minutes = 1;
					ref.layerMinutes.draw();
					if (ref.timer.hours > 23) {
						ref.timer.hours = 1;
						if (ref.timer.days > 0) {
							ref.timer.days--;
							ref.layerDays.draw();
						}
					} else {
						ref.timer.hours++;
					}
					ref.layerHours.draw()
				} else {
					ref.timer.minutes++;
				}

				ref.layerMinutes.draw();
			} else {
				ref.timer.seconds++;
			}

			ref.layerSeconds.draw();
		}, 1000);

		/*
		 cbfc_final_countdown_box_size(ref, 'cbfc-circular-countdown-container-480');
        if ( ref.interval != null ) {
            clearInterval(ref.interval);
        }
        ref.interval = setInterval( function() {
            $( window ).resize(function() {
		 cbfc_final_countdown_box_size(ref, 'cbfc-circular-countdown-container-480');
            });

            if (ref.timer.seconds > 59 ) {
                if (60 - ref.timer.minutes === 0 && 24 - ref.timer.hours === 0 && ref.timer.days === 0) {
                    clearInterval(ref.interval);
                    callbackFunction.call(this); // brings the scope to the callback
                    return;
                }

                ref.timer.seconds = 1;

                if (ref.timer.minutes > 59) {
                    ref.timer.minutes = 1;
                    ref.reflayerMinutes.draw();
                    if (ref.timer.hours > 23) {
                        ref.timer.hours = 1;
                        if (ref.timer.days > 0) {
                            ref.timer.days--;
                            ref.layerDays.draw();
                        }
                    } else {                        
                        ref.timer.hours++;
                    }
                    ref.layerHours.draw()
                } else {
                    ref.timer.minutes++;
                }

                ref.layerMinutes.draw();
                //prepareCounters(ref)
            } else {            
                ref.timer.seconds++;
            }

            ref.layerSeconds.draw();
            prepareCounters(ref)
        }, 1000);
        */
    }

})(jQuery);