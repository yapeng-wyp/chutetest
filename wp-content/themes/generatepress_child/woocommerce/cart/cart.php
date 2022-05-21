<?php
/**
 * Cart Page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <table id="cart-table" class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
        <tr>
            <th rowspan="2" class="product-remove">&nbsp;</th>
            <th rowspan="2" class="product-thumbnail">&nbsp;</th>
            <th rowspan="2" style="text-align: center" class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th colspan="2" style="text-align: center" class="product-certificate"><?php esc_html_e( 'Certificat', 'woocommerce' ); ?></th>
            <th rowspan="2" style="text-align: center" class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
            <th rowspan="2" style="text-align: center" class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
            <th rowspan="2" style="text-align: center" class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
        </tr>
        <tr>
            <td class="product-ccpu-name" style="text-align: center" ><?php esc_html_e( 'Code de certificat', 'woocommerce' ); ?></td>
            <td class="product-ccpu-action" style="text-align: center" ><?php esc_html_e( 'Action', 'woocommerce' ); ?></td>
        </tr>
        </thead>
        <tbody>
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $cart_item['certificate'] = 1;
//            print_r($cart_item);die;
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>

                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                    <td class="product-remove">
                        <?php
                        if($_product->get_name() == 'CCPU selon disponibilité' || $_product->get_name() == 'CCPU 3.1.B (Certificat de contrôle produit par l\'usine)' || $_product->get_name() == 'Certificat de conformité Quali Chutes' ){
                            echo '';
                        }else{
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    esc_html__( 'Remove this item', 'woocommerce' ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ),
                                $cart_item_key
                            );
                        }

                        ?>
                    </td>

                    <td class="product-thumbnail">
                        <?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $product_permalink ) {
                            echo $thumbnail; // PHPCS: XSS ok.
                        } else {
                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                        }
                        ?>
                    </td>

                    <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                        <?php

                        global $wpdb;
                        $productId = apply_filters( 'woocommerce_cart_item_product', $_product->get_id(), $cart_item, $cart_item_key );
                        $sql = $wpdb->prepare("SELECT name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN wp_term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE wp_term_relationships.object_id = $productId AND $wpdb->term_taxonomy.taxonomy = 'pa_ccpu'");
                        $ccpu = $wpdb->get_var($sql);

                        if ( ! $product_permalink ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                        } else {
                            if($_product->get_name() == 'CCPU selon disponibilité' || $_product->get_name() == 'CCPU 3.1.B (Certificat de contrôle produit par l\'usine)' || $_product->get_name() == 'Certificat de conformité Quali Chutes' ){
                                $customizeFields = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = $productId AND meta_key='_certificate'");
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key)).'</br>'.$customizeFields ;
                            }else {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key)) . '<br/><b>CCPU : </b>&nbsp;' . $ccpu;
                            }
                        }

                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                        // Meta data.
                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                        // Backorder notification.
                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                        }
                        ?>
                    </td>

                    <td class="product-ccpu" data-title="<?php esc_attr_e( 'CCPU', 'woocommerce' ); ?>" >
                        <?php
                            global $wpdb;
                            if($_product->get_name() == 'CCPU selon disponibilité' || $_product->get_name() == 'CCPU 3.1.B (Certificat de contrôle produit par l\'usine)' || $_product->get_name() == 'Certificat de conformité Quali Chutes' ){
                                echo '<span></span>';
                            }else {
                                $productId = apply_filters('woocommerce_cart_item_product', $_product->get_id(), $cart_item, $cart_item_key);
                                $sql = $wpdb->prepare("SELECT name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN wp_term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE wp_term_relationships.object_id = $productId AND $wpdb->term_taxonomy.taxonomy = 'pa_ccpu'");
                                $ccpu = $wpdb->get_var($sql);
                                if ($ccpu == '') {
                                    echo '<span id="ccpu_text_' . $productId . '" ccpu-state="0" >Certificat de conformité</span>';
                                } else {
                                    echo '<span id="ccpu_text_' . $productId . '">CCPU:' . $ccpu . '</span>';
                                }
                            }
                        ?>
                    </td>

                    <td class="product-ccpu-action" data-title="<?php esc_attr_e( 'Action', 'woocommerce' ); ?>" >
                        <?php
//                        var_dump($ccpu);
                            if($ccpu == 'N/A'){
                                $sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_content = 'N/A'");
//                                print_r($sql);
                                $certificate = $wpdb->get_var($sql);
                            }elseif ($ccpu == '' || $ccpu === '0' ){
                                $sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_content = '0'");
//                                print_r($sql);
                                $certificate = $wpdb->get_var($sql);
                            }else{
                                $sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_content = 'CCPU'");
//                                print_r($sql);
                                $certificate = $wpdb->get_var($sql);
                            }
                            if($_product->get_name() == 'CCPU selon disponibilité' || $_product->get_name() == 'CCPU 3.1.B (Certificat de contrôle produit par l\'usine)' || $_product->get_name() == 'Certificat de conformité Quali Chutes' ){
                                $disbale = 'disabled="disabled"';
                            }else{
                                $disbale = '';
                            }
                        ?>

                        <button type="submit" class="button certificate-button" name="add-to-cart" id="add_ccpu_<?php echo $productId; ?>" style="margin: 0 25%;" value="<?php echo $certificate; ?>" <?php echo $disbale; ?> ><?php esc_attr_e( 'Ajouter un certificat', 'woocommerce' ); ?></button><?php do_action( 'woocommerce_cart_certificate' ); ?>
                        <input type="hidden" class="hide" name="ccpu-hide[]" id="hide_add_ccpu_<?php echo $productId; ?>" style="margin: 0 25%;" value="<?php echo ($ccpu)?$ccpu:'null'; ?>" />
                        <input type="hidden" class="hide" id="num_add_ccpu_<?php echo $productId; ?>" style="margin: 0 25%;" value="1" />

                        <!--<a class="wcpt-button wcpt-noselect wcpt-button-cart_ajax wcpt-1636438988994" data-wcpt-link-code="cart_ajax" href="http://chutetest.test/cart/" target="_self">
                            <span class="wcpt-button-label">
                                <div class="wcpt-item-row wcpt-1636438989042 " style="background-color:#dd9f32;text-align: center;line-height: 30px;">
                                    <span class="wcpt-text  wcpt-1636438989042">Ajouter un certificat</span>
                                    <input type="hidden" class="hide" name="ccpu-hide[]" id="hide_add_ccpu_<?php echo $productId; ?>" style="margin: 0 25%;" value="<?php echo $ccpu; ?>" />
                                </div>
                            </span>
                        </a>
                        <input type="button" class="ccpu-button action-button" name="ccpu-action[]" id="add_ccpu_--><?php //echo $productId; ?><!--" style="margin: 0 25%;" value="--><?php //esc_attr_e( 'Vue Certificat ', 'woocommerce' ); ?><!--"  />-->

                    </td>
                    <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                        ?>
                    </td>

                    <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                        <?php
                        if ( $_product->is_sold_individually() ) {
                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                        } else {
                            $product_quantity = woocommerce_quantity_input(
                                array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ),
                                $_product,
                                false
                            );
                        }

                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                        ?>
                    </td>

                    <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_contents' ); ?>

        <tr>
            <td colspan="8" class="actions" style="display: none;">

                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon">
                        <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>

                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                <?php do_action( 'woocommerce_cart_actions' ); ?>

                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
        </tr>

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        </tbody>
    </table>
    <?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>