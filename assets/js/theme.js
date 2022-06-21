$( document ).ready(function() {
	
	/* Header scroll on fixed */
	
	if ( $(this).width() > 992 ) {
		var nav = $('.header');
		$(window).scroll(function () {
			if ($(this).scrollTop()) {
				nav.addClass("fixed-header");
			} else {
				nav.removeClass("fixed-header");
			}
		});
	}
});