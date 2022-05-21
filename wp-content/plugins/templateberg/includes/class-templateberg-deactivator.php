<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://www.templateberg.com/
 * @since      1.0.0
 *
 * @package    Templateberg
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Templateberg
 * @author     Templateberg <info@templateberg.com>
 */
class Templateberg_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        update_option('__templateberg_do_redirect', false);
    }
}
