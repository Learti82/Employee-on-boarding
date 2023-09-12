<?php
// Assuming this code is in a file named "team_template.php"

$current_user = wp_get_current_user();
$user_teams = get_user_meta($current_user->ID, 'user_team', true);

// Get the team posts
$team_args = array(
    'post_type' => 'team', // Replace with your actual post type slug
    'posts_per_page' => -1, // Retrieve all team posts
    'post__in' => $user_teams,
);

$team_query = new WP_Query($team_args);

// Check if there are team posts
if ($team_query->have_posts()) {
    ?>

    <div class="main-rs flex flex-col h-full bg-inherit hide-on-small">
        <div class="rightsidebar fixed top-0 right-0 h-full" style="margin-top: 60px; border-left: 1px solid rgba(67, 44, 44, 0.24);">
            <?php
            $team_count = 0;
            $remaining_titles = array();

            while ($team_query->have_posts()) {
                $team_query->the_post();

                $title = get_the_title(); // Get the title of the current team post
                $description = get_field('team_description');

                // Display the details of the first team
                if ($team_count === 0) {
                    $team_count++;
                    ?>
                    <div class="p-9 h-full">
                        <?php if ($title || $description) : ?>
                            <h1 class="text-2xl pb-3 text-center uppercase font-normal leading-11 tracking-tighter text-opacity-40 mt-6 " style="color: #242220;font-weight:bold;"><?php echo $title; ?></h1>

                            <?php if ($description) : ?>
                                <div class="description-container font-normal my-4">
                                    <?php
                                    // Calculate the character length for 40% of the description
                                    $character_length = (int)(strlen($description) * 0.4);
                                    $excerpt = substr($description, 0, $character_length);
                                    $remaining_content = substr($description, $character_length);
                                    ?>

                                    <p class="text-sm w-60 text-left min-h-title break-words">
                                        <?php echo $excerpt; ?>
                                        <?php if (strlen($description) > $character_length) : ?>
                                            <span class="read-more-btn">
                                                ...
                                                <button class="text-red-500">Read More</button>
                                            </span>
                                            <span class="full-description hidden">
                                                <?php echo $remaining_content; ?>
                                                <br>
                                                <button class="text-red-500 read-less-btn">Read Less</button>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <!-- Team Members Section -->
                        <div class="my-8 w-full">
                            <h2 class="text-xl mt-4 text-center capitalize font-normal leading-5 text-opacity-20" style="color: #242220;"> Members </h2>
                            <div class="flex items-start mt-4">
                                <?php
                                $developer_args = array(
                                    'role' => 'developer', 
                                    'meta_query' => array(
                                        array(
                                            'key' => 'user_team', 
                                            'value' => get_the_ID(), 
                                            'compare' => 'LIKE',
                                        ),
                                    ),
                                );
                                $developer_query = new WP_User_Query($developer_args);

                                $display_members = 0;
                                foreach ($developer_query->results as $developer) {
                                    if ($display_members >= 3){
                                        break;
                                    }

                                    $developer_id = $developer->ID;
                                    $developer_name = get_field('user_name', 'user_' . $developer_id);
                                    $developer_image = get_field('user_image', 'user_' . $developer_id);

                                    if ($developer_image) {
                                        echo '<div class="w-16 h-16 m-1 rounded-full">';
                                        echo '<img src="' . esc_url($developer_image['url']) . '" alt="' . esc_attr($developer_name) . '" class="w-full h-full rounded-full object-cover">';
                                        echo '</div>';
                                        $display_members++;
                                    }
                                }
                                ?>
                            </div>

                            <!-- Display the number of remaining developer members -->
                            <?php if ($developer_query->total_users > 3) : ?>
                            <span class="rounded-full flex justify-center self-center text-red-500 font-medium text-xl w-16 h-16 m-1" style="background-color: rgba(200, 201, 217, 0.48);">
                                <?php
                                $remaining_members = max(0, $developer_query->total_users - 3);
                                echo esc_html('+' .$remaining_members); 
                                ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <!-- End of Team Members Section -->

                        <!-- Team Leader Section -->
                        <div class="my-8 w-full">
                            <h2 class="text-xl mt-4 text-center capitalize font-normal leading-5 text-opacity-20" style="color: #242220;"> Leader </h2>
                            <div class="flex items-start text-center self-center capitalize font-normal mt-4">
                                <?php
                                // Get a user with the role "Team Leader" who is assigned to the current team
                                $leader_args = array(
                                    'role' => 'team_leader',
                                    'meta_query' => array(  
                                        array(
                                            'key' => 'user_team', 
                                            'value' => get_the_ID(), 
                                            'compare' => 'LIKE', 
                                        ),
                                    ),
                                    'number' => 1,
                                );

                                $leader_query = new WP_User_Query($leader_args);

                                if ($leader_query->results) {
                                    $leader = $leader_query->results[0]; // Get the first (and only) leader
                                    $leader_id = $leader->ID;
                                    $leader_name = get_field('user_name', 'user_' . $leader_id);
                                    $leader_image = get_field('user_image', 'user_' . $leader_id);

                                    if ($leader_image) {
                                        echo '<div class="w-16 h-16 rounded-full m-1 mt-4">';
                                        echo '<img src="' . esc_url($leader_image['url']) . '" alt="' . esc_attr($leader_name) . '" class="w-full h-full rounded-full object-cover">';
                                        echo '</div>';
                                    }

                                    // Display leader's name and role
                                    echo '<div class="ml-5">';
                                    echo '<h3 class="text-lg font-normal text-left">' . esc_html($leader_name) . '</h3>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <!-- End of Team Leader Section -->
                        </div>
                    <?php
                } else {
                    // Store remaining team titles
                    $remaining_titles[] = $title;
                }
            }
            ?>
        </div>
        
        <!-- Display remaining team titles -->
        <div class="remaining-titles p-4 bg-inherit">
            <?php
            foreach ($remaining_titles as $title) {
                echo '<div class="team-title text-center mb-4">';
                echo $title;
                echo '</div>';
            }
            ?>
        </div>
        
    </div>
    <?php
}

// Reset the post data after the loop
wp_reset_postdata();
?>

<script>
    const readMoreButtons = document.querySelectorAll('.read-more-btn');
    readMoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            const container = button.closest('.description-container');
            container.querySelector('.full-description').classList.remove('hidden');
            container.querySelector('.read-less-btn').classList.remove('hidden');
            button.classList.add('hidden');
        });
    });

    const readLessButtons = document.querySelectorAll('.read-less-btn');
    readLessButtons.forEach(button => {
        button.addEventListener('click', () => {
            const container = button.closest('.description-container');
            container.querySelector('.full-description').classList.add('hidden');
            container.querySelector('.read-more-btn').classList.remove('hidden');
            button.classList.add('hidden');
        });
    });

     // Attach an event listener to the "User Team" relationship field
     document.addEventListener('DOMContentLoaded', function () {
        const userTeamField = document.querySelector('[data-key="field_64ac85eb8101c"]');
        const formSubmitButton = document.querySelector('input[type="submit"]');

        if (userTeamField && formSubmitButton) {
            userTeamField.addEventListener('change', function () {
                const selectedTeam = this.querySelector('input[type="hidden"]').value;
                const teamHasLeader = this.getAttribute('data-has-leader') === 'true';

                if (teamHasLeader) {
                    alert('This team already has a leader assigned. Please choose a team without a leader.');
                    this.querySelector('.acf-suggestions').innerHTML = '';
                }
            });

            formSubmitButton.addEventListener('click', function (event) {
                const selectedTeam = userTeamField.querySelector('input[type="hidden"]').value;
                const teamHasLeader = userTeamField.getAttribute('data-has-leader') === 'true';

                if (teamHasLeader) {
                    event.preventDefault(); // Prevent form submission
                    alert('This team already has a leader assigned. Please choose a team without a leader.');
                }
            });
        }
    });
</script>

<style>
    @media (max-width: 1300px) {
        .hide-on-small {
            display: none;
        }
    }
</style>
