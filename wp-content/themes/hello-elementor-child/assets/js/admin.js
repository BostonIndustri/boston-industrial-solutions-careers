jQuery( document ).ready( function( $ ) {
	'use strict';

	// Localizd variables.
	var ajax_url   = Boston_Careers_Admin_Js_Props.ajax_url;
	var ajax_nonce = Boston_Careers_Admin_Js_Props.ajax_nonce;
	var job_listing_url = Boston_Careers_Admin_Js_Props.job_listing_url
	console.log(job_listing_url);
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


	jQuery('#sync-all-jobs-form').on('submit', function(e) {
		e.preventDefault();
	
		// Gather job titles, IDs, and details from the table
		var jobs = [];
		jQuery('#jobs-table tbody tr').each(function() {
			var jobTitle = jQuery(this).find('td:first').text().trim();
			var jobId = jQuery(this).find('a.sync-single-job').data('jobid');
			var jobDetails = jQuery(this).find('a.sync-single-job').data('jobdetails');
	
			// Add job data to the array
			jobs.push({
				title: jobTitle,
				id: jobId,
				details: jobDetails
			});
		});
		// console.log(jobs);
		// If no jobs found, alert the user
		if (jobs.length === 0) {
			alert('No jobs to sync.');
			return;
		}
	
		$.ajax({
			url: ajax_url,
			type: 'POST',
			data: {
				action: 'sync_all_jobs',
				jobs: jobs
				// nonce: bis_admin_ajax.nonce
			},
			success: function(response) {
				if (response.success) {
					jQuery('.notice-success').css('display', 'block');
					window.location.href = job_listing_url;
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
