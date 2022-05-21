<div class="tb-global__header">
    <div class="tb-container">
            <div class="tb-global__caption">
                <h2 class="tb-global__htitle">
                    <?php echo esc_html__('Welcome to Templateberg', 'templateberg'); ?>
                </h2>
                <p class="tb-global__desc">
                    <?php echo esc_html__("Templateberg power you to create site quickly and easily. You don't have to spend hours trying to create a template and block design. With a click your favourite template design will import on your site and you can change text, image and customize it for your needs.", 'templateberg'); ?>
                </p>
                <a  href="<?php echo esc_url(admin_url('post-new.php?post_type=page')); ?>" target="_blank" class="tb-btn tb-btn__primary tb-btn__lg">
                    <?php echo esc_html__('Get Started With New Page', 'templateberg'); ?>
                </a>
            </div>
            <img src="<?php echo esc_url(TEMPLATEBERG_URL . 'assets/img/prospective-image-640x214.png')?>" alt="<?php esc_attr_e('Template Kits', 'templateberg'); ?>"/>
    </div>
</div>
