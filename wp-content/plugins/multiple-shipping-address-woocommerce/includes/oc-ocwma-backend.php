<?php
if (!defined('ABSPATH'))
  exit;

if (!class_exists('OCWMA_admin_menu')) {
    class OCWMA_admin_menu {
        protected static $OCWMA_instance;

            function OCWMA_submenu_page() {
                add_submenu_page( 'woocommerce', 'Multiple Address Option', 'Multiple Address Option', 'manage_options', 'multiple-address',array($this, 'OCWMA_callback'));
            }

            function OCWMA_callback() {
            global $ocwma_comman;
            ?>    
                <div class="wrap">
                    <h2><u><?php echo __('Multiple address setting','multiple-shipping-address-woocommerce');?></u></h2>
                    <?php if(isset($_REQUEST['message']) && $_REQUEST['message'] == 'success'){ ?>
                        <div class="notice notice-success is-dismissible"> 
                            <p><strong><?php echo __('Record updated successfully.','multiple-shipping-address-woocommerce');?></strong></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="ocwma-container">
                    <form method="post" >
                      <?php wp_nonce_field( 'ocwma_nonce_action', 'ocwma_nonce_field' ); ?>   
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Billing Address Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Enable Multiple Billing Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_comman[ocwma_enable_multiple_billing_adress]" class="ocwma_enable_multi_bill_adress" value="yes"<?php if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){echo "checked";} ?>>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('MAX Billing Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="number" name="ocwma_max_adress" class="regular-text" value="3" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Address Type On Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_address_type]" class="regular-text">
                                                <option value="Dropdown"<?php if($ocwma_comman['ocwma_select_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','multiple-shipping-address-woocommerce');?></option>
                                                <option value="Popup"<?php if($ocwma_comman['ocwma_select_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Address position Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_address_position]" class="regular-text">
                                                <option value="billing_before_form_data"<?php if($ocwma_comman['ocwma_select_address_position'] == 'billing_before_form_data'){echo "selected";}?>><?php echo __('Before Billing Form Data','multiple-shipping-address-woocommerce');?></option>
                                                <option value="billing_after_form_data"<?php if($ocwma_comman['ocwma_select_address_position'] == 'billing_after_form_data'){echo "selected";}?>><?php echo __('After Billing Form Data','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Popup Button Style Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_popup_btn_style]" class="regular-text">
                                                <option value="button"<?php if($ocwma_comman['ocwma_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','multiple-shipping-address-woocommerce');?></option>
                                                <option value="link"<?php if($ocwma_comman['ocwma_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Button Title for Billing','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_head_title" value="Add Billing Address" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Shipping Address Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Enable Multiple Shipping Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_comman[ocwma_enable_multiple_shipping_adress]" class="ocwma_enable_multi_ship_adress" value="yes"<?php if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){echo "checked";} ?>>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('MAX Shipping Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="number" name="ocwma_max_shipping_adress" class="regular-text" value="3" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Address Type On Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_shipping_address_type]" class="regular-text">
                                                <option value="Dropdown"<?php if($ocwma_comman['ocwma_select_shipping_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','multiple-shipping-address-woocommerce');?></option>
                                                <option value="Popup"<?php if($ocwma_comman['ocwma_select_shipping_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Address position Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_shipping_address_position]" class="regular-text">
                                                <option value="shipping_before_form_data"<?php if($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_before_form_data'){echo "selected";}?>><?php echo __('Before Shipping Form Data','multiple-shipping-address-woocommerce');?></option>
                                                <option value="shipping_after_form_data"<?php if($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_after_form_data'){echo "selected";}?>><?php echo __('After Shipping Form Data','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Popup Button Style Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_shipping_select_popup_btn_style]" class="regular-text">
                                                <option value="button"<?php if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','multiple-shipping-address-woocommerce');?></option>
                                                <option value="link"<?php if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Button Title for Shipping','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_head_title_ship" value="Add Shipping Address" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Button Style','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Font size','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_font_size" value="15" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Font color','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="color-picker" data-alpha="true" name="ocwma_comman[ocwma_font_clr]" value="<?php echo $ocwma_comman['ocwma_font_clr'];?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Background Color','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="color-picker" data-alpha="true" name="ocwma_comman[ocwma_btn_bg_clr]" value="<?php echo $ocwma_comman['ocwma_btn_bg_clr']; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Button Padding','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_comman[ocwma_btn_padding]" value="<?php echo $ocwma_comman['ocwma_btn_padding'];?>">
                                            <span><?php echo __('give value in px(ex.6px 8px)','multiple-shipping-address-woocommerce');?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('User Role Selection Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('User Role Selection Enable/Disable','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_user_role_enable_disable" class="user_role_enable_disable" value="yes" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="user_role_setting">
                                        <th><?php echo __('User Role Selection','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select id="wg_select_user_role" name="wg_roles_select[]" multiple="multiple" style="width:350px;" disabled>
                                                <?php 
                                                    $user_roles = get_option('wg_roles_select');
                                                    
                                                    if (!empty($user_roles)) {
                                                        foreach ($user_roles as $key => $value) {
                                                            $role_names = ( mb_strlen( $value ) > 50 ) ? mb_substr( $value, 0, 49 ) . '...' : $value;
                                                            ?>
                                                                <option value="<?php echo $value;?>" selected="selected"><?php echo $role_names;?></option>
                                                            <?php   
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <input type="hidden" name="action" value="ocwma_save_option">
                        <input type="submit" value="Save changes" name="submit" class="button-primary" id="wfc-btn-space">
                    </form>  
                </div>
            <?php
            }

            function ocwma_role_ajax(){
                global $wp_roles;
                $return = array();
                
                foreach( $wp_roles->role_names as $role => $name ) {
                    $return[] = array( $role, $name );
                }

                echo json_encode( $return );
                die;
            }

            function OCWMA_recursive_sanitize_text_field( $array ) {
                foreach ( $array as $key => &$value ) {
                    if ( is_array( $value ) ) {
                        $value = $this->OCWMA_recursive_sanitize_text_field($value);
                    }else{
                        $value = sanitize_text_field( $value );
                    }
                }
                return $array;
            
            }
            
            function OCWMA_save_options(){
                if( current_user_can('administrator') ) { 
                    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ocwma_save_option'){
                        if(!isset( $_POST['ocwma_nonce_field'] ) || !wp_verify_nonce( $_POST['ocwma_nonce_field'], 'ocwma_nonce_action' ) ){
                            print 'Sorry, your nonce did not verify.';
                            exit;
                        }else{

                            $isecheckbox = array(
                                'ocwma_enable_multiple_billing_adress',
                                'ocwma_enable_multiple_shipping_adress',
                                'ocwma_user_role_enable_disable',
                            );

                            foreach ($isecheckbox as $key_isecheckbox => $value_isecheckbox) {
                                if(!isset($_REQUEST['ocwma_comman'][$value_isecheckbox])){
                                    $_REQUEST['ocwma_comman'][$value_isecheckbox] ='no';
                                }
                            }   

                            $wg_roles_select = $this->OCWMA_recursive_sanitize_text_field( $_REQUEST['wg_roles_select'] );
                            update_option('wg_roles_select', $wg_roles_select, 'yes');
                                                
                            //print_r($_REQUEST);
                            foreach ($_REQUEST['ocwma_comman'] as $key_ocwma_comman => $value_ocwma_comman) {
                               // echo $key_ocwma_comman;
                                update_option($key_ocwma_comman, sanitize_text_field($value_ocwma_comman), 'yes');
                            }
                        }

                    wp_redirect( admin_url( '/admin.php?page=multiple-address' ) );
                    exit;

                    }
                }
            }

            function init() {
                add_action( 'admin_menu',  array($this, 'OCWMA_submenu_page'));
                add_action( 'init',  array($this, 'OCWMA_save_options'));
                add_action( 'wp_ajax_nopriv_wg_roles_ajax',array($this, 'ocwma_role_ajax') );
                add_action( 'wp_ajax_wg_roles_ajax', array($this, 'ocwma_role_ajax') ); 
            }

            public static function OCWMA_instance() {
                if (!isset(self::$OCWMA_instance)) {
                    self::$OCWMA_instance = new self();
                    self::$OCWMA_instance->init();
                }
            return self::$OCWMA_instance;
        }
    }

 OCWMA_admin_menu::OCWMA_instance();
}

