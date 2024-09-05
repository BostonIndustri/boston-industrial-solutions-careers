jQuery( document ).ready( function( $ ) {
	'use strict';

	// Localizd variables.
	var ajax_url   = Boston_Careers_Admin_Js_Props.ajax_url;
	var ajax_nonce = Boston_Careers_Admin_Js_Props.ajax_nonce;

	// Sync single job.
	if ( $( '.sync-single-job' ).length ) {
		$( '.sync-single-job' ).on( 'click', function( e ) {
			e.preventDefault();
			$( this ).text( 'Syncing..' );
			
			// Get job title from the table cell.
			var jobTitle = $( this ).closest( 'tr' ).find( 'td:first' ).text().trim();
	
			$.ajax( {
				url: ajax_url,
				type: 'POST',
				data: {
					action: 'sync_single_job',
					job_title: jobTitle,
					ajax_nonce: ajax_nonce,
				},
				success: function( response ) {
					if ( response.success ) {
						console.log( 'Job synced successfully!' );
						$( '.sync-single-job' ).text( 'Sync' );
						location.reload();
					} else {
						console.warn( 'Failed to sync job: ' + response.data );
					}
				},
				error: function( xhr, status, error ) {
					console.warn( 'An error occurred: ' + error );
				}
			} );
		} );
	}
} );
