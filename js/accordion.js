jQuery(document).ready(function($){

	$('.rs-accordion').each(function(index, element){
		$(this).find('.accordion-item-content').hide().first().show().parent().addClass('active');

		// OPTIONAL - All Accordion-Tabs are initially closed
		// $(this).find('.accordion-item-content').hide().first().removeClass('active');

	});

	$('.rs-accordion .accordion-item-title a').click(function(event){
		event.preventDefault();

		if ( ! $(this).parents('.accordion-item').hasClass('active') ) {

			// Set active class
			$(this).parents('.accordion-item').addClass('active').siblings().removeClass('active');

			// Hide others content
			$(this).parents('.accordion-item').siblings().children('.accordion-item-content').slideUp('fast');

			// Show own content
			$(this).parent().siblings('.accordion-item-content').slideDown('fast');

		}
	});
});
