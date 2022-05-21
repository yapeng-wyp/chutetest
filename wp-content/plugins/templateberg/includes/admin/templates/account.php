<div class="tb-all_content_wrap">
<?php
$account_info = templateberg_connect()->get_account();
require_once TEMPLATEBERG_PATH . 'includes/admin/templates/header.php';
?>
    <div class="tb-account">
        <div class="tb-account__content">
            <div class="tb-container">
                <div class="tb-row">
                    <div class="tb-col-3">
                        <div class="tb-account__details">
                            <div class="tb-account__profile tb-text__center">
                                <div class="tb-account__pic">
                                    <?php echo get_avatar($account_info['email'], 100); ?>
                                </div>
                                <div class="tb-account__info">
                                    <h5>
                                        <a href="https://templateberg.com/dashboard/">
                                            <?php echo esc_html($account_info['user-name']); ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="tb-account__details">
                            <h6> <?php esc_html_e('Contact Information', 'templateberg'); ?></h6>
                            <ul>

                                <li>
                                    <span class="dashicons dashicons-email"></span>
                                    <strong>
                                        <?php esc_html_e('Support:', 'templateberg'); ?>
                                    </strong>
                                    <a href="https://templateberg.com/contact/">
                                        <?php esc_html_e('Create A Ticket', 'templateberg'); ?>
                                    </a>
                                </li>

                                <li>
                                    <span class="dashicons dashicons-email"></span>
                                    <strong>
                                        <?php esc_html_e('Email:', 'templateberg'); ?>
                                    </strong>
                                    <a href="mailto:support@templateberg.com">
                                        <?php esc_html_e('support@templateberg.com', 'templateberg'); ?>
                                    </a>
                                </li>

                            </ul>

                            <h6><?php esc_html_e('Social Network', 'templateberg'); ?></h6>
                            <ul class="tb-social__links">
                                <li>
                                    <a href="https://www.facebook.com/templateberg">
                                        <span class="dashicons dashicons-facebook-alt"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/templateberg">
                                        <span class="dashicons dashicons-twitter"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/in/templateberg/">
                                        <span class="dashicons dashicons-linkedin"></span>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="tb-col-9">
                        <div class="tb-account__connection">
                            <div class="tb-row">
                                <div class="tb-col-12">
                                    <h3 class="tb-account__heading">
                                        <?php esc_html_e('Connections', 'templateberg'); ?>
                                    </h3>
                                </div>
                                <div class="tb-col-6">
                                    <div class="tb-account__details">
                                        <h6><?php esc_html_e('Site Connection', 'templateberg'); ?></h6>
                                        <div class="tb-connection__wrap">
                                            <div class="tb-connection__pic">
                                                <?php
                                                $site_icon = admin_url('images/w-logo-blue.png');
                                                if (get_site_icon_url()) {
                                                    $site_icon = get_site_icon_url();
                                                } elseif (get_theme_mod('custom_logo')) {
                                                    $custom_logo_id = get_theme_mod('custom_logo');
                                                    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                                                    $site_icon = $image[0];
                                                }
                                                ?>
                                                <img
                                                        src="<?php echo esc_url($site_icon)?>"
                                                        alt="<?php echo esc_url(get_bloginfo('name')); ?>"
                                                        width="80"
                                                        height="80"
                                                />
                                            </div>
                                            <div class="tb-connection__desc">
                                                <p>
                                                    <?php esc_html_e(
                                                        'Your Site is connected to Templateberg.com',
                                                        'templateberg'
                                                    );
                                                                ?>
                                                    <span>
                                                        <?php esc_html_e(
                                                            'Enjoy Templateberg.',
                                                            'templateberg'
                                                        );
?>
                                                    </span>
                                                </p>
                                                <a id="tb-open-manage-connection"
                                                   href="#"
                                                   class="tb-btn tb-btn__primary">
                                                    <?php esc_html_e('Manage Connection', 'templateberg'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tb-col-6">
                                    <div class="tb-account__details">
                                        <h6><?php esc_html_e('Account Connection', 'templateberg'); ?></h6>
                                        <div class="tb-connection__wrap">
                                            <div class="tb-connection__pic">
                                                <?php echo get_avatar($account_info['email'], 80)?>
                                            </div>
                                            <div class="tb-connection__desc">
                                                <p>
                                                    <?php esc_html_e('Connected as', 'templateberg'); ?>
                                                    <strong>
                                                        <?php
                                                        echo esc_html($account_info['user-name']);
                                                        ?>
                                                    </strong>
                                                    <span><?php echo esc_html($account_info['email']);?></span>
                                                </p>
                                                <a href="https://templateberg.com/dashboard/"
                                                   target="_blank"
                                                   class="tb-btn tb-btn__primary">
                                                    <?php esc_html_e('Manage Account', 'templateberg'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tb-purchase__info">
                                <div class="tb-row">
                                    <div class="tb-col-12">
                                        <h3 class="tb-global__heading tb-account__heading">
                                            <?php esc_html_e('Purchase Information', 'templateberg'); ?>
                                            <a href="#" class="tb-data__sync tb-data__purchase_sync">
                                                <i class="dashicons dashicons-image-rotate"></i>
                                                <?php esc_html_e('Sync', 'templateberg'); ?>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="tb-col-12 tb-purchase__data">
                                        <?php
                                        templateberg_get_payment_info_html()
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tb-templates">
                                <div class="tb-row">
                                    <div class="tb-col-12">
                                        <h3 class="tb-account__heading">
                                            <?php esc_html_e('Available Templates', 'templateberg'); ?>
                                            <a href="#" class="tb-data__sync tb-data__free_sync" style="display: none">
                                                <i class="dashicons dashicons-image-rotate"></i>
                                                <?php esc_html_e('Sync', 'templateberg'); ?>
                                            </a>
                                        </h3>
                                        <a href="https://templateberg.com/wordpress-themes-template-kits/" class="tb-btn tb-btn__primary" target="_blank">
                                            <?php esc_html_e('Themes Template Kits', 'templateberg'); ?>
                                        </a>
                                        <a href="https://templateberg.com/gutenberg-templates/" class="tb-btn tb-btn__primary" target="_blank">
                                            <?php esc_html_e('Gutenberg Templates', 'templateberg'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="tb-templates__wrap">
                                    <div class="tb-templates__list">
                                        <?php
                                        templateberg_get_free_templates_html()
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            require_once TEMPLATEBERG_PATH . 'includes/admin/templates/faq.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The modal / dialog box, hidden somewhere near the footer -->
        <div id="tb-manage-connection" class="hidden">
            <div class="tb-manage-connection-wrap">
                <div class="tb-manage__body">

                    <p class="tb-manage__info">
                        <?php esc_html_e('Templateberg power you to create site quickly and easily.', 'templateberg'); ?>
                        <?php esc_html_e("You don't have to spend hours trying to create a template and block design.", 'templateberg'); ?>
                        <?php esc_html_e("With a click the block and template will import on your site and you can change text, image and customize it for your needs.", 'templateberg'); ?>
                        <?php esc_html_e("Once you disconnect Templateberg, these features will no longer be available and you may no longer create design faster.", 'templateberg'); ?>
                    </p>
                    <h4 class="tb-manage__title"><?php esc_html_e('Templateberg power you to create any of the following websites.', 'templateberg'); ?></h4>
                    <ul class="tb-manage__tempList">
                        <li><?php esc_html_e('Blog', 'templateberg'); ?></li>
                        <li><?php esc_html_e('News & Magazine', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Multipurpose', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Ecommerce/WooCommerce', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Easy Digital Downloads', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Business', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Finance', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Automotive', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Consultant', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Medical', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Education', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Photography', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Construction', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Travel', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Fitness', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Restaurant', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Lawyer', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Charity', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Portfolio', 'templateberg'); ?></li>
                        <li><?php esc_html_e('Beauty', 'templateberg'); ?></li>
                        <li><?php esc_html_e('And many more....', 'templateberg'); ?></li>
                    </ul>
                    <div class="tb-info__box">
                        <div class="tb-manage__help tb-text__center">
                            <p><?php esc_html_e('Have a question? We’d love to help! Send a question to the Templateberg support team.', 'templateberg'); ?></p>
                            <a id="tb-send-question-btn" class="tb-manage-help__link tb-btn tb-btn__primary tb-btn__lg" href="https://templateberg.com/contact/" rel="noopener noreferrer" target="_blank">
                                <?php esc_html_e('Send a question', 'templateberg'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tb-manage__footer">
                    <p><?php esc_html_e('Are you sure you want to disconnect?', 'templateberg'); ?></p>
                    <div class="tb-manage__button-row">
                        <a id="tb-cancel-btn" type="button" class="tb-btn tb-btn__primary">
                            <?php esc_html_e('Cancel', 'templateberg'); ?>
                        </a>
                        <a id="tb-reset-btn" href="<?php echo esc_url(templateberg_connect()->get_remote_connect_url(true))?>" target="_blank" type="button" class="tb-btn tb-btn__sucess tb-btn__reset">
                            <?php esc_html_e('Reset Connect', 'templateberg'); ?>
                        </a>
                        <a type="button" href="<?php echo esc_url(templateberg_connect()->get_remote_disconnect_url())?>" class="tb-btn tb-btn__default">
                            <?php esc_html_e('Disconnect', 'templateberg'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
