<?php

require_once(ABSPATH . 'wp-admin/includes/screen.php');

//Change "Add title" in new post input

function change_client_title( $title ){
    $screen = get_current_screen();

    if  ( $screen->post_type == 'clients' ) {
        return 'Enter New Client Here';
    }
}

add_filter( 'enter_title_here', 'change_client_title' );

//Add Meta Boxes
function add_post_meta_boxes() {
    add_meta_box(
        "client_info", // div id containing rendered fields
        "Client Information", // section heading displayed as text
        "post_meta_box_client_info", // callback function to render fields
        "clients", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "client_notes", // div id containing rendered fields
        "Client Notes", // section heading displayed as text
        "post_meta_box_client_notes", // callback function to render fields
        "clients", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes" );

function save_post_meta_boxes(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "client_name", sanitize_text_field( $_POST[ "client_name" ] ) );
    update_post_meta( $post->ID, "client_email", sanitize_text_field( $_POST[ "client_email" ] ) );
    update_post_meta( $post->ID, "client_phone", sanitize_text_field( $_POST[ "client_phone" ] ) );
    update_post_meta( $post->ID, "client_notes", sanitize_text_field( $_POST[ "client_notes" ] ) );
}
add_action( 'save_post', 'save_post_meta_boxes' );

function post_meta_box_client_info($post)
{
    ?>
    <label for="client_name">Name</label>
    <input type="text" id="client_name" name="client_name" value="<?php echo get_post_meta($post->ID, 'client_name', true) ?>">
    <br>
    <label for="client_email">Email</label>
    <input type="email" id="client_email" name="client_email" value="<?php echo get_post_meta($post->ID, 'client_email', true) ?>">
    <br>
    <label for="client_phone">Phone</label>
    <input type="tel" id="client_phone" name="client_phone" value="<?php echo get_post_meta($post->ID, 'client_phone', true) ?>">

    <?php
}

function post_meta_box_client_notes($post)
{
    ?>
    <textarea name="client_notes" id="client_notes" cols="60" rows="7"><?php echo get_post_meta($post->ID, 'client_notes', true) ?></textarea>

    <?php
}


