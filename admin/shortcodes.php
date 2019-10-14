<?php
//Adding Shortcodes
function sc_client_name(){
    $client = $_POST[ "invoice_client_name" ];
    $nice_name = get_userdata($client);

    return $nice_name->first_name . ' ' . $nice_name->last_name;
}
add_shortcode( 'client', 'sc_client_name' );

function sc_invoice_date()
{
    $date = sanitize_text_field( $_POST[ "due_date" ] );
    $newdate = date("F-j-Y", strtotime($date));

    return $newdate;
}
add_shortcode( 'date', 'sc_invoice_date' );

function sc_invoice_amount()
{
    $amount = sanitize_text_field( $_POST[ "invoice_amount" ] );

    return $amount;

}
add_shortcode( 'amount', 'sc_invoice_amount' );