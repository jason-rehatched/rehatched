<?php

//Setup Invoices Custom Post Type

function invoices_cpt()
{
    $supports = array(
        'title', // post title
        'revisions', // post revisions
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('Invoices', 'plural'),
        'singular_name' => _x('Invoice', 'singular'),
        'menu_name' => _x('Invoices', 'admin menu'),
        'name_admin_bar' => _x('Invoices', 'admin bar'),
        'add_new' => _x('Add New Invoice', 'add new'),
        'add_new_item' => __('Add New Invoice'),
        'new_item' => __('New Invoice'),
        'edit_item' => __('Edit Invoice'),
        'view_item' => __('View Invoice'),
        'all_items' => __('Invoices'),
        'search_items' => __('Search Invoices'),
        'not_found' => __('No Invoices found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'invoices'),
        'has_archive' => true,
        'hierarchical' => true,
        'menu_icon' => 'dashicons-portfolio',
        'show_in_menu' => 'wp_freelancer'
    );
    register_post_type('invoices', $args);
}

add_action('init', 'invoices_cpt');


//Remove Invoices Custom Post Type

function invoices_cpt_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'invoices' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'invoices_cpt_deactivation' );