<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codeboxr.com/
 * @since             1.0.0
 * @package           CodeboxrFlexibleCountdown
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Flexible CountDown
 * Plugin URI:        https://codeboxr.com/product/cbx-flexible-event-countdown-for-wordpress
 * Description:       Multi style event count down plugin for wordpress
 * Version:           1.8.3
 * Author:            Codeboxr
 * Author URI:        https://codeboxr.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codeboxrflexiblecountdown
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

//plugin definition specific constants
defined('CBFC_PLUGIN_NAME') or define('CBFC_PLUGIN_NAME',
    'codeboxrflexiblecountdown'); //need to define in uninstall also
defined('CBFC_PLUGIN_VERSION') or define('CBFC_PLUGIN_VERSION', '1.8.3'); //need to define in uninstall also
defined('CBFC_PLUGIN_BASE_NAME') or define('CBFC_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
defined('CBFC_PLUGIN_ROOT_PATH') or define('CBFC_PLUGIN_ROOT_PATH', plugin_dir_path(__FILE__));
defined('CBFC_PLUGIN_ROOT_URL') or define('CBFC_PLUGIN_ROOT_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-codeboxrflexiblecountdown-activator.php
 */
function activate_codeboxrflexiblecountdown()
{
    require_once plugin_dir_path(__FILE__).'includes/class-codeboxrflexiblecountdown-activator.php';
    CodeboxrFlexibleCountdown_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-codeboxrflexiblecountdown-deactivator.php
 */
function deactivate_codeboxrflexiblecountdown()
{
    require_once plugin_dir_path(__FILE__).'includes/class-codeboxrflexiblecountdown-deactivator.php';
    CodeboxrFlexibleCountdown_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_codeboxrflexiblecountdown');
register_deactivation_hook(__FILE__, 'deactivate_codeboxrflexiblecountdown');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__).'includes/class-codeboxrflexiblecountdown.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_codeboxrflexiblecountdown()
{

    $plugin = new CodeboxrFlexibleCountdown();
    $plugin->run();

}

run_codeboxrflexiblecountdown();
