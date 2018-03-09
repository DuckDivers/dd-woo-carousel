(function( $ ) {
	'use strict';

$(".duck-carousel").owlCarousel({
        loop:true,
        autoplay: true,
        autoWidth: false,
        center: false,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        margin: 10,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            949:{
                items:2,
                nav:false
            },
            1200:{
                items:4,
                nav:false,
                }
        }
        });
        
})( jQuery );