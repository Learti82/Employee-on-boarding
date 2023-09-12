<?php
/* Template Name: Custom Reset Password */

global $wpdb;
$errors = new WP_Error();

if (isset($_GET['reset_key'])) {
    $reset_key = sanitize_text_field($_GET['reset_key']);
    $user_login = sanitize_text_field($_GET['login']);
    $user = check_password_reset_key($reset_key, $user_login);

    if ($user && !is_wp_error($user)) {
        if (isset($_POST['reset_password'])) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password === $confirm_password) {
                // Save the new password
                wp_set_password($password, $user->ID);

                // Redirect the user to the login page after successful password reset
                wp_redirect(home_url('/login/'));
                exit;
            } else {
                $errors->add('invalid_password', 'Passwords do not match');
            }
        }
    } else {
        $errors->add('invalid_key', 'Invalid reset key or user login');
    }
}

get_header();
?>
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="flex flex-col-reverse md:flex-row w-full max-w-screen-md mx-auto bg-white shadow-lg rounded overflow-hidden">
      <!-- Login Form -->
      <div class="w-full md:w-1/2 p-6 border-gray-300 md:pl-4 md:pr-7">
        <div class="text-center mb-5">
          <h3 class="text-2xl font-bold">Reset your password</h3>
        </div>
        <form method="post" class="space-y-6">
          <div>
            <label class="block" for="password">New Password</label>
            <input type="password" name="password" id="password" placeholder="New password" required
              class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-red-600">
          </div>
          <div>
            <label class="block" for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required
              class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-red-600">
          </div>
          <input type="hidden" name="user_login" value="<?php echo esc_attr($_GET['login']); ?>">
          <input type="hidden" name="reset_key" value="<?php echo esc_attr($reset_key); ?>">
          <?php
                    if ($errors->get_error_code()) {
                        echo '<div class="text-sm text-red-600"><p>' . $errors->get_error_message($errors->get_error_code()) . '</p></div>';
                    }
                    ?>
          <button type="submit" name="reset_password"
            class="w-full px-6 py-2 text-white bg-red-600 rounded-lg hover:bg-red-900">Reset my
            password</button>
        </form>
      </div>

      <!-- Separator Line with Padding on Both Sides (Hidden for Mobile) -->
      <div class="hidden md:block bg-gray-300 h-72" style="width: 2px"></div>

      <!-- Company Image -->
      <?php
            $site_logo = get_field('site_logo', 'option');
            if (empty($site_logo)) {
                $defaultLogoUrl = get_template_directory_uri() . '/images/starlabs.png';
                $site_logo = $defaultLogoUrl;
            }
            ?>
      <div class="w-full md:w-1/2 p-6 flex items-center justify-center md:pl-4 md:pr-7 mobile-image-order">
        <img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
          class="w-2/3 h-auto rounded-lg"> <!-- Adjusted width to 5/6 -->
      </div>
    </div>
  </div>
</section>
<?php
if ($errors->get_error_code()) {
    echo '<p class="text-red-600">' . $errors->get_error_message($errors->get_error_code()) . '</p>';
} else {
    echo '<p class="text-red-600">Invalid password reset link.</p>';
}

get_footer();
?>