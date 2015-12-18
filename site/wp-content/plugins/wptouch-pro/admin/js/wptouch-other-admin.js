function wptouchSetupNonWPtouchPage() {
	var pluginNotificationDiv = jQuery( '.wptouch.update-plugins' );
	if ( pluginNotificationDiv.length ) {
		wptouchHandlePluginNotification();
	}

	jQuery( document ).on( 'wp-plugin-update-success', function( response ) {
		if ( jQuery( '#wptouch-pro-update div' ).hasClass( 'updated-message' ) ) {
			location.reload();
		}
	} );
}

function wptouchHandlePluginNotification() {
	var ajaxParams = {};

	wptouchAdminAjax( 'load-notifications-plugin', ajaxParams, function( notificationData ) {
		if ( notificationData.length ) {
			var result = jQuery.parseJSON( notificationData );
			if ( result.count > 0 ) {
				jQuery( '.wptouch.update-plugins .update-count' ).html( result.count );
				jQuery( '.wptouch.update-plugins' ).show();
			}
		}
	});
}

jQuery( document ).ready( function() { wptouchSetupNonWPtouchPage(); } );