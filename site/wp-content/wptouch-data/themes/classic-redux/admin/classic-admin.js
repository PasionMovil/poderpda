function doClassicThumbnailEvaluate( selectedOption ) {
	if ( selectedOption == 'featured' ) {
		jQuery( '#setting-thumbnail_custom_field' ).hide();
	} else {
		jQuery( '#setting-thumbnail_custom_field' ).slideDown();
	}
}

function doClassicThumbnailRadio() {
	var thumbSelect = jQuery( '#setting-thumbnail_type input' );
	thumbSelect.change( function(){
		var selectedOption = jQuery( 'input[name=wptouch__classic-redux__thumbnail_type]:checked' ).val();
		doClassicThumbnailEvaluate( selectedOption );
	});

	doClassicThumbnailEvaluate( jQuery( 'input[name=wptouch__classic-redux__thumbnail_type]:checked' ).val() );
}

function doClassicAdminReady() {
	wptouchCheckToggle( '#show_tab_bar', '#setting-tab_bar_cat_tags, #setting-tab_bar_max_cat_tags' );

	doClassicThumbnailRadio();
}

jQuery( document ).ready( function() { doClassicAdminReady(); } );