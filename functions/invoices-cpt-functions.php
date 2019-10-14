<?php

require_once(ABSPATH . 'wp-admin/includes/screen.php');

//Change Publish Button Text
function change_publish_button( $text ) {
    $screen = get_current_screen();
    if ( $text == 'Publish' && $screen->post_type == 'invoices')     // Your button text
        $text = 'Send Invoice';
    return $text;
}
add_filter( 'gettext', 'change_publish_button', 10, 2 );

//Send Invoice Function
function send_invoice_email()
{
    $client = sanitize_text_field( $_POST[ "client_name" ] );
    $nice_name = get_userdata($client);
    $message = sanitize_text_field( $_POST[ "invoice_message" ] );
    $date = sanitize_text_field( $_POST[ "due_date" ] );
    $amount = sanitize_text_field( $_POST[ "invoice_amount" ] );
    $body = 'Dear ' . $nice_name->first_name . ', '. "\n".'
            You have an invoice in the amount of: $' . $amount . ' due.  
            Please pay the invoice no later than ' . $date . '.' ."\n" . $message;

    wp_mail('jason@rehatched.com', 'Invoice Due', $body);
}
add_action('publish_invoices', 'send_invoice_email');

//Change "Add title" in new post input
function change_invoice_title( $title ){
    $screen = get_current_screen();

    if  ( $screen->post_type == 'invoices' ) {
        return 'Enter New Invoice Here';
    }
}
add_filter( 'enter_title_here', 'change_invoice_title' );

//Add Meta Boxes
function add_post_meta_boxes_invoices() {
    add_meta_box(
        "invoice_info", // div id containing rendered fields
        "Invoice Information", // section heading displayed as text
        "post_meta_box_invoice_info", // callback function to render fields
        "invoices", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "invoice_message", // div id containing rendered fields
        "Invoice Message (To Be Sent)", // section heading displayed as text
        "post_meta_box_invoice_message", // callback function to render fields
        "invoices", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "invoice_notes", // div id containing rendered fields
        "Invoice Notes (Private)", // section heading displayed as text
        "post_meta_box_invoice_notes", // callback function to render fields
        "invoices", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "invoice_project", // div id containing rendered fields
        "Related Project", // section heading displayed as text
        "post_meta_box_invoice_project", // callback function to render fields
        "invoices", // name of post type on which to render fields
        "side", // location on the screen
        "high" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes_invoices" );

function save_post_meta_boxes_invoices(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "client_name", sanitize_text_field( $_POST[ "client_name" ] ) );
    update_post_meta( $post->ID, "due_date", sanitize_text_field( $_POST[ "due_date" ] ) );
    update_post_meta( $post->ID, "invoice_amount", sanitize_text_field( $_POST[ "invoice_amount" ] ) );
    update_post_meta( $post->ID, "invoice_notes", sanitize_text_field( $_POST[ "invoice_notes" ] ) );
    update_post_meta( $post->ID, "invoice_message", sanitize_text_field( $_POST[ "invoice_message" ] ) );
    update_post_meta( $post->ID, "invoice_project", sanitize_text_field( $_POST[ "invoice_project" ] ) );
}
add_action( 'save_post', 'save_post_meta_boxes_invoices' );

function post_meta_box_invoice_info($post)
{
    ?>
    <label for="client_name">Client Name</label>
    <?php wp_dropdown_users( array( 'role' => 'client', 'name' => 'client_name', 'id' => 'client_name' ) ); ?>
    <br>
    <label for="due_date">Due Date</label>
    <input type="date" id="due_date" name="due_date" value="<?php echo get_post_meta($post->ID, 'due_date', true) ?>" />
    <br>
    <label for="invoice_amount">Invoice Amount</label>
    <input type="text" id="invoice_amount" name="invoice_amount" placeholder="$" value="<?php echo get_post_meta($post->ID, 'invoice_amount', true) ?>">
    <?php
}

function post_meta_box_invoice_notes($post)
{
    ?>
    <textarea name="invoice_notes" id="invoice_notes" cols="60" rows="7"><?php echo get_post_meta($post->ID, 'invoice_notes', true) ?></textarea>
    <?php
}

function post_meta_box_invoice_message($post)
{
    ?>
    <textarea name="invoice_message" id="invoice_message" cols="60" rows="7"><?php echo get_post_meta($post->ID, 'invoice_message', true) ?></textarea>
    <?php
}

function post_meta_box_invoice_project()
{
    wp_dropdown_pages(array('post_type' => 'projects', 'name' => 'invoice_project', 'selected' => ''));
}
