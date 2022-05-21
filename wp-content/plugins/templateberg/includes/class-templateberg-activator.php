<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.templateberg.com/
 * @since      1.0.0
 *
 * @package    Templateberg
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Templateberg
 * @author     Templateberg <info@templateberg.com>
 */
class Templateberg_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( '__templateberg_do_redirect', true );
	}
}
