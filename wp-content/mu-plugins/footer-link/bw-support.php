<?php
/**
 * Plugin Name:  	  Footer Link
 * Plugin URI:        https://bestwebsite.com/
 * Description:       Best Website Footer Link
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Best Website Nashville
 * Author URI:        https://bestwebsite.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://bestwebsite.com/
 * Text Domain:       bw-support
*/

if ( ! defined('WPINC') ) {
	die;
}

define( 'BW_SUPPORT_VERSION', '1.0.0' );


if( !function_exists( 'bestwebsite_support_activator' ) ) {
	function bestwebsite_support_activator(){
		#code
	}
	register_activation_hook( __FILE__, 'bestwebsite_support_activator' );
}

if ( !function_exists( 'bestwebsite_support_deactivator' ) ) {
	function bestwebsite_support_deactivator() {
		# code...
	}
	register_deactivation_hook( __FILE__, 'bestwebsite_support_deactivator' );
}

require_once plugin_dir_path( __FILE__ ) .'inc/bw-support.php';

function run_bw_support() {
	$GLOBALS['bw-support'] = new BW_Support();
}
run_bw_support();