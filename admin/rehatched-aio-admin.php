<?php

include 'settings.php';

//Add Admin Menu Items
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
    add_menu_page( 'WP Freelancer', 'WP Feelancer', 'manage_options', 'wp_freelancer', 'rehatched_admin_page', 'dashicons-admin-site', 6  );
    add_submenu_page( 'wp_freelancer', 'Welcome', 'Welcome', 'manage_options', 'rehatched_admin_welcome', 'rehatched_admin_sub_page' );
    add_submenu_page( 'wp_freelancer', 'Settings', 'Settings', 'manage_options', 'rehatched_admin_settings', 'rehatched_admin_settings_page' );
}

//Admin Pages
function rehatched_admin_page(){
    ?>

    <?php
}

function rehatched_admin_sub_page(){
    ?>
    <div class="wrap">
        <h2>Welcome To My Plugin Sub Page</h2>

    </div>
    <?php
}

