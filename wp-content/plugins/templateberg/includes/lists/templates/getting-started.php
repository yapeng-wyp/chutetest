<div class="tb-theme-popup" style="display: none">
    <div class="tb-theme-popup__wrap">
        <div class="tb-theme-popup__close">
            <span class="dashicon dashicons dashicons-no-alt"></span>
        </div>
        <div class="tb-theme-popup__body">
                <div class="tb-connect__notice tb-text__center">

                <div class="tb-connect__icon">
                    <img
                        src='<?php echo esc_url(TEMPLATEBERG_URL . 'assets/img/logo-48x48.png');?>'
                        alt="<?php esc_attr_e('Templateberg', 'templateberg');?>"
                    />
                </div>
                <h3 class="tb-connect__title">
                    <?php esc_html_e('Get access to hundreds of free templates by creating free account.', 'templateberg')?>
                </h3>
                <p class="tb-connect__desc">
                    <?php
                    esc_html_e("Templateberg power you to create site quickly and easily. You don't have to spend hours trying to create a template and block design. With a click your favourite template design will import on your site and you can change text, image and customize it for your needs.", 'templateberg');
                    esc_html_e("Clicking the button below will install and activate the Gutentor Plugin since most of the templates are built with it.", 'templateberg');
                    ?>
                </p>
                <a id="tb-connect-btn"
                     href='<?php echo esc_url(templateberg_connect()->get_remote_connect_url());?>'
                    target="_blank"
                    class="tb-btn tb-btn__primary tb-btn__lg">
                    <?php
                        esc_html_e('Get Started With Templateberg', 'templateberg')
                    ?>
                </a>
            </div>
        </div>
    </div>
</div>
