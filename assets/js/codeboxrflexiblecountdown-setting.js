(function( $ ) {
	'use strict';

	$(document.body).ready(function () {
        $('.wp-color-picker-field').wpColorPicker();

        $('.selecttwo-select').select2({
            placeholder: codeboxrflexiblecountdown_setting.please_select,
            allowClear: false
        });

        $('.datepicker').datepicker({ dateFormat: 'mm/dd/yy' });

		// Switches option sections
		var activetab = '';
		if (typeof (localStorage) !== 'undefined') {
			activetab = localStorage.getItem('codeboxrflexiblecountdown');
		}

		//if url has section id as hash then set it as active or override the current local storage value
		if (window.location.hash) {
			if ($(window.location.hash).hasClass('cbfc_setting_group')) {
				activetab = window.location.hash;
				if (typeof (localStorage) !== 'undefined') {
					localStorage.setItem('codeboxrflexiblecountdown', activetab);
				}
			}
		}


		if (activetab !== '' && $(activetab).length && $(activetab).hasClass('cbfc_setting_group')) {
			$('.cbfc_setting_group').hide();
			$(activetab).fadeIn();
		}


		if (activetab !== '' && $(activetab + '-tab').length) {
			$('.nav-tab-wrapper a.nav-tab').removeClass('nav-tab-active');
			$(activetab + '-tab').addClass('nav-tab-active');
		}

		$('.nav-tab-wrapper a').on('click', function(e) {
			e.preventDefault();

			var $this = $(this);

			$('.nav-tab-wrapper a.nav-tab').removeClass('nav-tab-active');
			$this.addClass('nav-tab-active').blur();

			var clicked_group = $(this).attr('href');

			if (typeof(localStorage) !== 'undefined') {
				localStorage.setItem('codeboxrflexiblecountdown', $(this).attr('href'));
			}
			$('.cbfc_setting_group').hide();
			$(clicked_group).fadeIn();

			cbfc_run($);
		});

		$('.wpsa-browse').on('click', function(event) {
			event.preventDefault();

			var self = $(this);

			// Create the media frame.
			var file_frame = wp.media.frames.file_frame = wp.media({
				title: codeboxrflexiblecountdown_setting.upload_title,
				button: {
					text: codeboxrflexiblecountdown_setting.please_select
				},
				multiple: false
			});

			file_frame.on('select', function() {
				var attachment = file_frame.state().get('selection').first().toJSON();

				self.prev('.wpsa-url').val(attachment.url);
			});

			// Finally, open the modal
			file_frame.open();
		}); //end file chooser

		//make the subheading single row
		$('.setting_subheading').each(function (index, element) {
			var $element = $(element);
			var $element_parent = $element.parent('td');
			$element_parent.attr('colspan', 2);
			$element_parent.prev('th').remove();
		});

		//make the subheading single row
		$('.setting_heading').each(function (index, element) {
			var $element = $(element);
			var $element_parent = $element.parent('td');
			$element_parent.attr('colspan', 2);
			$element_parent.prev('th').remove();
		});

		$('.cbfc_setting_group').each(function (index, element) {
			var $element = $(element);
			var $form_table = $element.find('.form-table');
			$form_table.prev('h2').remove();
		});

        //var adjustment_photo;
        $('.cbfc_setting_group').sortable({
            vertical         : true,
            handle           : '.multicheck_field_handle',
            containerSelector: '.multicheck_fields',
            itemSelector     : '.multicheck_field',
            //placeholder      : '<p class="multicheck_field_placeholder"/>',
            placeholder      : 'multicheck_field_placeholder',
        });

        $('.cbfc_setting_group').on('click', '.checkbox', function() {
            var mainParent = $(this).closest('.checkbox-toggle-btn');
            if($(mainParent).find('input.checkbox').is(':checked')) {
                $(mainParent).addClass('active');
            } else {
                $(mainParent).removeClass('active');
            }
        });


        $('#cbfc_info_trig').on('click', function (e) {
            e.preventDefault();

            $('#cbfc_resetinfo').toggle();
        });

        $('#cbfc_tools').on('click', '.cbfc_jump', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $target = $this.data('target');

            var $scroll_to = $('#'+$target).offset().top - $('#'+$target).height()-30;
            $('html, body').animate({
                scrollTop: $scroll_to
            }, 1000);

        });


		/*$('.codeboxrflexiblecountdown_demo_copy').on("click", function (e) {
			var text = $(this).text();
			var $this = $(this);
			var $input = $('<input class="codeboxrflexiblecountdown_demo_copy" type="hidden">');
			$input.prop('value', text);
			$input.insertAfter($(this));
			$input.focus();
			$input.select();
			$input.hide();
			//$this.hide();

			try {
				document.execCommand("copy");
			} catch (err) {

			}

			$input.focusout(function(){
				//$this.show();
				$input.remove();
			});
		});*/

        /*Button Display*/
        /*var current_value_toggle = $(".cbxresume_sec_display").val();
        $("#display_toggle").minitoggle({
            on: 1 == current_value_toggle
        });
        if (1 == current_value_toggle) {
            $("#display_toggle .toggle-handle").attr('style', 'transform: translate3d(27px, 0px, 0px)');
        }

        $("#display_toggle").on("toggle", function (e) {
            if (e.isActive)
                $(".cbxresume_sec_display").val(1);
            else
                $(".cbxresume_sec_display").val(0);
        });
*/

        //copy shortcode
		$('.shortcode_demo_btn').on('click', function (event) {
			event.preventDefault();

			var $this = $(this);
			var $target = $this.data('target-cp');
			var $copy_area = $($target);

			$copy_area.focus();
			$copy_area.select();

			try {
				var successful = document.execCommand('copy');
				if(successful){
					$this.text(codeboxrflexiblecountdown_setting.copy_success);
					$this.addClass('copy_success');
				}
				else{
					$this.text(codeboxrflexiblecountdown_setting.copy_fail);
					$this.addClass('copy_fail');
				}
			} catch (err) {
				$this.text(codeboxrflexiblecountdown_setting.copy_fail);
				$this.addClass('copy_fail');
			}

		});//end copy shortcode

		//one click save setting for the current tab
		$('#save_settings').on('click', function (e) {
			e.preventDefault();

			var $current_tab = $('.nav-tab.nav-tab-active');
			var $tab_id      = $current_tab.data('tabid');
			$('#' + $tab_id).find('.submit_codeboxrflexiblecountdown').trigger('click');
		});


	});//end of dom ready

})( jQuery );
