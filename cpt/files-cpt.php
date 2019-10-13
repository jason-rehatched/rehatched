<?php

//Setup Files Custom Post Type

function files_cpt()
{
    $supports = array(
        'title', // post title
        'thumbnail', // featured images
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('Files', 'plural'),
        'singular_name' => _x('File', 'singular'),
        'menu_name' => _x('Files', 'admin menu'),
        'name_admin_bar' => _x('Files', 'admin bar'),
        'add_new' => _x('Add New File', 'add new'),
        'add_new_item' => __('Add New File'),
        'new_item' => __('New File'),
        'edit_item' => __('Edit File'),
        'view_item' => __('View File'),
        'all_items' => __('Files'),
        'search_items' => __('Search Files'),
        'not_found' => __('No Files found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'files'),
        'has_archive' => true,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-media-default',
        'show_in_menu' => 'wp_freelancer'
    );
    register_post_type('files', $args);
}

add_action('init', 'files_cpt');

//Remove Files Custom Post Type

function files_cpt_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'files' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'files_cpt_deactivation' );
