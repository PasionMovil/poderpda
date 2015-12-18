/* WPtouch Classic Redux JS File */

function classicHandleTextDropDowns() {
	jQuery( '#content' ).on( 'click', '.text-expand', function() {
		var arrow = jQuery( this );
		var content = jQuery( this ).parent().find( '.post-content' );
		if ( arrow.hasClass( 'wptouch-icon-chevron-up' ) ) {
			arrow.removeClass( 'wptouch-icon-chevron-up' ).addClass( 'wptouch-icon-chevron-down' );
			content.webkitSlideToggle();
		} else {
			arrow.removeClass( 'wptouch-icon-chevron-down' ).addClass( 'wptouch-icon-chevron-up' );
			content.webkitSlideToggle();
		}
	});
}

function classicHandleTabMenu() {
	if ( jQuery( 'ul.tab-menu' ).length ) {
		jQuery( 'ul.tab-menu' ).on( 'click', 'a:not(.login-button)', function( e ) {
			jQuery( 'ul.tab-menu li a' ).removeClass( 'active' );
			jQuery( this ).addClass( 'active' );
			jQuery( '.tab-section' ).hide();
			var sectionName = ( '.' + jQuery( this ).attr( 'data-section' ) );
			jQuery( sectionName ).show();

			// Triggers focus on the search field when the search tab item is clicked
			if ( jQuery( this ).hasClass( 'wptouch-icon-search' ) ) {
				jQuery( '#search-text' ).focus();
			}

			e.preventDefault();
		});

		jQuery( 'ul.tab-menu li' ).find( 'a' ).first().click();
	} else {
		jQuery( '.wptouch-menu' ).css( 'display', 'block' );
	}
}

function classicSwapGalleryNav(){
	var prevEl = jQuery( '.gallery-nav .left' );
	var nextEl = jQuery( '.gallery-nav .right' );
	var prevLink = prevEl.find( 'a' ).attr( 'href' );
	var nextLink = nextEl.find( 'a' ).attr( 'href' );
	if ( prevLink != undefined ) {
		prevEl.html( '<a class="gallery-nav-links" href="'+prevLink+'"><i class="wptouch-icon-circle-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;|' );
	}
	if ( nextLink != undefined ) {
		nextEl.html( '<a class="gallery-nav-links" href="'+nextLink+'"><i class="wptouch-icon-circle-arrow-right"></i></a>' );
	}

	jQuery( '.gallery-nav' ).on( 'click', 'a.gallery-nav-links', function( e ) {
		var galleryNavUrl = jQuery( this ).attr( 'href' );
		e.preventDefault();
		window.location = galleryNavUrl;
	});
}

// Setup iOS7 scrollable menus in Web App Mode
function classicWebAppMenu(){
	if ( navigator.standalone ) {
		var bodyCheck = jQuery( 'body.web-app-mode.ios7.smartphone' );
		var menuEl = jQuery( '#menu' );
		jQuery( window ).resize( function() {
			var windowHeight = jQuery( window ).height() - 64;
			if ( bodyCheck.hasClass( 'portrait' ) ) {
				menuEl.css( 'max-height', windowHeight );
			}
			if ( bodyCheck.hasClass( 'landscape' ) ) {
				menuEl.css( 'max-height', windowHeight );
			}
		}).resize();
	}
}

function classicTabletView(){
/* If it's a tablet & the clientWidth is less than 1024,
assume it's portrait, else landscape, and remove classes when the visitor changes orientation */
	if ( jQuery( 'body' ).hasClass( 'tablet' ) ) {
		jQuery( window ).resize( function(){
			var menuEl = jQuery( '#menu' );
			var animatedClasses = 'slide-out slide-in';
			if ( document.body.clientWidth < 1024 ) {
				menuEl.hide().removeClass( animatedClasses );
			} else {
				menuEl.show().removeClass( animatedClasses );
			}
		}).resize();
	}
}

// Add 'touched' class to these elements when they're actually touched (100ms delay) for a better UI experience (tappable module)
function classicBindTappableLinks(){
	// Drop down menu items
	jQuery( '.wptouch-menu li, ul.tab-menu li a' ).each( function(){
		jQuery( this ).addClass( 'tappable' );
	});
}

function classicHandleAds(){
	var adDiv = jQuery( '.wptouch-showcase' );
	jQuery( window ).resize( function(){
		if ( jQuery( 'body' ).hasClass( 'smartphone' ) && jQuery( 'body' ).hasClass( 'top-content-showcase' ) ) {
			adDiv.detach();
			jQuery( '.post' ).before( adDiv );
		} else if ( jQuery( 'body' ).hasClass( 'smartphone' ) && jQuery( 'body' ).hasClass( 'bottom-content-showcase' ) ) {
			adDiv.detach();
			jQuery( '.post' ).after( adDiv );
		}
	}).resize();
}

function doClassicReady() {
	classicTabletView();
	classicSwapGalleryNav();
	classicHandleTextDropDowns();
	classicHandleTabMenu();
	classicWebAppMenu();
	classicBindTappableLinks();
	classicHandleAds();
 }

jQuery( document ).ready( function() { doClassicReady(); } );