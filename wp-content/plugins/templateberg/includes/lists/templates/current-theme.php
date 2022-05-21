<link rel="stylesheet" id="templateberg-dashboard-shortcode-css" href="<?php echo TEMPLATEBERG_URL . 'dist/list.css' ?>" type="text/css" media="all">
<?php

$active = isset($_GET['type']) && $_GET['type']?$_GET['type']:'current';
if (templateberg_theme_templates()->is_selected_theme()) {
    $theme = $_GET['slug'];
} else {
    $theme = get_stylesheet();
}

require_once TEMPLATEBERG_PATH . 'includes/lists/templates/theme-buy-preview.php';
require_once TEMPLATEBERG_PATH . 'includes/lists/templates/getting-started.php';
if (!templateberg_has_templates('current-theme', $theme)) {
    ?>
    <div class="tb-connect__notice tb-text__center">
        <div class="tb-connect__icon">
            <img src="http://localhost/templateberg/wp-content/plugins/templateberg/assets/img/logo-48x48.png" alt="Templateberg">
        </div>
        <h4 class="tb-connect__title">
            <?php
            esc_html_e('You need to click on the Refresh button below or The current theme does not have Templates on Templateberg.', 'templateberg');
            ?>
        </h4>
        <p class="tb-connect__desc">
            <?php
            esc_html_e("Templateberg power you to create site quickly and easily. You don't have to spend hours trying to create a template and block design. With a click your favourite template design will import on your site and you can change text, image and customize it for your needs.", 'templateberg');
            ?>
        <p class="tb-connect__gutentor">
        </p>
        <a href="#" class="tb-btn tb-btn__primary tb-btn__lg tb-current-themes-template-kits-refresh"><?php esc_html_e('Refresh', 'templateberg');?></a>
        <a href="#" class="tb-btn tb-btn__primary tb-btn__lg tb-list__theme_type" data-type="available"><?php esc_html_e('View Available Themes Template Kits', 'templateberg');?></a>
    </div>
    <?php
    return;
}
$paged = get_query_var('paged')?get_query_var('paged'):1;
$themes_list_popular = get_transient('templateberg_ct_p_'.$paged);

$themes_list = templateberg_get_current_theme_templates($paged, $theme);

$max_pages = get_transient('templateberg_ct_'.$theme.'_max');
$total_themes = get_transient('templateberg_ct_'.$theme.'_total');

$purchased_items = get_transient('templateberg_ct_'.$theme.'_total');

$current_theme_purchase_id = templateberg_connect()->get_current_theme_purchase_templates_id();
/**
 * Create Instance for Templateberg_Template_Lists_Data
 *
 * @since    1.0.0
 * @access   public
 *
 * @param
 *
 * @return object
 */
templateberg_template_lists_data()->setup_themes($themes_list);
$data = templateberg_template_lists_data()->data;
echo '<div class="ai-content-blocker hidden">';
echo '<div class="ai-notification-title"><p>' . esc_html__('Processing... Please do not refresh this page or do not go to other url!', 'templateberg') . '</p></div>';
echo '<div id="ai-demo-popup"></div>';
echo '</div>';
?>
<div class="tb-list__template" role="document">
    <div class="tb-list__sidebar">
        <div class="tb-list__search">
            <input class="tb-list__searchinput" type="text" id="" placeholder="Search" value="">
            <i class="fas fa-search" tabindex="-1"></i>
        </div>
        <div class="tb-list__categories"><h3><?php echo esc_html__('Categories', 'templateberg'); ?></h3>
            <div class="tb-list__categories-filter-wrap">
                <ul class="tb-list__categories-wrap-tab">
                    <li class="tb-list__categories-tab-item tb-filter-active" data-id="all"><?php echo esc_html__('All', 'templateberg'); ?></li>
                    <li class="tb-list__categories-tab-item" data-id="free"><?php echo esc_html__('Free', 'templateberg'); ?></li>
                    <li class="tb-list__categories-tab-item" data-id="pro"><?php echo esc_html__('Pro', 'templateberg'); ?></li>
                </ul>
            </div>
            <ul class="tb-list__cat_lists tb-cat-lists-all tb-cats-content-active">
                <?php
                $current_tab_cats = array();
                $count_items = templateberg_template_lists_data()->countItems;
                if (isset($count_items['all'])) {
                    $current_tab_cats =$count_items['all'];
                }
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html__('All Items', 'templateberg'); ?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <ul class="tb-list__cat_lists tb-cat-lists-free">
                <?php
                $current_tab_cats = array();
                $count_items = templateberg_template_lists_data()->countFreeItems;
                if (isset($count_items['all'])) {
                    $current_tab_cats =$count_items['all'];
                }
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all-free') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html__('All Items', 'templateberg'); ?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <ul class="tb-list__cat_lists tb-cat-lists-pro">
                <?php
                $current_tab_cats = array();
                $count_items = templateberg_template_lists_data()->countProItems;
                if (isset($count_items['all'])) {
                    $current_tab_cats =$count_items['all'];
                }
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all-pro') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html__('All Items', 'templateberg'); ?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>">
                                    <?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?>
                                    <span><?php echo $count;?></span>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="tb-list__container">
        <div>
            <span class="tb-list__btn"><i class="fas fa-bars"></i></span>
        </div>
        <div class="tb-list__header">
            <div class="tb-list__links">
                <a href="#" class="tb-list__cat_btn" data-type="purchased">
                    <i class="fas fa-history"></i>
                    <?php echo esc_html__('Purchased', 'templateberg'); ?>
                </a>
                <a href="#" class="tb-list__cat_btn is-selected" data-type="all">
                    <i class="fas fa-images"></i>
                    <?php echo esc_html__('All', 'templateberg'); ?>
                </a>
                <?php
                $current_tab_data = $data['all'];
                if (isset($data['normal'])) {
                    ?>
                    <a href="#" class="tb-list__cat_btn" data-type="normal">
                        <i class="fas fa-images"></i>
                        <?php echo esc_html__('Normal', 'templateberg'); ?>
                    </a>
                    <?php
                }
                if (isset($data['gutenberg'])) {
                    ?>
                    <a href="#" class="tb-list__cat_btn" data-type="gutenberg">
                        <i class="far fa-file"></i>
                        <?php echo esc_html__('Gutenberg', 'templateberg'); ?>
                    </a>
                    <?php
                }
                if (isset($data['full-site-editing'])) {
                    ?>
                    <a href="#" class="tb-list__cat_btn" data-type="full-site-editing">
                        <i class="fas fa-th-large"></i>
                        <?php echo esc_html__('Full Site Editing', 'templateberg'); ?>
                    </a>
                    <?php
                }
                if (isset($data['elementor'])) {
                    ?>
                    <a href="#" class="tb-list__cat_btn" data-type="elementor">
                        <i class="fas fa-th-large"></i>
                        <?php echo esc_html__('Elementor', 'templateberg'); ?>
                    </a>
                    <?php
                }
                ?>
            </div>
            <div class="tb-list__actions">
                <div class="tb-list__sorting">
                    <label for="tb-list__sorting_select"><?php echo esc_html__('Sort by', 'templateberg'); ?> :</label>
                    <select name="tb-list__sorting" id="tb-list__sorting_select">
                        <option value="newest" selected><?php echo esc_html__('Newest Items', 'templateberg'); ?></option>
                        <option value="popularity"><?php echo esc_html__('Popular Items', 'templateberg'); ?></option>
                    </select>
                </div>
                <!--Added-->
                <div class="tb-current-themes-template-kits-refresh">
                    <span class="dashicon dashicons dashicons-image-rotate"></span>
                </div>
            </div>
        </div>
        <div class="tb-list__content">
            <?php
            if (!empty($current_tab_data)) {
                foreach ($current_tab_data as $item) {
                    ?>
                    <div aria-label="<?php echo esc_attr($item['title'])?>"
                         class="tb-list__item tb-list__active_theme" data-id="<?php echo esc_attr($item['id'])?>"
                         data-type="<?php echo esc_attr($item['type']);?>">
                        <div class="tb-list__item_preview">
                            <img src="<?php echo esc_url($item['screenshot_url']);?>" loading="lazy" alt="<?php echo esc_attr($item['title'])?>" />
                            <span class="tb-list__author"><i class="fas fa-user"></i>
                                            <?php
                                            echo esc_html__('By : ', 'templateberg').
                                                 esc_html(ucwords($item['author'])); ?>
                                        </span>
                        </div>
                        <div class="tb-list__item_footer">
                            <div class="tb-list__item_price">
                                <?php $tb_download_price = (int) $item['price']; ?>
                                <span>
                                                <?php
                                                if ($tb_download_price > 0) :
                                                    echo wp_kses_post($item['price_with_symbol']);
                                                else :
                                                    echo esc_html__('Free', 'templateberg');
                                                endif;
                                                ?>
                                            </span>
                            </div>
                            <div class="tb-list__item_meta">
                                <h4>
                                    <a class="tb-list__item_title_link" href="<?php echo esc_url($item['permalink'])?>" target="_blank" rel="noopener">
                                        <?php echo esc_attr($item['title'])?>
                                    </a>
                                </h4>

                                <?php
                                if (isset($item['theme'])) {
                                    ?>
                                    <span class="tb-list__item-theme">
										<span class="tb-list__item-theme--link" data-theme_slug="<?php echo esc_attr($item['theme']['slug'])?>" ><span class="dashicons dashicons-saved"></span><?php echo esc_attr($item['theme']['name'])?></span>
									</span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tb-list__item_actions">
                                <a class="tb-item__preview_link" href="<?php echo esc_url($item['demo_url']);?>" target="_blank"><?php echo esc_html__('Preview', 'templateberg'); ?></a>

                                <?php
                                if (templateberg_is_current_theme_template_available($item)) {
                                    ?>
                                    <a class="tb-list__item_btn tb-list__item_buy_btn"
                                       data-id="<?php echo esc_attr($item['id'])?>"
                                       data-is_pro="<?php echo esc_attr(( $tb_download_price > 0 ) ? 'pro' : 'free'); ?>"
                                       data-is_available="yes"
                                       data-theme_name="<?php echo esc_attr($item['theme']['name'])?>"
                                       data-theme_slug="<?php echo esc_attr($item['theme']['slug'])?>"
                                       href="<?php echo esc_url($item['permalink'])?>" target="_blank"
                                       rel="noopener"
                                    >
                                        <?php
                                        echo esc_html__('Import', 'templateberg');
                                        ?>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a class="tb-list__item_btn tb-list__item_buy_btn"
                                       data-id="<?php echo esc_attr($item['id'])?>"
                                       data-is_pro="<?php echo esc_attr(( $tb_download_price > 0 ) ? 'pro' : 'free'); ?>"
                                       data-is_available="no"
                                       data-theme_name="<?php echo esc_attr($item['theme']['name'])?>"
                                       data-theme_slug="<?php echo esc_attr($item['theme']['slug'])?>"
                                       href="<?php echo esc_url($item['permalink'])?>"
                                       target="_blank"
                                       rel="noopener"
                                    >
                                        <?php
                                        echo esc_html__('Purchase', 'templateberg');
                                        ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
        echo templateberg_pagination($paged, $max_pages);
        ?>
    </div>
</div>
<?php
// Scripts.
wp_enqueue_script(
    'templateberg-current-theme', // Handle.
    TEMPLATEBERG_URL . 'dist/current.min.js', // Block.build.js: We register the block here. Built with Webpack.
    array( 'jquery' ), // Dependencies, defined above.
    TEMPLATEBERG_VERSION, // Version: File modification time.
    true // Enqueue the script in the footer.
);
wp_localize_script(
    'templateberg-current-theme',
    'templateberg_current_theme',
    array(
                'restNonce'          => wp_create_nonce('wp_rest'),
                'restUrl'            => esc_url_raw(rest_url()),
                'purchasesIds'           => $current_theme_purchase_id,
                'popularThemes'           => $themes_list_popular,
                'allThemes'           => $themes_list,
                'text'          => array(
                        'import' => esc_html__('Import', 'templateberg'),
                        'purchase' => esc_html__('Purchase', 'templateberg'),
                        'preview' => esc_html__('Preview', 'templateberg'),
                        'noItem' => esc_html__('No item on selected categories!', 'templateberg'),
                        'allItems' => esc_html__('All Items', 'templateberg'),
                        'by' => esc_html__('By', 'templateberg'),
                        'templates' => esc_html__('Templates', 'templateberg'),
                ),
        )
);
