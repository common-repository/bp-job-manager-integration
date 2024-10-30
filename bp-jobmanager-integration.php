<?php

/**
 * Plugin Name:       BP Job Manager Integration
 * Plugin URI:        http://kinic.fr
 * Description:       BP Job Manager Integration is based on the Buddypress Geodirectory Integration plugin from MinimalPink and adapted to WP Job Manager.
 * Version:           1.0.0
 * Author:            Damien Boussicut - KINIC
 * Author URI:        http://kinic.fr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       job-manager-integration
  * Domain Path: /languages/
 */

 define ( 'JOB_INTEGRATION_SLUG', 	plugin_basename( __FILE__ )	);
 
/*-----------------------------------------------------------------------------------*/
# Load Text Domain
/*-----------------------------------------------------------------------------------*/
add_action('plugins_loaded', 'bpjm_integration');
function bpjm_integration() {
	load_plugin_textdomain( 'bp-job-manager-integration' , false, dirname( JOB_INTEGRATION_SLUG ).'/languages' );
}

/**
 * Add profile nav and subnav tabs
 */

function add_bpjmi_tabs() {
global $bp;
bp_core_new_nav_item( array(
'name'                  =>  __('Job','bp-job-manager-integration'),
'slug'                  => 'job',
'parent_url'            => $bp->displayed_user->domain,
'parent_slug'           => $bp->profile->slug,
'position'              => 25,
'default_subnav_slug'   => 'job_listings',
'show_for_displayed_user' => false
) );
bp_core_new_subnav_item( array(
'name'              => __('All Jobs','bp-job-manager-integration'),
'slug'              => 'job_listings',
'parent_url'        => trailingslashit( bp_displayed_user_domain() . 'job' ),
'parent_slug'       => 'job',
'screen_function'   => 'bpjmi_screen',
'position'          => 100,
'user_has_access'   => bp_is_my_profile()
) );
bp_core_new_subnav_item( array(
'name'              => __('My jobs','bp-job-manager-integration'),
'slug'              => 'my_jobs',
'parent_url'        => trailingslashit( bp_displayed_user_domain() . 'job' ),
'parent_slug'       => 'job',
'screen_function'   => 'bpjmi_myjob_screen',
'position'          => 200,
'user_has_access'   => bp_is_my_profile()
) );
bp_core_new_subnav_item( array(
'name'              => __('Add Job','bp-job-manager-integration'),
'slug'              => 'add-job',
'parent_url'        =>  trailingslashit( bp_displayed_user_domain() . 'job' ),
'parent_slug'       => 'job',
'screen_function'   => 'bpjmi_addjob_screen',
'position'          => 300,
'user_has_access'   => bp_is_my_profile()
) );
}
add_action( 'bp_setup_nav', 'add_bpjmi_tabs', 20 );

/**
 * Add relavent output for the directory tabs
 */

function bpjmi_screen() {
    add_action( 'bp_template_content', 'bpjmi_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function bpjmi_screen_content() { 
echo '[jobs]'; 
}

function bpjmi_myjob_screen() {
    add_action( 'bp_template_content', 'bpjmi_myjob_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function bpjmi_myjob_screen_content() { 
global $current_user;
      get_currentuserinfo();
	  echo do_shortcode( '[job_dashboard]');
}

function bpjmi_addjob_screen() {
    add_action( 'bp_template_content', 'bpjmi_addjob_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function bpjmi_addjob_screen_content() { 
echo  '[submit_job_form]'; 
}