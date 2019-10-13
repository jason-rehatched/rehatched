<?php

/*
  Plugin name: Rehatched AOI
  Plugin URI: http://rehatched.com
  Description: Extensive AIO Developer Management Plugin
  Author: Rehatched
  Author URI: http://rehatched.com
  Version: 1.0
  */

require 'cpt/projects-cpt.php';
require 'cpt/invoices-cpt.php';
require 'cpt/files-cpt.php';
require 'cpt/tasks-cpt.php';

require 'functions/client-cpt-functions.php';
require 'functions/projects-cpt-functions.php';
require 'functions/tasks-cpt-functions.php';
require 'functions/invoices-cpt-functions.php';

require 'admin/js/scripts.php';


//Add New Roles
function add_roles_on_plugin_activation() {
    add_role( 'client', 'Client', array( 'read' => true, 'edit_posts' => true, 'delete_posts' => false ) );
    add_role( 'contractor', 'Contractor', array( 'read' => true, 'edit_posts' => false, 'delete_posts' => false ) );
    add_role( 'team_member', 'Team Member', array( 'read' => true, 'edit_posts' => true, 'delete_posts' => false ) );
}
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

if ( is_admin() ) {
    // we are in admin mode
    require_once( dirname( __FILE__ ) . '/admin/rehatched-aio-admin.php' );
}

function media_uploader_enqueue() {
    wp_enqueue_media();
    wp_register_script( 'media-uploader', plugins_url( 'public/js/media-uploader.js' , __FILE__ ) );
    wp_enqueue_script( 'media-uploader');
}
add_action( 'admin_enqueue_scripts', 'media_uploader_enqueue');

function clientInfoForms($user) {
    ?>
    <h2>Client Info</h2>
    <table class="form-table">
        <tr>
            <th><label for="acquired_from">Acquired From</label></th>
            <td>
                <input type="text" name="acquired_from" id="acquired_from" value="<?php echo esc_attr(get_user_meta($user->ID, 'acquired_from', true)); ?>">
                <!--                <span class="description">Some description to the input</span>-->
            </td>
        </tr>
        <tr>
            <th><label for="client_tel">Phone Number</label></th>
            <td>
                <input type="tel" name="client_tel" id="client_tel" value="<?php echo esc_attr(get_user_meta($user->ID, 'client_tel', true)); ?>">
<!--                <span class="description">Some description to the input</span>-->
            </td>
        </tr>
        <tr>
            <th><label for="client_address">Client Address</label></th>
            <td>
                <textarea name="client_address" id="v" cols="30" rows="10"><?php echo esc_attr(get_user_meta($user->ID, 'client_address', true)); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'clientInfoForms'); // editing your own profile
add_action('edit_user_profile', 'clientInfoForms'); // editing another user
add_action('user_new_form', 'clientInfoForms'); // creating a new user

function clientInfoFormsSave($userId) {
    if (!current_user_can('edit_user', $userId)) {
        return;
    }

    update_user_meta($userId, 'client_tel', $_REQUEST['client_tel']);
    update_user_meta($userId, 'acquired_from', $_REQUEST['acquired_from']);
    update_user_meta($userId, 'client_address', $_REQUEST['client_address']);
}
add_action('personal_options_update', 'clientInfoFormsSave');
add_action('edit_user_profile_update', 'clientInfoFormsSave');
add_action('user_register', 'clientInfoFormsSave');