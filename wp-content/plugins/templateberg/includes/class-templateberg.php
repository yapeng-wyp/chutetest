<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used to
 * add/remove/edit the functionality of the Templateberg Plugin
 *
 * @link       https://www.templateberg.com/
 * @since      1.0.0
 *
 * @package    Templateberg
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * functionality of the plugin
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Templateberg
 * @author     Templateberg <info@templateberg.com>
 */
class Templateberg
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Templateberg_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * Full Name of plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_full_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_full_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Main Instance
     *
     * Insures that only one instance of Templateberg exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since    1.0.0
     * @access   public
     *
     * @return object
     */
    public static function instance()
    {

        // Store the instance locally to avoid private static replication
        static $instance = null;

        // Only run these methods if they haven't been ran previously
        if (null === $instance) {
            $instance = new Templateberg();

            do_action('templateberg_loaded');
        }

        // Always return the instance
        return $instance;
    }

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function run()
    {
        if (defined('TEMPLATEBERG_VERSION')) {
            $this->version = TEMPLATEBERG_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name      = TEMPLATEBERG_PLUGIN_NAME;
        $this->plugin_full_name = esc_html__('Templateberg', 'templateberg');

        $this->load_dependencies();
        $this->set_locale();

        $this->define_hooks();
        $this->load_hooks();
    }


    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Templateberg_Loader. Orchestrates the hooks of the plugin.
     * - Templateberg_i18n. Defines internationalization functionality.
     * - Templateberg. Defines all hooks for the admin area.
     * - Templateberg_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        require_once TEMPLATEBERG_PATH . 'includes/class-templateberg-loader.php';

        require_once TEMPLATEBERG_PATH . 'includes/class-templateberg-i18n.php';

        /*Functions*/
        require_once TEMPLATEBERG_PATH . 'includes/functions.php';

        /*Hooks*/
        require_once TEMPLATEBERG_PATH . 'includes/class-templateberg-hooks.php';

        /*Admin*/
        require_once TEMPLATEBERG_PATH . 'includes/admin/class-templateberg-connect.php';

        /*Templates*/
        require_once TEMPLATEBERG_PATH . 'includes/lists/templateberg-template-lists-data.php';
        require_once TEMPLATEBERG_PATH . 'includes/lists/class-templateberg-gutenberg-templates.php';
        require_once TEMPLATEBERG_PATH . 'includes/lists/class-templateberg-themes-template-kits.php';

        /*Rest API*/
        require_once TEMPLATEBERG_PATH . 'includes/admin/class-templateberg-template-api.php';


        $this->loader = new Templateberg_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Templateberg_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Templateberg_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_hooks()
    {

        $plugin_hooks = templateberg_hooks();

        /*Hook : Admin page*/
        $this->loader->add_action('admin_enqueue_scripts', $plugin_hooks, 'admin_scripts');

        /*Hook: Editor assets.*/
        $this->loader->add_action('enqueue_block_editor_assets', $plugin_hooks, 'block_editor_assets');

        $this->loader->add_action('block_categories_all', $plugin_hooks, 'add_block_categories', 9999);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function load_hooks()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Templateberg_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
