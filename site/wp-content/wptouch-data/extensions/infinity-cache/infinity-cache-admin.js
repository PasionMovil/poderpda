function doInfinityCacheReady() {
	jQuery( '#cache_delete_cache' ).click( function( e ) {
		var ajaxParams = {};
			
		jQuery( '#cache_delete_cache' ).attr( 'disabled', 'disabled' );
		wptouchAdminAjax( 'infinity-cache-reset', ajaxParams, function( result ) {
			jQuery( '#cache_delete_cache' ).removeAttr( 'disabled' );
		});
		e.preventDefault();
	});
}

jQuery( document ).ready( function() { doInfinityCacheReady(); });