/* WPtouch Simple Theme JS File */
/* Public functions called here reside in base.js, found in the Foundation theme */

function doSimpleReady() {
	jQuery( 'iframe' ).load( function(){
		jQuery( '#map' ).addClass( 'hide' ).css( 'margin-top', 'hidden' );
	});

	jQuery( '.map-address' ).on( 'click', function() {
		jQuery( '#map' ).removeClass( 'start' ).toggleClass( 'hide' );
	});

	simpleWebApp();
}

function doSimpleTouchedClasses(){
	/* Adds/removes a 'touched' class to elements when they're actually touched (after 100ms delay) for a better UI experience (tappable module) */
	jQuery( '.homepage-menu a, .homepage-menu span, #menu li' ).each( function(){
		jQuery( this ).addClass( 'tappable' );
	});
}

function simpleWebApp(){
	if ( navigator.standalone ) {
		jQuery( 'body' ).prepend( '<span class="fixed-header-fill"></span>' );
	}
}

jQuery( document ).ready( function() { doSimpleReady(); });
jQuery( window ).load( function() { doSimpleTouchedClasses(); });