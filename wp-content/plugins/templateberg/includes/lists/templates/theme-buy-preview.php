<!--Loading HTML-->
<div id="tb-list__popup_loader" class="tb-modal__overlay" style="display:none;">
    <div class="tb-preview__main_loader">
        <div class="tb-preview__main_loading">
            <div class="tb-preview__lines"></div>
            <div class="tb-preview__lines"></div>
            <div class="tb-preview__lines"></div>
        </div>
    </div>
    <!--purchase button-->
</div>

<!--Buy now Popup-->
<div id="tb-list__item_buy_popup" class="tb-modal__overlay" style="display:none;">
    <div class="tb-preview__main_loader">
        <div class="tb-preview__main_loading">
            <div class="tb-preview__lines"></div>
            <div class="tb-preview__lines"></div>
            <div class="tb-preview__lines"></div>
        </div>
    </div>
    <!--purchase button-->
</div>

<!--Preview-->
<div id="tb-list__item_preview" class="tb-preview__wrapper" style="display: none">
    <div class="tb-preview__sidebar">
        <div class="tb-preview__header">
            <div class="tb-preview__actions">
                <button type="button" class="tb-preview__close">
                </button>
                <button type="button" class="tb-preview__prev">
                </button>
                <button type="button" class="tb-preview__next">
                </button>
            </div>
        </div>
        <div class="tb-preview__sidebar-content">
            <h4><?php echo esc_html__('Click', 'templateberg'); ?></h4>
            <div class="tb-preview__thumb">
                <img>
            </div>
            <div class="tb-preview__author">
                <i class="fas fa-user"></i>
                <?php echo esc_html__('By :', 'templateberg'); ?><span><?php echo esc_html__('Gutentor', 'templateberg'); ?></span>
            </div>
            <button type="button" tabindex="0" class="tb-list__item_btn tb-list__item_buy_btn" data-id="<?php echo esc_attr(get_the_ID())?>" data-is_pro="free">
            </button>
        </div>

        <div class="tb-preview__footer">
            <button type="button" class="tb-preview__collapse-btn">
                <span class="tb-preview__collapse-arrow"></span>
                <span class="tb-preview__collapse-label"><?php echo esc_html__('Hide Controls', 'templateberg'); ?></span>
            </button>
            <div class="tb-preview__devices-wrapper">
                <div class="tb-preview__devices">
                    <button type="button" class="tb-preview__desktop active" aria-pressed="true" data-device="desktop">
                        <span class="screen-reader-text"><?php echo esc_html__('Enter desktop preview mode', 'templateberg'); ?></span>
                    </button>
                    <button type="button" class="tb-preview__tablet" aria-pressed="false" data-device="tablet">
                        <span class="screen-reader-text"><?php echo esc_html__('Enter tablet preview mode', 'templateberg'); ?></span>
                    </button>
                    <button type="button" class="tb-preview__mobile" aria-pressed="false" data-device="mobile">
                        <span class="screen-reader-text"><?php echo esc_html__('Enter mobile preview mode', 'templateberg'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="tb-preview__main">
        <div class="tb-preview__main_loader">
            <div class="tb-preview__main_loading">
                <div class="tb-preview__lines"></div>
                <div class="tb-preview__lines"></div>
                <div class="tb-preview__lines"></div>
            </div>
        </div>
        <iframe id="tb-preview__frame" title="<?php esc_attr_e('Preview', 'templateberg'); ?>"></iframe>
    </div>
</div>

<!--Free Information-->

<div id="tb-list__item_free_popup" class="tb-modal__overlay" style="display: none">
    <div class="tb-modal">
        <div class="tb-modal__header">
            <h3 class="tb-modal__title"><?php esc_html_e('First Install Theme and After Import Demo', 'templateberg');?></h3>
            <a href="#" class="tb-modal__cancel">
                <span class="dashicons dashicons-no-alt"></span>
            </a>
        </div>
        <div class="tb-modal__content-wrap">
            <section class="tb-modal__content">
                <div class="tb-modal__content-info">
                    <h2 class="tb-modal__content-h">
                        <?php printf(esc_html__('1. First Install and Activate %1$s %2$s Theme', 'templateberg'), "<a href='".admin_url('theme-install.php?search=')."' target='_blank' class='tb-modal__theme_install_link'>", '</a>')?>
                    </h2>
                    <p class="tb-modal__content-p">
                        <?php printf(esc_html__('Another theme is activated currently, to install this template kit first you need to install  %1$s %2$s Theme', 'templateberg'), "<a href='".admin_url('theme-install.php?search=')."' target='_blank' class='tb-modal__theme_install_link'>", '</a>')?>
                    </p>
                    <p class="tb-modal__content-p">
                        <?php esc_html_e('Please install and activate the Theme.', 'templateberg');?>
                    </p>
                </div>
                <div class="tb-modal__content-img-wrap">
                <img src="<?php echo esc_url(TEMPLATEBERG_URL . 'assets/img/theme-install.png');?>" alt="<?php esc_attr_e('Templateberg', 'templateberg');?>">
                </div>
            </section>
            <section class="tb-modal__content">
                <div class="tb-modal__content-img-wrap">
                <img src="<?php echo esc_url(TEMPLATEBERG_URL . 'assets/img/theme-template-kits.png');?>" alt="<?php esc_attr_e('Templateberg', 'templateberg');?>">
                </div>
                <div class="tb-modal__content-info">
                    <h2 class="tb-modal__content-h">
                        <?php printf(esc_html__('2. Come back to %1$s Templateberg Themes Template Kits %2$s', 'templateberg'), "<a href='".admin_url('admin.php?page='.templateberg_theme_templates()->get_slug())."' class='tb-modal__comeback_link'>", '</a>')?>
                    </h2>
                    <p class="tb-modal__content-p">
                        <?php esc_html_e('After installing and activating the required theme, come back to Templateberg Themes Template Kits.', 'templateberg');?>
                    </p>
                    <p class="tb-modal__content-p">
                        <?php esc_html_e('And Install the template kit.', 'templateberg');?>
                    </p>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="tb-notice" style="display: none">
    <div class="tb-notice-links">
        <div class="tb-notice-events">
            <div class="tb-notice-info">
                <p></p>
            </div>
            <div class="tb-notice-events-btn">
                <a class="tb-event-sure" href="#" target="_blank">
                    <span class="dashicons dashicons-thumbs-up"></span>
                    <?php esc_html_e('Sure', 'templateberg');?>
                </a>
                <button type="button" class="tb-event-may-be-later">
                    <span class="dashicons dashicons-calendar"></span>
                    <?php esc_html_e('Maybe Later', 'templateberg');?>
                </button>
            </div>
            <div class="tb-notice-events-btn">
                <a class="tb-event-purchase" href="https://templateberg.com/dashboard/?action=purchases" target="_blank">
                    <span class="dashicons dashicons-admin-users"></span>
                    <?php esc_html_e('Purchases', 'templateberg');?>
                </a>
                <a class="tb-event-support" href="https://templateberg.com/dashboard/?action=support" target="_blank">
                    <span class="dashicons dashicons-editor-help"></span>
                    <?php esc_html_e('Contact Support', 'templateberg');?>
                </a>
            </div>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Close settings', 'templateberg');?>" class="tb-notice-close">
            <span class="dashicon dashicons dashicons-no-alt"></span>
        </button>
    </div>
</div>
