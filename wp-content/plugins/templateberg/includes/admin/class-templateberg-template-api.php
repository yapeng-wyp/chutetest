<?php
if (! defined('ABSPATH')) {
    exit;
}
if (! class_exists('Templateberg_Template_Api')) {

    /**
     * Advanced Import
     *
     * @package Templateberg
     * @since 1.0.1
     */
    class Templateberg_Template_Api extends WP_Rest_Controller
    {

        /**
         * Rest route namespace.
         *
         * @var Templateberg_Template_Api
         */
        public $namespace = 'templateberg/';

        /**
         * Rest route version.
         *
         * @var Templateberg_Template_Api
         */
        public $version = 'v1';

        /**
         * Initialize the class
         */
        public function run()
        {
            add_action('rest_api_init', array( $this, 'register_routes' ));
        }

        /**
         * Register REST API route
         */
        public function register_routes()
        {
            $namespace = $this->namespace . $this->version;

            register_rest_route(
                $namespace,
                '/is_connected',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'is_connected' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            register_rest_route(
                $namespace,
                '/get_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'get_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            register_rest_route(
                $namespace,
                '/get_template_data',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'get_template_data' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            register_rest_route(
                $namespace,
                '/purchase_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'purchase_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            register_rest_route(
                $namespace,
                '/purchases',
                array(
                    array(
                        'methods'             => \WP_REST_Server::CREATABLE,
                        'callback'            => array( $this, 'purchases' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            register_rest_route(
                $namespace,
                '/free_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'free_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('edit_posts');
                        },
                    ),
                )
            );

            /*Gutenberg Templates
            1.0.4
            */
            register_rest_route(
                $namespace,
                '/gutenberg_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'gutenberg_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('manage_options');
                        },
                    ),
                )
            );

            /*Theme Templates
            1.0.4
            */
            register_rest_route(
                $namespace,
                '/theme_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'theme_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('manage_options');
                        },
                    ),
                )
            );

            /*Current Theme Templates
           1.0.4
           */
            register_rest_route(
                $namespace,
                '/current_theme_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'current_theme_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('manage_options');
                        },
                    ),
                )
            );

            /*Current Theme Purchased Templates
           1.0.4
           */
            register_rest_route(
                $namespace,
                '/current_theme_purchased_templates',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'current_theme_purchased_templates' ),
                        'permission_callback' => function () {
                            return current_user_can('manage_options');
                        },
                    ),
                )
            );

            /*Import Theme Templates
          1.0.4
          */
            register_rest_route(
                $namespace,
                '/import_theme_template',
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => array( $this, 'import_theme_template' ),
                        'permission_callback' => function () {
                            return current_user_can('manage_options');
                        },
                    ),
                )
            );
        }

        /**
         * Function to fetch templates.
         * Fetching templates is public
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function is_connected(\WP_REST_Request $request)
        {
            $connected = false;
            if (templateberg_connect()->has_account()) {
                $connected = true;
            }
            return rest_ensure_response($connected);
        }

        /**
         * Function to delete templates and bock json transient
         *
         * @since 2.0.9
         * @return void
         */
        public function delete_transient()
        {

            $max_pages = get_transient('templateberg_edt_max');
            if (!$max_pages) {
                $max_pages = 10;
            }
            for ($paged = 1; $paged <= $max_pages; $paged++) {
                delete_transient('templateberg_edt_'.$paged);
            }

            /*Delete Block Json Transient*/
            global $wpdb;
            $transients = $wpdb->get_col("SELECT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_gutentor_get_block_json_%'");

            if ($transients) {
                foreach ($transients as $transient) {
                    $transient = preg_replace('/^_transient_/i', '', $transient);
                    delete_transient($transient);
                }
            }

            /*Delete Block Json Transient*/
            global $wpdb;
            $transients = $wpdb->get_col("SELECT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_templateberg_template_%'");

            if ($transients) {
                foreach ($transients as $transient) {
                    $transient = preg_replace('/^_transient_/i', '', $transient);
                    delete_transient($transient);
                }
            }
        }

        /**
         * Function to fetch templates.
         * Fetching templates is public
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function get_templates(\WP_REST_Request $request)
        {

            if (!templateberg_connect()->has_account()) {
                return rest_ensure_response(false);
            }
            $paged = $request->get_param('paged') ? $request->get_param('paged') : 1;
            $templates_list = templateberg_get_editor_templates($paged);
            $max_pages = get_transient('templateberg_edt_max');

            if ($request->get_param('reset')) {
                $this->delete_transient();
                $templates_list = array();
            }

            if (empty($templates_list)) {
                /*
                fetch template library data from live*/
                $url       = templateberg_connect()->get_template_url($paged);

                $body_args = array(
                    /*API version*/
                    'api_version' => wp_get_theme()['Version'],
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $get_templates = json_decode(wp_remote_retrieve_body($raw_json), true);
                    $templates_list_old = $get_templates['templates'];
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (is_array($templates_list_old)) {
                            $templates_list = array();
                            $purchase_ids = templateberg_connect()->get_purchase_templates_id();
                            if (is_array($purchase_ids)) {
                                foreach ($templates_list_old as $templates) {
                                    if (in_array($templates['id'], $purchase_ids)) {
                                        $new_array = $templates;
                                        $new_array['is_purchased'] = 'purchased';
                                        array_push($templates_list, $new_array);
                                    } else {
                                        array_push($templates_list, $templates);
                                    }
                                }
                            } else {
                                $templates_list = $templates_list_old;
                            }
                        }

                        $max_pages = $get_templates['max_pages'];
                        $total_templates = $get_templates['found_posts'];
                    } else {
                        return new WP_Error(
                            'rest_templateberg_json_error',
                            __('Something went wrong. Please contact to templateberg.com'),
                            array( 'status' => 200 )
                        );
                    }
                } else {
                    return rest_ensure_response($raw_json);
                }

                /*Gutentor compatible*/
                $templates_list = apply_filters('gutentor_get_template_library', $templates_list);

                /*New hook*/
                $templates_list = apply_filters('templateberg_get_templates', $templates_list);

                /*Store on transient*/
                set_transient('templateberg_edt_max', $max_pages);
                templateberg_set_editor_templates($templates_list, $paged);
            }
            return rest_ensure_response(array(
                'templates' => $templates_list,
                'found_posts' => $total_templates,
                'max_pages' => $max_pages,
                'purchased_items' => templateberg_connect()->get_purchase_templates(),
            ));
        }

        /**
         * Function to fetch single template data.
         * Fetching templates is public
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function get_template_data(\WP_REST_Request $request)
        {

            $template_id = $request->get_param('id');
            $url       = $request->get_param('template_url');

            if (!templateberg_connect()->has_account()) {
                return rest_ensure_response(false);
            }
            if (!$request->get_param('ignore_plugins') && $request->get_param('plugins')) {
                $plugins = $request->get_param('plugins');
                $required_plugins = json_decode($plugins, true);
                $missing_plugins = array();
                if ($required_plugins) {
                    foreach ($required_plugins as $required_plugin) {
                        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                        // check for plugin using plugin name
                        if (!is_plugin_active($required_plugin['slug'].'/'.$required_plugin['main_file'])) {
                            $missing_plugins[] = $required_plugin;
                        }
                    }
                    if ($missing_plugins) {
                        return rest_ensure_response(array(
                            'missing_plugins' => $missing_plugins
                        ));
                    }
                }
            }


            if ($url && 'server' != $url) {
                $template_json = $this->get_data_from_url($url);
            } else {
                $template_json = get_transient('templateberg_tj_' . $template_id);
                if (empty($template_json)) {
                    /*
                fetch template library data from live*/
                    $url       = templateberg_connect()->get_template_data_url($request->get_params());

                    $body_args = array(
                        /*API version*/
                        'api_version' => wp_get_theme()['Version'],
                        /*lang*/
                        'site_lang'   => get_bloginfo('language'),
                    );
                    $raw_json  = wp_safe_remote_get(
                        $url,
                        array(
                            'timeout' => 100,
                            'body'    => $body_args,
                        )
                    );

                    if (! is_wp_error($raw_json)) {
                        $tb_data = json_decode(wp_remote_retrieve_body($raw_json), true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            if (is_array($tb_data)) {
                                $template_json = $tb_data;
                                set_transient('templateberg_tj_' . $template_id, $template_json, DAY_IN_SECONDS);
                            }
                        } else {
                            return new WP_Error(
                                'rest_templateberg_json_error',
                                __('Something went wrong. Please contact to templateberg.com'),
                                array( 'status' => 200 )
                            );
                        }
                    } else {
                        return rest_ensure_response($raw_json);
                    }
                }
            }
            return rest_ensure_response($template_json);
        }

        /**
         * Function to fetch purchased data.
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function purchase_templates(\WP_REST_Request $request)
        {

            if (!templateberg_connect()->has_account()) {
                return rest_ensure_response(false);
            }
            if ($request->get_param('reset')) {
                /*
                fetch template library data from live*/
                $url       = templateberg_connect()->get_purchase_url();
                $body_args = array(
                    /*API version*/
                    'api_version' => wp_get_theme()['Version'],
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $tb_data = json_decode(wp_remote_retrieve_body($raw_json), true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (is_array($tb_data)) {
                            $purchases = $tb_data;
                            templateberg_connect()->set_purchase($purchases['info']);
                            templateberg_connect()->set_purchase_templates($purchases['templates']);
                        }
                    } else {
                        return new WP_Error(
                            'rest_templateberg_json_error',
                            __('Something went wrong. Please contact to templateberg.com', 'templateberg'),
                            array( 'status' => 200 )
                        );
                    }
                } else {
                    if (!empty($raw_json)) {
                        return rest_ensure_response($raw_json);
                    }
                    return rest_ensure_response(false);
                }
            }
            return rest_ensure_response(templateberg_connect()->get_purchase_templates());
        }

        /**
         * Function to fetch data from URL
         * Fetching templates is public
         *
         * @since 1.0.0
         * @param String $url
         * @return String| WP_Error object on failure.
         */
        public function get_data_from_url($url)
        {

            $url_array  = explode('/', $url);
            $block_id   = $url_array[ count($url_array) - 2 ];
            $block_json = get_transient('templateberg_tj_' . $block_id);

            /*Get Json*/
            if (empty($block_json)) {
                $body_args = array(
                    /*API version*/
                    'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $block_json = json_decode(wp_remote_retrieve_body($raw_json));
                    /*Store on transient*/
                    set_transient('templateberg_tj_' . $block_id, $block_json, DAY_IN_SECONDS);
                } else {
                    $block_json = $raw_json;
                }
            }
            return $block_json;
        }

        /**
         * Function to set Purchase info
         *
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function purchases(\WP_REST_Request $request)
        {
            $purchases = $request->get_param('purchases');

            if (isset($purchases['info'])) {
                templateberg_connect()->set_purchase($purchases['info']);
            } else {
                templateberg_connect()->set_purchase('');
            }
            if (isset($purchases['templates'])) {
                templateberg_connect()->set_purchase_templates($purchases['templates']);
            } else {
                templateberg_connect()->set_purchase_templates('');
            }
            if (isset($purchases['wp_theme_template_kits'])) {
                templateberg_connect()->set_current_theme_purchase_templates($purchases['wp_theme_template_kits']);
            } else {
                templateberg_connect()->set_current_theme_purchase_templates('');
            }
            ob_start();
            templateberg_get_payment_info_html();
            $html = ob_get_clean();
            return rest_ensure_response($html);
        }

        /**
         * Function to set Free Templates
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function free_templates(\WP_REST_Request $request)
        {
            $free_templates = $request->get_param('freeTemplates');
            if ('reset' === $free_templates) {
                templateberg_connect()->set_free_templates('');
            } else {
                templateberg_connect()->set_free_templates($free_templates);
            }
            ob_start();
            templateberg_get_free_templates_html();
            $html = ob_get_clean();
            return rest_ensure_response($html);
        }

        /**
         * Function to set Gutenberg Templates
         *
         * @since 1.0.4
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function gutenberg_templates(\WP_REST_Request $request)
        {
            $paged       = $request->get_param('paged');
            if ($request->get_param('reset')) {
                templateberg_delete_transients_by_prefix('templateberg_gutenberg_templates');
            }

            $templates_list = templateberg_get_gutenberg_templates($paged);
            $max_pages = get_transient('templateberg_gt_max');
            $total_templates = get_transient('templateberg_gt_total');

            /*Get Json*/
            if (empty($templates_list)) {
                $url       = templateberg_connect()->get_gutenberg_tempaltes_url($paged);
                $body_args = array(
                    /*API version*/
                    'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $get_templates = json_decode(wp_remote_retrieve_body($raw_json), true);

                    $templates_list = apply_filters(
                        'templateberg_gutenberg_templates',
                        $get_templates['templates']
                    );
                    $max_pages = apply_filters(
                        'templateberg_gutenberg_templates_max_pages',
                        $get_templates['max_pages']
                    );
                    $total_templates = apply_filters(
                        'templateberg_gutenberg_templates_found_posts',
                        $get_templates['found_posts']
                    );

                    /*Store on transient*/
	                set_transient('templateberg_gt_max', $max_pages);
                    set_transient('templateberg_gt_total', $total_templates);
                    templateberg_set_gutenberg_templates($templates_list, $paged);
                }
            }
            return rest_ensure_response(array(
                'templates' => $templates_list,
                'found_posts' => $total_templates,
                'max_pages' => $max_pages,
                'purchased_items' => templateberg_connect()->get_purchase_templates(),
            ));
        }

        /**
         * Function to set Free Templates
         *
         * @since 1.0.4
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function theme_templates(\WP_REST_Request $request)
        {
            $paged       = $request->get_param('paged');
            if ($request->get_param('reset')) {
                templateberg_delete_transients_by_prefix('templateberg_theme_templates');
            }

            $templates_list = templateberg_get_theme_templates($paged);
            $max_pages = get_transient('templateberg_tt_max');
            $total_templates = get_transient('templateberg_tt_total');

            /*Get Json*/
            if (empty($templates_list)) {
                $url       = templateberg_connect()->get_theme_tempaltes_url($paged);
                $body_args = array(
                    /*API version*/
                    'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $get_templates = json_decode(wp_remote_retrieve_body($raw_json), true);

                    $templates_list = apply_filters(
                        'templateberg_theme_templates',
                        $get_templates['templates']
                    );
                    $max_pages = apply_filters(
                        'templateberg_theme_templates_max_pages',
                        $get_templates['max_pages']
                    );
                    $total_templates = apply_filters(
                        'templateberg_theme_templates_found_posts',
                        $get_templates['found_posts']
                    );

                    /*Store on transient*/
                    set_transient('templateberg_tt_max', $max_pages);
                    set_transient('templateberg_tt_total', $total_templates);
                    templateberg_set_theme_templates($templates_list, $paged);
                }
            }
            return rest_ensure_response(array(
                'templates' => $templates_list,
                'found_posts' => $total_templates,
                'max_pages' => $max_pages,
                'purchased_items' => templateberg_connect()->get_purchase_templates(),
            ));
        }

        /**
         * Function to set Current Theme Templates
         *
         * @since 1.0.4
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function current_theme_templates(\WP_REST_Request $request)
        {
            if ($request->get_param('theme')) {
                $theme = $request->get_param('theme')['stylesheet'];
            } else {
                $theme = get_stylesheet();
            }

            $paged       = $request->get_param('paged');
            if ($request->get_param('reset')) {
                templateberg_delete_transients_by_prefix('templateberg_ct_'.$theme.'_templates');
            }

            $templates_list = templateberg_get_current_theme_templates($paged, $theme);

            $max_pages = get_transient('templateberg_ct_'.$theme.'_max');
            $total_templates = get_transient('templateberg_ct_'.$theme.'_total');

            /*Get Json*/
            if (empty($templates_list) || "nothing" === $templates_list) {
                $url       = templateberg_connect()->get_current_theme_tempaltes_url($paged, $request->get_param('theme'));
                $body_args = array(
                    /*API version*/
                    'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $get_templates = json_decode(wp_remote_retrieve_body($raw_json), true);

                    $templates_list = apply_filters(
                        'templateberg_current_theme_'.$theme.'_templates',
                        $get_templates['templates']
                    );
                    $max_pages = apply_filters(
                        'templateberg_current_theme_'.$theme.'_templates_max_pages',
                        $get_templates['max_pages']
                    );
                    $total_templates = apply_filters(
                        'templateberg_current_theme_'.$theme.'_templates_found_posts',
                        $get_templates['found_posts']
                    );
                    if (!$templates_list) {
                        $templates_list = 'nothing';
                    }

                    /*Store on transient*/
                    set_transient('templateberg_ct_'.$theme.'_max', $max_pages, WEEK_IN_SECONDS);
                    set_transient('templateberg_ct_'.$theme.'_total', $total_templates, WEEK_IN_SECONDS);
                    templateberg_set_current_theme_templates($templates_list, $paged, $theme);
                }
            }
            return rest_ensure_response(array(
                'templates' => $templates_list,
                'found_posts' => $total_templates,
                'max_pages' => $max_pages,
                'purchased_items' => templateberg_connect()->get_purchase_templates(),
            ));
        }

        /**
         * Function to set Current Theme Purchased Templates
         *
         * @since 1.0.4
         * @param WP_REST_Request $request Full details about the request.
         * @return bool|WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function current_theme_purchased_templates(\WP_REST_Request $request)
        {

            if (!templateberg_connect()->has_account()) {
                return rest_ensure_response(false);
            }
            if ($request->get_param('reset')) {
                /*
                fetch template library data from live*/
                $url       = templateberg_connect()->get_current_theme_purchase_url();
                $body_args = array(
                    /*API version*/
                    'api_version' => wp_get_theme()['Version'],
                    /*lang*/
                    'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $url,
                    array(
                        'timeout' => 100,
                        'body'    => $body_args,
                    )
                );

                if (! is_wp_error($raw_json)) {
                    $tb_data = json_decode(wp_remote_retrieve_body($raw_json), true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (is_array($tb_data)) {
                            $purchases = $tb_data;
                            templateberg_connect()->set_current_theme_purchase($purchases['info']);
                            templateberg_connect()->set_current_theme_purchase_templates($purchases['templates']);
                        }
                    } else {
                        return new WP_Error(
                            'rest_templateberg_json_error',
                            __('Something went wrong. Please contact to templateberg.com', 'templateberg'),
                            array( 'status' => 200 )
                        );
                    }
                } else {
                    if (!empty($raw_json)) {
                        return rest_ensure_response($raw_json);
                    }
                    return rest_ensure_response(false);
                }
            }
            return rest_ensure_response(templateberg_connect()->get_current_theme_purchase_templates());
        }

        /**
         * Function to fetch theme template data.
         * Import it
         *
         * @since 1.0.0
         * @param WP_REST_Request $request Full details about the request.
         * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
         */
        public function import_theme_template(\WP_REST_Request $request)
        {

            if (!templateberg_connect()->has_account()) {
                return rest_ensure_response(false);
            }
            /*fetch template library data from live*/
            $url       = templateberg_connect()->get_theme_template_data_url($request->get_params());

            $body_args = array(
                /*API version*/
                'api_version' => wp_get_theme()['Version'],
                /*lang*/
                'site_lang'   => get_bloginfo('language'),
            );
            $raw_json  = wp_safe_remote_get(
                $url,
                array(
                    'timeout' => 100,
                    'body'    => $body_args,
                )
            );

            if (! is_wp_error($raw_json)) {
                $tb_data = json_decode(wp_remote_retrieve_body($raw_json), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if (isset($tb_data['code']) && isset($tb_data['import']) && !$tb_data['import']) {
                        return rest_ensure_response($tb_data);
                    }
                    $plugins = isset($tb_data['plugins']) && is_array($tb_data['plugins']) ? ' data-plugins="' . esc_attr(wp_json_encode($tb_data['plugins'])) . '"' : '';

                    $html = '<div class="ai-item" data-template_url="'.esc_url($tb_data['theme_template_url']).'" data-template_type="url" style="display:none;visibility:hidden">
		                '.wp_nonce_field('advanced-import', '_wpnonce', true, false).'
		                <div class="ai-item-footer">
			                <div class="ai-item-footer_meta">
				                <div class="ai-item-footer-actions">
					                <a class="ai-demo-import ai-item-import"
					                   href="#" aria-label="Import"
					                   '.$plugins.'
					                >
					                </a>
				                </div>
			                </div>
		                </div>
	                </div>';
                    return rest_ensure_response($html);
                } else {
                    return new WP_Error(
                        'rest_templateberg_json_error',
                        __('Something went wrong. Please contact to templateberg.com'),
                        array( 'status' => 200 )
                    );
                }
            } else {
                return rest_ensure_response($raw_json);
            }
        }

        /**
         * Gets an instance of this object.
         * Prevents duplicate instances which avoid artefacts and improves performance.
         *
         * @static
         * @access public
         * @since 1.0.1
         * @return object
         */
        public static function get_instance()
        {
            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if (null === $instance) {
                $instance = new self();
            }

            // Always return the instance
            return $instance;
        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden.
            _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'templateberg'), '1.0.0');
        }

        /**
         * Disable unserializing of the class
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden.
            _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'templateberg'), '1.0.0');
        }
    }

}
Templateberg_Template_Api::get_instance()->run();
