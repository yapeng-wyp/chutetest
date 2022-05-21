<?php
/**If this file is called directly, abort.*/
if (! defined('WPINC')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/**
 *
 * @link              https://www.templateberg.com/
 * @since             1.0.0
 * @package           Templateberg
 *
 * @wordpress-plugin
 * Plugin Name:       Templateberg - Gutenberg Templates, WordPress Themes Template Kits & WordPress Templates
 * Description:       Easily Import pre-designed templates with starter content on your website and instantly build an elegant website with WordPress. Templateberg content Gutenberg Templates, Patterns and WordPress Theme Template Kits.
 * Version:           1.1.3
 * Author:            templateberg
 * Author URI:        https://www.templateberg.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       templateberg
 */

/*Define Constants for this plugin*/
define('TEMPLATEBERG_VERSION', '1.1.3');
define('TEMPLATEBERG_PLUGIN_NAME', 'templateberg');
define('TEMPLATEBERG_PATH', plugin_dir_path(__FILE__));
define('TEMPLATEBERG_URL', plugin_dir_url(__FILE__));
define('TEMPLATEBERG_SCRIPT_PREFIX', ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-templateberg-activator.php
 */
function activate_templateberg()
{
    require_once TEMPLATEBERG_PATH . 'includes/class-templateberg-activator.php';
    Templateberg_Activator::activate();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require TEMPLATEBERG_PATH . 'includes/class-templateberg.php';

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-templateberg-deactivator.php
 */
function deactivate_templateberg()
{
    require_once TEMPLATEBERG_PATH . 'includes/class-templateberg-deactivator.php';
    Templateberg_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_templateberg');
register_deactivation_hook(__FILE__, 'deactivate_templateberg');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if (! function_exists('run_templateberg')) {

    function run_templateberg()
    {

        return Templateberg::instance();
    }
    run_templateberg()->run();
}
