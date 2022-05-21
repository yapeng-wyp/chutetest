<?php
/**
 * Templateberg Gutenberg Templates
 *
 * @since 1.0.4
 */

if (! class_exists('Templateberg_Gutenberg_Templates')) {
    /**
     * Class Templateberg_Gutenberg_Templates.
     */
    class Templateberg_Gutenberg_Templates
    {

        private static $page_slug = 'templateberg-gutenberg-templates';

        /**
         * Main Templateberg_Gutenberg_Templates Instance
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @return object $instance Templateberg_Gutenberg_Templates Instance
         */
        public static function instance()
        {

            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if (null === $instance) {
                $instance              = new Templateberg_Gutenberg_Templates();
            }

            // Always return the instance
            return $instance;
        }

        /**
         * Get Slug
         *
         * @since 1.0.4
         */
        public function get_slug()
        {
            return self::$page_slug;
        }

        /**
         * Run the method
         *
         * @since 1.0.0
         */
        public function run()
        {

            add_action('admin_menu', array( __CLASS__, 'admin_pages' ), 99);
        }

        /**
         * Admin Page Menu and submenu page
         *
         * @since 1.0.0
         */
        public static function admin_pages()
        {

            add_submenu_page(
                templateberg_connect()->get_slug(),
                esc_html__('Gutenberg Templates', 'templateberg'),
                esc_html__('Gutenberg Templates', 'templateberg'),
                'manage_options',
                self::$page_slug,
                array( __CLASS__, 'gutenberg_templates' )
            );
        }


        /**
         * Load account templates
         *
         * @since 1.0.0
         */
        public static function gutenberg_templates()
        {
            ?>
            <div class="tb-gutenberg-templates" style="display: none">
                <?php
                require_once TEMPLATEBERG_PATH . 'includes/lists/templates/gutenberg.php';
                ?>
            </div>
            <?php
        }
    }
}

/**
 * Begins execution of the hooks.
 *
 * @since    1.0.0
 */
function templateberg_gutenberg_templates()
{
    return Templateberg_Gutenberg_Templates::instance();
}
templateberg_gutenberg_templates()->run();
