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
			var jobId = $( this ).data( 'jobid' );
			var jobDetails = $( this ).data( 'jobdetails' ); // Fetch job details as JSON from the data attribute

			$.ajax( {
				url: ajax_url,
				type: 'POST',
				data: {
					action: 'sync_single_job',
					job_title: jobTitle,
					job_id: jobId,
					jobdetails: jobDetails,
					ajax_nonce: ajax_nonce
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


	    // Click event to sync all jobs from listing.
		jQuery('#sync-all-jobs-form').on('submit', function(e) {
			e.preventDefault();
	
			 // Gather job titles from the table
			 var jobTitles = [];
			 jQuery('#jobs-table tbody tr').each(function() {
				 var jobTitle = jQuery(this).find('td:first').text().trim();
				 jobTitles.push(jobTitle);
			 });
	
			 // If no job titles found, alert the user
			 if (jobTitles.length === 0) {
				 alert('No jobs to sync.');
				 return;
			 }
					 
			 jQuery.ajax({
				url: ajax_url,
				type: 'POST',
				data: {
					action: 'sync_all_jobs',
					job_titles: jobTitles,
					// nonce: bis_admin_ajax.nonce
				},
				success: function(response) {
					if (response.success) {
						jQuery('.notice-success').css('display','block');
						window.location.href = "https://careers.bostonindustrialsolutions.com/wp-admin/edit.php?post_type=job"
					} else {
						alert('Failed to sync jobs: ' + response.data);
					}
				},
				error: function(xhr, status, error) {
					alert('An error occurred: ' + error);
				}
			});
		});
} );
