<?php

//Setup Tasks Custom Post Type

function task_cpt()
{
    $supports = array(
        'title', // post title
        'revisions', // post revisions
        'page-attributes',
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('Tasks', 'plural'),
        'singular_name' => _x('Task', 'singular'),
        'menu_name' => _x('Tasks', 'admin menu'),
        'name_admin_bar' => _x('Tasks', 'admin bar'),
        'add_new' => _x('Add New Task', 'add new'),
        'add_new_item' => __('Add New Task'),
        'new_item' => __('New Task'),
        'edit_item' => __('Edit Task'),
        'view_item' => __('View Task'),
        'all_items' => __('Tasks'),
        'search_items' => __('Search Tasks'),
        'not_found' => __('No Tasks found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tasks'),
        'has_archive' => true,
        'hierarchical' => true,
        'menu_icon' => 'dashicons-businessperson',
        'show_in_menu' => 'wp_freelancer',
        
    );
    register_post_type('tasks', $args);
}

add_action('init', 'task_cpt');