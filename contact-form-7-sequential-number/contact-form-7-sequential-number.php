<?php
/*
Plugin Name: Contact Form 7 Sequencial Number Generator
Description: Generates sequential number to output in contact form 7 mail
Version: 0.5
License: GPL
Author: Ian Cozens
Author URI: http://www.welldevelopedforu.com
*/
// reference the settings page
require_once("admin-settings.php");

//Function to check option exists in the database

function exist_option( $arg ) {

    global $wpdb;
    $prefix = $wpdb->prefix;
    $db_options = $prefix.'options';
    $sql_query = 'SELECT * FROM ' . $db_options . ' WHERE option_name LIKE "' . $arg . '"';

    $results = $wpdb->get_results( $sql_query, OBJECT );

    if ( count( $results ) === 0 ) {
        return false;
    } else {
        return true;
    }
}
// generate sequential number
function wpcf7_generate_seq_number( $wpcf7_data ) {
$properties = $wpcf7_data->get_properties();

// Set shortcode
$shortcode = '[rand-generator]';

//declare mail properties
$mail = $properties['mail']['body'];
$mail_2 = $properties['mail_2']['body'];
$mailsu_2 = $properties['mail_2']['subject'];
$mailsu = $properties['mail']['subject'];

//Check for shortcode
if( preg_match( "/{$shortcode}/", $mail ) || preg_match( "/[{$shortcode}]/", $mail_2 ) || preg_match( "/[{$shortcode}]/", $mailsu ) || preg_match( "/[{$shortcode}]/", $mailsu_2 ) ) {
//check prefix option exists, if not add new blank option
$prefix_option = 'wpcf7sg_' . $wpcf7_data->id() . '_prefix';
if( exist_option( 'wpcf7sg_' . $wpcf7_data->id() . '_prefix' ) == false ) {
    add_option( $prefix_option ,'',  '', true );
}
// get option by contact form id
$option = 'wpcf7sg_' . $wpcf7_data->id();

// get number and increase by one
$sequence_number = (int)get_option( $option ) + 1;

// update sequence
update_option( $option, $sequence_number );

// get prefix option data
$prefix = get_option( $prefix_option );

//replace shortcode in body
$properties['mail']['body'] = str_replace( $shortcode, $prefix . $sequence_number, $mail );
$properties['mail_2']['body'] = str_replace( $shortcode, $prefix . $sequence_number, $mail_2 );

//replace shortcode in subject
$properties['mail']['subject'] = str_replace( $shortcode, $prefix . $sequence_number, $mailsu );
$properties['mail_2']['subject'] = str_replace( $shortcode, $prefix . $sequence_number, $mailsu_2 );

$wpcf7_data->set_properties( $properties );
}
}
//call before email sent
add_action( 'wpcf7_before_send_mail', 'wpcf7_generate_seq_number' );
