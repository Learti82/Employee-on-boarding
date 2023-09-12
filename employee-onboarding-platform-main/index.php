<?php
global $user_ID;

// Check if the user is not logged in
if (!$user_ID) {
	// Redirect to the login page
	wp_redirect(site_url('/login/'));
	exit;
} else {

// If the user is logged in, proceed with the rest of the content:
	get_header();

	echo '
<!DOCTYPE html>
<html>

<head>
    <title>Two Sidebars Layout</title>
    <style>
        <style>
    @media (max-width: 530px) {
        .sm-section {
            width: 80%;
            margin-left: 74px !important;
            padding: 0 1rem;
        }

    }

    @media (max-width: 930px) {
        .md-section {
            width: 90%;
            margin-left: 74px !important;
            padding: 0 1rem;
        }

        .md-section > .container {
            width: 90%;
            margin: 0 auto;
        }
    }

    @media (min-width: 930px) {
        .lg-section {
            width: 85%;
            margin-left: 8rem;
            padding: 0 1rem;
        }

        .lg-section > .container {
            width: 75%;
            margin: 0 auto;
        }
    }

    @media (min-width: 1300px) and (max-width: 1614px) {
        .lg-section {
            padding-right: 8rem;
        }
    }


</style>
</head>

<body style="margin: 0; padding: 0;">

   

<section class="page sm-section md-section lg-section mt-16">
    <div class="container">';
	include('task-tracking-template.php');
	echo '
        </div>
    </div>
</body>

</html>
';

	get_footer();

}