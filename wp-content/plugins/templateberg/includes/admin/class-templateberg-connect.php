<?php
/**
 * Templateberg Connect
 *
 * @since 1.0.0
 */

if (! class_exists('Templateberg_Connect')) {
    /**
     * Class Templateberg_Connect.
     */
    class Templateberg_Connect
    {

        private static $page_slug = 'templateberg';
        private static $id = 'templateberg-connect';
        private static $disconnect_id = 'templateberg-disconnect';

        private static $purchase_id = 'templateberg-payments';
        private static $purchase_templates = 'templateberg-purchase-templates';

        const ACCOUNT_URL = 'https://templateberg.com/wp-login.php';
        const TEMPLATE_URL = 'https://templateberg.com/wp-json/connect/v1/get_templates/';

        const PURCHASE_URL = 'https://templateberg.com/wp-json/connect/v1/purchase/';

        const FREE_TEMPLATES_URL = 'https://templateberg.com/wp-json/connect/v1/free_templates/';
        const TEMPLATE_DATA_URL = 'https://templateberg.com/wp-json/connect/v1/get_template_data/';

        /*WordPress Templates*/
        private static $current_theme_purchase_id = 'templateberg-current-theme-payments';
        private static $current_theme_purchase_templates = 'templateberg-current-theme-purchase-templates';
        const GUTENBERG_TEMPLATES_URL = 'https://templateberg.com/wp-json/connect/v1/gutenberg_templates/';
        const THEME_TEMPLATES_URL = 'https://templateberg.com/wp-json/connect/v1/theme_templates/';
        const CURRENT_THEME_TEMPLATES_URL = 'https://templateberg.com/wp-json/connect/v1/current_theme_templates/';
        const CURRENT_THEME_PURCHASE_URL = 'https://templateberg.com/wp-json/connect/v1/purchase_current_theme_demos/';
        const THEME_TEMPLATE_DATA_URL = 'https://templateberg.com/wp-json/connect/v1/get_theme_template_data/';


        /**
         * Main Templateberg_Connect Instance
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @return object $instance Templateberg_Connect Instance
         */
        public static function instance()
        {

            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if (null === $instance) {
                $instance              = new Templateberg_Connect();
            }

            // Always return the instance
            return $instance;
        }

        /**
         * Create nonce
         *
         * @since 1.0.0
         */
        private function create_nonce()
        {
            return wp_create_nonce(self::$id);
        }

        /**
         * Check if user has account
         *
         * @since 1.0.0
         */
        public function has_account()
        {
            if (!get_user_meta(get_current_user_id(), self::$id, true)) {
                return false;
            }
            if (!is_array(maybe_unserialize(get_user_meta(get_current_user_id(), self::$id, true)))) {
                return false;
            }
            return true;
        }

        /**
         * Get Account
         *
         * @since 1.0.0
         */
        public function get_account($add_additional = true)
        {
            $account_info = maybe_unserialize(get_user_meta(get_current_user_id(), self::$id, true));
            if (!$add_additional) {
                return $account_info;
            }
            if (!$account_info) {
                return $account_info;
            }
            $user = wp_get_current_user();

            $additional_info = array(
                'redirect_url' => $this->get_redirect_url(),
                'site_url' => get_site_url(),
                'home_url' => get_home_url(),
                'local-user-id' => absint($user->ID),/*int*/
                'local-user-email' => sanitize_email($user->user_email),/*text*/
            );
            return array_merge(
                $account_info,
                $additional_info
            );
        }

        /**
         * Get Purchase
         *
         * @since 1.0.0
         */
        public function get_purchase()
        {
            return maybe_unserialize(get_user_meta(get_current_user_id(), self::$purchase_id, true));
        }

        /**
         * Set Purchase
         *
         * @since 1.0.0
         */
        public function set_purchase($prepare_data)
        {
            update_user_meta(get_current_user_id(), self::$purchase_id, $prepare_data);
            if (empty($prepare_data)) {
                $this->set_purchase_templates('');
            }
        }

        /**
         * Set Purchase templates
         *
         * @since 1.0.0
         */
        public function set_purchase_templates($templates_list)
        {
            if (is_array($templates_list)) {
                update_user_meta(get_current_user_id(), self::$purchase_templates, $templates_list);
            } else {
                update_user_meta(get_current_user_id(), self::$purchase_templates, '');
            }
        }

        /**
         * Get Purchase Templates ids
         *
         * @since 1.0.0
         */
        public function get_purchase_templates_id()
        {
            $templates_list = $this->get_purchase_templates();
            $all_ids = array();
            if (is_array($templates_list)) {
                foreach ($templates_list as $template) {
                    $all_ids[] = $template['id'];
                }
            }
            return $all_ids;
        }

        /**
         * Get Purchase templates
         *
         * @since 1.0.0
         */
        public function get_purchase_templates()
        {
            return maybe_unserialize(get_user_meta(get_current_user_id(), self::$purchase_templates, true));
        }

        /**
         * Get Free Templates
         *
         * @since 1.0.0
         */
        public function get_free_templates()
        {
            return array(
                array(
                    'title'          => __('Agency', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-10-home-01.jpg',
                ),
                array(
                    'title'          => __('Business', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/medical-template.jpg',
                ),
                array(
                    'title'          => __('Agency', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-03-home.jpg',
                ),
                array(
                    'title'          => __('Business', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-13-home.jpg',
                ),
                array(
                    'title'          => __('Agency', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-12-home.jpg',
                ),
                array(
                    'title'          => __('Business', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-13-home.jpg',
                ),
                array(
                    'title'          => __('Agency', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-10-home-01.jpg',
                ),
                array(
                    'title'          => __('Business', 'templateberg'),
                    'screenshot_url' => TEMPLATEBERG_URL . 'assets/img/cosmoswp_demo-02-home-01.jpg',
                ),
            );
        }

        /**
         * Set Free templates
         *
         * @since 1.0.0
         */
        public function set_free_templates($prepare_data)
        {
            $templates = array();
            if (is_array($prepare_data)) {
                foreach ($prepare_data as $data) {
                    array_push($templates, array(
                        'title'          => $data['title'],
                        'screenshot_url' => $data['screenshot_url'],
                    ));
                }
            }
            set_transient('templateberg_edt_free', $templates);
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
         * Check if current screen
         *
         * @since 1.0.0
         */
        public function is_current_screen()
        {
            if (get_current_screen() ->base === 'toplevel_page_'.self::$page_slug ||
                get_current_screen() ->base === 'templateberg_page_'.templateberg_gutenberg_templates()->get_slug() ||
                get_current_screen() ->base === 'templateberg_page_'.templateberg_theme_templates()->get_slug()
            ) {
                return true;
            }
            return false;
        }

        /**
         * Get Redirect Url
         *
         * @since 1.0.0
         */
        public function get_redirect_url()
        {
            return add_query_arg(array(
                '_wpnonce' => $this->create_nonce(),
            ), get_admin_url());
        }

        /**
         * Get Connect Url
         *
         * @since 1.0.0
         */
        public function get_remote_connect_url($is_reset = false)
        {
            $user = wp_get_current_user();
            return add_query_arg(array(
                'redirect_url' => $this->get_redirect_url(),
                'site_url' => get_site_url(),
                'home_url' => get_home_url(),
                'email' => $user->user_email,
                'from' => isset($_GET['page']) && 'templateberg' === $_GET['page']?'tb-dashboard':'wp-dashboard',
                'reset' =>$is_reset
            ), self::ACCOUNT_URL);
        }

        /**
         * Get Disconnect Url
         *
         * @since 1.0.0
         */
        public function get_remote_disconnect_url()
        {
            return add_query_arg(array(
                '_wpnonce' => $this->create_nonce(),
                self::$disconnect_id => 'templateberg.com',
                'user-id' => get_current_user_id(),
            ), get_admin_url());
        }

        /**
         * Get Templates Url
         *
         * @since 1.0.0
         */
        public function get_template_url($paged = 1)
        {
            if (!templateberg_connect()->has_account()) {
                return false;
            }
            return add_query_arg(array(
                'account'=>templateberg_connect()->get_account(),
                'paged'=>$paged
            ), self::TEMPLATE_URL);
        }

        /**
         * Get Purchase Url
         *
         * @since 1.0.0
         */
        public function get_purchase_url()
        {
            if (!templateberg_connect()->has_account()) {
                return false;
            }
            return add_query_arg(array(
                'account'=>templateberg_connect()->get_account(),
                'theme'=>templateberg_get_current_theme_info(),
            ), self::PURCHASE_URL);
        }

        /**
         * Get Free Purchase Url
         *
         * @since 1.0.0
         */
        public function get_free_templates_url()
        {
            return self::FREE_TEMPLATES_URL;
        }

        /**
         * Get Template Data Url
         *
         * @since 1.0.0
         */
        public function get_template_data_url($template)
        {
            if (!templateberg_connect()->has_account()) {
                return false;
            }
            return add_query_arg(array(
                'account'   =>templateberg_connect()->get_account(),
                'template' =>$template
            ), self::TEMPLATE_DATA_URL);
        }

        /**
         * Get Gutenberg Templates Url
         *
         * @since 1.0.4
         */
        public function get_gutenberg_tempaltes_url($paged = 1)
        {
            if (!templateberg_connect()->has_account()) {
                return add_query_arg(
                    array(
                        'paged'=>$paged
                    ),
                    self::GUTENBERG_TEMPLATES_URL
                );
            }
            return add_query_arg(
                array(
                    'paged'=>$paged,
                    'account'=>templateberg_connect()->get_account(),
                ),
                self::GUTENBERG_TEMPLATES_URL
            );
        }

        /**
         * Get Themes Templates Url
         *
         * @since 1.0.4
         */
        public function get_theme_tempaltes_url($paged = 1)
        {
            if (!templateberg_connect()->has_account()) {
                return add_query_arg(
                    array(
                        'paged'=>$paged
                    ),
                    self::THEME_TEMPLATES_URL
                );
            }
            return add_query_arg(
                array(
                    'paged'=>$paged,
                    'account'=>templateberg_connect()->get_account()
                ),
                self::THEME_TEMPLATES_URL
            );
        }

        /**
         * Get Themes Templates Url
         *
         * @since 1.0.4
         */
        public function get_current_theme_tempaltes_url($paged = 1, $theme = [])
        {
            if (!templateberg_connect()->has_account()) {
                return add_query_arg(
                    array(
                        'paged'=>$paged,
                        'theme'=>!empty($theme)?$theme:templateberg_get_current_theme_info(),
                    ),
                    self::CURRENT_THEME_TEMPLATES_URL
                );
            }
            return add_query_arg(
                array(
                    'paged'=>$paged,
                    'account'=>templateberg_connect()->get_account(),
                    'theme'=>!empty($theme)?$theme:templateberg_get_current_theme_info(),
                ),
                self::CURRENT_THEME_TEMPLATES_URL
            );
        }

        /**
         * Get Purchase Url
         *
         * @since 1.0.4
         */
        public function get_current_theme_purchase_url()
        {
            if (!templateberg_connect()->has_account()) {
                return false;
            }
            return add_query_arg(
                array(
                    'account'=>templateberg_connect()->get_account(),
                    'theme'=>templateberg_get_current_theme_info(),
                ),
                self::CURRENT_THEME_PURCHASE_URL
            );
        }

        /**
         * Set Purchase
         *
         * @since 1.0.4
         */
        public function set_current_theme_purchase($prepare_data)
        {
            update_user_meta(get_current_user_id(), self::$current_theme_purchase_id, $prepare_data);
            if (empty($prepare_data)) {
                $this->set_current_theme_purchase_templates('');
            }
        }

        /**
         * Set Purchase templates
         *
         * @since 1.0.4
         */
        public function set_current_theme_purchase_templates($templates_list)
        {
            if (is_array($templates_list)) {
                update_user_meta(get_current_user_id(), self::$current_theme_purchase_templates, $templates_list);
            } else {
                update_user_meta(get_current_user_id(), self::$current_theme_purchase_templates, '');
            }
        }

        /**
         * Get Purchase Templates ids
         *
         * @since 1.0.4
         */
        public function get_current_theme_purchase_templates_id()
        {
            $templates_list = $this->get_current_theme_purchase_templates();
            $all_ids = array();
            if (is_array($templates_list)) {
                foreach ($templates_list as $template) {
                    $all_ids[] = absint($template['id']);
                }
            }
            return $all_ids;
        }


        /**
         * Get Purchase templates
         *
         * @since 1.0.4
         */
        public function get_current_theme_purchase_templates()
        {
            return maybe_unserialize(
                get_user_meta(
                    get_current_user_id(),
                    self::$current_theme_purchase_templates,
                    true
                )
            );
        }

        /**
         * Get Template Data Url
         *
         * @since 1.0.4
         */
        public function get_theme_template_data_url($template)
        {
            if (!templateberg_connect()->has_account()) {
                return false;
            }
            return add_query_arg(array(
                'account'   =>templateberg_connect()->get_account(),
                'template' =>$template
            ), self::THEME_TEMPLATE_DATA_URL);
        }
        /**
         * Run the method
         *
         * @since 1.0.0
         */
        public function run()
        {
            add_action('admin_init', array( __CLASS__, 'connect' ), -1);
            add_action('admin_init', array( __CLASS__, 'disconnect' ), -1);
            add_action('admin_menu', array( __CLASS__, 'admin_pages' ));
            add_action('admin_init', array( __CLASS__, 'redirect' ));

            add_action('wp_ajax_templateberg_gutentor', array( $this, 'install_gutentor' ));
            add_action('wp_ajax_templateberg_advanced_import', array( $this, 'advanced_import' ));
        }

        /**
         * Admin Page Menu and submenu page
         *
         * @since 1.0.0
         */
        public static function admin_pages()
        {

            add_menu_page(
                esc_html__('Templateberg', 'templateberg'),
                esc_html__('Templateberg', 'templateberg'),
                'manage_options',
                self::$page_slug,
                array( __CLASS__, 'account' ),
                'data:image/svg+xml;base64,' . base64_encode(
                    '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.81 42.76"><defs><style>.cls-1{fill:#fff;}</style></defs><title>Untitled-1</title><g id="Logo_1" data-name="Logo 1"><path class="cls-1" d="M36.6,4.31A62.21,62.21,0,0,0,26,3.05C25.11,3,24.24,3,23.34,3H22A64,64,0,0,0,11.4,4a45.7,45.7,0,0,0-5.31,1.3v12.4H11.4V9.62a61.72,61.72,0,0,1,9.28-1.19V32L24,33.16,27.32,32V8.37a63,63,0,0,1,9.28,1v8.4h5.31v-12A42.36,42.36,0,0,0,36.6,4.31Z" transform="translate(-6.09 -3)"/><polygon class="cls-1" points="30.5 23.53 30.5 27.49 19.89 34.76 17.91 36.13 15.92 34.76 5.3 27.49 5.3 23.53 0 23.53 0 30.48 5.3 34.13 15.92 41.39 17.91 42.76 19.89 41.39 30.5 34.13 35.81 30.48 35.81 23.53 30.5 23.53"/></g></svg>'
                ),
                110
            );
        }

        /**
         * Get Admin URl
         *
         * @since 1.0.0
         */
        public function get_admin_url()
        {
            return menu_page_url(self::$page_slug, false);
        }

        /**
         * Redirect to plugin page when plugin activated
         *
         * @since 1.0.0
         */
        public static function redirect()
        {
            if (get_option('__templateberg_do_redirect')) {
                update_option('__templateberg_do_redirect', false);
                if (! is_multisite()) {
                    exit(wp_redirect(templateberg_connect()->get_admin_url()));
                }
            }
        }

        /**
         * Load account templates
         *
         * @since 1.0.0
         */
        public static function account()
        {
            if (isset($_GET['connecting'])) {
                require_once TEMPLATEBERG_PATH . 'includes/admin/templates/connecting.php';
            } else {
                if (templateberg_connect()->has_account()) {
                    require_once TEMPLATEBERG_PATH . 'includes/admin/templates/account.php';
                } else {
                    require_once TEMPLATEBERG_PATH . 'includes/admin/templates/getting-started.php';
                }
            }
        }

        /**
         * Connect
         *
         * @since 1.0.0
         */
        public static function connect()
        {
            if (isset($_GET[self::$id]) && $_GET[self::$id] == 'templateberg.com') {
                if (!isset($_GET['_wpnonce']) ||
                    !isset($_GET['key']) ||
                    !isset($_GET['token']) ||
                    !isset($_GET['email']) ||
                    !isset($_GET['user-name']) ||
                    !isset($_GET['user-id']) ||
                    !isset($_GET['site-id']) ||
                    ! wp_verify_nonce($_GET['_wpnonce'], self::$id)
                ) {
                    $invalid = esc_html__('Sorry, we could not connect. Please try again.', 'templateberg');
                    wp_die($invalid, $invalid, [
                        'link_url' => admin_url(),
                        'link_text' => esc_html__('Back to Admin', 'templateberg'),
                    ]);
                }
                $prepare_data = array(
                    'key' => sanitize_text_field($_GET['key']),/*text*/
                    'token' => sanitize_text_field($_GET['token']),/*text*/
                    'email' => sanitize_email($_GET['email']),/*email*/
                    'user-name' => sanitize_text_field($_GET['user-name']),/*text*/
                    'user-id' => sanitize_text_field($_GET['user-id']),/*text*/
                    'site-id' => sanitize_text_field($_GET['site-id']),/*text*/
                );

                update_user_meta(get_current_user_id(), self::$id, $prepare_data);

                $connect_url = templateberg_connect()->get_admin_url().'&connecting=true';
                if (isset($_GET['isPopup'])) {
                    $connect_url .= '&isPopup=true';
                }

                wp_redirect($connect_url);
                exit;
            }
        }

        /**
         * Disconnect
         *
         * @since 1.0.0
         */
        public static function disconnect()
        {
            if (isset($_GET[self::$disconnect_id]) && $_GET[self::$disconnect_id] == 'templateberg.com') {
                if (!isset($_GET['_wpnonce']) ||
                    !isset($_GET['user-id']) ||
                    get_current_user_id() != $_GET['user-id'] ||
                    ! wp_verify_nonce($_GET['_wpnonce'], self::$id)
                ) {
                    $invalid = esc_html__('Sorry, we could not disconnect. Please try again.', 'templateberg');
                    wp_die($invalid, $invalid, [
                        'link_url' => admin_url(),
                        'link_text' => esc_html__('Back to Admin', 'templateberg'),
                    ]);
                }
                delete_user_meta(get_current_user_id(), self::$id);

                wp_redirect(templateberg_connect()->get_admin_url());
                exit;
            }
        }

        /**
         * FAQ Array
         * @access Private
         * @return array
         */
        public function faq()
        {

            return array(
                array(
                    'q' => esc_html__('What is Templateberg?', 'templateberg'),
                    'a' => esc_html__('A collection of pre-designed template and template kits library for WordPress. Templateberg includes a variety of templates for all kinds of websites from any niche to multipurpose including blog, magazine, eCommerce, travel, business, medical, construction, photography, education, fitness, automotive, portfolio, restaurant, multipurpose and much more. Templateberg facilitates to import of pre-designed template with starter content on the user website so that user can quickly build a beautiful website with WordPress.', 'templateberg'),
                ),
                array(
                    'q' => esc_html__('What is a Gutenberg block?', 'templateberg'),
                    'a' => esc_html__('A section of a website page created with Gutenberg or Gutenberg Addons plugin. It is the most modern way to design a website. The possibility is endless to create any page design by importing and combing the block section.', 'templateberg'),

                ),
                array(
                    'q' => esc_html__('What is a Gutenberg template?', 'templateberg'),
                    'a' => esc_html__('A full-page pre-designed of a single page of a website with starter content created with Gutenberg block. It can be a home page, about, service, contact, pop-ups, products, pricing or any landing pages.', 'templateberg'),
                ),
                array(
                    'q' => esc_html__('What is a Gutenberg template kit?', 'templateberg'),
                    'a' => esc_html__('A collection of cohesive pre-designed Gutenberg templates with all pages for a niche/multipurpose website focusing on a similar design concept.', 'templateberg'),
                ),
                array(
                    'q' => esc_html__('What is Gutentor?', 'templateberg'),
                    'a' => sprintf(esc_html__('Gutentor is a WordPress plugin based on WordPress Block (Gutenberg) Editor, modern drag & drop WordPress page builder Know more about it on %1$sGutentor official website%2$s.', 'templateberg'), "<a href='https://www.gutentor.com/' target='_blank'>", '</a>'),
                ),
                array(
                    'q' => esc_html__('What is a WordPress Theme Template Kit?', 'templateberg'),
                    'a' => esc_html__('A pre-designed starter content for a specific theme that you can simply import on your site with a click. In other words, it can be called Demo Content for the theme.', 'templateberg'),
                ),
                array(
                    'q' => esc_html__('How Gutenberg Template Kit is different from Theme Template Kit?', 'templateberg'),
                    'a' => esc_html__('Gutenberg Template Kit is designed on WordPress Gutenberg Block Editor whereas Theme Template Kit is designed for the specific theme. Templates from Gutenberg Template Kits can be imported individually on a single page/post but when you import Theme Template Kit all content and pages import at once. Gutenberg Template Kit will work on any Theme but Theme Template Kit will work on a single theme it is created from.', 'templateberg'),
                ),
            );
        }

        private function install_plugin($plugin_info)
        {

            $plugin = $plugin_info['plugin'];
            $slug = $plugin_info['slug'];

            $status             = array(
                'install' => 'plugin',
                'slug'    => sanitize_key(wp_unslash($slug)),
            );
            if (is_plugin_active_for_network($plugin) || is_plugin_active($plugin)) {
                // Plugin is activated
                wp_send_json_success($status);
            }

            if (! current_user_can('install_plugins')) {
                $status['errorMessage'] = __('Sorry, you are not allowed to install plugins on this site.', 'templateberg');
                wp_send_json_error($status);
            }

            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            // Looks like a plugin is installed, but not active.
            if (file_exists(WP_PLUGIN_DIR . '/' . $slug)) {
                $plugin_data          = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                $status['plugin']     = $plugin;
                $status['pluginName'] = $plugin_data['Name'];

                if (current_user_can('activate_plugin', $plugin) && is_plugin_inactive($plugin)) {
                    $result = activate_plugin($plugin);

                    if (is_wp_error($result)) {
                        $status['errorCode']    = $result->get_error_code();
                        $status['errorMessage'] = $result->get_error_message();
                        wp_send_json_error($status);
                    }

                    wp_send_json_success($status);
                }
            }

            $api = plugins_api(
                'plugin_information',
                array(
                    'slug'   => sanitize_key(wp_unslash($slug)),
                    'fields' => array(
                        'sections' => false,
                    ),
                )
            );

            if (is_wp_error($api)) {
                $status['errorMessage'] = $api->get_error_message();
                wp_send_json_error($status);
            }

            $status['pluginName'] = $api->name;

            $skin     = new WP_Ajax_Upgrader_Skin();
            $upgrader = new Plugin_Upgrader($skin);
            $result   = $upgrader->install($api->download_link);

            if (defined('WP_DEBUG') && WP_DEBUG) {
                $status['debug'] = $skin->get_upgrade_messages();
            }

            if (is_wp_error($result)) {
                $status['errorCode']    = $result->get_error_code();
                $status['errorMessage'] = $result->get_error_message();
                wp_send_json_error($status);
            } elseif (is_wp_error($skin->result)) {
                $status['errorCode']    = $skin->result->get_error_code();
                $status['errorMessage'] = $skin->result->get_error_message();
                wp_send_json_error($status);
            } elseif ($skin->get_errors()->get_error_code()) {
                $status['errorMessage'] = $skin->get_error_messages();
                wp_send_json_error($status);
            } elseif (is_null($result)) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                WP_Filesystem();
                global $wp_filesystem;

                $status['errorCode']    = 'unable_to_connect_to_filesystem';
                $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.', 'templateberg');

                // Pass through the error from WP_Filesystem if one was raised.
                if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code()) {
                    $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
                }

                wp_send_json_error($status);
            }

            $install_status = install_plugin_install_status($api);

            if (current_user_can('activate_plugin', $install_status['file']) && is_plugin_inactive($install_status['file'])) {
                $result = activate_plugin($install_status['file']);

                if (is_wp_error($result)) {
                    $status['errorCode']    = $result->get_error_code();
                    $status['errorMessage'] = $result->get_error_message();
                    wp_send_json_error($status);
                }
            }
            wp_send_json_success($status);
        }
        /**
         * Get Started Notice
         * Active callback of wp_ajax
         * return void
         */
        public function install_gutentor()
        {

            check_ajax_referer('templateberg_nonce', 'security');

            $slug   = 'gutentor';
            $plugin = 'gutentor/gutentor.php';

            /*prevent gutentor to redirect*/
            update_option('__gutentor_do_redirect', false);

            $this->install_plugin(
                array(
                    'slug'=>$slug,
                    'plugin'=>$plugin,
                )
            );
        }

        /**
         * Install Advanced Import
         * Active callback of wp_ajax
         * return void
         */
        public function advanced_import()
        {

            check_ajax_referer('templateberg_nonce', 'security');

            $slug   = 'advanced-import';
            $plugin = 'advanced-import/advanced-import.php';

            /*prevent gutentor to redirect*/
            update_option('__gutentor_do_redirect', false);

            $this->install_plugin(
                array(
                    'slug'=>$slug,
                    'plugin'=>$plugin,
                )
            );
        }
    }
}

/**
 * Begins execution of the hooks.
 *
 * @since    1.0.0
 */
function templateberg_connect()
{
    return Templateberg_Connect::instance();
}
templateberg_connect()->run();
