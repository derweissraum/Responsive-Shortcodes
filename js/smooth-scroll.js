jQuery(document).ready(function($){

	// Smooth scrolling when clicking on a hash link

      $(function () {
        $('a[href^="#"]').click(function () { // Klick auf den Button
          $('body,html').animate({
            scrollTop: 0
          }, 800);
          return false;
        });
      });

});