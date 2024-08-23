jQuery(document).ready(function($) {
    jQuery('.sync-single-job').on('click', function(e) {
        e.preventDefault();
        jQuery(this).text('Syncing..');
        // Get job title from the table cell
        var jobTitle = jQuery(this).closest('tr').find('td:first').text().trim();

        jQuery.ajax({
            url: bis_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'sync_single_job',
                job_title: jobTitle,
                // nonce: bis_admin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    alert('Job synced successfully!');
                    jQuery(this).text('Sync');
                } else {
                    alert('Failed to sync job: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});