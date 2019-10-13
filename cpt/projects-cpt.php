<?php

//Setup Projects Custom Post Type

function project_cpt()
{
    $supports = array(
        'title', // post title
        'revisions', // post revisions
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('Projects', 'plural'),
        'singular_name' => _x('Project', 'singular'),
        'menu_name' => _x('Projects', 'admin menu'),
        'name_admin_bar' => _x('Projects', 'admin bar'),
        'add_new' => _x('Add New Project', 'add new'),
        'add_new_item' => __('Add New Project'),
        'new_item' => __('New Project'),
        'edit_item' => __('Edit Project'),
        'view_item' => __('View Project'),
        'all_items' => __('Projects'),
        'search_items' => __('Search Projects'),
        'not_found' => __('No Projects found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projects'),
        'has_archive' => true,
        'hierarchical' => true,
        'menu_icon' => 'dashicons-clipboard',
        'show_in_menu' => 'wp_freelancer'
    );
    register_post_type('projects', $args);
}

add_action('init', 'project_cpt');

//Remove Projects Custom Post Type

function projects_cpt_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'projects' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'projects_cpt_deactivation' );