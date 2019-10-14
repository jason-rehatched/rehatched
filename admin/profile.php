<?php

//Client Profile Additional Fields
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
        <tr>
            <th><label for="client_projects">Client Projects</label></th>
            <td>
                <ul>
                    <?php
                    if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
                        $user_id = get_current_user_id();
                        // If is another user's profile page
                    } elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) {
                        $user_id = $_GET['user_id'];
                    }
                        $args = array(
                            'post_type' => 'projects',
                            'posts_per_page' => -1,
                            'post_status' =>'publish',
                            'meta_value' => $user_id,
                             );
                        $projects = get_posts( $args );
                        if ( $projects ) {
                            foreach ( $projects as $project ) {
                                echo '<li><a href="'. get_permalink($project->ID) .'">'.$project->post_title.'</a></li>';
                            }
                        } ?>
                </ul>
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
