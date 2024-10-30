<?php
/*
Plugin Name: Mailchimp for Shopified
Plugin URI: http://wordpress.org/plugins/mailchimp-for-shopified/
Author: Jascha Burmeister
Author URI: http://www.wortbildton.de
Version: 1.2
Description: This plugin extends the checkout process of the shopified plugin with an option to subscribe newsletter.
License: GPLv2
*/


session_start();

// -------------------------
// Newsletter Checkbox Hook
// -------------------------

function theme_name_scripts() {

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'mailchimp_shopified', plugin_dir_url( __FILE__ ) . 'js/main.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );


// -----------
// Admin Menu
// -----------

function menu(){
    add_options_page('MS Options', 'Mailch. Shopified', 'manage_options', 'mailchimp-shopified-menu', 'plugin_options');
    add_action( 'admin_init', 'register_mysettings' );
}

add_action('admin_menu','menu');


// -------------
// Options Page
// -------------

function plugin_options(){
    include('admin/admin.php');
}

// ---------
// Settings
// ---------

function register_mysettings() {
	//register our settings
	register_setting( 'mcsf-settings-group', 'mcsf_api_key' );
	register_setting( 'mcsf-settings-group', 'mcsf_list_id' );
	register_setting( 'mcsf-settings-group', 'mcsf_checkbox_text' );
	//register_setting( 'mcsf-settings-group', 'option_etc' );
}

// -----
// Main
// -----

function main(){
	global $wpdb;

	require_once('include/MailChimp.php');

	$newsletter = $_SESSION['newsletter'];



	if(is_user_logged_in()) {
			
		$user_id = get_current_user_id();

		$user_calls = $wpdb->get_results("SELECT * FROM " . CUSTOMERS . " JOIN " . USERS . " ON " . CUSTOMERS . ".user_id = " . USERS . ".ID WHERE " . USERS . ".ID = '$user_id'");

		foreach ($user_calls as $user_call) {	
			$name = $user_call->customer_name;
			$mail = $user_call->user_email;
			$street = $user_call->customer_street;
			$number = $user_call->customer_number;
			$postal = $user_call->customer_postal;
			$city = $user_call->customer_city;
			$country_id = $user_call->customer_country;
			$country = get_country($country_id);
			$billing_name = $user_call->billing_name;
			$billing_street = $user_call->billing_street;
			$billing_number = $user_call->billing_number;
			$billing_postal = $user_call->billing_postal;
			$billing_city = $user_call->billing_city;
			$billing_country_id = $user_call->billing_country;
			$billing_country = get_country($billing_country_id);
		}

	}

	$arr_name = preg_split( "/\s+/", $name);
	$MailChimp = new MailChimp(get_option('mcsf_api_key'));

	if($newsletter == "subscribe")
	{	
		$result = $MailChimp->call('lists/subscribe', array(
		                'id'                => get_option('mcsf_list_id'),
		                'email'             => array('email'=>$mail),
		                'merge_vars'        => array('FNAME'=>$arr_name[0], 'LNAME'=>$arr_name[1]),
		                'double_optin'      => false,
		                'update_existing'   => true,
		                'replace_interests' => false,
		                'send_welcome'      => true,
		            ));
	}

	if($newsletter == "unsubscribe")
	{	
		$result = $MailChimp->call('lists/unsubscribe', array(
		                'id'                => get_option('mcsf_list_id'),
		                'email'             => array('email'=>$mail),
		                'send_goodbye'		=> false,
		            ));
	}
	


}

add_action( 'init', 'main' );


// -------------
// wp-head hook
// -------------

function hook_javascript()
{
	
	$output='<script type="text/javascript"> var mcsf_templateUrl = "'.get_bloginfo("template_url").'"; var mcsf_pluginsUrl = "'.plugins_url().'"; mcsf_pluginDirUrl = "'.plugin_dir_url( __FILE__ ).'";</script>';
	echo $output;
}

add_action('wp_head','hook_javascript');

// test v1.1

?>