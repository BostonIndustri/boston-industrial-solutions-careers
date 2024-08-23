<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

// Include the function files.
// include 'functions/remote_get.php';


/**
 * If the function, 'debug' doesn't exist.
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
 * If the function, 'hello_elementor_child_locale_stylesheet_uri_callback' doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_locale_stylesheet_uri_callback' ) ) {
	/**
	 * Set the locale stylesheet URI.
	 *
	 * @param string $uri Locale stylesheet URI.
	 * @return string
	 * @since 1.0.0
	 */
	function hello_elementor_child_locale_stylesheet_uri_callback( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}

		return $uri;
	}
}

add_filter( 'locale_stylesheet_uri', 'hello_elementor_child_locale_stylesheet_uri_callback' );

/**
 * If the function, 'hello_elementor_child_wp_enqueue_scripts_callback' doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_wp_enqueue_scripts_callback' ) ) {
	/**
	 * Enqueue the custom assets files.
	 *
	 * @since 1.0.0
	 */
	function hello_elementor_child_wp_enqueue_scripts_callback() {
		// Enqueue the main style file.
		wp_enqueue_style(
			'hello-elem-child-style',
			trailingslashit( get_stylesheet_directory_uri() ) . 'style.css',
			array( 'hello-elementor','hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' )
		);
	}
}

add_action( 'wp_enqueue_scripts', 'hello_elementor_child_wp_enqueue_scripts_callback' );


/**
 * If the function, 'hello_elementor_child_wp_admin_enqueue_scripts_callback' doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_wp_admin_enqueue_scripts_callback' ) ) {
	/**
	 * Enqueue js file for admin.
	 *
	 * @since 1.0.0
	 */
	function hello_elementor_child_wp_admin_enqueue_scripts_callback() {

		wp_enqueue_script('job-sync-js', get_stylesheet_directory_uri() . '/assets/js/admin.js', array('jquery'), null, true);
		wp_localize_script('job-sync-js', 'bis_admin_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('bis_admin_nonce')
		));

	}
}
add_action( 'admin_enqueue_scripts', 'hello_elementor_child_wp_admin_enqueue_scripts_callback' ); 


/**
 * Theme option page to store theme settings.
 *
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'menu_title' => 'BIS Settings',
		'menu_slug' => 'bis-settings'
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Zoho API Settings',
		'menu_title' => 'Zoho API Settings',
		'parent_slug' => 'bis-settings',
	));	
}


/**
 * If the function, `hello_elementor_child_init_callback` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_init_callback' ) ) {
	/**
	 * Do something on WordPress initialization.
	 *
	 * @since 1.0.0
	 */
	function hello_elementor_child_init_callback() {
		// $zoho_auth_token = hello_elementor_child_zoho_crm_auth_token();
		// $response = wp_remote_get(
		// 	'https://recruit.zoho.com/recruit/v2/settings/modules',
		// 	array(
		// 		'headers' => array(
		// 			'Authorization' => 'Zoho-oauthtoken 1000.03xxxxxxxxxxxxxxxxxa5317.dxxxxxxxxxxxxxxxxxfa',
		// 		)
		// 	)
		// );

		// debug( $response );
		// die;

		// if ( ( !is_wp_error($response)) && (200 === wp_remote_retrieve_response_code( $response ) ) ) {
		// 	$responseBody = json_decode($response['body']);
		// 	if( json_last_error() === JSON_ERROR_NONE ) {
		// 		//Do your thing.
		// 	}
		// }


		$labels = array(
			'name'               => _x('Jobs', 'post type general name','hello-elementor-child'),
			'singular_name'      => _x('Job', 'post type singular name','hello-elementor-child'),
			'menu_name'          => _x('Jobs', 'admin menu','hello-elementor-child'),
			'name_admin_bar'     => _x('Job', 'add new on admin bar','hello-elementor-child'),
			'add_new'            => _x('Add New', 'job','hello-elementor-child'),
			'add_new_item'       => __('Add New Job','hello-elementor-child'),
			'new_item'           => __('New Job','hello-elementor-child'),
			'edit_item'          => __('Edit Job','hello-elementor-child'),
			'view_item'          => __('View Job','hello-elementor-child'),
			'all_items'          => __('All Jobs','hello-elementor-child'),
			'search_items'       => __('Search Jobs','hello-elementor-child'),
			'not_found'          => __('No jobs found.','hello-elementor-child'),
			'not_found_in_trash' => __('No jobs found in Trash.','hello-elementor-child'),
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-portfolio',
			'query_var'          => true,
			'rewrite'            => array('slug' => 'jobs'),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
		);
	
		register_post_type('jobs', $args);



		// Register Recruiter Taxonomy
		register_taxonomy('recruiter', 'jobs', array(
			'labels' => array(
				'name' => __('Recruiters', 'hello-elementor-child'),
				'singular_name' => __('Recruiter', 'hello-elementor-child'),
				'search_items' => __('Search Recruiters', 'hello-elementor-child'),
				'all_items' => __('All Recruiters', 'hello-elementor-child'),
				'edit_item' => __('Edit Recruiter', 'hello-elementor-child'),
				'update_item' => __('Update Recruiter', 'hello-elementor-child'),
				'add_new_item' => __('Add New Recruiter', 'hello-elementor-child'),
				'new_item_name' => __('New Recruiter Name', 'hello-elementor-child'),
				'menu_name' => __('Recruiters', 'hello-elementor-child'),
			),
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'recruiter'),
		));
	
		// Register Industry Taxonomy
		register_taxonomy('industry', 'jobs', array(
			'labels' => array(
				'name' => __('Industries', 'hello-elementor-child'),
				'singular_name' => __('Industry', 'hello-elementor-child'),
				'search_items' => __('Search Industries', 'hello-elementor-child'),
				'all_items' => __('All Industries', 'hello-elementor-child'),
				'edit_item' => __('Edit Industry', 'hello-elementor-child'),
				'update_item' => __('Update Industry', 'hello-elementor-child'),
				'add_new_item' => __('Add New Industry', 'hello-elementor-child'),
				'new_item_name' => __('New Industry Name', 'hello-elementor-child'),
				'menu_name' => __('Industries', 'hello-elementor-child'),
			),
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'industry'),
		));
	
		// Register Job Type Taxonomy
		register_taxonomy('job_type', 'jobs', array(
			'labels' => array(
				'name' => __('Job Types', 'hello-elementor-child'),
				'singular_name' => __('Job Type', 'hello-elementor-child'),
				'search_items' => __('Search Job Types', 'hello-elementor-child'),
				'all_items' => __('All Job Types', 'hello-elementor-child'),
				'edit_item' => __('Edit Job Type', 'hello-elementor-child'),
				'update_item' => __('Update Job Type', 'hello-elementor-child'),
				'add_new_item' => __('Add New Job Type', 'hello-elementor-child'),
				'new_item_name' => __('New Job Type Name', 'hello-elementor-child'),
				'menu_name' => __('Job Types', 'hello-elementor-child'),
			),
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'job-type'),
		));
	}
}

add_action( 'init', 'hello_elementor_child_init_callback' );


if ( ! function_exists( 'hello_elementor_child_add_sync_button_to_jobs_list' ) ) {
    function hello_elementor_child_add_sync_button_to_jobs_list() {
        $screen = get_current_screen();

        // Only add the button on the Jobs post type listing page
        if ( $screen->post_type == 'jobs' ) {
            echo '<a href="' . admin_url( 'edit.php?post_type=jobs&sync_zoho_jobs=1' ) . '" class="page-title-action">Sync Jobs</a>';
        }
    }
}
add_action( 'admin_page_title_buttons', 'hello_elementor_child_add_sync_button_to_jobs_list' );


// /**
//  * If the function, `hello_elementor_child_zoho_crm_auth_token` doesn't exist.
//  */
// if ( ! function_exists( 'hello_elementor_child_zoho_crm_auth_token' ) ) {
// 	/**
// 	 * Generate ZOHO CRM authentication code.
// 	 *
// 	 * @return
// 	 */
// 	function hello_elementor_child_zoho_crm_auth_token() {
// 		$response = wp_remote_post(
// 			'https://accounts.zoho.com/oauth/v2/token',
// 			array(
// 				'method'      => 'POST',
// 				'timeout'     => 45,
// 				'headers'     => array(),
// 				'body'        => array(
// 					'grant_type'    => 'authorization_code',
// 					'client_id'     => '1000.YTF6MHHC4DR21EOQ7HS8AAI4QSPKYZ',
// 					'client_secret' => 'a25dbd4bf36647256bfd17ab8ed5069fda765a4a67',
// 					'client_secret' => '',
// 				),
// 			)
// 		);
		
// 		if ( is_wp_error( $response ) ) {
// 			$error_message = $response->get_error_message();
// 			echo "Something went wrong: $error_message";
// 		} else {
// 			echo 'Response:<pre>';
// 			print_r( $response );
// 			echo '</pre>';
// 		}
// 	}
// }






/**
 * If the function, `hello_elementor_child_refresh_zoho_access_token` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_refresh_zoho_access_token' ) ) {
	/**
	 * Get refresh token generated from self client code.
	 *
	 * @since 1.0.0
	 */
	function hello_elementor_child_refresh_zoho_access_token() {

		$zoho_client_id = get_field('zoho_client_id','option');
		$zoho_client_secret = get_field('zoho_client_secret','option');
		$zoho_refresh_token = get_field('zoho_refresh_token','option');
		$zoho_token_url = get_field('zoho_token_url','option');

		$client_id = $zoho_client_id;
		$client_secret = $zoho_client_secret;
		$refresh_token = $zoho_refresh_token;
		$token_url = $zoho_token_url;

		// Request a new access token using the refresh token
		$response = wp_remote_post($token_url, array(
			'body' => array(
				'refresh_token' => $refresh_token,
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'grant_type' => 'refresh_token',
			),
		));

		if (is_wp_error($response)) {
			error_log('Error refreshing Zoho access token: ' . $response->get_error_message());
			return false;
		}

		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);

		if (isset($data['access_token'])) {
			return $data['access_token']; // Return the new access token
		} else {
			error_log('Failed to get new access token: ' . print_r($data, true));
			return false;
		}
	}
}


/**
 * If the function, `hello_elementor_child_fetch_zoho_job_openings` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_fetch_zoho_job_openings' ) ) {
		/**
		 * Fetch job openings from zoho portal.
		 *
		 * @since 1.0.0
		 */
	function hello_elementor_child_fetch_zoho_job_openings() {
		$access_token = hello_elementor_child_refresh_zoho_access_token();
		if (!$access_token) {
			return false; // Exit if no valid token
		}

		$zoho_job_openings_url = get_field('zoho_job_openings_url','option');

		$url = $zoho_job_openings_url;
		$response = wp_remote_get($url, array(
			'headers' => array(
				'Authorization' => 'Zoho-oauthtoken ' . $access_token,
			),
		));

		if (is_wp_error($response)) {
			error_log('Error fetching Zoho job openings: ' . $response->get_error_message());
			return false;
		} else {
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body, true);
			if (isset($data['data']) && is_array($data['data'])) {
				return $data['data']; // Return the job openings data
			} else {
				return false;
			}
		}
	}
}


/**
 * If the function, `hello_elementor_child_job_listing_shortcode` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_job_listing_shortcode' ) ) {
	/**
	 * Shortcode which generate job listing data dynamically.
	 *
	 * @since 1.0.0
	*/
	function hello_elementor_child_job_listing_shortcode() {

		$jobs = hello_elementor_child_fetch_zoho_job_openings(); // Fetch the jobs
		ob_start(); // Start output buffering
		if ($jobs) {
			?>
			<table>
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e('POSITION','hello-elementor-child'); ?></th>
						<th scope="col"><?php esc_html_e('DEPARTMENT','hello-elementor-child'); ?></th>
						<th scope="col"><?php esc_html_e('LOCATION','hello-elementor-child'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($jobs as $job) : ?>
						<tr>
							<td data-label="POSITION">
								<a href="javascript:void(0);"><?php echo esc_html($job['Job_Opening_Name'],'hello-elementor-child'); ?></a>
							</td>
							<td data-label="DEPARTMENT"><?php echo esc_html($job['Department'],'hello-elementor-child'); ?></td>
							<td data-label="LOCATION"><?php echo esc_html($job['State']).', '.esc_html($job['Country'],'hello-elementor-child'); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php
		} else {
			echo esc_html('No job listings found','hello-elementor-child');
		}
		return ob_get_clean(); // End output buffering and return the content
	}

}
add_shortcode('job_listing_table', 'hello_elementor_child_job_listing_shortcode');


/**
 * If the function, `hello_elementor_child_add_sync_page` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_add_sync_page' ) ) {
	/**
	 * function will create a custom setting page for job sync
	 *
	 * @since 1.0.0
	*/
    function hello_elementor_child_add_sync_page() {

        add_submenu_page(
            'edit.php?post_type=jobs',       // Parent slug (Jobs menu)
            'Sync Job Settings',             // Page title
            'Sync Jobs',                 	 // Menu title
            'manage_options',                // Capability
            'sync-job-settings',             // Menu slug
            'hello_elementor_child_sync_jobs' // Callback function
        );
    }

}
add_action( 'admin_menu', 'hello_elementor_child_add_sync_page' );


/**
 * If the function, `hello_elementor_child_sync_jobs` doesn't exist.
 */
if ( ! function_exists( 'hello_elementor_child_sync_jobs' ) ) {
	/**
	 * fetch jobs from zoho recruit on sync jobs page.
	 *
	 * @since 1.0.0
	*/
	function hello_elementor_child_sync_jobs() {
		$existing_jobs = get_posts([
			'post_type' => 'jobs',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'titles', // Get only the titles
		]);
	
		$existing_titles = wp_list_pluck($existing_jobs, 'post_title'); // Get an array of existing job titles
	
		$jobs = hello_elementor_child_fetch_zoho_job_openings(); // Fetch the jobs from Zoho
	
		// Filter out jobs that are already present in the CPT
		$new_jobs = array_filter($jobs, function($job) use ($existing_titles) {
			return !in_array($job['Job_Opening_Name'], $existing_titles);
		});
	
		?>
		<div class="wrap">
			<h1><?php esc_html_e('Sync Jobs', 'hello-elementor-child'); ?></h1>
			<h3><?php esc_html_e('Sync Jobs From Zoho Recruit', 'hello-elementor-child'); ?></h3>
			<?php if ( !empty($new_jobs) ) : ?>
				<table class="widefat fixed" cellspacing="0">
					<thead>
						<tr>
							<th><?php esc_html_e('Job Title', 'hello-elementor-child'); ?></th>
							<th><?php esc_html_e('Location', 'hello-elementor-child'); ?></th>
							<th><?php esc_html_e('Action', 'hello-elementor-child'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($new_jobs as $job) : ?>
							<tr>
								<td><?php echo esc_html($job['Job_Opening_Name']); ?></td>
								<td><?php echo esc_html($job['State']) . ', ' . esc_html($job['Country']); ?></td>
								<td><a href="javascript:void(0);" class="page-title-action sync-single-job"><?php esc_html_e('Sync', 'hello-elementor-child'); ?></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p><?php esc_html_e('No new jobs to sync.', 'hello-elementor-child'); ?></p>
			<?php endif; ?>
		</div>
		<?php
	}
	
}




/**
 * If the function, `bis_sync_single_job` doesn't exist.
 */
if ( ! function_exists( 'bis_sync_single_job' ) ) {
		/**
		 * Sync jobs thorugh sync job custom listing page.
		 *
		 * @since 1.0.0
		*/
	function bis_sync_single_job() {

		// check_ajax_referer('nonce', 'security');
		// Get the job title from the request
		$job_title = sanitize_text_field($_POST['job_title']);

		// Create a new post in the 'jobs' CPT
		$post_id = wp_insert_post([
			'post_title'    => $job_title,
			'post_type'     => 'jobs',
			'post_status'   => 'publish',
		]);

		if ($post_id) {
			wp_send_json_success('Job synced successfully.');
		} else {
			wp_send_json_error('Failed to create job post.');
		}
	}

}
add_action('wp_ajax_sync_single_job', 'bis_sync_single_job');