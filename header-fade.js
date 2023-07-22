jQuery(document).ready(function( $ ) {
    jQuery(window).scroll(function() {

        if ( $ (window).scrollTop() >= 400) {
            $ ('#vhomeheader').fadeIn();
          } else {
            $ ('#vhomeheader').fadeOut();
             }
    });
});