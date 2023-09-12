<?php
function custom_task_post_type() {
    $labels = array(
        'name'                => _x( 'Tasks', 'Post Type General Name', 'employee-onboarding-platform' ),
        'singular_name'       => _x( 'Task', 'Post Type Singular Name', 'employee-onboarding-platform' ),
        'menu_name'           => __( 'Tasks', 'employee-onboarding-platform' ),
        'parent_item_colon'   => __( 'Parent Task', 'employee-onboarding-platform' ),
        'all_items'           => __( 'All Tasks', 'employee-onboarding-platform' ),
        'view_item'           => __( 'View Task', 'employee-onboarding-platform' ),
        'add_new_item'        => __( 'Add New Task', 'employee-onboarding-platform' ),
        'add_new'             => __( 'Add New', 'employee-onboarding-platform' ),
        'edit_item'           => __( 'Edit Task', 'employee-onboarding-platform' ),
        'update_item'         => __( 'Update Task', 'employee-onboarding-platform' ),
        'search_items'        => __( 'Search Tasks', 'employee-onboarding-platform' ),
        'not_found'           => __( 'Not Found', 'employee-onboarding-platform' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'employee-onboarding-platform' ),
    );

    $args = array(
        'label'               => __( 'tasks', 'employee-onboarding-platform' ),
        'description'         => __( 'Tasks for users', 'employee-onboarding-platform' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
        'taxonomies'          => array( 'team' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type( 'task', $args );
}

add_action( 'init', 'custom_task_post_type', 0 );

function custom_company_post_type() {
    $labels = array(
        'name'                => _x( 'Company', 'Post Type General Name', 'employee-onboarding-platform' ),
        'singular_name'       => _x( 'Company', 'Post Type Singular Name', 'employee-onboarding-platform' ),
        'menu_name'           => __( 'Companies', 'employee-onboarding-platform' ),
        'parent_item_colon'   => __( 'Parent Company', 'employee-onboarding-platform' ),
        'all_items'           => __( 'All Companies', 'employee-onboarding-platform' ),
        'view_item'           => __( 'View Company', 'employee-onboarding-platform' ),
        'add_new_item'        => __( 'Add New Company', 'employee-onboarding-platform' ),
        'add_new'             => __( 'Add New', 'employee-onboarding-platform' ),
        'edit_item'           => __( 'Edit Company', 'employee-onboarding-platform' ),
        'update_item'         => __( 'Update Company', 'employee-onboarding-platform' ),
        'search_items'        => __( 'Search Companies', 'employee-onboarding-platform' ),
        'not_found'           => __( 'Not Found', 'employee-onboarding-platform' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'employee-onboarding-platform' ),
    );

    $args = array(
        'label'               => __( 'companies', 'employee-onboarding-platform' ),
        'description'         => __( 'Companies for the employee onboarding platform', 'employee-onboarding-platform' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
        'taxonomies'          => array( 'team' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type( 'company', $args );
}

add_action( 'init', 'custom_company_post_type', 0 );

function custom_team_post_type() {
    $labels = array(
        'name'                => _x( 'Teams', 'Post Type General Name', 'employee-onboarding-platform' ),
        'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'employee-onboarding-platform' ),
        'menu_name'           => __( 'Teams', 'employee-onboarding-platform' ),
        'parent_item_colon'   => __( 'Parent Team', 'employee-onboarding-platform' ),
        'all_items'           => __( 'All Teams', 'employee-onboarding-platform' ),
        'view_item'           => __( 'View Team', 'employee-onboarding-platform' ),
        'add_new_item'        => __( 'Add New Team', 'employee-onboarding-platform' ),
        'add_new'             => __( 'Add New', 'employee-onboarding-platform' ),
        'edit_item'           => __( 'Edit Team', 'employee-onboarding-platform' ),
        'update_item'         => __( 'Update Team', 'employee-onboarding-platform' ),
        'search_items'        => __( 'Search Teams', 'employee-onboarding-platform' ),
        'not_found'           => __( 'Not Found', 'employee-onboarding-platform' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'employee-onboarding-platform' ),
    );

    $args = array(
        'label'               => __( 'teams', 'employee-onboarding-platform' ),
        'description'         => __( 'Teams for the employee onboarding platform', 'employee-onboarding-platform' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type( 'team', $args );
}

add_action( 'init', 'custom_team_post_type', 0 );

function custom_project_post_type() {
    $labels = array(
        'name'                => _x( 'Projects', 'Post Type General Name', 'employee-onboarding-platform' ),
        'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'employee-onboarding-platform' ),
        'menu_name'           => __( 'Projects', 'employee-onboarding-platform' ),
        'parent_item_colon'   => __( 'Parent Project', 'employee-onboarding-platform' ),
        'all_items'           => __( 'All Projects', 'employee-onboarding-platform' ),
        'view_item'           => __( 'View Project', 'employee-onboarding-platform' ),
        'add_new_item'        => __( 'Add New Project', 'employee-onboarding-platform' ),
        'add_new'             => __( 'Add New', 'employee-onboarding-platform' ),
        'edit_item'           => __( 'Edit Project', 'employee-onboarding-platform' ),
        'update_item'         => __( 'Update Project', 'employee-onboarding-platform' ),
        'search_items'        => __( 'Search Projects', 'employee-onboarding-platform' ),
        'not_found'           => __( 'Not Found', 'employee-onboarding-platform' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'employee-onboarding-platform' ),
    );

    $args = array(
        'label'               => __( 'projects', 'employee-onboarding-platform' ),
        'description'         => __( 'Projects for the employee onboarding platform', 'employee-onboarding-platform' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type( 'project', $args );
}

add_action( 'init', 'custom_project_post_type', 0 );


?>

