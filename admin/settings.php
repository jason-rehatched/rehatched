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
    ?>
        <h2>WP Freelancer Settings</h2>

        <form method="post" action="options.php">
        <?php settings_fields( 'rehatched_settings' ); ?>
        <table class="form-table">
            <tr>
                <th><label for="registration_key">Registration Key</label></th>
                <td>
                    <input type="text" name="registration_key" id="registration_key" value="<?php echo get_option('registration_key', true); ?>">
                    <span class="description">Registration is limited to one domain</span>
                </td>
            </tr>
            <tr>
                <th><label for="pay_pal_id">PayPal ID</label></th>
                <td>
                    <input type="tel" name="pay_pal_id" id="pay_pal_id" value="<?php echo get_option('pay_pal_id', true); ?>">
                </td>
            </tr>
        </table>
            <button class="btn-sm btn-primary" type="submit">Save Settings</button>
        </form>
    <?php
}