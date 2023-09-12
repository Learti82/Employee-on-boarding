<?php
function load_css() {
	wp_register_style( 'main', get_template_directory_uri() . '/assets/css/main.css', [], 1, 'all' );
	wp_enqueue_style( 'main' );
	wp_enqueue_style( 'profile-styles', get_template_directory_uri() . '/assets/css/profile.css', [], '1.0', 'all' );
}

add_action( 'wp_enqueue_scripts', 'load_css' );


function acf_setup() {
	include_once get_template_directory() . '/includes/custom_acf.php';
	include_once get_template_directory() . '/includes/helpers.php';
	include_once get_template_directory() . '/includes/modules.php';
}

add_action( 'after_setup_theme', 'acf_setup' );

/**  Redirect user to our custom login page  **/
function custom_logout_redirect( $logout_url, $redirect ) {
	return home_url( '/login/' );
}

add_filter( 'logout_redirect', 'custom_logout_redirect', 10, 2 );

/**  Redirect user to our custom login page  **/

function enqueue_custom_scripts() {
	wp_enqueue_script( 'jquery' );
}

function validate_search_query( $query ) {
	if ( is_search() ) {
		if ( strpos( $query->query_vars['s'], 'http://' ) !== false || strpos( $query->query_vars['s'], 'https://' ) !== false ) {
			wp_die( 'Links are not allowed in the search bar!' );
		}
	}
}

add_action( 'pre_get_posts', 'validate_search_query' );


add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );


require_once( get_template_directory() . '/includes/post_types.php' );


function get_module_data() {
	// Check if we have any modules
	if ( have_rows( 'modules' ) ) :

		// Loop through the modules
		while ( have_rows( 'modules' ) ) : the_row();

			// Get the layout name (the module name)
			$layout = get_row_layout();

			// Form the name of the PHP file
			$file_name = get_template_directory() . "/modules/{$layout}.php";

			// Check if the file exists
			if ( file_exists( $file_name ) ) {
				// Include the file
				include( $file_name );
			} else {
				// If the file doesn't exist, display a warning (or handle this situation in a different way if you prefer)
				echo "<p>Warning: Module {$layout} does not have a corresponding PHP file.</p>";
			}

		endwhile;
	else :
		// No modules found
		echo 'No modules found';
	endif;
}

add_action( 'after_setup_theme', 'theme_setup' );
function theme_setup() {
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(array(
		'primary-menu' => 'Primary Menu'
	));
}

function menu_setup(){
	add_theme_support('menus');
}
add_action('after_theme_setup', 'menu_setup');

/** Changing the number of excerpt  */
function custom_excerpt_length( $length ) {
	return 15;
}

add_filter( 'excerpt_length', 'custom_excerpt_length' );
/** Changing the number of excerpt  */


if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		array(
			'key'      => 'group_60f30e5ebd86a',
			'title'    => 'Flexible Content',
			'fields'   => array(
				array(
					'key'     => 'field_60f30e6dbd86b',
					'label'   => 'Modules',
					'name'    => 'modules',
					'type'    => 'flexible_content',
					'layouts' => array(
						// Add your modules/layouts here
						array(
							'key'        => 'layout_cards',
							'name'       => 'cards_module',
							'label'      => 'Cards Module',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'           => 'field_64bc70355e721',
									'label'         => 'Mode',
									'name'          => 'mode',
									'type'          => 'button_group',
									'choices'       => array(
										'manual' => 'Manual',
										'latest' => 'Latest',
									),
									'default_value' => '',
									'return_format' => 'value',
									'allow_null'    => 0,
									'layout'        => 'horizontal',
								),
								array(
									'key'               => 'field_64b9416034783',
									'label'             => 'Select Posts',
									'name'              => 'select_posts',
									'type'              => 'relationship',
									'post_type'         => array(
										0 => 'post',
										1 => 'project',
										2 => 'team',
										3 => 'company',
										4 => 'task',
										5 => 'attachment',
										6 => 'page',
									),
									'filters'           => array(
										0 => 'search',
										1 => 'post_type',
										2 => 'taxonomy',
									),
									'return_format'     => 'object',
									'multiple'          => 1,
									'allow_null'        => 0,
									'ui'                => 1,
									'conditional_logic' => array(
										array(
											array(
												'field'    => 'field_64bc70355e721',
												'operator' => '==',
												'value'    => 'manual',
											),
										),
									),
								),
								array(
									'key'               => 'field_64bc6bf3eea54',
									'label'             => 'Post type name',
									'name'              => 'post_type_name',
									'type'              => 'select',
									'choices'           => array(
										'select'  => 'Select a post',
										'post'    => 'Posts',
										'task'    => 'Tasks',
										'company' => 'Companies',
										'team'    => 'Teams',
										'project' => 'Projects',
									),
									'default_value'     => false,
									'return_format'     => 'value',
									'multiple'          => 0,
									'allow_null'        => 0,
									'ui'                => 0,
									'ajax'              => 0,
									'conditional_logic' => array(
										array(
											array(
												'field'    => 'field_64bc70355e721',
												'operator' => '==',
												'value'    => 'latest',
											),
										),
									),
								),
							),
						),
						// Add the FAQ module layout
						array(
							'key'        => 'layout_faq',
							'name'       => 'faq_module',
							'label'      => 'FAQ Module',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_faq_title',
									'label' => 'FAQ Title',
									'name'  => 'faq_title',
									'type'  => 'text',
								),
								array(
									'key'        => 'field_faq_items',
									'label'      => 'FAQ Items',
									'name'       => 'faq_items',
									'type'       => 'repeater',
									'sub_fields' => array(
										array(
											'key'   => 'field_faq_question',
											'label' => 'Question',
											'name'  => 'question',
											'type'  => 'text',
										),
										array(
											'key'   => 'field_faq_answer',
											'label' => 'Answer',
											'name'  => 'answer',
											'type'  => 'textarea',
										),
									),
								),
							),
						),
						// Add more modules/layouts as needed
						array(
							'key'        => 'layout_content',
							'name'       => 'content_module',
							'label'      => 'Content Module',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_content_editor',
									'label' => 'Content Editor',
									'name'  => 'editor_field',
									'type'  => 'wysiwyg',
								),
							),
						),
						// Add more modules/layouts as needed
						array(
							'key'        => 'layout_video_module',
							'name'       => 'video_module',
							'label'      => 'Video Module',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_video_url',
									'label' => 'Video URL',
									'name'  => 'video_url',
									'type'  => 'url',
								),
							),
						),
						// Add more modules/layouts as needed
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'task',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'company',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'team',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'project',
					),
				),
				// Add more locations as needed
			),
		)
	);
}


//removes the wordpress editor
function remove_editor_support() {
	remove_post_type_support( 'post', 'editor' );
}

add_action( 'init', 'remove_editor_support' );


require_once( get_template_directory() . '/includes/helpers.php' );
require_once( get_template_directory() . '/includes/icon_acf.php' );




// Cover photo ajax
function enqueue_uploader_scripts() {
	if ( is_page_template( 'user-profile.php' ) ) {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );

		wp_localize_script( 'jquery', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_uploader_scripts' );


function save_user_cover_photo() {
	// Ensure the user is logged in
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( 'Not logged in' );
	}

	// Check for the image file
	if ( ! isset( $_FILES['cover_photo'] ) ) {
		wp_send_json_error( 'No file uploaded' );
	}

	$uploadedfile = $_FILES['cover_photo'];

	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile && ! isset( $movefile['error'] ) ) {
		$user_id = get_current_user_id();
		update_user_meta( $user_id, 'cover_photo', $movefile['url'] );
		wp_send_json_success( $movefile['url'] );
	} else {
		wp_send_json_error( $movefile['error'] );
	}
}

add_action( 'wp_ajax_save_user_cover_photo', 'save_user_cover_photo' );

function save_user_profile_image() {
	global $wpdb; // WordPress database connection

	// Ensure the user is logged in
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( 'Not logged in' );
	}

	// Check for the image file
	if ( ! isset( $_FILES['profile_image'] ) ) {
		wp_send_json_error( 'No file uploaded' );
	}

	$uploadedfile     = $_FILES['profile_image'];
	$upload_overrides = array( 'test_form' => false );
	$movefile         = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile && ! isset( $movefile['error'] ) ) {
		$user_id = get_current_user_id();

		// Save to user meta
		update_user_meta( $user_id, 'profile_image', $movefile['url'] );

		// Save to custom table
		$table_name = $wpdb->prefix . "your_table_name"; // make sure to replace 'your_table_name'
		$data       = array( 'image_url' => $movefile['url'] );
		$where      = array( 'user_id' => $user_id );

		$result = $wpdb->update( $table_name, $data, $where );

		if ( $result === false ) {
			wp_send_json_error( 'Error saving to custom table' );
		} else {
			wp_send_json_success( $movefile['url'] );
		}
	} else {
		wp_send_json_error( $movefile['error'] );
	}
}

add_action( 'wp_ajax_save_user_profile_image', 'save_user_profile_image' );

function delete_user_profile_image() {
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( 'Not logged in' );
	}

	$user_id = get_current_user_id();

	// Get the URL of the profile image
	$image_url = get_user_meta( $user_id, 'profile_image', true );

	// Convert the URL to a local path
	$upload_dir = wp_upload_dir();
	$image_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $image_url );

	// Delete the image file from the server
	@unlink( $image_path );

	// Remove the image URL from the user's metadata
	delete_user_meta( $user_id, 'profile_image' );

	wp_send_json_success();
}

add_action( 'wp_ajax_delete_user_profile_image', 'delete_user_profile_image' );

function delete_user_cover_photo() {
	$response = array(
		'success' => false,
		'data'    => 'Something went wrong.'
	);

	// Check if user is logged in
	if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();

		// Delete the user cover photo metadata
		if ( delete_user_meta($user_id, 'cover_photo') ) {
			$response['success'] = true;
			$response['data']    = 'Cover photo deleted successfully.';
		} else {
			$response['data'] = 'Failed to delete cover photo.';
		}
	} else {
		$response['data'] = 'You must be logged in to delete cover photo.';
	}

	// Send JSON response
	echo json_encode($response);
	wp_die();  // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_delete_user_cover_photo', 'delete_user_cover_photo');



function handle_profile_update() {
	if (isset($_POST['updateProfile']) && wp_verify_nonce($_POST['_wpnonce'], 'updateProfile')) {
		$user_id = get_current_user_id();
		$current_user = get_userdata($user_id);

		$firstName = sanitize_text_field($_POST['firstName']);
		$lastName = sanitize_text_field($_POST['lastName']);
		$fullName = sanitize_text_field($_POST['fullName']);
		$email = sanitize_email($_POST['email']);
		$password = $_POST['password'];
		$location = sanitize_text_field($_POST['location']);
		$website = esc_url($_POST['website']);
		$bio = sanitize_textarea_field($_POST['bio']);

		$userdata = array(
			'ID' => $user_id,
		);

		if (!empty($firstName)) {
			$userdata['first_name'] = $firstName;
		}

		if (!empty($lastName)) {
			$userdata['last_name'] = $lastName;
		}

		if (!empty($fullName)) {
			$userdata['display_name'] = $fullName;
		}

		if (!empty($email)) {
			$userdata['user_email'] = $email;
		}

		if (!empty($password)) {
			$userdata['user_pass'] = $password;
		}

		if (!empty($website)) {
			$userdata['user_url'] = $website;
		}

		if (!empty($bio)) {
			$userdata['description'] = $bio;
		}

		$user_id = wp_update_user($userdata);

		if (!empty($location)) {
			update_user_meta($user_id, 'location', $location);
		}

		if (is_wp_error($user_id)) {
			error_log(print_r($user_id, true));
			// There was an error
		} else {
			// Success
		}
	}
}

add_action('init', 'handle_profile_update');

function logout_action() {
	wp_logout();
	wp_die(); // Important to terminate the request properly.
}
add_action('wp_ajax_my_logout_action', 'logout_action');
add_action('wp_ajax_nopriv_my_logout_action', 'my_logout_action'); // For non-logged-in users

function custom_retrieve_password_message($message, $key, $user_login, $user_data)
{
	$reset_link = home_url("reset-password?reset_key=$key&login=" . rawurlencode($user_login));
	$message = "Someone has requested a password reset for the following account:\n\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\n\n";
	$message .= "If this was a mistake, just ignore this email and nothing will happen.\n\n";
	$message .= "To reset your password, visit the following address:\n\n";
	$message .= $reset_link . "\n";

	return $message;
}

add_filter('retrieve_password_message', 'custom_retrieve_password_message', 10, 4);

function change_author_base() {
	global $wp_rewrite;
	$wp_rewrite->author_base = 'employee';
	$wp_rewrite->flush_rules();
}

add_action('init', 'change_author_base');

function add_custom_user_profile_fields($user)
{
	?>
	<h3>Extra Profile Information</h3>
	<table class="form-table">
        <tr>
            <th>
                <label for="position">Position</label>
            </th>
            <td>
                <input type="text" name="position" id="position" value="<?php echo esc_attr(get_the_author_meta('position', $user->ID)); ?>" class="regular-text""><br>
            </td>
        </tr>
	</table>
	<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

function save_custom_user_profile_fields($user_id)
{
	if (!current_user_can('edit_user', $user_id))
		return FALSE;

	if (isset($_POST['position']))
		update_user_meta($user_id, 'position', $_POST['position']);

	update_user_meta($user_id, 'position', $_POST['position']);
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');
