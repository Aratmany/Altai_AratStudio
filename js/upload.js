jQuery(document).ready(function($){
	"use strict";
	var temp_upload;
	var temp_selector;

	function temp_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		temp_selector = selector;

		event.preventDefault();

	
		if ( temp_upload ) {
			temp_upload.open();
			return;
		} else {
	
			temp_upload = wp.media.frames.temp_upload =  wp.media({
		
				title: "Select Image",

		
				button: {
	
					text: "Selected",
	
					close: false
				}
			});


			temp_upload.on( 'select', function() {

				var attachment = temp_upload.state().get('selection').first();

				temp_upload.close();
				temp_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					temp_selector.find('.temp_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}

		temp_upload.open();
	}

	function temp_remove_file(selector) {
		selector.find('.temp_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.temp_upload_image_action .remove-image', function(event) {
		temp_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.temp_upload_image_action .add-image', function(event) {
		temp_add_file(event, $(this).parent().parent());
	});

});