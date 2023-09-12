<?php 
get_header();

// Get the team ID for the current post
$team_id = get_the_ID();

// Get the team name
$team_name = get_the_title($team_id);

// Query users associated with the current team
$user_args = array(     
    'meta_query' => array(
        array(
            'key' => 'user_team', 
            'value' => $team_id, 
            'compare' => 'LIKE',
        ),
    ),
);
$user_query = new WP_User_Query($user_args);

?>

<div class="px-16 py-6" style="display: grid; grid-template-columns: 1fr;">
  <h1 class="font-bold text-2xl " style="margin-left: 240px; margin-top: 15px;">Team: <?php echo esc_html($team_name); ?>

    <?php
    $team_leader_found = false;
    foreach ($user_query->get_results() as $user) {
        $user_id = $user->ID;
        $user_display_name = $user->display_name;
        $user_roles = implode(', ', $user->roles);
        $selected_roles = get_user_meta($user_id, 'selected_roles', true); // Get the selected roles for the user
        $selected_team = get_user_meta($user_id, 'selected_team', true); // Get the selected team for the user
        $user_biographical_info = get_the_author_meta('description', $user_id);
        $user_roles = ucfirst($user_roles);
        $user_image_attachment_ids = get_user_meta($user_id, 'user_image', false); // Change 'user_image' to your actual field key

        if ($user_roles === 'Team_leader') {
            // Display Team Leader section
            ?>
    <h3 class="font-bold text-2xl" style="margin-left: 240px; margin-top: 20px; margin-bottom: 15px;">Team Leader</h3>
    <div class="bg-white overflow-hidden"
      style="margin-bottom: 5px; border-radius: 5%; box-shadow: 3px 3px 3px 3px #E0E0E0; width: 400px; height: 550px; margin-left: 230px;">
      <div class="relative" style="height: 200px; margin-top: 12px;">
        <?php foreach ($user_image_attachment_ids as $attachment_id) : ?>
        <?php
                        $image_url = wp_get_attachment_url($attachment_id);
                        if ($image_url) :
                        ?>
        <img class="px-6 absolute w-full h-full object-cover rounded-lg" style="top: 10px; border-radius: 12%;"
          src="<?php echo esc_url($image_url); ?>" alt="">
        <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <br>
      <div class="m-4">
        <p class="font-bold text-xl " style="margin-left: 10px;">
          <?php 
                            if ($user_roles === 'Team_leader') {
                                echo 'Team Leader: ';
                            } else {
                                echo $user_roles . ': ';
                            }
                            echo $user_display_name; 
                        ?>
        </p>
        <br>
        <p class="font-semibold text-gray-500"
          style="margin-top: 30px; margin-left: 10px; font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
          <?php 
                            if ($user_roles === 'team_member') {
                                echo $user_display_name . ', ' . $user_roles;
                            } else {
                                echo 'Description: ' . esc_html($user_biographical_info);
                            }
                        ?>
        </p>
        <br>
        <div class="flex items-center space-x-2 mr-4">
          <div>
            <p class="text-xs text-gray-500" style="margin-left: 10px;  padding-top: 35px;">
              <?php echo $user_display_name; ?>,
              <?php echo ($user_roles === 'Team_leader') ? 'Team Leader' : $user_roles; ?></p>
          </div>
        </div>
      </div>
    </div>
    <?php
            $team_leader_found = true;
        }
    }
    ?>

    <h1 class="font-bold text-2xl" style="margin-left: 240px; position: relative; top: 10px;">Team Members</h1>
    <div class="px-16 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 "style="gap: 20px; margin-left: 165px;">
      <?php
        foreach ($user_query->get_results() as $user) {
            $user_id = $user->ID;
            $user_display_name = $user->display_name;
            $user_roles = implode(', ', $user->roles);
            $selected_roles = get_user_meta($user_id, 'selected_roles', true); // Get the selected roles for the user
            $selected_team = get_user_meta($user_id, 'selected_team', true); // Get the selected team for the user
            $user_biographical_info = get_the_author_meta('description', $user_id);
            $user_roles = ucfirst($user_roles);
            $user_image_attachment_ids = get_user_meta($user_id, 'user_image', false); // Change 'user_image' to your actual field key
            
            if ($user_roles !== 'Team_leader') {
                // Display Team Members section
                ?>
      <div class="bg-white overflow-hidden "
        style="margin-bottom: 50px; border-radius: 5%; box-shadow: 3px 3px 3px 3px #E0E0E0; width: 400px; height: 550px;">
        <div class="relative" style="height: 200px; margin-top: 12px;">
          <?php foreach ($user_image_attachment_ids as $attachment_id) : ?>
          <?php
                            $image_url = wp_get_attachment_url($attachment_id);
                            if ($image_url) :
                            ?>
          <img class="px-6 absolute w-full h-full object-cover rounded-lg" style="top: 10px; border-radius: 12%;"
            src="<?php echo esc_url($image_url); ?>" alt="">
          <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <br>
        <div class="m-4">
          <p class="font-bold text-xl " style="margin-left: 10px;">
            <?php 
                                if ($user_roles === 'Team_leader') {
                                    echo 'Team Leader: ';
                                } else {
                                    echo $user_roles . ': ';
                                }
                                echo $user_display_name; 
                            ?>
          </p>
          <br>
          <p class="font-semibold text-gray-500"
            style="margin-top: 30px; margin-left: 10px; font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
            <?php 
                                if ($user_roles === 'team_member') {
                                    echo $user_display_name . ', ' . $user_roles;
                                } else {
                                    echo 'Description: ' . esc_html($user_biographical_info);
                                }
                            ?>
          </p>
          <br>
          <div class="flex items-center space-x-2 mr-4">
            <div>
              <p class="text-xs text-gray-500" style="margin-left: 10px;  padding-top: 35px;">By:
                <?php echo $user_display_name; ?>,
                <?php echo ($user_roles === 'Team_leader') ? 'Team Leader' : $user_roles; ?></p>
            </div>
          </div>
        </div>
      </div>
      <?php
            }
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>