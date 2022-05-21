<?php
if (! function_exists('templateberg_is_edit_page')) {
    function templateberg_is_edit_page()
    {
        //make sure we are on the backend
        if (! is_admin()) {
            return false;
        }
        global $pagenow;
        return in_array($pagenow, array( 'post.php', 'post-new.php' ));
    }
}

if (! function_exists('templateberg_get_payment_info_html')) {
    function templateberg_get_payment_info_html()
    {
        $payment_info = templateberg_connect()->get_purchase();
        if (is_array($payment_info) && !empty($payment_info)) {
            ?>
            <div class="tb-purchase__wrap">
                <div class="tb-purchase__id">
                    <span class="tb-purchase__title"><?php echo esc_html__('ID', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__type">
                    <span class="tb-purchase__title"><?php echo esc_html__('Type', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__type">
                    <span class="tb-purchase__title"><?php echo esc_html__('Name', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__date">
                    <span class="tb-purchase__title"><?php echo esc_html__('Date', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__amount">
                    <span class="tb-purchase__title"><?php echo esc_html__('Amount', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__limit">
                    <span class="tb-purchase__title"><?php echo esc_html__('Limit', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__plan">
                    <span class="tb-purchase__title"><?php echo esc_html__('Plan', 'templateberg'); ?></span>
                </div>
                <div class="tb-purchase__link">
                    <span class="tb-purchase__title"><?php echo esc_html__('Details', 'templateberg'); ?></span>
                </div>
            </div>
            <?php
            foreach ($payment_info as $pi) {
                ?>
                <div class="tb-purchase__wrap">
                    <div class="tb-purchase__id">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['id'])?esc_html($pi['id']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__type">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['type'])?esc_html($pi['type']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__type">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['title'])?wp_kses_post($pi['title']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__date">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['date'])?esc_html($pi['date']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__amount">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['amount'])?esc_html($pi['amount']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__limit">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['limit'])?esc_html($pi['limit']):'';?>
                        </span>
                    </div>
                    <div class="tb-purchase__plan">
                        <span class="tb-purchase__desc">
                            <?php echo isset($pi['plan'])?esc_html($pi['plan']):'';?>
                        </span>
                    </div>

                    <div class="tb-purchase__plan">
                        <span class="tb-purchase__desc">
                            <?php echo wp_kses_post($pi['details'])?>
                        </span>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="tb-info__box">
                <?php echo esc_html__('No payment information found', 'templateberg'); ?>
            </div>
            <?php
        }
    }
}

if (! function_exists('templateberg_get_free_templates_html')) {
    function templateberg_get_free_templates_html()
    {
        $free_templates = templateberg_connect()->get_free_templates();
        if (is_array($free_templates) && !empty($free_templates)) {
            echo '<div class="tb-row">';
            foreach ($free_templates as $ft) {
                ?>
                <div class="tb-col-3">
                    <img src="<?php echo esc_url($ft['screenshot_url'])?>" alt="<?php echo esc_attr($ft['title'])?>"/>
                </div>
                <?php
            }
            echo '</div>';
        } else {
            ?>
            <div class="tb-info__box">
                <?php echo esc_html__('No template information found', 'templateberg'); ?>
            </div>
            <?php
        }
    }
}

/**
 * check if Gutentor activated
 */
if (! function_exists('templateburg_is_gutentor_active')) {

    function templateburg_is_gutentor_active()
    {
        return class_exists('Gutentor') ? true : false;
    }
}


/**
 * check if Gutentor activated
 */
if (! function_exists('templateburg_is_advanced_import_active')) {

    function templateburg_is_advanced_import_active()
    {
        return class_exists('Advanced_Import') ? true : false;
    }
}


/**
 * Get Transients by prefix
 *
 * @param  $prefix string Prefix of Transients
 * without _transient_
 *
 * @return array|boolean Array of Transients or false if no Transients
 */
if (!function_exists('templateberg_get_transients_by_prefix')) {
    function templateberg_get_transients_by_prefix($prefix)
    {

        global $wpdb;

        /*Add Prefix*/
        $prefix = $wpdb->esc_like('_transient_' . $prefix);

        /*SQL*/
        $sql = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";

        /*Get transients*/
        $transients = $wpdb->get_results(
            $wpdb->prepare(
                $sql,
                $prefix . '%'
            ),
            ARRAY_A
        );

        /*Return*/
        if ($transients && ! is_wp_error($transients)) {
            return $transients;
        }

        /*No transients, return false*/
        return false;
    }
}

/**
 * Delete Transients by prefix
 *
 * @param  $prefix string Prefix of Transients
 * without _transient_
 *
 * @return array|boolean Array of found Transients and deleted Transients options name
 *  or false if no Transients
 */
if (!function_exists('templateberg_delete_transients_by_prefix')) {

    function templateberg_delete_transients_by_prefix($prefix)
    {

        $transients = templateberg_get_transients_by_prefix($prefix);
        if (! $transients) {
            return false;
        }

        $deleted = array();

        /*Loop through found transients*/
        foreach ($transients as $transient) {
            $deleted[] = $transient['option_name'];
            delete_transient(str_replace('_transient_', '', $transient['option_name']));
        }

        /*Return an array of total transients
        and deleted transients option_name*/
        return array(
                'found'   => count($transients),
                'deleted' => $deleted,
        );
    }
}

/**
 * Function create pagination
 *
 * @param  [array] $attr
 * @return String
 */
if (!function_exists('templateberg_pagination')) {
    function templateberg_pagination($paged = false, $max_num_pages = false)
    {
        $da_link = get_post_type_archive_link('download');
        $nextDisabled = ($paged+1) > $max_num_pages?'tb-list__page-disabled':'';
        $prevDisabled = ($paged-1) < 1 ?'tb-list__page-disabled':'';
        $prevPage = ($paged-1) < 1?1:$paged-1;
        $nextPage = ($paged+1) > $max_num_pages?$max_num_pages:$paged+1;

        $phtml = '';
        $phtml .= '<div class="tb-list__navigation"><nav aria-label="Page navigation"><ul class="tb-list__pagination">';
        $phtml .= '<li class="tb-list__page-item '.$prevDisabled.'"><a class="tb-list__page-link" href="'.esc_url($da_link).'page/'.$prevPage.'" data-gpage="'.esc_html($prevPage).'">'.esc_html__('Previous', 'templateberg').'</a></li>';

        if (! $paged) {
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        }
        if (! $max_num_pages) {
            global $wp_query;
            $max_num_pages = $wp_query->max_num_pages;
            if (! $max_num_pages) {
                $max_num_pages = 1;
            }
        }
        $mid_pages = $paged >= 3 ? array( $paged - 1, $paged, $paged + 1 ) : array( 1, 2, 3 );
        if ($max_num_pages > 1) {
            if (! in_array(1, $mid_pages)) {
                $is_active = $paged == 1 ? ' tb-list__page-active' : '';
                $phtml .= '<li class="tb-list__page-item ' . $is_active . '">
                    <a class="tb-list__page-link" href="'.esc_url($da_link).'page/1" data-gpage="1">' . __('1', 'templateberg') . '</a>
                </li>';
            }
            if ($paged > 3) {
                $phtml .= '<li class="tb-list__page-item tb-list__pagination-dots"><a class="tb-list__page-link" href="#">...</a></li>';
            }
            foreach ($mid_pages as $i) {
                if ($max_num_pages >= $i) {
                    $is_active = $paged == $i ? ' tb-list__page-active' : '';
                    $phtml    .= '<li class="tb-list__page-item' . $is_active . '">
                    <a class="tb-list__page-link" href="'.esc_url($da_link).'page/'.$i.'" data-gpage="' . $i . '">' . __($i, 'templateberg') . '</a>
                </li>';
                }
            }
            if ($max_num_pages > $paged + 1) {
                if ($max_num_pages > 3) {
                    $phtml .= '<li class="tb-list__page-item tb-list__pagination-dots"><a class="tb-list__page-link" href="#">...</a></li>';
                }
                if ($max_num_pages > 3) {
                    $is_active = $paged == $max_num_pages ? ' tb-list__page-active' : '';
                    $phtml .= '<li class="tb-list__page-item  ' . $is_active . '">
                    <a class="tb-list__page-link" href="'.esc_url($da_link).'page/'.$max_num_pages.'" data-gpage="' . $max_num_pages . '">' . __($max_num_pages, 'templateberg') . '</a>
                </li>';
                }
            }
        }
        $phtml .= ' <li class="tb-list__page-item '.$nextDisabled.'"><a class="tb-list__page-link" href="'.esc_url($da_link).'page/'.$nextPage.'" data-gpage="'.esc_html($nextPage).'">'.esc_html__('Next', 'templateberg').'</a></li>';
        $phtml .= '</ul></nav></div>';
        return $phtml;
    }

}

/**
 * Function to get Current Theme Info
 *
 * @param  [array] $attr
 * @return array
 */
if (!function_exists('templateberg_get_current_theme_info')) {
    function templateberg_get_current_theme_info()
    {
        return array(
                'template'=>get_template(),
                'stylesheet'=>get_stylesheet(),
                'author'=>wp_get_theme()->get('Author'),
        );
    }
}

/**
 * Function to get Current Theme Button
 *
 * @param  [array] $attr
 * @return boolean
 */
if (!function_exists('templateberg_is_current_theme_template_available')) {
    function templateberg_is_current_theme_template_available($item)
    {
        $is_available = false;
        if (!isset($item['is_pro']) || !$item['is_pro']) {
            $is_available= true;
        } elseif (empty(templateberg_connect()->get_current_theme_purchase_templates_id())) {
            $is_available = false;
        } elseif (in_array($item['id'], templateberg_connect()->get_current_theme_purchase_templates_id())) {
            $is_available = true;
        }
        return $is_available;
    }
}

/**
 * Function check if templates has set up
 *
 * @param  [array] $attr
 * @return boolean
 */
if (!function_exists('templateberg_has_templates')) {
    function templateberg_has_templates($type, $theme_slug = '')
    {
        $is_available = false;

        switch ($type) {
            case 'current-theme':
                $paged = get_query_var('paged')?get_query_var('paged'):1;
                if ($theme_slug) {
                    $theme = $theme_slug;
                } else {
                    $theme = get_stylesheet();
                }
                $themes_list = templateberg_get_current_theme_templates($paged, $theme);
                if ($themes_list && 'nothing' !== $themes_list) {
                    $is_available = true;
                }
                break;

            case 'available-themes':
                $paged = get_query_var('paged')?get_query_var('paged'):1;
                $themes_list = templateberg_get_theme_templates($paged);
                if ($themes_list) {
                    $is_available = true;
                }
                break;

            default:
                $paged = get_query_var('paged')?get_query_var('paged'):1;
                $templates_list = templateberg_get_gutenberg_templates($paged);
                if ($templates_list) {
                    $is_available = true;
                }
                break;
        }

        return $is_available;
    }
}

/**
 * Function set gutenberg templates
 *
 * @param  [array] $attr
 * @return boolean
 */
if (!function_exists('templateberg_set_gutenberg_templates')) {
    function templateberg_set_gutenberg_templates($templates_list, $paged = 1)
    {
        $is_set = false;
        $message = array();
        if (set_transient('templateberg_gt_'.$paged, $templates_list, WEEK_IN_SECONDS) !== true) {
            global $wp_filesystem;
            if (! $wp_filesystem) {
                require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
            }
            $upload_dir = wp_upload_dir();
            $dir        = trailingslashit($upload_dir['basedir']) . 'templateberg' . DIRECTORY_SEPARATOR;

            WP_Filesystem();
            if (! $wp_filesystem->is_dir($dir)) {
                $message[] = $dir . __(' not exists', 'templateberg');
                if ($wp_filesystem->mkdir($dir)) {
                    $message[] = $dir . __(' created', 'templateberg');
                } else {
                    $message[] = $dir . __(' create permission issue', 'templateberg');
                }
            } else {
                $message[] = $dir . __(' exists', 'templateberg');
            }
            $templates_list = json_encode($templates_list);
            if ($wp_filesystem->put_contents($dir . 'gt-'.$paged.'.json', $templates_list, 0644)) {
                $is_set = true;
                $message[] = __('Successfully created file ', 'templateberg') . 'gt-'.$paged.'.json';
            } else {
                $message[] = __('Permission denied to create file ', 'templateberg') . 'gt-'.$paged.'.json';
            }
        } else {
            $is_set = true;
        }
        return $is_set;
    }
}

/**
 * Function get gutenberg templates
 *
 * @param  [array] $attr
 * @return boolean
 */
if (!function_exists('templateberg_get_gutenberg_templates')) {
    function templateberg_get_gutenberg_templates($paged = 1)
    {
        $templates_list = get_transient('templateberg_gt_'.$paged);
        if (!$templates_list) {
            $upload_dir = wp_upload_dir();
            $file_dir = $upload_dir['basedir'] . '/templateberg/'.'gt-'.$paged.'.json';
            if (file_exists($file_dir)) {
                $file_url = $upload_dir['baseurl'] . '/templateberg/'.'gt-'.$paged.'.json';
                $body_args = array(
                    /*API version*/
                        'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                        'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $file_url,
                    array(
                                'timeout' => 100,
                                'body'    => $body_args,
                        )
                );
                if (! is_wp_error($raw_json)) {
                    $templates_list = json_decode(wp_remote_retrieve_body($raw_json), true);
                } else {
                    $templates_list = false;
                }
            }
        }
        return $templates_list;
    }
}

/**
 * Function set editor templates
 *
 * @param  [array] $templates_list
 * @param  [int] $paged
 * @return boolean
 */
if (!function_exists('templateberg_set_editor_templates')) {
    function templateberg_set_editor_templates($templates_list, $paged = 1)
    {
        $is_set = false;
        $message = array();
        ob_start();
        $is_transient_saved = set_transient('templateberg_edt_'.$paged, $templates_list, WEEK_IN_SECONDS);
        ob_clean();
        if ($is_transient_saved !== true) {
            global $wp_filesystem;
            if (! $wp_filesystem) {
                require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
            }
            $upload_dir = wp_upload_dir();
            $dir        = trailingslashit($upload_dir['basedir']) . 'templateberg' . DIRECTORY_SEPARATOR;

            WP_Filesystem();
            if (! $wp_filesystem->is_dir($dir)) {
                $message[] = $dir . __(' not exists', 'templateberg');
                if ($wp_filesystem->mkdir($dir)) {
                    $message[] = $dir . __(' created', 'templateberg');
                } else {
                    $message[] = $dir . __(' create permission issue', 'templateberg');
                }
            } else {
                $message[] = $dir . __(' exists', 'templateberg');
            }
            $templates_list = json_encode($templates_list);
            if ($wp_filesystem->put_contents($dir . 'edt-'.$paged.'.json', $templates_list, 0644)) {
                $is_set = true;
                $message[] = __('Successfully created file ', 'templateberg') . 'edt-'.$paged.'.json';
            } else {
                $message[] = __('Permission denied to create file ', 'templateberg') . 'edt-'.$paged.'.json';
            }
        } else {
            $is_set = true;
        }
        return $is_set;
    }
}

/**
 * Function get editor templates
 *
 * @param  [int] $paged
 * @return array
 */
if (!function_exists('templateberg_get_editor_templates')) {
    function templateberg_get_editor_templates($paged = 1)
    {
        $templates_list = get_transient('templateberg_edt_'.$paged);
        if (!$templates_list) {
            $upload_dir = wp_upload_dir();
            $file_dir = $upload_dir['basedir'] . '/templateberg/'.'edt-'.$paged.'.json';
            if (file_exists($file_dir)) {
                $file_url = $upload_dir['baseurl'] . '/templateberg/'.'edt-'.$paged.'.json';
                $body_args = array(
                    /*API version*/
                        'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                        'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $file_url,
                    array(
                                'timeout' => 100,
                                'body'    => $body_args,
                        )
                );
                if (! is_wp_error($raw_json)) {
                    $templates_list = json_decode(wp_remote_retrieve_body($raw_json), true);
                } else {
                    $templates_list = false;
                }
            }
        }
        return $templates_list;
    }
}

/**
 * Function set theme templates
 *
 * @param  [array] $templates_list
 * @param  [int] $paged
 * @return boolean
 */
if (!function_exists('templateberg_set_theme_templates')) {
    function templateberg_set_theme_templates($templates_list, $paged = 1)
    {
        $is_set = false;
        $message = array();
        if (set_transient('templateberg_tt_'.$paged, $templates_list, 'WEEK_IN_SECONDS') !== true) {
            global $wp_filesystem;
            if (! $wp_filesystem) {
                require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
            }
            $upload_dir = wp_upload_dir();
            $dir        = trailingslashit($upload_dir['basedir']) . 'templateberg' . DIRECTORY_SEPARATOR;

            WP_Filesystem();
            if (! $wp_filesystem->is_dir($dir)) {
                $message[] = $dir . __(' not exists', 'templateberg');
                if ($wp_filesystem->mkdir($dir)) {
                    $message[] = $dir . __(' created', 'templateberg');
                } else {
                    $message[] = $dir . __(' create permission issue', 'templateberg');
                }
            } else {
                $message[] = $dir . __(' exists', 'templateberg');
            }
            $templates_list = json_encode($templates_list);
            if ($wp_filesystem->put_contents($dir . 'tt-'.$paged.'.json', $templates_list, 0644)) {
                $is_set = true;
                $message[] = __('Successfully created file ', 'templateberg') . 'tt-'.$paged.'.json';
            } else {
                $message[] = __('Permission denied to create file ', 'templateberg') . 'tt-'.$paged.'.json';
            }
        } else {
            $is_set = true;
        }
        return $is_set;
    }
}

/**
 * Function get editor templates
 *
 * @param  [int] $paged
 * @return array
 */
if (!function_exists('templateberg_get_theme_templates')) {
    function templateberg_get_theme_templates($paged = 1)
    {
        $templates_list = get_transient('templateberg_tt_'.$paged);
        if (!$templates_list) {
            $upload_dir = wp_upload_dir();
            $file_dir = $upload_dir['basedir'] . '/templateberg/'.'tt-'.$paged.'.json';
            if (file_exists($file_dir)) {
                $file_url = $upload_dir['baseurl'] . '/templateberg/'.'tt-'.$paged.'.json';
                $body_args = array(
                    /*API version*/
                        'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                        'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $file_url,
                    array(
                                'timeout' => 100,
                                'body'    => $body_args,
                        )
                );
                if (! is_wp_error($raw_json)) {
                    $templates_list = json_decode(wp_remote_retrieve_body($raw_json), true);
                } else {
                    $templates_list = false;
                }
            }
        }
        return $templates_list;
    }
}

/**
 * Function set current theme templates
 *
 * @param  [array] $templates_list
 * @param  [int] $paged
 * @return boolean
 */
if (!function_exists('templateberg_set_current_theme_templates')) {
    function templateberg_set_current_theme_templates($templates_list, $paged = 1, $theme_slug = '')
    {
        $is_set = false;
        $message = array();
        if ($theme_slug) {
            $theme = $theme_slug;
        } else {
            $theme = get_stylesheet();
        }
        if (set_transient('templateberg_ct_'.$theme.'_templates_'.$paged, $templates_list, 'WEEK_IN_SECONDS') !== true) {
            global $wp_filesystem;
            if (! $wp_filesystem) {
                require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
            }
            $upload_dir = wp_upload_dir();
            $dir        = trailingslashit($upload_dir['basedir']) . 'templateberg' . DIRECTORY_SEPARATOR;

            WP_Filesystem();
            if (! $wp_filesystem->is_dir($dir)) {
                $message[] = $dir . __(' not exists', 'templateberg');
                if ($wp_filesystem->mkdir($dir)) {
                    $message[] = $dir . __(' created', 'templateberg');
                } else {
                    $message[] = $dir . __(' create permission issue', 'templateberg');
                }
            } else {
                $message[] = $dir . __(' exists', 'templateberg');
            }
            $templates_list = json_encode($templates_list);
            if ($wp_filesystem->put_contents($dir . 'ct-'.$theme.'-'.$paged.'.json', $templates_list, 0644)) {
                $is_set = true;
                $message[] = __('Successfully created file ', 'templateberg') . 'ct-'.$theme.'-'.$paged.'.json';
            } else {
                $message[] = __('Permission denied to create file ', 'templateberg') . 'ct-'.$theme.'-'.$paged.'.json';
            }
        } else {
            $is_set = true;
        }
        return $is_set;
    }
}

/**
 * Function get current theme templates
 *
 * @param  [int] $paged
 * @return array
 */
if (!function_exists('templateberg_get_current_theme_templates')) {
    function templateberg_get_current_theme_templates($paged = 1, $theme_slug = '')
    {
        if ($theme_slug) {
            $theme = $theme_slug;
        } else {
            $theme = get_stylesheet();
        }

        $templates_list = get_transient('templateberg_ct_'.$theme.'_templates_' . $paged);
        if (!$templates_list) {
            $upload_dir = wp_upload_dir();
            $file_dir = $upload_dir['basedir'] . '/templateberg/'.'ct-'.$theme.'-'.$paged.'.json';
            if (file_exists($file_dir)) {
                $file_url = $upload_dir['baseurl'] . '/templateberg/'.'ct-'.$theme.'-'.$paged.'.json';
                $body_args = array(
                    /*API version*/
                        'api_version' => TEMPLATEBERG_VERSION,
                    /*lang*/
                        'site_lang'   => get_bloginfo('language'),
                );
                $raw_json  = wp_safe_remote_get(
                    $file_url,
                    array(
                                'timeout' => 100,
                                'body'    => $body_args,
                        )
                );
                if (! is_wp_error($raw_json)) {
                    $templates_list = json_decode(wp_remote_retrieve_body($raw_json), true);
                } else {
                    $templates_list = false;
                }
            }
        }
        return $templates_list;
    }
}

/**
 * Function check if templates has set up
 *
 * @param  [array] $attr
 * @return boolean
 */
if (!function_exists('templateberg_current_theme_is_nothing')) {
    function templateberg_current_theme_is_nothing()
    {
        $is_available = false;
        $paged = get_query_var('paged')?get_query_var('paged'):1;
        $theme = get_stylesheet();
        $themes_list = templateberg_get_current_theme_templates($paged, $theme);
        if ('nothing' === $themes_list) {
            $is_available = true;
        }
        return $is_available;
    }
}
