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

require 'admin/profile.php';


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