<?php

//Change "Add title" in new post input

function change_task_title(){
    $screen = get_current_screen();

    if  ( $screen->post_type == 'tasks' ) {
        return 'Enter New Task Here';
    }
}
add_filter( 'enter_title_here', 'change_task_title' );

//Add Meta Boxes
function add_post_meta_boxes_task() {
    add_meta_box(
        "task_info", // div id containing rendered fields
        "Task Information", // section heading displayed as text
        "post_meta_box_task_info", // callback function to render fields
        "tasks", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
    add_meta_box(
        "task_notes", // div id containing rendered fields
        "Task Notes", // section heading displayed as text
        "post_meta_box_task_notes", // callback function to render fields
        "tasks", // name of post type on which to render fields
        "normal", // location on the screen
        "high" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes_task" );

function save_post_meta_boxes_task(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "task_name", sanitize_text_field( $_POST[ "task_name" ] ) );
    update_post_meta( $post->ID, "assigned_project", sanitize_text_field( $_POST[ "assigned_project" ] ) );
    update_post_meta( $post->ID, "client_name", sanitize_text_field( $_POST[ "client_name" ] ) );
    update_post_meta( $post->ID, "start_date", sanitize_text_field( $_POST[ "start_date" ] ) );
    update_post_meta( $post->ID, "end_date", sanitize_text_field( $_POST[ "end_date" ] ) );
    update_post_meta( $post->ID, "task_notes", sanitize_text_field( $_POST[ "task_notes" ] ) );
}
add_action( 'save_post', 'save_post_meta_boxes_task' );

function post_meta_box_task_info($post)
{
    ?>
    <label for="related_project">Related Project</label>
    <?php wp_dropdown_pages(array('post_type' => 'projects', 'id' => 'assigned_project', 'name' => 'assigned_project')); ?>
    <br>
    <label for="task_name">Assigned To:</label>
    <?php wp_dropdown_users( array( 'role' => 'client', 'name' => 'client_name', 'id' => 'client_name' ) ); ?>
    <br>
    <label for="start_date">Task Start Date</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo get_post_meta($post->ID, 'start_date', true) ?>" />
    <br>
    <label for="start_date">Task End Date</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo get_post_meta($post->ID, 'end_date', true) ?>" />
    <?php
}

function post_meta_box_task_notes($post)
{
    ?>
    <textarea name="project_notes" id="task_notes" cols="60" rows="7"><?php echo get_post_meta($post->ID, 'project_notes', true) ?></textarea>
    <?php
}