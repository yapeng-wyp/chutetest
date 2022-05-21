<?php
/**
 * Templateberg Theme Templates
 *
 * @since 1.0.4
 */

if (! class_exists('Templateberg_Theme_Templates')) {
    /**
     * Class Templateberg_Theme_Templates.
     */
    class Templateberg_Theme_Templates
    {

        private static $page_slug = 'templateberg-themes-template-kits';

        /**
         * Main Templateberg_Theme_Templates Instance
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @return object $instance Templateberg_Theme_Templates Instance
         */
        public static function instance()
        {

            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if (null === $instance) {
                $instance              = new Templateberg_Theme_Templates();
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
            add_filter('advanced_import_current_url', array( $this, 'alter_url' ), 99, 2);
            add_action('admin_init', array( $this, 'admin_only' ), -10);
            add_filter('advanced_import_menu_hook_suffix', array( $this, 'add_hook_suffix' ), 99);
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
                esc_html__('Themes Template Kits', 'templateberg'),
                esc_html__('Themes Template Kits', 'templateberg'),
                'manage_options',
                self::$page_slug,
                array( __CLASS__, 'theme_templates' )
            );
        }


        public function is_selected_theme()
        {
            if (isset($_GET['type']) && 'selected' === $_GET['type'] && isset($_GET['theme']) && isset($_GET['slug'])) {
                return true;
            }
            return false;
        }
        /**
         * Load account templates
         *
         * @since 1.0.0
         */
        public static function theme_templates()
        {
            $active = isset($_GET['type']) && $_GET['type']?$_GET['type']:'current';
            ?>
            <div class="tb-themes-template-kits" style="display: none">
                <div class="tb-list__theme_type_header">
                    <div class="tb-list__theme_type_links">
                        <a href="#"
                           class="tb-list__current_theme tb-list__theme_type-btn tb-list__theme_type
                           <?php echo $active==='current'?'tb-list__theme_type-btn-active':''?>"
                           data-type="current"
                        >
                            <i class="dashicons dashicons-admin-appearance"></i>
                            <?php
                            printf(esc_html__('%s Theme Template Kits', 'templateberg'), wp_get_theme()) . '</h1>';
                            ?>
                        </a>
                        <?php
                        if (templateberg_theme_templates()->is_selected_theme()) {
                            ?>
                            <a href="#"
                               class="tb-list__current_theme tb-list__theme_type-btn tb-list__theme_type tb-list__theme_type-btn-active"
                               data-type="selected"
                            >
                                <i class="dashicons dashicons-admin-appearance"></i>
                                <?php
                                printf(esc_html__('%s Theme Template Kits', 'templateberg'), esc_html($_GET['theme'])) . '</h1>';
                                ?>
                            </a>
                            <?php
                        }
                        ?>
                        <a
                                href="#"
                                class="tb-list__available_theme tb-list__theme_type-btn tb-list__theme_type
                                <?php echo $active==='available'?'tb-list__theme_type-btn-active':''?>"
                                data-type="available"
                        >
                            <i class="dashicons dashicons-grid-view"></i>
                        <?php
                        esc_html_e('Available Template Kits', 'templateberg');
                        ?>
                        </a>
                    </div>
                </div>
                <!--if( tempaltebergGetUrlParameter('type') &&
            tempaltebergGetUrlParameter('theme') &&
            tempaltebergGetUrlParameter('slug')
        )-->
                <?php
                if ($active==='available') {
                    require_once TEMPLATEBERG_PATH . 'includes/lists/templates/theme.php';
                } elseif (templateberg_theme_templates()->is_selected_theme()) {
                    require_once TEMPLATEBERG_PATH . 'includes/lists/templates/current-theme.php';
                } else {
                    require_once TEMPLATEBERG_PATH . 'includes/lists/templates/current-theme.php';
                }
                ?>

            </div>
            <?php
        }

        public function alter_url($current_url, $pagenow)
        {

            if ((get_current_screen() && get_current_screen() ->base === 'templateberg_page_'.templateberg_theme_templates()->get_slug()) ||
                    (isset($_GET['page']) && self::$page_slug === $_GET['page'])
            ) {
                $current_url = admin_url('admin.php?page='.templateberg_theme_templates()->get_slug());
                if (isset($_GET['type'])) {
                    $current_url = $current_url.'&type='.$_GET['type'];
                }
            }
            return $current_url;
        }

        public function admin_only()
        {
            $template    = get_option('template');
            add_filter('advanced_import_' . $template . '_required_plugins', array( $this, 'add_plugins' ), 99, 2);
        }

        public function add_plugins($plugins)
        {
            $plugins[] = 'gutentor/gutentor.php';
            $plugins[] = 'templateberg/templateberg.php';
            return $plugins;
        }

        public function add_hook_suffix($hook_suffix)
        {
            $hook_suffix[] = 'templateberg_page_'.self::$page_slug;
            return $hook_suffix;
        }
    }
}

/**
 * Begins execution of the hooks.
 *
 * @since    1.0.0
 */
function templateberg_theme_templates()
{
    return Templateberg_Theme_Templates::instance();
}
templateberg_theme_templates()->run();
