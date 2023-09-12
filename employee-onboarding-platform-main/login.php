<?php
/* Template Name: Custom Login Page */
global $user_ID;
global $wpdb;
$message = '';
$redirect_url = '';

if(!is_user_logged_in()){
	if(isset($_POST['email'], $_POST['password'])){
		$email = $wpdb->prepare($_POST['email']);
		$password = $wpdb->prepare($_POST['password']);

		$login_array = array();
		$login_array['user_login'] = $email;
		$login_array['user_password'] = $password;
		$login_array['remember'] = true;  // Always remember the user.

		$verify_user = wp_signon($login_array, false);

		if(!is_wp_error($verify_user)){
			wp_set_auth_cookie($verify_user->ID, true);  // Set the WP Auth cookie
			$redirect_url = site_url();
		} else{
			$message = "<p>Email or password is incorrect</p>";
		}
	}

}

if (!empty($redirect_url)) {
	wp_redirect($redirect_url);
	exit;
}

get_header();
?>

<?php if(!is_user_logged_in()): ?>
<?php
	if (isset($_GET['forgot_password']) && $_GET['forgot_password'] == 'true') {
        include_once('forgetpassword.php');
    } elseif (isset($_GET['reset_key']) && isset($_GET['login'])) {
        include_once('resetpassword.php');
    } else {
		?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-50 dark:bg-gray-900">
  <section class="bg-gray-50">
    <div class="flex items-center justify-center min-h-screen">
      <!-- Login Form and Company Image Section -->
      <div
        class="flex flex-col-reverse md:flex-row w-full max-w-screen-md mx-auto bg-white shadow-lg rounded overflow-hidden">
        <!-- Login Form -->
        <div class="w-full md:w-1/2 p-6 border-gray-300 md:pl-4 md:pr-7">
          <div class="text-center mb-5">
            <h3 class="text-2xl font-bold">Welcome Back!</h3>
            <p class="text-gray-600">Please enter your details to log in.</p>
          </div>
          <form action="#" method="POST" class="space-y-5">
            <!-- Form Inputs ... -->
            <label for="email" class="block">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address"
              class="w-full px-4 py-2 border rounded-md focus:ring-1 focus:ring-red-600" required>

            <label for="password" class="block">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password"
              class="w-full px-4 py-2 border rounded-md focus:ring-1 focus:ring-red-600" required>

            <div class="flex items-center justify-between mt-2">
              <label class="flex items-center">
                <input name="remember_me" type="checkbox"
                  class="h-4 w-4 text-red-600 focus:ring-red-600 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-900">Remember me</span>
              </label>
              <a href="<?php echo site_url('/login/?forgot_password=true'); ?>"
                class="text-red-600 font-medium hover:text-red-600">Forgot password?</a>
            </div>
            <button type="submit"
              class="w-full px-6 py-2 mt-4 border border-transparent text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-600">
              Sign In
            </button>
          </form>
        </div>
        <!-- Separator Line with Padding on Both Sides (Hidden for Mobile) -->
        <div class="hidden md:block bg-gray-300 h-96" style="width: 2px;"></div>
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
            class="w-1/2 md:w-2/3 h-auto rounded-lg"> <!-- Adjusted width to w-1/2 in desktop view -->
        </div>

      </div>

  </section>
</body>

</html>






<?php } ?>

<?php endif; ?>

<?php get_footer(); ?>