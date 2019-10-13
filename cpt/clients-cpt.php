<?php

//Setup Clients Custom Post Type

function client_cpt() {
    $supports = array(
        'title', // post title
        'thumbnail', // featured images
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('Clients', 'plural'),
        'singular_name' => _x('client', 'singular'),
        'menu_name' => _x('Clients', 'admin menu'),
        'name_admin_bar' => _x('Clients', 'admin bar'),
        'add_new' => _x('Add New Client', 'add new'),
        'add_new_item' => __('Add New Client'),
        'new_item' => __('New Client'),
        'edit_item' => __('Edit Client'),
        'view_item' => __('View Client'),
        'all_items' => __('Clients'),
        'search_items' => __('Search Clients'),
        'not_found' => __('No clients found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'clients'),
        'has_archive' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-businessperson',
        'show_in_menu' => 'wp_freelancer',
    );
    register_post_type('clients', $args);
}
add_action('init', 'client_cpt');


//Remove Clients Custom Post Type

function clients_cpt_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'clients' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'clients_cpt_deactivation' );