<?php
global $wpdb;

$errors = new WP_Error();

if(isset($_POST['user_login']) && $_POST['user_login']){
	$user_login = trim($_POST['user_login']);

	if(empty($user_login)){
		$errors->add('empty_username', 'Please enter your email address');
	} elseif(!is_email($user_login)) {
		$errors->add('invalid_email', 'Please enter a valid email address');
	} else if(!email_exists($user_login)) {
		$errors->add('invalid_email', 'There is no user registered with that email address');
	} else {
		$retrieve_password = retrieve_password();

		if(is_wp_error($retrieve_password)){
			$errors = $retrieve_password;
		} else {
			$redirect_to = site_url('/login/');
			wp_redirect($redirect_to);
			exit;
		}
	}
}
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
      <!-- Combined Box for Reset Password and Image -->
      <div
        class="flex flex-col-reverse md:flex-row w-full max-w-screen-md mx-auto bg-white shadow-lg rounded overflow-hidden">
        <!-- Login Form -->
        <div class="w-full md:w-1/2 p-6 border-gray-300 md:pl-4 md:pr-7">
          <div class="text-center mb-5">
            <h3 class="text-2xl font-bold">Reset your password</h3>
          </div>
          <form action="" method="post" class="space-y-6">
            <label for="user_login" class="block">Email</label>
            <input type="text" name="user_login" id="user_login" placeholder="Enter your email"
              class="w-full px-4 py-2 border rounded-md focus:ring-1 focus:ring-red-600">

            <?php
            if ($errors->get_error_code()) {
              echo '<div class="text-sm text-red-600"><p>' . $errors->get_error_message($errors->get_error_code()) . '</p></div>';
            }
            ?>

            <div class="flex items-center justify-between mt-2">
              <button class="w-full px-6 py-2 mt-4 text-white bg-red-600 rounded-lg hover:bg-red-900"
                type="submit">Reset my password</button>
            </div>
            <div class="text-sm pt-3">
              <label class="font-medium text-red-600 hover:text-red-600">
                <a href="<?php echo site_url('/home/?forgot_password=false'); ?>">Go to login Page</a>
              </label>
            </div>
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
</body>

</html>