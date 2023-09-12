<?php
    function redirect_to_custom_login_page() {
        if (
            strpos($_SERVER['REQUEST_URI'], 'wp-admin') === false
            && $_SERVER['PHP_SELF'] != "/wp-login.php"
            && $_SERVER['REQUEST_METHOD'] == 'GET'
            && !is_user_logged_in()
            && strpos($_SERVER['REQUEST_URI'], '/home') === false
        ) {
            wp_redirect(site_url("/home"));
            exit;
        }
    }

    add_action('init', 'redirect_to_custom_login_page');

    function custom_reset_password_page() {
        if (isset($_GET['reset_key']) && isset($_GET['login'])) {
            $user_login = sanitize_text_field($_GET['login']);
            $reset_key = $_GET['reset_key'];
    
            $user = check_password_reset_key($reset_key, $user_login);
    
            if ($user && !is_wp_error($user)) {
                // Redirect to the custom reset password page
                wp_redirect(home_url('/resetpassword/?reset_key=' . $reset_key . '&login=' . $user_login));
                exit;
            } else {
                echo '<p>Invalid reset key or user login</p>';
            }
        }
    }    

    // Add the custom reset password form to the login page
    function add_custom_reset_password_form_to_login() {
        // Only add the custom reset password form to the login page
        if (
            strpos($_SERVER['REQUEST_URI'], '/login/') !== false
            && !is_user_logged_in()
            && isset($_GET['action']) // Check for the reset password action
            && $_GET['action'] === 'rp'
        ) {
            add_filter('login_form_bottom', 'custom_reset_password_form');
        }
    }

    add_action('login_enqueue_scripts', 'add_custom_reset_password_form_to_login');

    // Remove the shortcode and add the reset password form directly to the login page
    remove_shortcode('custom_reset_password');
    add_action('login_form_bottom', 'custom_reset_password_page');

    add_action('wp_login', 'my_login_redirect', 10, 2);
    function my_login_redirect($user_login, $user) {
        // When a user logs in, redirect them to the homepage
        if (strpos($_SERVER['HTTP_REFERER'], 'wp-login') !== false) {
            wp_redirect(admin_url()); // If logging in from WP login, redirect to admin dashboard
        } else {
            wp_redirect(home_url()); // If logging in from custom login, redirect to home
        }
        exit();
    }

    add_action('init', 'allow_admin_access');
    function allow_admin_access() {
        // If a user is trying to access /wp-admin and they're already logged in
        if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false && is_user_logged_in()) {
            // Allow them access
            return;
        } else if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false) {
            // If a user is trying to access /wp-admin but they're not logged in, redirect them to the custom login page
            auth_redirect(); // This will redirect to wp-login.php if the user is not logged in.
        }
    }

    add_action('wp_logout', 'my_logout_redirect');
    function my_logout_redirect() {
        // When a user logs out, redirect them to the custom login page
        wp_redirect(home_url('/login/'));
        exit();
    }

    add_filter('retrieve_password_message', 'modify_reset_password_link', 10, 4);
    function modify_reset_password_link($message, $key, $user_login, $user_data) {
        if (strpos($message, 'action=rp&key=') !== false) {
            // Modify the link to point to your custom reset password page
            $reset_url = home_url('/resetpassword/');
            $reset_url = add_query_arg(array('action' => 'rp', 'key' => $key, 'login' => $user_login), $reset_url);

            // Properly encode the URL only once
            $reset_url = esc_url_raw($reset_url);

            // Replace the original reset password link with the modified reset password link
            $message = str_replace(network_site_url('wp-login.php', 'login'), $reset_url, $message);
        }
        return $message;
    }
?>