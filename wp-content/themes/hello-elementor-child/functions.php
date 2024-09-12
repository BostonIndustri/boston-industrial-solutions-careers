<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

// Include the files.
include 'includes/reusable-functions.php';

/**
 * If the function, 'debug' doesn't exist.
 * This should be removed from production environment.
 */
if ( ! function_exists( 'debug' ) ) {
	/**
	 * Print_r the requested variable.
	 */
	function debug( $params ) {
		echo '<pre>';
		print_r( $params );
		echo '</pre>';
	}
}

/**
 * If the function, 'boston_careers_locale_stylesheet_uri_callback' doesn't exist.
 */
if ( ! function_exists( 'boston_careers_locale_stylesheet_uri_callback' ) ) {
	/**
	 * Set the locale stylesheet URI.
	 *
	 * @param string $uri Locale stylesheet URI.
	 * @return string
	 * @since 1.0.0
	 */
	function boston_careers_locale_stylesheet_uri_callback( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}

		return $uri;
	}
}

add_filter( 'locale_stylesheet_uri', 'boston_careers_locale_stylesheet_uri_callback' );

/**
 * If the function, 'boston_careers_wp_enqueue_scripts_callback' doesn't exist.
 */
if ( ! function_exists( 'boston_careers_wp_enqueue_scripts_callback' ) ) {
	/**
	 * Enqueue the custom assets files.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_wp_enqueue_scripts_callback() {
		// Enqueue the custom style file.
		wp_enqueue_style(
			'boston-careers-custom-css',
			trailingslashit( get_stylesheet_directory_uri() ) . '/assets/css/public.css',
			array(),
			filemtime( get_stylesheet_directory() . '/assets/css/public.css' ),
			'all'
		);

		// Enqueue the custom style file.
		wp_enqueue_style(
			'boston-careers-custom-media-css',
			trailingslashit( get_stylesheet_directory_uri() ) . '/assets/css/public-media.css',
			array(),
			filemtime( get_stylesheet_directory() . '/assets/css/public-media.css' ),
			'all'
		);

		// Enqueue the main style file.
		wp_enqueue_style(
			'hello-elem-child-style',
			trailingslashit( get_stylesheet_directory_uri() ) . '/style.css',
			array( 'hello-elementor','hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' ),
			filemtime( get_stylesheet_directory() . '/style.css' ),
			'all'
		);
	}
}

add_action( 'wp_enqueue_scripts', 'boston_careers_wp_enqueue_scripts_callback' );


/**
 * If the function, 'boston_careers_wp_admin_enqueue_scripts_callback' doesn't exist.
 */
if ( ! function_exists( 'boston_careers_wp_admin_enqueue_scripts_callback' ) ) {
	/**
	 * Enqueue js file for admin.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_wp_admin_enqueue_scripts_callback() {
		// Enqueue custom script for admin dashboard.
		wp_enqueue_script(
			'boston-careers-admin',
			get_stylesheet_directory_uri() . '/assets/js/admin.js',
			array( 'jquery' ),
			filemtime( get_stylesheet_directory() . '/assets/js/admin.js' ),
			true
		);

		// Localize variables 
		wp_localize_script(
			'boston-careers-admin',
			'Boston_Careers_Admin_Js_Props',
			array(
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'bis_admin_nonce' ),
			)
		);

	}
}

add_action( 'admin_enqueue_scripts', 'boston_careers_wp_admin_enqueue_scripts_callback' );

/**
 * If the function, `boston_careers_acf_init_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_acf_init_callback' ) ) {
	/**
	 * Initialize the ACF custom settings page.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_acf_init_callback() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			// Add main options page.
			acf_add_options_page(
				array(
					'menu_title' => __( 'Boston Careers Settings', 'boston-careers' ),
					'menu_slug' => 'bis-settings'
				)
			);

			// Add child page to the main options page.
			acf_add_options_sub_page(
				array(
					'page_title' => __( 'Zoho Recruit', 'boston-careers' ),
					'menu_title' => __( 'Zoho Recruit', 'boston-careers' ),
					'parent_slug' => 'bis-settings',
				)
			);	
		}
	}
}

add_action( 'acf/init', 'boston_careers_acf_init_callback' );

/**
 * If the function, `boston_careers_register_job_custom_post_type` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_register_job_custom_post_type' ) ) {
	/**
	 * Register custom post type: job.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_register_job_custom_post_type() {
		register_post_type(
			'job',
			array(
				'labels'             => array(
					'name'               => _x( 'Jobs', 'post type general name', 'boston-careers' ),
					'singular_name'      => _x( 'Job', 'post type singular name', 'boston-careers' ),
					'menu_name'          => _x( 'Jobs', 'admin menu', 'boston-careers' ),
					'name_admin_bar'     => _x( 'Job', 'add new on admin bar', 'boston-careers' ),
					'add_new'            => _x( 'Add New', 'job', 'boston-careers' ),
					'add_new_item'       => __( 'Add New Job', 'boston-careers' ),
					'new_item'           => __( 'New Job', 'boston-careers' ),
					'edit_item'          => __( 'Edit Job', 'boston-careers' ),
					'view_item'          => __( 'View Job', 'boston-careers' ),
					'all_items'          => __( 'All Jobs', 'boston-careers' ),
					'search_items'       => __( 'Search Jobs', 'boston-careers' ),
					'not_found'          => __( 'No Job Found.', 'boston-careers' ),
					'not_found_in_trash' => __( 'No Job Found in Trash.', 'boston-careers' ),
				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-portfolio',
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'job' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);

		// flush rewrite rules.
		$job_rewrite = get_option( 'job_post_type_rewrite' );

		if ( 'yes' !== $job_rewrite ) {
			flush_rewrite_rules( false );
			update_option( 'job_post_type_rewrite', 'yes', false );
		}
	}
}

/**
 * If the function, `boston_careers_register_recruiter_custom_taxonomy` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_register_recruiter_custom_taxonomy' ) ) {
	/**
	 * Register custom taxonomy: recruiter.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_register_recruiter_custom_taxonomy() {
		// Register Recruiter Taxonomy
		register_taxonomy(
			'recruiters',
			'job',
			array(
				'labels'            => array(
					'name'          => __( 'Recruiters', 'boston-careers' ),
					'singular_name' => __( 'Recruiter', 'boston-careers' ),
					'search_items'  => __( 'Search Recruiter', 'boston-careers' ),
					'all_items'     => __( 'All Recruiters', 'boston-careers' ),
					'edit_item'     => __( 'Edit Recruiter', 'boston-careers' ),
					'update_item'   => __( 'Update Recruiter', 'boston-careers' ),
					'add_new_item'  => __( 'Add New Recruiter', 'boston-careers' ),
					'new_item_name' => __( 'New Recruiter Name', 'boston-careers' ),
					'menu_name'     => __( 'Recruiters', 'boston-careers' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'recruiter' ),
			)
		);
	}
}

/**
 * If the function, `boston_careers_register_industry_custom_taxonomy` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_register_industry_custom_taxonomy' ) ) {
	/**
	 * Register custom taxonomy: industry.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_register_industry_custom_taxonomy() {
		// Register Industry Taxonomy
		register_taxonomy(
			'industry',
			'job',
			array(
				'labels'            => array(
					'name'          => __( 'Industries', 'boston-careers' ),
					'singular_name' => __( 'Industry', 'boston-careers' ),
					'search_items'  => __( 'Search Industries', 'boston-careers' ),
					'all_items'     => __( 'All Industries', 'boston-careers' ),
					'edit_item'     => __( 'Edit Industry', 'boston-careers' ),
					'update_item'   => __( 'Update Industry', 'boston-careers' ),
					'add_new_item'  => __( 'Add New Industry', 'boston-careers' ),
					'new_item_name' => __( 'New Industry Name', 'boston-careers' ),
					'menu_name'     => __( 'Industries', 'boston-careers' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'industry' ),
			)
		);
	}
}

/**
 * If the function, `boston_careers_register_job_type_custom_taxonomy` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_register_job_type_custom_taxonomy' ) ) {
	/**
	 * Register custom taxonomy: industries.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_register_job_type_custom_taxonomy() {
		// Register Recruiter Taxonomy
		register_taxonomy(
			'job_type',
			'job',
			array(
				'labels'            => array(
					'name'          => __( 'Job Types', 'boston-careers' ),
					'singular_name' => __( 'Job Types', 'boston-careers' ),
					'search_items'  => __( 'Search Job Typess', 'boston-careers' ),
					'all_items'     => __( 'All Job Typess', 'boston-careers' ),
					'edit_item'     => __( 'Edit Job Types', 'boston-careers' ),
					'update_item'   => __( 'Update Job Types', 'boston-careers' ),
					'add_new_item'  => __( 'Add New Job Types', 'boston-careers' ),
					'new_item_name' => __( 'New Job Types Name', 'boston-careers' ),
					'menu_name'     => __( 'Job Typess', 'boston-careers' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'job_type' ),
			)
		);
	}
}

/**
 * If the function, `boston_careers_init_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_init_callback' ) ) {
	/**
	 * Do something on WordPress initialization.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_init_callback() {
		boston_careers_register_job_custom_post_type(); // Register jobs custom post type.
		boston_careers_register_recruiter_custom_taxonomy(); // Register recruiters custom taxonomy.
		boston_careers_register_industry_custom_taxonomy(); // Register industries custom taxonomy.
		boston_careers_register_job_type_custom_taxonomy(); // Register job types custom taxonomy.
	}
}

add_action( 'init', 'boston_careers_init_callback' );

/**
 * If the function, `boston_careers_admin_head_edit_php_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_admin_head_edit_php_callback' ) ) {
	/**
	 * Add custom button on the admin list, job post type.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_admin_head_edit_php_callback() {
		$screen      = get_current_screen();
		$button_text = __( 'Sync Zoho Recruit', 'boston-careers' );
		$button_url  = admin_url( 'edit.php?post_type=job&page=sync-job' );

		// Only add the button on the Jobs post type listing page
		if ( 'job' === $screen->post_type ) {
			?>
			<script type="text/javascript">
				var button_text = '<?php echo $button_text; ?>';
				var button_url  = '<?php echo $button_url; ?>';

				jQuery( document ).ready( function() {
					jQuery( '<a href="' + button_url + '" class="page-title-action">' + button_text + '</a>' ).insertAfter( '.wrap a.page-title-action' );
				} );
			</script>
			<?php
		}
	}
}

add_action( 'admin_head-edit.php', 'boston_careers_admin_head_edit_php_callback' );

/**
 * If the function, `boston_careers_refresh_zoho_access_token` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_refresh_zoho_access_token' ) ) {
	/**
	 * Get refresh token generated from self client code.
	 *
	 * @return false|string
	 * @since 1.0.0
	 */
	function boston_careers_refresh_zoho_access_token() {
		// Get the zoho recruiters.
		$zoho_client_id     = get_field( 'zoho_client_id', 'option' );
		$zoho_client_secret = get_field( 'zoho_client_secret', 'option' );
		$zoho_refresh_token = get_field( 'zoho_refresh_token', 'option' );
		$zoho_token_url     = get_field( 'zoho_token_url', 'option' );

		// Return false, if either of the zoho API credentials are not available.
		if (
			( empty( $zoho_client_id ) || false === $zoho_client_id ) ||
			( empty( $zoho_client_secret ) || false === $zoho_client_secret ) ||
			( empty( $zoho_refresh_token ) || false === $zoho_refresh_token ) ||
			( empty( $zoho_token_url ) || false === $zoho_token_url )
		) {
			return false;
		}

		// Request a new access token using the refresh token.
		$response = wp_remote_post(
			$zoho_token_url,
			array(
				'body' => array(
					'refresh_token' => $zoho_refresh_token,
					'client_id'     => $zoho_client_id,
					'client_secret' => $zoho_client_secret,
					'grant_type'    => 'refresh_token',
				),
			)
		);

		// Return false, if the API returned an error response.
		if ( is_wp_error( $response ) ) {
			error_log( 'Error refreshing Zoho access token: ' . $response->get_error_message() );

			return false;
		}

		// Get the response from the body.
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		// Return the new access token.
		if ( isset( $data['access_token'] ) ) {
			return $data['access_token'];
		}

		// Log the error if the access token is not received in the response.
		error_log( 'Failed to get new access token: ' . print_r( $data, true ) );

		return false;
	}
}

/**
 * If the function, `boston_careers_fetch_zoho_job_openings` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_fetch_zoho_job_openings' ) ) {
	/**
	 * Fetch job openings from zoho recruit portal.
	 *
	 * @return false|string
	 * @since 1.0.0
	 */
	function boston_careers_fetch_zoho_job_openings() {
		$access_token = boston_careers_refresh_zoho_access_token();

		// Return false, if no access token is received.
		if ( false === $access_token ) {
			return false;
		}

		$zoho_job_openings_url = get_field( 'zoho_job_openings_url', 'option' );

		// Return false, if the API url is not given.
		if ( empty( $zoho_job_openings_url ) || false === $zoho_job_openings_url ) {
			return false;
		}

		// Hit the API.
		$response = wp_remote_get(
			$zoho_job_openings_url,
			array(
				'headers' => array(
					'Authorization' => "Zoho-oauthtoken {$access_token}",
				),
			)
		);

		// Return false, if the API returned an error response.
		if ( is_wp_error( $response ) ) {
			error_log( 'Error refreshing Zoho job openings: ' . $response->get_error_message() );

			return false;
		}

		// Get the response from the body.
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		// debug($data);
		// Return the job listings.
		if ( isset($data['data'] ) && is_array( $data['data'] ) ) {
			return $data['data'];
		}

		// Log the error if the job listing is not received in the response.
		error_log( 'Failed to get job listings: ' . print_r( $data, true ) );

		return false;
	}
}

/**
 * If the function, `boston_careers_job_listing_table_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_job_listing_table_callback' ) ) {
	/**
	 * Shortcode to list the jobs intabular format.
	 *
	 * @param $args array Shortcode arguments.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	*/
	function boston_careers_job_listing_table_callback( $args = array() ) {
		$jobs_query = boston_careers_get_posts( 'job' ); // Fetch the jobs.
		
		// Start output buffering
		ob_start();
		?>
		<table>
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'POSITION','boston-careers' ); ?></th>
					<th scope="col"><?php esc_html_e( 'DEPARTMENT','boston-careers' ); ?></th>
					<th scope="col"><?php esc_html_e( 'LOCATION','boston-careers' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $jobs_query->posts ) && is_array( $jobs_query->posts ) ) { ?>
					<?php foreach ( $jobs_query->posts as $job_id ) {
						$department = '';
						$location   = '';
						?>
						<tr>
							<td data-label="POSITION">
								<a href="<?php echo esc_url( get_permalink( $job_id ) ); ?>"><?php echo wp_kses_post( get_the_title( $job_id ) ); ?></a>
							</td>
							<td data-label="DEPARTMENT"><?php echo wp_kses_post( $department ); ?></td>
							<td data-label="LOCATION"><?php echo wp_kses_post( $location ); ?></td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td colspan="3"><?php esc_html_e( 'No jobs available to apply.', 'boston-careers' ); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php

		return ob_get_clean(); // End output buffering and return the content.
	}

}

add_shortcode( 'job_listing_table', 'boston_careers_job_listing_table_callback' );

/**
 * If the function, `boston_careers_admin_menu_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_admin_menu_callback' ) ) {
	/**
	 * Create a submenu to sync jobs with Zoho recruit.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_admin_menu_callback() {
		add_submenu_page(
			'edit.php?post_type=job',
			__( 'Sync Job Settings', 'boston-careers' ),
			__( 'Sync Jobs', 'boston-careers' ),
			'manage_options',
			'sync-job',
			'boston_careers_sync_jobs'
		);
	}
}

add_action( 'admin_menu', 'boston_careers_admin_menu_callback' );

/**
 * If the function, `boston_careers_sync_jobs` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_sync_jobs' ) ) {
	/**
	 * fetch jobs from zoho recruit on sync jobs page.
	 *
	 * @since 1.0.0
	*/
	function boston_careers_sync_jobs() {
		$jobs_query = boston_careers_get_posts('job'); // Fetch the jobs.
	
		// Convert WP_Query object to an array of posts
		$jobs = $jobs_query->posts; 
	
		$existing_titles = wp_list_pluck($jobs, 'post_title'); // Get an array of existing job titles
	
		$zoho_jobs = boston_careers_fetch_zoho_job_openings(); // Fetch jobs from Zoho Recruit
		// debug($zoho_jobs);
		// Filter out jobs that are already present in the CPT
		if($zoho_jobs){
			$new_jobs = array_filter($zoho_jobs, function($job) use ($existing_titles) {
				return !in_array($job['Job_Opening_Name'], $existing_titles);
			});
		}
		// Your existing HTML code to display jobs
		?>
		<div class="wrap">
			<h1><?php esc_html_e('Sync Jobs', 'boston-careers'); ?></h1>
			<h3><?php esc_html_e('Sync Jobs From Zoho Recruit', 'boston-careers'); ?></h3>
			<?php if (!empty($new_jobs)) { ?>
				<table class="widefat fixed" cellspacing="0" id="jobs-table">
					<thead>
						<tr>
							<th><?php esc_html_e('Job Title', 'boston-careers'); ?></th>
							<th><?php esc_html_e('Location', 'boston-careers'); ?></th>
							<th><?php esc_html_e('Action', 'boston-careers'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($new_jobs as $job) { 
							$job_details = array(
								'Client_Name' => $job['Client_Name']['name'],
								'Currency_Symbol' => $job['$currency_symbol'],
								'Posting_Title' => $job['Posting_Title'],
								'Date_Opened' => $job['Date_Opened'],
								'Account_Manager' => $job['Account_Manager'],
								'City' => $job['City'],
								'Job_Opening_Status' => $job['Job_Opening_Status'],
								'Work_Experience' => $job['Work_Experience'],
								'Job_Opening_Name' => $job['Job_Opening_Name'],
								'Number_of_Positions' => $job['Number_of_Positions'],
								'State' => $job['State'],
								'Country' => $job['Country'],
								'Created_By' => $job['Created_By']['name'],
								'Salary' => $job['Salary'],
								'No_of_Candidates_Hired' => $job['No_of_Candidates_Hired'],
								'Expected_Revenue' => $job['Expected_Revenue'],
								'Contact_Name' => $job['Contact_Name']
							);

							// Convert the job details to a JSON string for data attribute
    						$job_details_json = esc_attr(json_encode($job_details));
							?>
							<tr>
								<td><?php echo esc_html($job['Job_Opening_Name']); ?></td>
								<td><?php echo esc_html($job['State']) . ', ' . esc_html($job['Country']); ?></td>
								<td><a href="javascript:void(0);" data-jobid="<?php echo esc_html($job['Job_Opening_ID']); ?>" data-jobdetails="<?php echo $job_details_json; ?>" class="page-title-action sync-single-job"><?php esc_html_e('Sync', 'boston-careers'); ?></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- Add Sync All Jobs Button with Checkbox -->
                <form id="sync-all-jobs-form" method="POST" action="" style="margin-top: 10px;">
                    <label>
                        <input type="checkbox" name="sync_existing_jobs" value="0">
                        <?php esc_html_e('Sync Existing Jobs', 'boston-careers'); ?>
                    </label>
                    <input type="submit" class="button button-primary" value="<?php esc_attr_e('Sync All Jobs', 'boston-careers'); ?>" style="margin-top: 0px;">
                </form>
			<?php } else { ?>
				<p><?php esc_html_e( 'No new jobs to sync.', 'boston-careers' ); ?></p>
			<?php } ?>
		</div>
		<?php
	}
}

/**
 * If the function, `boston_careers_sync_single_job_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_sync_single_job_callback' ) ) {
	/**
	 * Sync on job at a time from the global sync page.
	 *
	 * @since 1.0.0
	 */
	function boston_careers_sync_single_job_callback() {

		// check_ajax_referer('nonce', 'security');
		// Get the job title from the request.
		$job_title = filter_input( INPUT_POST, 'job_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$job_id = filter_input( INPUT_POST, 'job_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$job_details_json = isset( $_POST['jobdetails'] ) ? wp_unslash( $_POST['jobdetails'] ) : ''; // Use wp_unslash to remove slashes from the input

		// // Add job details to meta input array
        // foreach ( $job_details_json as $key => $value ) {
		// 	echo $key;
		// 	die('lkoooo');
        //     if ( is_array( $value ) ) {
        //         // If the value is an array (e.g., nested data), serialize it to store it as a string
        //         $meta_input[ $key ] = maybe_serialize( $value );
        //     } else {
        //         // Otherwise, sanitize and add the value directly
        //         $meta_input[ $key ] = sanitize_text_field( $value );
        //     }
        // }


		// Create a new post in the 'jobs' CPT.
		$post_id = wp_insert_post(
			array(
				'post_title'  => $job_title,
				'post_type'   => 'job',
				'post_status' => 'publish',
				'meta_input'  => array(
					'source'         => 'zoho-recruit',
					'sync_date_time' => time(),
					'zoho_job_id'    => $job_id, // Store the Zoho job ID
				),
			)
		);

		if ( $post_id ) {
			wp_send_json_success(
				array(
					'message' => 'Job synced successfully.',
				)
			);
		} else {
			wp_send_json_error(
				array(
					'message' => 'Failed to create job post.',
				)
			);
		}

		wp_die();
	}
}

add_action( 'wp_ajax_sync_single_job', 'boston_careers_sync_single_job_callback' );

/**
 * If the function, `boston_careers_posts_args_callback` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_posts_args_callback' ) ) {
	/**
	 * Override the wp post query arguments.
	 *
	 * @param $args array WP_Query post arguments.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function boston_careers_posts_args_callback( $args ) {
		global $current_screen;

		// // If it's the sync screen.
		if ( ! empty( $current_screen->base ) && 'job_page_sync-job' === $current_screen->base ) {
			$args['fields'] = 'titles';
		}

		return $args;
	}
}

add_filter( 'boston_careers_posts_args', 'boston_careers_posts_args_callback' );

/**
 * If the function, `boston_careers_template_include_callback` doesn't include.
 */
if ( ! function_exists( 'boston_careers_template_include_callback' ) ) {
	/**
	 * Include custom post and page templates.
	 *
	 * @since 1.0.0
	 *
	 * @param array $templates This variable holds the all the templates array.
	 */
	function boston_careers_template_include_callback( $templates ) {
		// Check if it's the job details page.
		if ( is_singular( 'job' ) ) {
			$templates = get_stylesheet_directory() . '/templates/custom-post-type/job/single.php';
		}

		return $templates;
	}
}

add_filter( 'template_include', 'boston_careers_template_include_callback' );

/**
 * If the function, `boston_careers_zoho_crm_auth_token` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_zoho_crm_auth_token' ) ) {
	/**
	 * Generate ZOHO CRM authentication code.
	 *
	 * @return
	 */
	// function boston_careers_zoho_crm_auth_token() {
	// 	$response = wp_remote_post(
	// 		'https://accounts.zoho.com/oauth/v2/token',
	// 		array(
	// 			'method'      => 'POST',
	// 			'timeout'     => 45,
	// 			'headers'     => array(),
	// 			'body'        => array(
	// 				'grant_type'    => 'authorization_code',
	// 				'client_id'     => '1000.YTF6MHHC4DR21EOQ7HS8AAI4QSPKYZ',
	// 				'client_secret' => 'a25dbd4bf36647256bfd17ab8ed5069fda765a4a67',
	// 				'client_secret' => '',
	// 			),
	// 		)
	// 	);
		
	// 	if ( is_wp_error( $response ) ) {
	// 		$error_message = $response->get_error_message();
	// 		echo "Something went wrong: $error_message";
	// 	} else {
	// 		echo 'Response:<pre>';
	// 		print_r( $response );
	// 		echo '</pre>';
	// 	}
	// }
}


/**
 * If the function, `boston_careers_sync_all_jobs` doesn't exist.
 */
if ( ! function_exists( 'boston_careers_sync_all_jobs' ) ) {
	/**
	 * Sync all jobs.
	 *
	 * @since 1.0.0
	*/
	function boston_careers_sync_all_jobs() {
		// Check for nonce for security if needed
		// check_ajax_referer('nonce', 'security');

		// Get job titles from the AJAX request
		$job_titles = isset($_POST['job_titles']) ? array_map('sanitize_text_field', $_POST['job_titles']) : [];

		if (empty($job_titles)) {
			wp_send_json_error('No job titles provided.');
			return;
		}

		foreach ($job_titles as $job_title) {
		
			wp_insert_post([
				'post_title'    => $job_title,
				'post_type'     => 'jobs',
				'post_status'   => 'publish',
				'meta_input'  => array(
					'source'         => 'zoho-recruit',
					'sync_date_time' => time()
				),
			]);
		}

		wp_send_json_success('All jobs synced successfully.');
	}
}

add_action('wp_ajax_sync_all_jobs', 'boston_careers_sync_all_jobs');