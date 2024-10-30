<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://codeboxr.com/
 * @since      1.0.0
 *
 * @package    CodeboxrFlexibleCountdown
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


defined('CBFC_PLUGIN_NAME') or define('CBFC_PLUGIN_NAME', 'codeboxrflexiblecountdown');
defined('CBFC_PLUGIN_VERSION') or define('CBFC_PLUGIN_VERSION', '1.7.7');

function codeboxrflexiblecountdown_delete()
{
    if ( ! class_exists('CBFC_Settings_API')) {
        require_once plugin_dir_path(__FILE__).'includes/class-codeboxrflexiblecountdown-setting.php';
    }

    if ( ! class_exists('CBFCHelper')) {
        require_once plugin_dir_path(__FILE__).'includes/class-codeboxrflexiblecountdown-helper.php';
    }

    //global $wpdb;
    $settings = new CBFC_Settings_API();

    $delete_global_config = $settings->get_option('delete_global_config', 'cbfc_tools', 'no');

    if ($delete_global_config == 'yes') {
        $option_prefix = 'cbfc_';

        //delete plugin global options

        $option_values = CBFCHelper::getAllOptionNames();

        foreach ($option_values as $key => $option_value) {
            delete_option($option_value['option_name']);
        }

        do_action('cbfc_plugin_option_delete');


        do_action('cbfc_plugin_uninstall', $option_prefix);
    }
}

codeboxrflexiblecountdown_delete();