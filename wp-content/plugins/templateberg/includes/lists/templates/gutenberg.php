<?php
$paged = get_query_var('paged')?get_query_var('paged'):1;
$templates_list = templateberg_get_gutenberg_templates($paged);
$templates_list_popular = get_transient('templateberg_gt_p_'.$paged);
$total_posts = get_transient('templateberg_gt_total');
$max_pages = get_transient('templateberg_gt_max');

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
templateberg_template_lists_data()->run($templates_list);
$data = templateberg_template_lists_data()->data;
?>

<link rel="stylesheet" id="templateberg-dashboard-shortcode-css" href="<?php echo TEMPLATEBERG_URL . 'dist/list.css' ?>" type="text/css" media="all">

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
                $current_tab = '';
                $current_tab_cats = array();
                $count_items = templateberg_template_lists_data()->countItems;
                if (isset($data['template-kits'])) {
                    $current_tab ='template-kits';
                    $current_tab_cats =$count_items['template-kits'];
                } elseif (isset($data['templates'])) {
                    $current_tab ='templates';
                    $current_tab_cats =$count_items['templates'];
                } elseif (isset($data['blocks'])) {
                    $current_tab ='blocks';
                    $current_tab_cats =$count_items['blocks'];
                }
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html__('All Items', 'templateberg'); ?><span><?php echo $count;?></span></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class=""><a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?><span><?php echo $count;?></span></a></li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <ul class="tb-list__cat_lists tb-cat-lists-free">
                <?php
                $count_items = templateberg_template_lists_data()->countFreeItems;
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all-free') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html__('All Items', 'templateberg'); ?><span><?php echo $count;?></span></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class=""><a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?><span><?php echo $count;?></span></a></li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <ul class="tb-list__cat_lists tb-cat-lists-pro">
                <?php
                $count_items = templateberg_template_lists_data()->countProItems;
                if (!empty($current_tab_cats)) {
                    foreach ($current_tab_cats as $cat => $count) {
                        if ($cat === 'all-pro') {
                            ?>
                            <li class="tb-list__current_item">
                                <a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html__('All Items', 'templateberg'); ?><span><?php echo $count;?></span></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class=""><a href="#" data-cat="<?php echo esc_attr($cat);?>"><?php echo esc_html(ucwords(str_replace("-", " ", $cat)));?><span><?php echo $count;?></span></a></li>
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
                <?php
                $current_tab_data = array();
                if (isset($data['template-kits'])) {
                    if (empty($current_tab_data)) {
                        $current_tab_data = $data['template-kits'];
                    }
                    ?>
                    <a href="#" class="tb-list__cat_btn <?php echo $current_tab ==='template-kits'?'is-selected':'';?>" data-type="template-kits">
                        <i class="fas fa-images"></i>
                        <?php echo esc_html__('Template Kits', 'templateberg'); ?>
                    </a>
                    <?php
                }
                if (isset($data['templates'])) {
                    if (empty($current_tab_data)) {
                        $current_tab_data = $data['templates'];
                    }
                    ?>
                    <a href="#" class="tb-list__cat_btn <?php echo $current_tab ==='templates'?'is-selected':'';?>" data-type="templates">
                        <i class="far fa-file"></i>
                        <?php echo esc_html__('Templates', 'templateberg'); ?>
                    </a>
                    <?php
                }
                if (isset($data['blocks'])) {
                    if (empty($current_tab_data)) {
                        $current_tab_data = $data['blocks'];
                    }
                    ?>
                    <a href="#" class="tb-list__cat_btn <?php echo $current_tab ==='blocks'?'is-selected':'';?>" data-type="blocks">
                        <i class="fas fa-th-large"></i>
                        <?php echo esc_html__('Blocks', 'templateberg'); ?>
                    </a>
                    <?php
                }
                ?>
            </div>
            <div class="tb-list__actions">
                <div class="tb-list__sorting">
                    <label for="tb-list__sorting_select"><?php echo esc_html__('Sort by:', 'templateberg'); ?></label>
                    <select name="tb-list__sorting" id="tb-list__sorting_select">
                        <option value="newest" selected><?php echo esc_html__('Newest Items', 'templateberg'); ?></option>
                        <option value="popularity"><?php echo esc_html__('Popular Items', 'templateberg'); ?></option>
                    </select>
                </div>
                <!--Added-->
                <div class="tb-gutenberg-templates-refresh">
                    <span class="dashicon dashicons dashicons-image-rotate"></span>
                </div>
            </div>
        </div>
        <div class="tb-list__content">
            <?php
            if (!empty($current_tab_data)) {
                foreach ($current_tab_data as $item) {
                    ?>
                    <div aria-label="<?php echo esc_attr($item['title'])?>" class="tb-list__item" data-id="<?php echo esc_attr($item['id'])?>" data-type="<?php echo esc_attr($item['type']);?>">
                        <div class="tb-list__item_preview">
                            <img src="<?php echo esc_url($item['screenshot_url']);?>" loading="lazy">
                            <span class="tb-list__author"><i class="fas fa-user"></i>
                            <?php echo esc_html__('By : ', 'templateberg').esc_html(ucwords($item['author'])); ?>
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
                                if (isset($item['templates']) && is_array($item['templates']) && count($item['templates'])) {
                                    echo '<span class="tb-list__item-tk-count">'.count($item['templates']).' Templates</span>';
                                }
                                ?>
                            </div>
                            <div class="tb-list__item_actions">
                                <a class="tb-item__preview_link" href="<?php echo esc_url($item['demo_url']);?>" target="_blank"><?php echo esc_html__('Preview', 'templateberg'); ?></a>
                                <a class="tb-list__item_btn tb-list__item_buy_btn" data-id="<?php echo esc_attr($item['id'])?>" data-is_pro="<?php echo esc_attr(( $tb_download_price > 0 ) ? 'pro' : 'free'); ?>" href="<?php echo esc_url($item['permalink'])?>" target="_blank" rel="noopener">
                                    <?php if ($tb_download_price > 0) :
                                        echo esc_html__('Purchase', 'templateberg');
                                    else :
                                        echo esc_html__('Get It Free', 'templateberg');
                                    endif;
                                    ?>
                                </a>
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
require_once TEMPLATEBERG_PATH . 'includes/lists/templates/gutenberg-buy-preview.php';
// Scripts.
wp_enqueue_script(
    'templateberg-gutenberg', // Handle.
    TEMPLATEBERG_URL . 'dist/gutenberg.min.js', // Block.build.js: We register the block here. Built with Webpack.
    array( 'jquery' ), // Dependencies, defined above.
    TEMPLATEBERG_VERSION, // Version: File modification time.
    true // Enqueue the script in the footer.
);
wp_localize_script(
    'templateberg-gutenberg',
    'templateberg_gutenberg',
    array(
                'restNonce'          => wp_create_nonce('wp_rest'),
                'restUrl'            => esc_url_raw(rest_url()),
                'currentTab'           => $current_tab,
                'popularList'           => $templates_list_popular,
                'normalList'           => $templates_list,
                'text'          => array(
                        'preview' => esc_html__('Preview', 'templateberg'),
                        'purchase' => esc_html__('Purchase', 'templateberg'),
                        'noItem' => esc_html__('No item on selected categories!', 'templateberg'),
                        'allItems' => esc_html__('All Items', 'templateberg'),
                        'by' => esc_html__('By', 'templateberg'),
                        'templates' => esc_html__('Templates', 'templateberg'),
                ),
        )
);
