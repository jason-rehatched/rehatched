<?php

//Change "Add title" in new post input

function change_project_title(){
    $screen = get_current_screen();

    if  ( $screen->post_type == 'projects' ) {
        return 'Enter New Project Here';
    }
}
add_filter( 'enter_title_here', 'change_project_title' );

//Add Complete Button
function top_form_edit_projects($post)
{
    if( 'projects' == $post->post_type )
    {
        echo '<input id="complete_project" class="button button-primary button-large" type="submit" name="complete_project" value="Mark Project Complete">';
    }
}

add_action( 'edit_form_top', 'top_form_edit_projects' );


//Add Meta Boxes
function add_post_meta_boxes_projects() {
    add_meta_box(
        "project_info", // div id containing rendered fields
        "Project Information", // section heading displayed as text
        "post_meta_box_project_info", // callback function to render fields
        "projects", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "project_files", // div id containing rendered fields
        "Project Files", // section heading displayed as text
        "post_meta_box_project_files", // callback function to render fields
        "projects", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "project_invoices", // div id containing rendered fields
        "Project Invoices", // section heading displayed as text
        "post_meta_box_project_invoices", // callback function to render fields
        "projects", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "project_notes", // div id containing rendered fields
        "Project Notes", // section heading displayed as text
        "post_meta_box_project_notes", // callback function to render fields
        "projects", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes_projects" );

function save_post_meta_boxes_projects(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "client_name", sanitize_text_field( $_POST[ "client_name" ] ) );
    update_post_meta( $post->ID, "project_notes", sanitize_text_field( $_POST[ "project_notes" ] ) );
    update_post_meta( $post->ID, "start_date", sanitize_text_field( $_POST[ "start_date" ] ) );
    update_post_meta( $post->ID, "end_date", sanitize_text_field( $_POST[ "end_date" ] ) );
}
add_action( 'save_post', 'save_post_meta_boxes_projects' );

function post_meta_box_project_info($post)
{
    ?>
    <label for="client_name">Client Name</label>
    <?php wp_dropdown_users( array( 'role' => 'client', 'name' => 'client_name', 'id' => 'client_name' ) ); ?>
    <br>
    <label for="start_date">Project Start Date</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo get_post_meta($post->ID, 'start_date', true) ?>" />
    <br>
    <label for="start_date">Project End Date</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo get_post_meta($post->ID, 'end_date', true) ?>" />
    <?php
}

function post_meta_box_project_notes($post)
{
    ?>
    <textarea name="project_notes" id="client_notes" cols="60" rows="7"><?php echo get_post_meta($post->ID, 'project_notes', true) ?></textarea>
    <?php
}

function post_meta_box_project_files($post)
{
    ?>
    <input id="background_image" type="text" name="background_image" value="<?php echo get_option('background_image'); ?>" />
    <input id="upload_image_button" type="button" class="button-primary" value="Upload File" />
    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    $args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' =>'any', 'post_parent' => $post->ID );
    $attachments = get_posts( $args );
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            echo apply_filters( 'the_title' , $attachment->post_title );
            the_attachment_link( $attachment->ID , false );
        }
    }
        endwhile; else : ?>
        <p><?php esc_html_e( 'Sorry, there are no attachments.' ); ?></p>
    <?php endif;
}

function post_meta_box_project_invoices($post)
{
    $mypages = get_pages( array( 'post_type' => 'invoices', 'meta_value' => $post->ID ) );
    foreach( $mypages as $page ) {
        ?>
        <h2><a href="<?php echo get_page_link( $page->ID ); ?>"><?php echo $page->post_title; ?></a></h2>
        <?php
    }
}



