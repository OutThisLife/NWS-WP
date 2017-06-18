(function($) {

$(document).on('gform_post_render', function(e, id) {
	var fields = $('.gfield input[type!=checkbox][type!=radio], .gfield select, .gfield textarea'),

	checkValidation = function(e) {
		var el = $(e.target ? e.target : e),
			label = el.parent().prev('.gfield_label'),
			isBlank = el.val() == '';

		// Is an event
		if (e.type && isBlank) {
			if (e.type === 'focus')
				label.addClass('out');

			else if (e.type === 'blur')
				label.removeClass('out');
		}

		// Single element
		else {
			if (isBlank)
				label.removeClass('out');

			else label.addClass('out');
		}

		if (isBlank) el.addClass('is-blank');
		else el.removeClass('is-blank');
	};

	fields.addClass('is-blank');
	fields.on('focus blur', checkValidation);

	fields.map(function(i, el) {
		checkValidation(el)
	});

	$('.ginput_container_fileupload').each(function(i, el) {
		$(this).prev().remove()
	});
});

})(jQuery);