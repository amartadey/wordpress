/**
 * WGH Starter — theme JS.
 * Initialises the bundled jQuery plugins and the mobile nav toggle.
 */
( function ( $ ) {
	'use strict';

	$( function () {

		// Superfish dropdown menu.
		var $sfMenu = $( 'ul.sf-menu' );
		if ( $sfMenu.length && $.fn.superfish ) {
			$sfMenu.superfish( { delay: 100, speed: 'fast' } );
		}

		// Mobile nav toggle.
		$( '.menu-toggle' ).on( 'click', function () {
			var expanded = $( this ).attr( 'aria-expanded' ) === 'true';
			$( this ).attr( 'aria-expanded', ! expanded );
			$( '#navigation' ).toggleClass( 'is-open' );
		} );

		// Owl Carousel — any project markup with .owl-carousel.
		if ( $.fn.owlCarousel ) {
			$( '.owl-carousel' ).each( function () {
				$( this ).owlCarousel( $( this ).data( 'owl' ) || { items: 1, loop: true, nav: true } );
			} );
		}

		// Responsive Slides — any project markup with .rslides.
		if ( $.fn.responsiveSlides ) {
			$( '.rslides' ).responsiveSlides( { auto: true, pager: true, nav: false, speed: 500 } );
		}

	} );

}( jQuery ) );
