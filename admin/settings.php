<?php

//Settings
function rehatched_settings_init()
{
    register_setting('rehatched_settings', 'pay_pal_id');
    register_setting('rehatched_settings', 'registration_key');
}

add_action( 'admin_init', 'rehatched_settings_init' );

function rehatched_admin_settings_page()
{
    /** Register */
    wp_register_style('itg-plugin-page-css', plugins_url('css/bootstrap.min.css', __FILE__));
    /** Enqueue */
    wp_enqueue_style('itg-plugin-page-css');
    ?>
    <div class="container-fluid">
        <h2>WP Freelancer Settings</h2>

        <form method="post" action="options.php">
            <?php settings_fields( 'rehatched_settings' ); ?>
            <div class="form-group col-4">
                <label for="pay_pal_id">Registration Key</label>
                <input type="text" class="form-control" id="registration_key" name="registration_key" aria-describedby="registration_key" value="<?php echo get_option('registration_key'); ?>" placeholder="Registration Key">
                <small id="registration_key" class="form-text text-muted">Registration is limited to one domain</small>
                <label for="pay_pal_id">PayPal ID</label>
                <input type="text" class="form-control" id="pay_pal_id" name="pay_pal_id" aria-describedby="pay_pal_id" value="<?php echo get_option('pay_pal_id'); ?>" placeholder="Enter Your PayPal ID">
                <small id="pay_pal_id" class="form-text text-muted">Enter your PayPal ID</small>
            </div>
            <button class="btn-sm btn-primary" type="submit">Save Settings</button>
        </form>
    </div>
    <?php
}