jQuery(document).ready(function($){

	$('.rs-toggle').each(function(index, element){
		$(this).find('.toggle-content').hide();
	});

	$('.rs-toggle .toggle-title a').click(function(event){
		event.preventDefault();

		$(this).toggleClass('active').parent().siblings('.toggle-content').slideToggle('fast');

	});
});
