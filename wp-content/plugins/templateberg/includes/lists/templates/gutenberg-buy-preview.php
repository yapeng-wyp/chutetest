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
            <h3 class="tb-modal__title"><?php esc_html_e('Free Design Templates', 'templateberg');?></h3>
            <a href="#" class="tb-modal__cancel">
                <!-- <i class="fas fa-times"></i> -->
                <span class="dashicons dashicons-no-alt"></span>

            </a>
        </div>
        <div class="tb-modal__content-wrap">
            <section class="tb-modal__content">
                <div class="tb-modal__content-info">
                    <h2 class="tb-modal__content-h"><?php esc_html_e('1. Getting Started ( Free License )', 'templateberg');?></h2>
                    <p class="tb-modal__content-p"><?php printf(esc_html__('Once you install the plugin. Go to %1$sDashboard =&gt; Templateberg.%2$s', 'templateberg'), "<strong>", '</strong>')?></p>
                    <p class="tb-modal__content-p"><?php printf(esc_html__('Click on %1$sGet Started with Templateberg.%2$s', 'templateberg'), "<strong>", '</strong>')?></p>
                    <p class="tb-modal__content-p"><?php esc_html_e('A new window will open follow the step to automatically setup license key on your site.', 'templateberg');?></p>
                </div>
                <div class="tb-modal__content-img-wrap">
                    <img class="" src="https://templateberg.com/wp-content/uploads/2021/02/getstarted.png">
                </div>
            </section>
            <section class="tb-modal__content">
                <div class="tb-modal__content-img-wrap">
                    <img class="" src="https://templateberg.com/wp-content/uploads/2021/02/import.png">
                </div>
                <div class="tb-modal__content-info">
                    <h2 class="tb-modal__content-h"><?php esc_html_e('2. Import', 'templateberg');?></h2>
                    <p class="tb-modal__content-p">
                        <?php printf(esc_html__(' Edit any Gutenberg Enabled Page or Post. %1$sYou will see %2$sTemplateberg%3$s button at the top left of the editor.', 'templateberg'), "<br><br>", '<strong>', '</strong>')?>
                    <p class="tb-modal__content-p">
                        <?php esc_html_e('Click on it, you are ready to inset any available template kits, templates and blocks', 'templateberg');?>
                    </p>
                </div>
            </section>
            <section class="tb-modal__content">
                <div class="tb-modal__content-info">
                    <h2 class="tb-modal__content-h"><?php esc_html_e('3. Customizing', 'templateberg');?></h2>
                    <p class="tb-modal__content-p">
                        <?php esc_html_e('After importing design, you can customize content and design to meet your site requirements.', 'templateberg');?>
                    </p>
                </div>
                <div class="tb-modal__content-img-wrap">
                    <img class="" src="https://templateberg.com/wp-content/uploads/2021/02/customization.png">
                </div>
            </section>
        </div>
    </div>
</div>
