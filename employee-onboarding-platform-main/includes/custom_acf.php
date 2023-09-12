<?php
if (function_exists('acf_add_local_field_group')) {
    function add_custom_roles() {
        add_role('team_leader', 'Team Leader', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => false,
        ));
    
        add_role('developer', 'Developer', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
        ));
    }
    add_action('init', 'add_custom_roles');
    
    function team_has_leader($team_id) {
        $leader_args = array(
            'role' => 'team_leader',
            'meta_query' => array(
                array(
                    'key' => 'user_team',
                    'value' => $team_id,
                    'compare' => 'LIKE',
                ),
            ),
            'number' => 1,
        );
    
        $leader_query = new WP_User_Query($leader_args);
    
        if ($leader_query->results) {
            return true;
        } else {
            return false;
        }
    }    
    
    function prevent_team_with_leader($post_id) {
        if (get_post_type($post_id) === 'team') {
            if (team_has_leader($post_id)) {
                $message = 'This team already has a leader assigned. Please choose a team without a leader.';
                wp_die($message, 'Error', ['response' => 400]);
            }
        }
        return $post_id;
    }
    add_filter('acf/pre_save_post', 'prevent_team_with_leader', 10, 1);
    
    function modify_user_team_relationship_field($args, $field, $post_id) {
        if ($field['key'] === 'field_64ac85eb8101c') {
            if (current_user_can('edit_users')) {
                $user_roles = wp_get_current_user()->roles;
                if (in_array('team_leader', $user_roles)) {
                    $teams_with_leader_args = array(
                        'taxonomy' => 'teams',
                        'meta_query' => array(
                            array(
                                'key' => 'user_team',
                                'compare' => 'EXISTS',
                            ),
                        ),
                    );
                    $teams_with_leader = get_terms($teams_with_leader_args);
    
                    if (!empty($teams_with_leader)) {
                        $args['post__not_in'] = array();
                        $args['post__in'] = wp_list_pluck($teams_with_leader, 'term_id');
                    }
                }
            }
        }
        return $args;
    }    
    
    function exclude_teams_without_leader_filter($args, $field, $post_id) {
        if ($field['key'] === 'field_64ac85eb8101c') {
            // Check if we are editing an existing user
            if ($post_id && get_post_type($post_id) === 'user') {
                $edited_user = get_userdata($post_id);
                $user_roles = $edited_user->roles;
    
                // Check if the edited user has the 'team_leader' role
                if (in_array('team_leader', $user_roles)) {
                    $teams_with_leader_args = array(
                        'role' => 'team_leader',
                        'meta_key' => 'user_team',
                        'meta_compare' => 'EXISTS',
                        'fields' => 'ids',
                    );
                    $teams_with_leader = get_users($teams_with_leader_args);
    
                    if (!empty($teams_with_leader)) {
                        $args['post__not_in'] = $teams_with_leader;
                    }
                }
            } elseif (isset($_POST['role']) && $_POST['role'] === 'team_leader') {
                // Check if we are creating a new user with the 'team_leader' role
                $user_roles = ['team_leader'];
    
                $teams_with_leader_args = array(
                    'role' => 'team_leader',
                    'meta_key' => 'user_team',
                    'meta_compare' => 'EXISTS',
                    'fields' => 'ids',
                );
                $teams_with_leader = get_users($teams_with_leader_args);
    
                if (!empty($teams_with_leader)) {
                    $args['post__not_in'] = $teams_with_leader;
                }
            } elseif (isset($_POST['role']) && $_POST['role'] === 'developer') {
                // Skip the filter for users with the 'developer' role
            }
        }
        return $args;
    }    

    function exclude_teams_without_leader_filter_for_team($args, $field, $post_id) {
        if ($field['key'] === 'field_64ac85eb8101c') {
            // Get all teams
            $all_teams_args = array(
                'post_type' => 'team',
                'posts_per_page' => -1,
            );
    
            $all_teams = new WP_Query($all_teams_args);
    
            if ($all_teams->have_posts()) {
                $teams_with_leader = array();
    
                while ($all_teams->have_posts()) {
                    $all_teams->the_post();
                    $team_id = get_the_ID();
    
                    // Check if the team has a leader
                    if (team_has_leader($team_id)) {
                        $teams_with_leader[] = $team_id;
                    }
                }
    
                // Exclude the teams that already have a leader.
                if (!empty($teams_with_leader)) {
                    $args['post__not_in'] = $teams_with_leader;
                }
            }
    
            wp_reset_postdata();
        }
        return $args;
    }
    add_filter('acf/fields/relationship/query', 'exclude_teams_without_leader_filter_for_team', 10, 3);    
    
    function add_team_leader_status_attribute($field) {
        if ($field['key'] === 'field_64ac85eb8101c') {
            $team_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
            $has_leader = team_has_leader($team_id);
            $field['data-has-leader'] = $has_leader ? 'true' : 'false';
        }
        return $field;
    }
    add_action('acf/load_field', 'add_team_leader_status_attribute');
    
    //Custom Field Group
    acf_add_local_field_group(array(
        'key' => 'group_60f30e5ebd86a',
        'title' => 'Custom Field Group',
        'fields' => array(
            array(
                'key' => 'field_60f30e6dbd86b',
                'label' => 'Editor Field',
                'name' => 'editor_field',
                'type' => 'wysiwyg',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
    ));
    
    //Task Fields
    acf_add_local_field_group(array(
        'key' => 'group_64abcde152497',
        'title' => 'Task Fields',
        'fields' => array(
            array(
                'key' => 'field_64abfae926c0d',
                'label' => 'Task Description',
                'name' => 'description',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_64b6605d723bf',
                'label' => 'Task Image',
                'name' => 'task_image',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
                'preview_size' => 'medium',
            ),
            array(
              'key' => 'field_steps',
              'label' => 'Steps',
              'name' => 'steps',
              'type' => 'repeater',
              'sub_fields' => array(
                  array(
                      'key' => 'field_step_complete',
                      'label' => 'Step Complete',
                      'name' => 'step_complete',
                      'type' => 'true_false',
                      'default_value' => 0,
                  ),
                  array(
                      'key' => 'field_step_description',
                      'label' => 'Step Description',
                      'name' => 'step_description',
                      'type' => 'text',
                  ),
              ),
              'collapsed' => 'field_step_description',
              'layout' => 'table',
          ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'task',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
    //Team Fields
    acf_add_local_field_group(array(
        'key' => 'group_64abce7a88b75',
        'title' => 'Team Fields',
        'fields' => array(
            array(
                'key' => 'field_64ac81a3f537b',
                'label' => 'Tasks',
                'name' => 'tasks_relationship',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'task',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                ),
                'return_format' => 'object',
                'min' => '',
                'max' => '5',
                'elements' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_64d7a8f247ff6',
        'title' => 'Team Description',
        'fields' => array(
            array(
                'key' => 'field_64d7a8f2dc1ac',
                'label' => 'Team Description',
                'name' => 'team_description',
                'aria-label' => '',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'rows' => '',
                'placeholder' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    )); 
    
    //User Team Assignment
    acf_add_local_field_group(array(
        'key' => 'group_64abfc0fda6b8',
        'title' => 'User Team Assigment',
        'fields' => array(
            array(
                'key' => 'field_64ac85eb8101c',
                'label' => 'User Team',
                'name' => 'user_team',
                'aria-label' => '',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'team',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                ),
                'return_format' => 'object',
                'min' => '',
                'max' => '',
                'elements' => '',
                'exclude' => array(),
            ),
            array(
                'key' => 'field_64ac85eb8101d',
                'label' => 'User Name',
                'name' => 'user_name',
                'type' => 'text',
            ),
            array(
                'key' => 'field_64ac85eb8101e',
                'label' => 'User Image',
                'name' => 'user_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'user_form',
                    'operator' => '==',
                    'value' => 'all',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
}

?>