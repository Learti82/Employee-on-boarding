<?php
/*
Template Name: Tasks Template
*/

// Get current user's display name
$current_user = wp_get_current_user();
$user_name    = $current_user->display_name;

get_header();

// Get current user ID
$current_user_id = get_current_user_id();

// Get user's selected team
$user_teams    = get_user_meta( $current_user_id, 'user_team' );
$selected_team = isset( $user_teams[0][0] ) ? $user_teams[0][0] : null;

if ( is_page() ) {
	echo "";
} else {
	?>
    <h2 class="font-bold text-2xl">Hello <?php echo esc_html( $user_name ); ?>, check out these tasks for you:</h2>
	<?php
}


// Check if a team is selected
if ( $selected_team ) {
	// Get the selected tasks for the team using the Relationship field
	$selected_tasks = get_field( 'tasks_relationship', $selected_team );

	if ( $selected_tasks ) {
		?>
        <div class="mx-0 mt-8">

			<?php if ( is_page() ) : ?>
                <section class="page sm-section md-section lg-section">
                <div class="container">
                <h2 class="font-bold text-4xl mt-16 mb-8">Hello <?php echo esc_html( $user_name ); ?>, check out these tasks for you</h2>
				<?php foreach ( $selected_tasks as $selected_task ) {
					// Display each selected task information here
					$task_title       = get_the_title( $selected_task );
					$task_description = get_field( 'description', $selected_task );
					$task_image       = get_field( 'task_image', $selected_task );
					$task_permalink   = get_permalink( $selected_task ); // Get the task's permalink
					// ... (add more fields as needed)
					?>
                    <div class="bg-white shadow-lg overflow-hidden rounded-lg p-3 mb-4 md:flex md:h-44">
						<?php if ( $task_image ) { ?>
                            <div class="mb-4 md:self-start">
                                <img class="object-cover h-32 w-32 mr-4"
                                     src="<?php echo esc_url( $task_image['url'] ); ?>"
                                     alt="<?php echo esc_attr( $task_image['alt'] ); ?>">
                            </div>
						<?php } ?>
                        <div class="flex-grow">
                            <h2 class="text-2xl font-bold text-black mb-2 <?php echo ( $task_image ) ? 'mb-2' : ''; ?>"
                                style="<?php echo ( ! $task_image ) ? 'margin-top: -0.5rem; margin-bottom: 0.25rem;' : ''; ?>">
								<?php echo esc_html( $task_title ); ?>
                            </h2>
                            <p class="text-red-500"><?php echo wpautop( $task_description ); ?></p>
                            <div class="mt-8">
                                <a href="<?php echo esc_url( $task_permalink ); ?>"
                                   class="bg-gray-800 hover:bg-gray-900 text-white px-2 py-1 rounded-md inline-block">Learn
                                    More</a>
                            </div>
                        </div>
                    </div>
				<?php } ?>
                    </div>
                    </section>

			<?php else: ?>
				<?php foreach ( $selected_tasks as $selected_task ) {
					// Display each selected task information here
					$task_title       = get_the_title( $selected_task );
					$task_description = get_field( 'description', $selected_task );
					$task_image       = get_field( 'task_image', $selected_task );
					$task_permalink   = get_permalink( $selected_task ); // Get the task's permalink
					// ... (add more fields as needed)
					?>
                    <div class="bg-white shadow-lg overflow-hidden rounded-lg p-3 mb-4 md:flex md:h-44">
						<?php if ( $task_image ) { ?>
                            <div class="mb-4 md:self-start">
                                <img class="object-cover h-32 w-32 mr-4"
                                     src="<?php echo esc_url( $task_image['url'] ); ?>"
                                     alt="<?php echo esc_attr( $task_image['alt'] ); ?>">
                            </div>
						<?php } ?>
                        <div class="flex-grow">
                            <h2 class="text-2xl font-bold text-black mb-2 <?php echo ( $task_image ) ? 'mb-2' : ''; ?>"
                                style="<?php echo ( ! $task_image ) ? 'margin-top: -0.5rem; margin-bottom: 0.25rem;' : ''; ?>">
								<?php echo esc_html( $task_title ); ?>
                            </h2>
                            <p class="text-red-500"><?php echo wpautop( $task_description ); ?></p>
                            <div class="mt-8">
                                <a href="<?php echo esc_url( $task_permalink ); ?>"
                                   class="bg-gray-800 hover:bg-gray-900 text-white px-2 py-1 rounded-md inline-block">Learn
                                    More</a>
                            </div>
                        </div>
                    </div>
				<?php } ?>
			<?php endif; ?>
        </div>


	<?php } else {
		echo '<p>No tasks selected for the team.</p>';
	}
} else {
	echo '<p>Please select a team in your user settings.</p>';
}

get_footer();
?>

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
