jQuery(document).ready(function($) {

	"use strict";

	/* SHORTCODES AND WIDGETS */

	// Enable tabs
	$('.mjr-tabs').each( function() {
		$(this).tabs();
		$('br', this).remove();
		$(this).show();
	});

	// Toggle
	$(".toggle-container").hide(); 
	$(".trigger").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	$(".trigger").click(function(){
		$(this).next(".toggle-container").slideToggle();
	});

	// Accordion
	$('.trigger-button').click(function() {
		$('.trigger-button').removeClass('active')
	 	$('.accordion').slideUp('normal');
		if($(this).next().is(':hidden') == true) {
			$(this).next().slideDown('normal');
			$(this).addClass('active');
		 } 
	 });
	$('.accordion').hide();

	// Slideshow generator
	function mjr_generate_slideshow() {
		$('.mjr-slider').each( function() {
			$(this).flexslider({
				slideshowSpeed: $(this).data('slideshowspeed'),
				animationSpeed: $(this).data('animationspeed'),
				animation: $(this).data('animation'),
				direction: $(this).data('direction'),
				slideshow: $(this).data('autostart'),
				keyboard: true,
				touch: true,
				pauseOnHover: true
			});
		});
	}
	mjr_generate_slideshow();

}); /* end ready */