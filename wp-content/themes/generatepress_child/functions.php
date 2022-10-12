<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

add_action('wp_enqueue_scripts', 'my_enqueue_assets');
function my_enqueue_assets(){
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script( 'child-customize-script', get_stylesheet_directory_uri() . '/asset/js/customize.js',array(),false,true );
}

//generate   product csv
function generate_product_csv()
{
    //connect
    $link = mysqli_connect('localhost:65498','root','root123456','old_qualichutes');
    //set
    mysqli_query($link,'set names utf8');
    $sql = "SELECT chute_famille.name as parents, chute_nuance.designation , chute_ident.chuteid as sku, chute_etat.intitule as etat_intitule, chute_format.intitule as format, chute_ident.intitules as name, chute_ident.etat, chute_ident.prixht as Regula_price, chute_ident.ccpu, chute_ident.photo, chute_mesure.Diametre as diameter, chute_mesure.Largeur as width, chute_mesure.Longeur as length , chute_mesure.Poids, chute_nuance.AFNOR, chute_nuance.Euronorme, chute_nuance.NF, chute_nuance.AISI, chute_nuance.DIN, chute_nuance.Werskstoff

	FROM chute_ident 

	LEFT JOIN chute_etat ON chute_etat.etatid = chute_ident.etat
	LEFT JOIN chute_nuance ON chute_nuance.nuanceid = chute_ident.nuanceid
	LEFT JOIN chute_famille ON chute_famille.famille_id = chute_nuance.famille_id
	LEFT JOIN chute_format ON chute_format.formatid = chute_ident.formatid
	LEFT JOIN chute_mesure ON chute_mesure.chuteid = chute_ident.chuteid

	ORDER BY chute_ident.chuteid ASC
	";
    $row = mysqli_query($link,$sql);
    $data = [];
    while($res = mysqli_fetch_assoc($row)){
        $data[] = $res;
    }
    foreach ($data as $key => $value) {
        // print_r($value);die;

        if($value['format'] == 'Plat' ){
            $value['Epaisseur'] = $value['diameter'];
            $value['Diameter_Largrue_Cote'] = $value['width'];
            $value['Longueur'] = $value['length'];
        }else{
            $value['Epaisseur'] = $value['width'];
            $value['Diameter_Largrue_Cote'] = $value['diameter'];
            $value['Longueur'] = $value['length'];
        }

        $value['Categories'] = $value['parents'].'>'.$value['designation'];
        $value['Tags'] = $value['format'];
        $value['Stock'] = 1;
        $value['Sold individually?'] = 1;
        $value['Attribute 0 name'] = 'Format';
        $value['Attribute 0 value(s)'] = $value['format'];
        $value['Attribute 0 global'] = 1;
        $value['Attribute 1 name'] = 'AFNOR';
        $value['Attribute 1 value(s)'] = $value['AFNOR'];
        $value['Attribute 1 global'] = 1;
        $value['Attribute 2 name'] = 'Euronorme';
        $value['Attribute 2 value(s)'] = $value['Euronorme'];
        $value['Attribute 2 global'] = 1;
        $value['Attribute 3 name'] = 'NF';
        $value['Attribute 3 value(s)'] = $value['NF'];
        $value['Attribute 3 global'] = 1;
        $value['Attribute 4 name'] = 'AISI';
        $value['Attribute 4 value(s)'] = $value['AISI'];
        $value['Attribute 4 global'] = 1;
        $value['Attribute 5 name'] = 'DIN';
        $value['Attribute 5 value(s)'] = $value['DIN'];
        $value['Attribute 5 global'] = 1;
        $value['Attribute 6 name'] = 'Werskstoff';
        $value['Attribute 6 value(s)'] = $value['Werskstoff'];
        $value['Attribute 6 global'] = 1;
        $value['Attribute 7 name'] = 'CCPU';
        $value['Attribute 7 value(s)'] = $value['ccpu'];
        $value['Attribute 7 global'] = 1;
        $value['Attribute 8 name'] = 'Epaisseur';
        $value['Attribute 8 value(s)'] = $value['Epaisseur'];
        $value['Attribute 8 global'] = 1;
        $value['Attribute 9 name'] = 'Diameter/Largrue/Cote';
        $value['Attribute 9 value(s)'] = $value['Diameter_Largrue_Cote'];
        $value['Attribute 9 global'] = 1;
        $value['Attribute 10 name'] = 'Longueur';
        $value['Attribute 10 value(s)'] = $value['Longueur'];
        $value['Attribute 10 global'] = 1;
        unset($value['format']);
        unset($value['AFNOR']);
        unset($value['Euronorme']);
        unset($value['NF']);
        unset($value['AISI']);
        unset($value['DIN']);
        unset($value['Werskstoff']);
        unset($value['ccpu']);

        $product_json[] = json_encode($value);
    }
    // print_r($product_json);die;


    $f = fopen('chute.csv', 'w');


    //$array = json_decode($product_json,true);

    $firstLineKeys = false;

    foreach ($product_json as $chute_val ) {
        $json_array = json_decode($chute_val,true);
        // print_r($json_array);die ;


        if(empty($firstLineKeys))
        {
            $firstLineKeys = array_keys($json_array);
            fputcsv($f, $firstLineKeys);
            $firstLineKeys = array_flip($firstLineKeys);
        }
        fputcsv($f, array_merge($firstLineKeys,$json_array));
    }
    fclose($f);
}
//  自定义 导入数据时所需要的栏目
/**
 * Register the 'Custom Column' column in the importer.
 * 在导入器中注册“自定义列”列。
 *
 * @param array $options
 * @return array $options
 */
function add_column_to_importer( $options ) {

    // column slug => column name
//    $options['format'] = 'Format';
    $options['epaisseur'] = 'Epaisseur';
    $options['diameter_largrue_cote'] = 'Diameter/Largrue/Cote';
    $options['longueur'] = 'Longueur';
    $options['certificate'] = 'Certificate';

    return $options;
}
add_filter( 'woocommerce_csv_product_import_mapping_options', 'add_column_to_importer' );

/**
 * Add automatic mapping support for 'Custom Column'.
 * This will automatically select the correct mapping for columns named 'Custom Column' or 'custom column'.
 * 为“自定义列”添加自动映射支持。 这将自动为名为“自定义列”或“自定义列”的列选择正确的映射。
 *
 * @param array $columns
 * @return array $columns
 */
function add_column_to_mapping_screen( $columns ) {

//     potential column name => column slug
//    $columns['Format'] = 'format';
    $columns['Epaisseur'] = 'epaisseur';
    $columns['Diameter/Largrue/Cote'] = 'diameter_largrue_cote';
    $columns['Longueur'] = 'longueur';
    $columns['Certificate'] = 'certificate';

    return $columns;
}
add_filter( 'woocommerce_csv_product_import_mapping_default_columns', 'add_column_to_mapping_screen' );

/**
 * Process the data read from the CSV file.
 * This just saves the value in meta data, but you can do anything you want here with the data.
 * 处理从 CSV 文件中读取的数据。
 * 这只是将值保存在元数据中，但您可以在此处对数据执行任何操作。
 *
 * @param WC_Product $object - Product being imported or updated.
 * @param array $data - CSV data read for the product.
 * @return WC_Product $object
 */
function process_import( $object, $data ) {

//    if ( ! empty( $data['format'] ) ) {
//        $object->update_meta_data( 'format', $data['format'] );
//    }
    if ( ! empty( $data['epaisseur'] ) ) {
        $object->update_meta_data( 'epaisseur', $data['epaisseur'] );
    }
    if ( ! empty( $data['diameter_largrue_cote'] ) ) {
        $object->update_meta_data( 'diameter_largrue_cote', $data['diameter_largrue_cote'] );
    }
    if ( ! empty( $data['longueur'] ) ) {
        $object->update_meta_data( 'longueur', $data['longueur'] );
    }
    if ( ! empty( $data['certificate'] ) ) {
        $object->update_meta_data( 'certificate', $data['certificate'] );
    }


    return $object;
}
add_filter( 'woocommerce_product_import_pre_insert_product_object', 'process_import', 10, 2 );
//   add customize fields  in woocommerce
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
function woo_add_custom_general_fields() {
    global $woocommerce, $post;
    echo '<div class="options_group">';

    woocommerce_wp_text_input(
        array(
            'id'          => '_longueur',
            'label'       => __( 'Chute Longueur(mm)', 'woocommerce' ),
            'placeholder' => 'Longueur(mm)',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the Longueur here.', 'woocommerce' )
        )
    );
    woocommerce_wp_text_input(
        array(
            'id'          => '_diameter',
            'label'       => __( 'Chute Diameter(mm)', 'woocommerce' ),
            'placeholder' => 'Diameter/Largrue/Cote(mm)',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the Diameter or Largrue or Cote here .', 'woocommerce' )
        )
    );
    woocommerce_wp_text_input(
        array(
            'id'          => '_epaisseur',
            'label'       => __( 'Chute Epaisseur(mm)', 'woocommerce' ),
            'placeholder' => 'Epaisseur(mm)',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the Epaisseur here.', 'woocommerce' )
        )
    );
    woocommerce_wp_text_input(
        array(
            'id'          => '_certificate' ,
            'label'       => __( 'Certificat' , 'woocommerce'),
            'desc_tip'    => 'true',
            'description' => __( 'Chute id and  ccpu number ', 'woocommerce' )
        )
    );

    echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
function woo_add_custom_general_fields_save( $post_id ){
    $woocommerce_longueur = $_POST['_longueur'];
    if( !empty( $woocommerce_longueur ) )
        update_post_meta( $post_id, '_longueur', esc_attr( $woocommerce_longueur ) );

    $woocommerce_diameter = $_POST['_diameter'];
    if( !empty( $woocommerce_diameter ) )
        update_post_meta( $post_id, '_diameter', esc_attr( $woocommerce_diameter ) );

    $woocommerce_epaisseur = $_POST['_epaisseur'];
    if( !empty( $woocommerce_epaisseur ) )
        update_post_meta( $post_id, '_epaisseur', esc_attr( $woocommerce_epaisseur ) );

    $woocommerce_certificate = $_POST['_certificate'];
    if( !empty( $woocommerce_certificate ) )
        update_post_meta( $post_id, '_certificate', esc_attr( $woocommerce_certificate ) );

}

function my_add_product_submenu()
{
    add_submenu_page('edit.php?post_type=product', 'latest_product', 'Latest Product', 'manage_options', 'latest_product', 'my_product_function');
}
function my_product_function()
{
    $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
    if (!$con) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con, 'set names  utf8');
    $product_sql = '
            SELECT chute_famille.name as famille_name, chute_nuance.designation, chute_ident.chuteid as chute_id, chute_etat.intitule as etat, chute_famille.txt as famille_txt , chute_format.intitule as format , chute_ident.intitules as chute_intitule , chute_ident.prixht as price, chute_ident.ccpu as ccpu, chute_ident.photo, chute_mesure.Diametre, chute_mesure.Largeur, chute_mesure.Longeur, chute_mesure.Poids as poids, chute_nuance.AFNOR, chute_nuance.Euronorme, chute_nuance.NF, chute_nuance.AISI, chute_nuance.DIN , chute_nuance.Werskstoff
            FROM chute_ident 
            LEFT JOIN chute_etat ON chute_etat.etatid = chute_ident.etat
            LEFT JOIN chute_nuance ON chute_nuance.nuanceid = chute_ident.nuanceid
            LEFT JOIN chute_famille ON chute_famille.famille_id = chute_nuance.famille_id
            LEFT JOIN chute_format ON chute_format.formatid = chute_ident.formatid
            LEFT JOIN chute_mesure ON chute_mesure.chuteid = chute_ident.chuteid
            ORDER BY chute_famille.famille_id ASC , chute_nuance.designation ASC
            LIMIT 5';
    $pro_result = mysqli_query($con, $product_sql);
    $data = array();
    if (mysqli_num_rows($pro_result) > 0) {
        while ($res = mysqli_fetch_object($pro_result)) {
            $data[] = $res;
        }
    }
    echo '
        <div id="header" class="header"><h3>Product Data From Old_Qualichutes</h3></div>
        <span><img src=""/></span><input type="submit" id="save_old_product" value="' . __('Save To New Database') . '"/>
        <div id="body" class="table">
            <table id="product" class="wp-list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th style="text-align: center" scope="col" id="photo" class="manage-column column-thumb"><span class="wc-image tips">' . __('Image') . '</span></th>
                        <th style="text-align: center" id="chuteId" class="manage-column column-id column-primary sortable asc">' . __('chuteId') . '</th>
                        <th style="text-align: center" id="name" class="manage-column column-name column-primary sortable asc">' . __('Name') . '</th>
                        <!--  tab  -->
                        <th style="text-align: center" id="famille" class="manage-column column-famille column-primary sortable asc">' . __('Family') . '</th>
                        <th style="text-align: center" id="sub_cate" class="manage-column column-sub column-primary sortable asc">' . __('sub-Cate') . '</th>
                        <th style="text-align: center" id="format" class="manage-column column-format column-primary sortable asc">' . __('Format') . '</th>
                        <!-- size -->
                        <th style="text-align: center" id="long" class="manage-column column-format column-primary sortable asc">' . __('Long  (mm)') . '</th>
                        <th style="text-align: center" id="width" class="manage-column column-format column-primary sortable asc">' . __('Width  (mm)') . '</th>
                        <th style="text-align: center" id="diameter" class="manage-column column-format column-primary sortable asc">' . __('Diameter  (mm)') . '</th>
                        <!--  price  -->
                        <th style="text-align: center" id="price" class="manage-column column-price column-primary sortable asc">' . __('Price (€)') . '</th>
                        <th style="text-align: center" id="weight" class="manage-column column-weight column-primary sortable asc">' . __('Weight (Kg)') . '</th>
                        <th style="text-align: center" id="state" class="manage-column column-state column-primary sortable asc">' . __('State') . '</th>            
                        <th style="text-align: center" id="ccpu" class="manage-column column-ccpu column-primary sortable asc">CCPU</th>    
                        <!--  Other designation  -->        
                        <th style="text-align: center" id="other" class="manage-column column-other column-primary sortable asc">' . __('Other') . '</th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($data as $key => $val) {
        echo '
                        <tr>
                            <th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-' . $val->chute_id . '">Select ' . $val->chute_intitule . '</label><input id="cb-select-' . $val->chute_id . '" type="checkbox" name="post[]" value="' . $val->chute_id . '"></th>
                            <td style="text-align: center" class="thumb column-thumb" data-colname="Image"><img src="/wp-content/themes/arilewp/assets/img/test.jpeg"  alt="image" loading="lazy"  sizes="(max-width: 150px) 100vw, 150px" width="75" height="75"></td>
                            <td style="text-align: center" class="id column-id has-row-actions column-primary" data-colname="Id">' . $val->chute_id . '</td>
                            <td style="text-align: center" class="name column-name has-row-actions column-primary" data-colname="Name"><strong><a class="row-title" href="javascript:void(0);">' . $val->chute_intitule . '</a></strong></td>
                            <td style="text-align: center" class="famille column-famille" data-colname="Famille">' . $val->famille_name . '</td>
                            <td style="text-align: center" class="sub-cate column-sub-cate" data-colname="Sub-cate">' . $val->designation . '</td>
                            <td style="text-align: center" class="format column-format" data-colname="Format">' . $val->format . '</td>
                            <td style="text-align: right" class="long column-long" data-colname="Long">' . $val->Longeur . '</td>
                            <td style="text-align: right" class="width column-width" data-colname="Width">' . $val->Largeur . '</td>
                            <td style="text-align: right" class="diameter column-diameter" data-colname="Diameter">' . $val->Diametre . '</td>
                            <td style="text-align: right" class="price column-price" data-colname="Price"><ins>' . $val->price . '</ins></td>
                            <td style="text-align: right" class="weight column-weight" data-colname="Weight">' . $val->poids . '</td>
                            <td style="text-align: center" class="state column-state" data-colname="State">' . $val->etat . '</td>
                            <td style="text-align: center" class="ccpu column-ccpu" data-colname="Ccpu">' . $val->ccpu . '</td>
                            <td style="text-align: center" class="other column-other" data-colname="Other">
                                AFNOR : ' . $val->AFNOR . '<br/>
                                Euronorme : ' . $val->Euronorme . '<br/>
                                NF : ' . $val->NF . '<br/>
                                AISI : ' . $val->AISI . '<br/>
                                DIN : ' . $val->DIN . '<br/>
                                Weedkstoff : ' . $val->Weedkstoff . '                      
                            </td>
                        </tr>              
                        ';
    }
    echo '</tbody>
            </table>
        </div>
	';

}
//add_action('admin_menu', 'my_add_product_submenu');
function save_product_to_new()
{
    global $woocommerce;
    $n = 0;
    $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
    if (!$con) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con, 'set names  utf8');
    $product_fmt_sql = 'SELECT * FROM chute_format WHERE formatid !=  0 ';
    $pro_fmt = mysqli_query($con,$product_fmt_sql);
    $fmt = array();
    if (mysqli_num_rows($pro_fmt)>0){
        while ($fmt_res = mysqli_fetch_object($pro_fmt)){
            $fmt[] = $fmt_res;
        }
    }
    foreach ($fmt as $fmt_key=>$fmt_val){
        switch ($fmt_val->intitule) {
            case 'Rond' :
                $size = 'chute_mesure.Diametre,';
                break;
            case 'Plat' :
                $size = 'chute_mesure.Diametre as epaisseur, chute_mesure.Largeur as width,';
                break;
            case 'Ebauche / Tube / Couronne : Rond' :
                $size = 'chute_mesure.Diametre as outside_diameter, chute_mesure.Largeur as epaisseur,';
                break;
            case 'Ebauche / Tube / Couronne : Carre' :
                $size = 'chute_mesure.Diametre as cote, Chute_mesure.Largeur as epaisseur,';
                break;
            case 'Six Pans' :
                $size = 'chute_mesure.Diametre as insideDiameter,';
                break;
            case 'Demi Lune' :
                $size = 'chute_mesure.Diametre,';
                break;
        }

        $product_sql = '
                SELECT chute_famille.name as famille_name, chute_nuance.designation, chute_ident.chuteid as sku, chute_etat.intitule as stock_status, chute_format.intitule as format , chute_ident.intitules as chute_intitule , chute_ident.prixht as price, chute_ident.ccpu as ccpu, chute_ident.photo, '.$size.'  chute_mesure.Longeur as length, chute_mesure.Poids as weight, chute_nuance.AFNOR, chute_nuance.Euronorme, chute_nuance.NF, chute_nuance.AISI, chute_nuance.DIN , chute_nuance.Werskstoff
                FROM chute_ident 
                LEFT JOIN chute_etat ON chute_etat.etatid = chute_ident.etat
                LEFT JOIN chute_nuance ON chute_nuance.nuanceid = chute_ident.nuanceid
                LEFT JOIN chute_famille ON chute_famille.famille_id = chute_nuance.famille_id
                LEFT JOIN chute_format ON chute_format.formatid = chute_ident.formatid
                LEFT JOIN chute_mesure ON chute_mesure.chuteid = chute_ident.chuteid
                WHERE chute_format.intitule = "'.$fmt_val->intitule.'"
                ORDER BY chute_ident.chuteid ASC
                ';

        // ORDER BY chute_famille.famille_id ASC , chute_nuance.designation ASC
        // LIMIT 5

        $pro_result = mysqli_query($con, $product_sql);
        $data = array();
        if (mysqli_num_rows($pro_result) > 0) {
            while ($res = mysqli_fetch_object($pro_result)) {
                $data[] = $res;
            }
        }
        if ($n == 1) return false;
        if ($_SERVER["QUERY_STRING"] == 'post_type=product&page=latest_product' && current_user_can('manage_options')) {
            foreach ($data as $key => $val) {
                $user_id = get_current_user_id();
                $product = array(
                    'post_author' => $user_id,
                    'post_date' => date('Y-m-d h:i:s'),
                    'post_data_gmt' => gmdate('Y-m-d h:i:s'),
                    'post_connect' => '',
                    'post_connect_filtered' => '',
                    'post_title' => $val->chute_intitule,
                    'post_excerpt' => '',
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post_name' => $val->chute_intitule,
                    'post_modified' => date('Y-m-d h:i:s'),
                    'post_modified_gmt' => gmdate('Y-m-d h:i:s'),
                    'guid' => 'http://chutetest.test/?post_type=product&#038;p=' . $val->chute_id . ''
                );
//                var_dump($val);die;
                $other = array('AFNOR' => $val->AFNOR, 'Euronorme' => $val->Euronorme, 'NF' => $val->NF, 'AISI' => $val->AISI, 'DIN' => $val->DIN, 'Werskstoff' => $val->Werskstoff);
                $val = json_decode(json_encode($val), true);
                $newData = array_diff($val, $other);
                array_push($newData, serialize($other));
                $newData['other'] = $newData['0'];
                unset($newData['0']);
//                print_r($newData);die;
//                $newProductData = [
//
//                ];
                $post_id = wp_insert_post($product, $wp_error = true, $fire_after_hooks = true);
                foreach ($newData as $v_key => $v_val) {
//                    print_r($v_key);die;
                    $meta_type = 'post';
                    //  insert into wp_post
                    add_metadata($meta_type, $post_id, '_' . $v_key, $v_val);
                }
            }
            $n = 1;
        }
    }
}
//add_action('admin_init','save_product_to_new');
function my_add_user_submenu()
{
    add_submenu_page('users.php', 'latest_customer', 'Latest Customers', 'manage_options', 'latest_customer', 'my_user_function');
}
function my_user_function()
{
    $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
    if (!$con) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con, 'set names  utf8');
    $client_sql = '
        SELECT client.clientid as customer_id , client.nom as defaultLast_name , client.prenom as defaultFirst_name , client.email as email , client.societe as defaultCompany , client.mdp as password , client.siret as companyCode , client.adresse as defaultAddressOne , client.adressesuite as defaultAddressTwo , client.cp as defaultPostcode , client.ville as defaultCity , client.telcontact as defaultTelOne , client.tel as telTwo , client.fax as fax ,  client_adresse.livid as customizeAds , client_adresse.nom as otherLastname , client_adresse.prenom as otherFirstname , client_adresse.societe as otherCompany , client_adresse.adresse as otherAddressOne , client_adresse.adressesuite as otherAddressTwo , client_adresse.cp as otherPostcode , client_adresse.telcontact as otherTel , client_etat.nom as etat_nom , client_etat.txt as etat_txt , client_adresse.id as ads_id ,client_pays.nom as country , client_pays.code as country_code , reglement.intitule as modereg, client.genre
        FROM client
        LEFT JOIN client_adresse ON client.clientid = client_adresse.clientid
        LEFT JOIN client_etat ON client.etat = client_etat.etatid
        LEFT JOIN client_pays ON client.pays = client_pays.paysid
        LEFT JOIN reglement ON client.modereg = reglement.reglementid
        ORDER BY client.clientid ASC , client_adresse.id ASC 
        LIMIT 20';
    $cli_result = mysqli_query($con, $client_sql);
    $client_data = array();
    if (mysqli_num_rows($cli_result) > 0) {
        while ($cli_res = mysqli_fetch_object($cli_result)) {
            $client_data[] = $cli_res;
        }
    }
    echo '
        <div id="header" class="header"><h3>' . __('Customer Data From Old_Qualichutes') . '</h3></div>
        <span><img src=""/></span><input type="submit" value="' . __('Save To New Database') . '"/>
        <div id="body" class="table">
            <table id="customer" class="wp-list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th style="text-align: center" id="customerId" class="manage-column column-id column-primary sortable asc">' . __('customerId') . '</th>
                        <th style="text-align: center" id="country" class="manage-column column-country column-primary sortable asc">' . __('country') . '</th>
                        <th style="text-align: center" id="email" class="manage-column column-email column-primary sortable asc">' . __('email') . '</th>
                        <th style="text-align: center" id="genre" class="manage-column column-genre column-primary sortable asc">' . __('Genre') . '</th>
                        <th style="text-align: center" id="password" class="manage-column column-password column-primary sortable asc">' . __('password') . '</th>
                        <th style="text-align: center" id="companycode" class="manage-column column-companycode column-primary sortable asc">' . __('Company Code') . '</th>
                        <th style="text-align: center" id="fax" class="manage-column column-fax column-primary sortable asc">' . __('fax') . '</th>
                        
                        <th style="text-align: center" id="default-name" class="manage-column column-primary sortable asc">' . __('User name') . '</th>
                        <th style="text-align: center" id="default-city" class="manage-column column-city column-primary sortable asc">' . __('user city') . '</th>
                        <th style="text-align: center" id="default-company" class="manage-column column-company column-primary sortable asc">' . __('User company') . '</th>
                        <th style="text-align: center" id="default-postcode" class="manage-column column-postcode column-primary sortable asc">' . __('User postcode') . '</th>
                        <th style="text-align: center" id="default-tel" class="manage-column column-tel column-primary sortable asc">' . __('User tel') . '</th>
                        <th style="text-align: center" id="default-addressOne" class="manage-column column-address column-primary sortable asc">' . __('User address One') . '</th>
                        <th style="text-align: center" id="default-addressTwo" class="manage-column column-address column-primary sortable asc">' . __('User address Two') . '</th>
                        
                        <th style="text-align: center" id="default-name" class="manage-column column-primary sortable asc">' . __('Receiver name') . '</th>
                        <th style="text-align: center" id="city" class="manage-column column-city column-primary sortable asc">' . __('customize Address name') . '</th>
                        <th style="text-align: center" id="addressOne" class="manage-column column-address column-primary sortable asc">' . __(' Receiver address One') . '</th>  
                        <th style="text-align: center" id="addressTwo" class="manage-column column-address column-primary sortable asc">' . __(' Receiver address Two') . '</th>
                        <th style="text-align: center" id="company" class="manage-column column-company column-primary sortable asc">' . __(' Receiver company') . '</th>
                        <th style="text-align: center" id="postcode" class="manage-column column-postcode column-primary sortable asc">' . __(' Receiver postcode') . '</th>
                        <th style="text-align: center" id="telTwo" class="manage-column column-tel column-primary sortable asc">' . __(' Receiver telTwo') . '</th>
                        
                        <th style="text-align: center" id="other-tel" class="manage-column column-tel column-primary sortable asc">' . __('Other tel') . '</th>
                        <th style="text-align: center" id="register" class="manage-column column-registered column-primary sortable asc">' . __('Registration mode') . '</th>
                        <th style="text-align: center" id="state-name" class="manage-column column-stats column-primary sortable asc">' . __('State name') . '</th>
                        <th style="text-align: center" id="state-txt" class="manage-column column-stats column-primary sortable asc">' . __('State txt') . '</th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($client_data as $cli_key => $cli_val) {
        echo '
                            <tr>
                                <th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-' . $cli_val->ads_id . '">Select This address</label><input id="cb-select-' . $cli_val->ads_id . '" type="checkbox" name="post[]" value="' . $cli_val->ads_id . '"></th>
                                <td class="woocommerce-table__item">' . $cli_val->customer_id . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->country . '&nbsp;(' . $cli_val->country_code . ')</td>
                                <td class="woocommerce-table__item"><email>' . $cli_val->email . '</email></td>
                                <td class="woocommerce-table__item">';
        if ($cli_val->genre == 1) {
            echo 'Mr.';
        } elseif ($cli_val->genre == 2) {
            echo 'Ms.';
        } else {
            echo 'Miss';
        }
        echo '</td>
                                <td class="woocommerce-table__item"><accronym title="' . $cli_val->password . '">******</accronym></td>
                                <td class="woocommerce-table__item">' . $cli_val->companyCode . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->fax . '</td>
                                
                                <td class="woocommerce-table__item">' . $cli_val->defaultLast_name . '&nbsp;.' . $cli_val->defaultFirst_name . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->defaultCity . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->defaultCompany . '</td>
                                <td class="woocommerce-table__item"><code>' . $cli_val->defaultPostcode . '</code></td>
                                <td class="woocommerce-table__item"><code>' . $cli_val->defaultTelOne . '</code></td>
                                <td class="woocommerce-table__item"><address>' . $cli_val->defaultAddressOne . '</address></td>
                                <td class="woocommerce-table__item"><address>' . $cli_val->defaultAddressTwo . '</address></td>
                                
                                <td class="woocommerce-table__item">' . $cli_val->otherLastname . '&nbsp;.' . $cli_val->otherFirstname . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->customizeAds . '</td>
                                <td class="woocommerce-table__item"><address>' . $cli_val->otherAddressOne . '</address></td>
                                <td class="woocommerce-table__item"><address>' . $cli_val->otherAddressTwo . '</address></td>
                                <td class="woocommerce-table__item">' . $cli_val->otherCompany . '</td>
                                <td class="woocommerce-table__item"><code>' . $cli_val->otherPostcode . '</code></td>
                                <td class="woocommerce-table__item"><code>' . $cli_val->telTwo . '</code></td>
                                
                                <td class="woocommerce-table__item"><code>' . $cli_val->otherTel . '</code></td>
                                <td class="woocommerce-table__item">' . $cli_val->modereg . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->etat_nom . '</td>
                                <td class="woocommerce-table__item">' . $cli_val->etat_txt . '</td>
                            </tr>
                        ';
    }
    echo '</tbody>
            </table>
                ';
}
//add_action('admin_menu', 'my_add_user_submenu');
function save_customer_to_new()
{
    global $woocommerce;
//    /*
    $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
    if (!$con) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con, 'set names  utf8');
    $client_sql = '
        SELECT client.clientid as customer_id , client.nom as defaultLast_name , client.prenom as defaultFirst_name , client.email as email , client.societe as defaultCompany , client.mdp as nickname , client.siret as password , client.adresse as defaultAddressOne , client.adressesuite as defaultAddressTwo , client.cp as defaultPostcode , client.ville as defaultCity , client.telcontact as defaultTelOne , client.tel as telTwo , client.fax as fax ,  client_adresse.livid as otherCity , client_adresse.nom as otherLastname , client_adresse.prenom as otherFirstname , client_adresse.societe as otherCompany , client_adresse.adresse as otherAddressOne , client_adresse.adressesuite as otherAddressTwo , client_adresse.cp as otherPostcode , client_adresse.telcontact as otherTel , client_etat.nom as etat_nom , client_etat.txt as etat_txt , client_adresse.id as ads_id ,client_pays.nom as country , client_pays.code as country_code , reglement.intitule as modereg
        FROM client
        LEFT JOIN client_adresse ON client.clientid = client_adresse.clientid
        LEFT JOIN client_etat ON client.etat = client_etat.etatid
        LEFT JOIN client_pays ON client.pays = client_pays.paysid
        LEFT JOIN reglement ON client.modereg = reglement.reglementid
        ORDER BY client.clientid ASC , client_adresse.id ASC 
        LIMIT 20';
    $cli_result = mysqli_query($con, $client_sql);
    $client_data = array();
    if (mysqli_num_rows($cli_result) > 0) {
        while ($cli_res = mysqli_fetch_object($cli_result)) {
            $client_data[] = $cli_res;
        }
    }
//    */
    if ($_SERVER["QUERY_STRING"] == 'page=latest_customer' && current_user_can('manage_options')) {

//        /*
        foreach ($client_data as $cli_key => $cli_val) {
            $customer = array(
                'ID' => '1',
                'user_pass' => wp_hash_password($cli_val->password),
                'user_login' => $cli_val->email,
                'user_nicename' => '',
                'user_url' => '',
                'user_email' => $cli_val->email,
                'display_name' => '',
                'nickname' => '',
                'first_name' => $cli_val->defaultFirst_name,
                'last_name' => $cli_val->defaultLast_name,
                'description' => '',
                'rich_editing' => 'true',
                'syntax_highlighting' => 'true',
                'comment_shortcuts' => 'false',
                'admin_color' => 'fresh',
                'user_ssl' => false,
                'user_registered' => 'Y-m-d H:i:s',
                'user_activation_key' => '',
                'spam' => false,
                'show_admin_bar_front' => 'false',
                'role' => '',
                'locale' => 'fr'

            );
            $data = [
                'email' => $cli_val->email,
                'first_name' => $cli_val->defaultFirst_name,
                'last_name' => $cli_val->defaultLast_name,
                'username' => $cli_val->defaultFirst_name . '.' . $cli_val->defaultLast_name,
                'billing' => [
                    'first_name' => $cli_val->defaultFirst_name,
                    'last_name' => $cli_val->defaultLast_name,
                    'company' => $cli_val->defaultCompany,
                    'address_1' => $cli_val->defaultAddressOne,
                    'address_2' => $cli_val->defaultAddressTwo,
                    'city' => $cli_val->defaultCity,
                    'state' => 'CA',
                    'postcode' => $cli_val->defaultPostcode,
                    'country' => $cli_val->country,
                    'email' => $cli_val->email,
                    'phone' => $cli_val->defaultTelOne
                ],
                'shipping' => [
                    'first_name' => $cli_val->defaultFirst_name,
                    'last_name' => $cli_val->defaultLast_name,
                    'company' => $cli_val->defaultCompany,
                    'address_1' => $cli_val->defaultAddressOne,
                    'address_2' => $cli_val->defaultAddressTwo,
                    'city' => $cli_val->defaultCity,
                    'state' => 'CA',
                    'postcode' => $cli_val->defaultPostcode,
                    'country' => $cli_val->country
                ]
            ];
            $woocommerce->post('customer', $data);
            wp_insert_user($customer);
//            print_r($data);
//            die;
        }

//        $meta_type = 'user',
//        add_user_meta( $val['customer_id'], '_'.$v_key, $v_val );
//        echo '111';
//        */
    }
}
//add_action('admin_init','save_customer_to_new');
/**
 * old order data
 */
function my_old_order_menu()
{
    add_menu_page('Old Order', 'old_order', 'manage_options', 'old_order', 'my_old_order_function');
}
function my_old_order_function()
{
    // print_r($_SERVER);die; // [QUERY_STRING] => page=old_order
    $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
    if (!$con) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con, 'set names  utf8');
    $order_sql = '
        SELECT cmdes.cmdeid , cmdes.clientid , cmdes.livid , cmdes.email , cmdes.refclient , cmdes.refclient , cmdes.total_prixht , cmdes.total_pds as weight , cmdes.date , cmde_etat.nom as cmdes_etat , cmdes.moyreg , cmdes.genre , cmdes.nom , cmdes.prenom , cmdes.societe , cmdes.adresse , cmdes.adressesuite , cmdes.cp , cmdes.ville , cmdes.pays , cmdes.telcontact , cmdes.trans , cmdes.zone
        FROM cmdes
        LEFT JOIN cmde_etat ON cmde_etat.etatid = cmdes.etat
        WHERE cmdes.cmdeid >0 
        GROUP BY cmdes.cmdeid asc 
        LIMIT 5
    ';
    $cmdes_res_1 = mysqli_query($con, $order_sql);
    $cmde_id_arr = array();
    $cmde_arr = array();
    if (mysqli_num_rows($cmdes_res_1) > 0) {
        while ($cmdes_res_val = mysqli_fetch_object($cmdes_res_1)) {
            $cmde_arr[] = $cmdes_res_val;
        }
    }
//    echo '';
    foreach ($cmde_arr as $cmde_val) {

        echo '
    <table class="wp-list-table widefat fixed striped table-view-list" >
    <thead>
        <tr>
            <th class="manage-column column-primary sortable asc" style="text-align: center;color: #0e90d2">' . __('Order ID') . '</th>
            <th class="manage-column column-primary sortable asc" style="/*display: none;*/color: #0e90d2">' . __('Customer ID') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Email') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Livid') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Ref Client') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Total Weight') . '</th>
            <th class="manage-column column-primary sortable asc" style="text-align: center;color: #0e90d2">' . __('Date') . '</th>
            <th class="manage-column column-primary sortable asc" style="text-align: center;color: #0e90d2">' . __('State') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Moyreg') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Genre') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Last Name') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('First Name') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Company') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Adresse') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Adresse Suitr') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Post Code') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Ville') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Country') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Tel') . '</th>
            <th class="manage-column column-primary sortable asc" style="display: none;color: #0e90d2">' . __('Transport') . '</th>
            <th class="manage-column column-primary sortable asc" style="text-align: center;color: #0e90d2">' . __('Total price (&euro;)') . '</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="manage-column column-primary sortable asc" style="text-align: center;">' . $cmde_val->cmdeid . '</td>  
            <td class="manage-column column-primary sortable asc" style="/*display: none;*/">' . $cmde_val->clientid . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->livid . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->email . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->refclient . '</td>
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->weight . '</td>  
            <td class="manage-column column-primary sortable asc" style="text-align: center;">' . $cmde_val->date . '</td>  
            <td class="manage-column column-primary sortable asc" style="text-align: center;">' . $cmde_val->cmdes_etat . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->moyreg . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->genre . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->nom . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->prenom . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->societe . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->adresse . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->adressesuite . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->cp . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->ville . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->pays . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->telcontacr . '</td>  
            <td class="manage-column column-primary sortable asc" style="display: none;">' . $cmde_val->transport . '</td>
            <td class="manage-column column-primary sortable asc" style="text-align: center;">' . $cmde_val->total_prixht . '</td>    
        </tr><tr>
        <table class="wp-list-table widefat fixed striped table-view-list" >
            <thead>
                <th class="manage-column column-primary sortable asc">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Product ID') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Product Name') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Diamep (mm)') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Width (mm)') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Long (mm)') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Price (&euro;)') . '</th>
                <th class="manage-column column-primary sortable asc" style="color: #fc3">' . __('Pds (&euro;)') . '</th>
            </thead>
            <tbody>
        ';
        $cmde_ligne_sql = 'SELECT * FROM cmde_lignes WHERE cmdeid = "' . $cmde_val->cmdeid . '"';
        $cmdeligne_res = mysqli_query($con, $cmde_ligne_sql);
        $ligne_arr = array();
        if (mysqli_num_rows($cmdeligne_res) > 0) {
            while ($ligne_val = mysqli_fetch_object($cmdeligne_res)) {
                $ligne_arr[] = $ligne_val;
            }
        }
//        echo '';
        foreach ($ligne_arr as $ligne_val) {
            echo '
            <tr>
                <td class="manage-column column-primary sortable asc">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->chuteid . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->intitule . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->diamep . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->largeur . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->longeur . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->prixht . '</td>
                <td class="manage-column column-primary sortable asc">' . $ligne_val->pds . '</td>
            </tr>
                
            ';
        }
        echo '</tbody></table></tr></tbody></table>';
    }
//    echo '';
}
//add_action('admin_menu', 'my_old_order_menu');
function save_old_order()
{
    if ($_SERVER["QUERY_STRING"] == 'page=old_order' && current_user_can('manage_options')) {
        $con = mysqli_connect('localhost', 'root', 'admin&970906', 'old_qualichutes', '3306');
        if (!$con) {
            die('Could not connect: ' . mysqli_error());
        }
        mysqli_query($con, 'set names  utf8');
        $order_sql = '
            SELECT cmdes.cmdeid , cmdes.clientid , cmdes.livid , cmdes.email , cmdes.refclient , cmdes.refclient , cmdes.total_prixht , cmdes.total_pds , cmdes.date , cmde_etat.nom as cmdes_etat , cmdes.moyreg , cmdes.genre , cmdes.nom , cmdes.prenom , cmdes.societe , cmdes.adresse , cmdes.adressesuite , cmdes.cp , cmdes.ville , cmdes.pays , cmdes.telcontact , cmdes.trans , cmdes.zone , client_pays.code as countryCode
            FROM cmdes
            LEFT JOIN cmde_etat ON cmde_etat.etatid = cmdes.etat
            LEFT JOIN client_pays ON client_pays.paysid = cmdes.pays
            WHERE cmdes.cmdeid >0 
            GROUP BY cmdes.cmdeid asc 
            LIMIT 1
        ';
        $cmdes_res_1 = mysqli_query($con, $order_sql);
        $order_arr = array();
        if (mysqli_num_rows($cmdes_res_1) > 0) {
            while ($cmdes_res_val = mysqli_fetch_object($cmdes_res_1)) {
                $order_arr[] = $cmdes_res_val;
            }
        }
        foreach ($order_arr as $order_key => $order_val) {
            $cmde_ligne_sql = 'SELECT * FROM cmde_lignes WHERE cmdeid = "' . $order_val->cmdeid . '"';
            $cmdeligne_res = mysqli_query($con, $cmde_ligne_sql);
            $ligne_arr = array();
            if (mysqli_num_rows($cmdeligne_res) > 0) {
                while ($ligne_val = mysqli_fetch_object($cmdeligne_res)) {
                    $ligne_arr[] = $ligne_val;
                }
            }
            $order_val->data = $ligne_arr;
        }
        print_r($order_arr);
        die;
        foreach ($order_arr as $order_key => $order_val) {
            $address = array(
                'first_name' => $order_val->prenom,
                'last_name' => $order_val->nom,
                'company' => $order_val->societe,
                'email' => $order_val->email,
                'phone' => $order_val->telcontact,
                'address_1' => $order_val->adresse,
                'address_2' => $order_val->adressesuite,
                'city' => $order_val->ville,
                'state' => $order_val->cmdes_etat,
                'postcode' => $order_val->cp,
                'country' => $order_val->countryCode
            );
            $order = wc_create_order();
            foreach ($order_val->data as $pro_data) $order->add_product(get_product($prodata->chuteid), 1); //(get_product with id and next is for quantity)

            $order->set_address($address, 'billing');
            $order->set_address($address, 'shipping');
            // $order->add_coupon('Fresher','10','2'); // accepted param $couponcode, $couponamount,$coupon_tax
            $order->calculate_totals();
        }
    }
}
//add_action('admin_init','save_old_order');
/**
 * remove menu
 */
function remove_menus()
{
    global $menu;
    $restricted = array(__('Posts'), __('Media'), __('Links'), __('Projects'), __('Comments'));
    end($menu);
    while (prev($menu)) {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {
            unset($menu[key($menu)]);
        }
    }
}
if (!is_admin()) {
    // delete left menu
//    add_action('admin_menu', 'remove_menus');
}

/**
 * search product
 *
 * @param int   $length product  Minimum length
 * @param int   $width  product Minimum width
 * @param strint $format product format  or  not check
 * @param int   $diameter product minimum diameter
 * @param string $nuance product Material standards
 * @global  $wpdb
 *

    function search_product_callback () {
        global $wpdb;
        $nuance = '' ;
        $format = 'Rond';
        $diameter = '';
        $length = '';
        $width = '';
        if (!empty($nuance)) {
            $like = '%';
            $str = $wpdb->esc_like($like.$nuance.$like);
            $whereNuance = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_other' AND $wpdb->postmeta.meta_value  LIKE %s OR $wpdb->postmeta.meta_key = '_designation' AND $wpdb->postmeta.meta_value  LIKE %s",$str,$str);
        }else{
            $whereNuance = '';
        }
    //    echo $whereNuance;die;

        switch($format) {
            case 'Rond' :
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereDiameter = (!empty($diameter))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_Diametre' AND $wpdb->postmeta.meta_value >= %d ",$diameter) : '' ;
                $whereOther = $whereFormat.$whereDiameter;
                break;
            case 'Plat' :
                $epaisseur = $diameter;
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereEpaisseur = (!empty($epaisseur))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_epaisseur' AND $wpdb->postmeta.meta_value >= %d ",$epaisseur) : '' ;
                $whereWidth = (!empty($width))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_width' AND $wpdb->postmeta.meta_value >= %d ",$width) : '' ;
                $whereOther = $whereFormat.$whereEpaisseur.$whereWidth;
                break;
            case 'Ebauche / Tube / Couronne : Rond' :
                $epaisseur = $width;
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereDiameter = (!empty($diameter))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_outside_diameter' AND $wpdb->postmeta.meta_value >= %d ",$diameter) : '' ;
                $whereEpaisseur = (!empty($epaisseur))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_epaisseur' AND $wpdb->postmeta.meta_value >= %d ",$epaisseur) : '' ;
                $whereOther = $whereFormat.$whereEpaisseur.$whereDiameter;
                break;
            case 'Ebauche / Tube / Couronne : Carre' :
                $epaisseur = $width;
                $cote = $diameter;
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereEpaisseur = (!empty($epaisseur))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_epaisseur' AND $wpdb->postmeta.meta_value >= %d ",$epaisseur) : '' ;
                $whereCote = (!empty($cote))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_cote' AND $wpdb->postmeta.meta_value >= %d ",$cote) : '' ;
                $whereOther = $whereFormat.$whereEpaisseur.$whereCote;
                break;
            case 'Six Pans' :
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereDiameter = (!empty($diameter))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_insideDiameter' AND $wpdb->postmeta.meta_value >= %d ",$diameter) : '' ;
                $whereOther = $whereFormat.$whereDiameter;
                break;
            case 'Demi Lune' :
                $whereFormat = $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_format' AND $wpdb->postmeta.meta_value = '%s' ",$format);
                $whereDiameter = (!empty($diameter))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_Diametre' AND $wpdb->postmeta.meta_value >= %d ",$diameter) : '' ;
                $whereOther = $whereFormat.$whereDiameter;
                break;
            default :
                $whereOther = '';
        }
    //    echo $whereOther;die;
        $whereLength = (!empty($length))? $wpdb->prepare("AND $wpdb->postmeta.meta_key = '_length' AND $wpdb->postmeta.meta_value >= %d ",$length) : '' ;

        $seaschSqlId = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta LEFT JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->postmeta.post_id WHERE $wpdb->posts.post_type = 'product' $whereNuance $whereOther $whereLength ");

    //    echo $seaschSqlId;die;
        $pro_result_id = $wpdb->get_results($seaschSqlId);

    //    print_r($pro_result_id);die;
        foreach ($pro_result_id as $result_id_key => $result_id_val) {
    //        echo $result_id_val->post_id;die;
            $result_id_val->post_id;
            $pro_detailed_Sql = $wpdb->prepare("SELECT mate_value FROM $wpdb->postmeta WHERE post_id = $result_id_val->post_id AND  meta_key = '_designation' ");
            $pro_cate_name = $wpdb->get_var($pro_detailed_Sql);
            echo '
                <table id="result-'.$pro_cate_name.'">
                    <tr>
                        <td rowspan="2"><span id="description-'.$pro_cate_name.'" class="pro-description">'.$pro_cate_name.'</span></td>
                        <td><span id="'.$pro_cate_name.'-AFNOR-key" class="AFNPR-key">AFNOR</span><td>
                        <td><span id="'.$pro_cate_name.'-Euronorme-key" class="Euronorme-key">Euronorme</span><td>
                        <td><span id="'.$pro_cate_name.'-NF-key" class="NF-key">NF</span><td>
                        <td><span id="'.$pro_cate_name.'-AISI-key" class="AISI-key">AISI</span><td>
                        <td><span id="'.$pro_cate_name.'-DIN-key" class="DIN-key">DIN</span><td>
                        <td><span id="'.$pro_cate_name.'-Wersktoff-key" class="Wersktoff-key">WK</span><td>
                    </tr>
                    <tr>';
            $pro_other_Sql = $wpdb->prepare("SELECT mate_value FROM $wpdb->postmeta WHERE post_id = $result_id_val->post_id AND  meta_key = '_other' ");
            $pro_other_str = $wpdb->get_var($pro_other_Sql);
            $pro_other_arr = unserialize($pro_other_str);
            foreach ($pro_other_arr as $other_arr_key =>$other_arr_val) {
                echo '<td><span id="'.$pro_cate_name.'-'.$other_arr_key.'-value" class="'.$other_arr_key.'-value">'.$other_arr_val.'</span><td>';
            }
            echo '
                        <!--<td><span id="'.$pro_cate_name.'-Euronorme-value" class="Euronorme-value">X5CrNi18-10</span><td>-->
                        <!--<td><span id="'.$pro_cate_name.'-NF-value" class="NF-value">A35-574-90</span><td>-->
                        <!--<td><span id="'.$pro_cate_name.'-AISI-value" class="AISI-value">304</span><td>-->
                        <!--<td><span id="'.$pro_cate_name.'-DIN-value" class="DIN-value">X5CrNi18-10</span><td>-->
                        <!--<td><span id="'.$pro_cate_name.'-Wersktoff-value" class="Wersktoff-value">1-4301</span><td>-->
                    </tr>
                    <tr>
                        <td><span class="format">Format&nbsp;:</span></td>
                        <td><span class="format">Rond</span></td>
                        <td><span class="format">Plat</span></td>
                        <td><span class="format">Ebauche / Tube / Couronne : Rond</span></td>
                        <td><span class="format">Ebauche / Tube / Couronne : Carre</span></td>
                        <td><span class="format">Six Pans</span></td>
                        <td><span class="format">Demi Lune</span></td>
                    </tr>
                    <tr>
                        <td><span class="stock">Stock&nbsp;:</span></td>
                        <td><span id="'.$pro_cate_name.'-Rond-stock" class="stock">0</span></td>
                        <td><span id="'.$pro_cate_name.'-Plat-stock" class="stock">0</span></td>
                        <td><span id="'.$pro_cate_name.'-ETCR-stock" class="stock">0</span></td>
                        <td><span id="'.$pro_cate_name.'-ETCC-stock" class="stock">0</span></td>
                        <td><span id="'.$pro_cate_name.'-Pans-stock" class="stock">0</span></td>
                        <td><span id="'.$pro_cate_name.'-DL-stock" class="stock">0</span></td>
                    </tr>
                </table>
            ';
        }

        // search product by nuance

    }
    add_action('wp_ajax_nopriv_search_product','search_product_callback');
    add_action('wp_ajax_search_product','search_product_callback');

 * */

/**
    add_action('wp_ajax_nopriv_all-this-cate-goods','all_this_cate_pro_callback');
    add_action('wp_ajax_all-this-cate-goods','all_this_cate_pro_callback');
    function all_this_cate_pro_callback(){
        global $wpdb;
         $cate_id = $_POST['id']; // example
    //    echo '<pre>';
    //    print_r($_POST);
    //    echo '</pre>';die;
        $cateSql = $wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id = $cate_id ");
        $cate = $wpdb->get_var($cateSql);
        $rondNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Rond'");
        $rondNum = $wpdb->get_var($rondNumSql);
        $platNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Plat'");
        $platNum = $wpdb->get_var($platNumSql);
        $tubeRondNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Ebauche / Tube / Couronne : Rond'");
        $tubeRondNum = $wpdb->get_var($tubeRondNumSql);
        $tubeCarreNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Ebauche / Tube / Couronne : Carre'");
        $tubeCarreNum = $wpdb->get_var($tubeCarreNumSql);
        $pansNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Six Pans'");
        $pansNUm = $wpdb->get_var($pansNumSql);
        $luneNumSql = $wpdb->prepare("SELECT count(post_id) FROM $wpdb->postmeta WHERE meta_key = '_desigantion' AND meta_value = '".$cate."' AND meta_key = '_format' AND meta_value = 'Demi Lune'");
        $luneNum = $wpdb->get_var($luneNumSql);
        $otherSql = $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_other' AND meta_key = '_designation' AND meta_value = '".$cate."' LIMIT 1 ");
    //    $otherSql = $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_wp_attachment_metadata' LIMIT 1");
        $other = $wpdb->get_results($otherSql);
        $otherarr = unserialize($other[0]->meta_value);
    //    echo '<pre>'; echo print_r($otherarr);echo '</pre>';die;
        echo '
        <div id="sub-cate">
            <center><h3 style="background-color:#CDD1D3;color: #000"> Material Categories ('.$cate.') </h3></center>
            <table id="category" class="column-categories">
            <input type="hidden" id="hide_cate_id" value="'.$cate_id.'"/>
                <tr>
                    <td rowspan="2"><center><span style="font-size: 30px;">'.$cate.'</span></center></td>
                    <td class="key-key"><span>AFNOR </span></td>
                    <td class="key-key"><span>Euronorme </span></td>
                    <td class="key-key"><span>NF </span></td>
                    <td class="key-key"><span>AISI </span></td>
                    <td class="key-key"><span>DIN </span></td>
                    <td class="key-key"><span>WK </span></td>
                </tr>
                <tr>
                    <td class="value"><span>'.$otherarr['AFNOR'].'</span></td>
                    <td class="value"><span>'.$otherarr['Euronorme'].'</span></td>
                    <td class="value"><span>'.$otherarr['NF'].'</span></td>
                    <td class="value"><span>'.$otherarr['AISI'].'</span></td>
                    <td class="value"><span>'.$otherarr['DIN'].'</span></td>
                    <td class="value"><span>'.$otherarr['Werskstoff'].'</span></td>
                </tr>
                <tr>
                    <td class="format"><span>Format : </span></td>
                    <td class="format"><span>Rond</span></td>
                    <td class="format"><span>Plat</span></td>
                    <td class="format"><span>ETC :Rond</span></td>
                    <td class="format"><span>ETC :Carre</span></td>
                    <td class="format"><span>Pans</span></td>
                    <td class="format"><span>Lune</span></td>
                </tr>
                <tr>
                    <td class="stock"><span>Stock : </span></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="rond_'.$cate_id.'">'.$rondNum.'<input type="hidden" class="format-sub" value="Rond"/></span></a></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="plat_'.$cate_id.'">'.$platNum.'</span></a><input type="hidden" class="format-sub" value="Plat"/></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="etcRond_'.$cate_id.'">'.$tubeRondNum.'</span></a><input type="hidden" class="format-sub" value="Ebauche / Tube / Couronne : Rond"/></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="etcCarre_'.$cate_id.'">'.$tubeCarreNum.'</span></a><input type="hidden" class="format-sub" value="Ebauche / Tube / Couronne : Carre"/></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="pans_'.$cate_id.'">'.$pansNUm.'</span></a><input type="hidden" class="format-sub" value="Six Pans"/></td>
                    <td class="stock num-ratings"><a href="javascript:void(0);" ><span style="text-align: center;" class="pro-num" id="lune_'.$cate_id.'">'.$luneNum.'</span></a><input type="hidden" class="format-sub" value="Demi Lune"/></td>
                </tr>
        </table>
    </div>
        ';

    }

    add_action('wp_ajax_this-format-goods','this_format_goods_callback');
    add_action('wp_ajax_nopriv_this-format-goods','this_format_goods_callback');
    function this_format_goods_callback() {
        global $wpdb;
        $cateid = $_POST['cate_id'];
        $format = $_POST['format'];
        $cate = $wpdb->get_var($wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id = %d",$cateid));
        $postidSql = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE  mate_key = '_designation' AND meta_value = '%s' ",$format,$cate);
        $postid = $wpdb->get_results($postidSql);
        $postidArr = array();
        foreach ($postid as $postid_key =>$postid_val) {
            $postFormat = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_format' AND post_id = %d ",$postid_val->post_id));
            if ($format == $postFormat) {
                array_push($postidArr,$postid_val->post_id);
            }
        }

        foreach ($postidArr as $post_val) {
            $title = $wpdb->get_var($wpdb->prepare("SELECT post_title FROM $wpdb->posts WHERE ID = %d",$post_val->post_id));
            $otherSQL = $wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d",$$post_val->post_id);
            $otherResult = $wpdb->get_results($otherSQL);
            $this_goodsArr  = array();
            foreach ($otherResult as $other_key => $other_val) {
                $this_goodsArr[$other_val->meta_key] = $other_val->meta_value;
            }

            echo '
                <div id="goodsList" >
                <form class="cart" action="http://chutetest.test/shop/acier-a-ressort/51cdv4/new-goods/" method="post" enctype="multipart/form-data">
                    <table class="woocommerce-grouped-product-list-item__label">
                        <tr class="product_title">form-data
                            <td>Diameter</td>
                            <td>Long</td>
                            <td>Designation</td>
                            <td>Certificate</td>
                            <td>Weight</td>
                            <td>Price</td>
                            <td>piece</td>
                            <td>Action</td>
                        </tr>';
                    foreach ($this_goodsArr as $goods_key => $goods_value) {
                        if($goods_value->_ccpu == '' || $goods_value == 'N/A' || $goods_value == 0) {
                            $ccpu = 'Certificat de Conformité';
                        }else{
                            $ccpu = 'C.C.P.U.&nbsp;&nbsp;'.$goods_value->_ccpu;
                        }
                        echo '
                                <tr class="product_meta">
                                    <td><span>D.'.$goods_value->_diameter.'</span></td>
                                    <td><span>'.$goods_value->_length.' mm</span></td>
                                    <td><span>'.$goods_value->_chute_intitules.'</span></td>
                                    <td><span>'.$ccpu.'</span></td>
                                    <td><span>'.$goods_value->_weight.' kg</span></td>
                                    <td><span>'.$goods_value->_price.' &euro;</span></td>
                                    <td><span>'.$goods_value->_chute_id.'</span></td>
                                    <td>
                                        <span><img src="screenshot.png" alt="pdf"/></span>

                                    </td><button class="single_add_to_cart_button button alt" type="submit" name="add-to-cart" value="'.$post_val->post_id.'">Add to cart</button>
                                </tr>';
                    }
                    echo '</table></form>
                </div>
            ';
        }
    }

*/

add_action('wp_ajax_nopriv_unique-nickname','unique_nickname_callback');
add_action('wp_ajax_unique-nickname','unique_nickname_callback');
function unique_nickname_callback(){
    global $wpdb;
    $nickname = $_POST['nickname'];
    $sql = $wpdb->prepare("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'nickname'");
    $nicknameArr = $wpdb->get_results($sql);
    $newnicknameArr = array();
    foreach ($nicknameArr as $value){
        array_push($newnicknameArr,$value->meta_value);
    }
    if (in_array($nickname,$newnicknameArr)) {
        exit(json_encode(['code'=>0,'msg'=>'事情不大,就不说了!!']));
    }else {
        exit(json_encode(['code'=>1,'msg'=>'Le nom d\'utilisateur est dupliqué, veuillez en changer un autre !!']));
    }

}

add_action( 'user_register', 'pft_registration_save', 10, 1 );
function pft_registration_save( $user_id ) {
    if ( isset( $_POST['username'] ) )
        update_user_meta($user_id, 'username', $_POST['username']);
    if ( isset( $_POST['first_name'] ) )
        update_user_meta($user_id, 'first_name', $_POST['first_name']);
        update_user_meta($user_id, 'billing_first_name', $_POST['first_name']);
        update_user_meta($user_id, 'shipping_first_name', $_POST['first_name']);
    if ( isset( $_POST['last_name'] ) )
        update_user_meta($user_id, 'last_name', $_POST['last_name']);
        update_user_meta($user_id, 'billing_last_name', $_POST['last_name']);
        update_user_meta($user_id, 'shipping_last_name', $_POST['last_name']);
    if ( isset( $_POST['country'] ) )
        update_user_meta($user_id, 'country', $_POST['country']);
        update_user_meta($user_id, 'billing_country', $_POST['country']);
        update_user_meta($user_id, 'shipping_country', $_POST['country']);
    if ( isset( $_POST['address_1'] ) )
        update_user_meta($user_id, 'address_1', $_POST['address_1']);
        update_user_meta($user_id, 'billing_address_1', $_POST['address_1']);
        update_user_meta($user_id, 'shipping_address_1', $_POST['address_1']);
    if ( isset( $_POST['address_2'] ) )
        update_user_meta($user_id, 'address_2', $_POST['address_2']);
        update_user_meta($user_id, 'billing_address_2', $_POST['address_2']);
        update_user_meta($user_id, 'shipping_address_2', $_POST['address_2']);

    if ( isset( $_POST['email'] ) )
        update_user_meta($user_id, 'email', $_POST['email']);
        update_user_meta($user_id, 'billing_email', $_POST['email']);
        update_user_meta($user_id, 'shipping_email', $_POST['email']);
    if ( isset( $_POST['siret'] ) )
        update_user_meta($user_id, 'siret', $_POST['siret']);
        update_user_meta($user_id, 'billing_siret', $_POST['siret']);
        update_user_meta($user_id, 'shipping_siret', $_POST['siret']);
    if ( isset( $_POST['company'] ) )
        update_user_meta($user_id, 'company', $_POST['company']);
        update_user_meta($user_id, 'billing_company', $_POST['company']);
        update_user_meta($user_id, 'shipping_company', $_POST['company']);
    if ( isset( $_POST['password'] ) )
        update_user_meta($user_id, 'password', $_POST['password']);
    if ( isset( $_POST['postcode'] ) )
        update_user_meta($user_id, 'postcode', $_POST['postcode']);
        update_user_meta($user_id, 'billing_postcode', $_POST['postcode']);
        update_user_meta($user_id, 'shipping_postcode', $_POST['postcode']);
    if ( isset( $_POST['per_tel'] ) )
        update_user_meta($user_id, 'per_phone', $_POST['per_tel']);
        update_user_meta($user_id, 'billing_per_phone', $_POST['per_tel']);
        update_user_meta($user_id, 'shipping_per_phone', $_POST['per_tel']);
    if ( isset( $_POST['com_tel'] ) )
        update_user_meta($user_id, 'com_phone', $_POST['com_tel']);
        update_user_meta($user_id, 'billing_com_phone', $_POST['com_tel']);
        update_user_meta($user_id, 'shipping_com_phone', $_POST['com_tel']);
    if ( isset( $_POST['fax'] ) )
        update_user_meta($user_id, 'fax', $_POST['fax']);
        update_user_meta($user_id, 'billing_fax', $_POST['fax']);
        update_user_meta($user_id, 'shipping_fax', $_POST['fax']);
}
// edit  information

/* delete  all order */
function del_order() {
    global $wpdb;
    $orderSql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = 'shop_order'");
    $orderRes = $wpdb->get_results($orderSql);
    foreach ($orderRes as $orderkey => $orderval ) {
        $orderid = $orderval->ID;
        wp_delete_post( $orderid ,true);
    }
}
//add_action('admin_init','del_order');

// delete term iten
function delete_term_item() {
    wp_delete_term(2515,'product_tag');
}

/**
 * 37094 @tableTemplateId  sortCode
 * _orderby  @order_by_rule  ( 'column_6' => 'Rond' )
 * _tax_product_tag[0]=2525
 * @2525 = Plat
 * @2518 = Rond
 * @3175 = half Rond
 * @4506 = six pans
 * @3121 = tube Rond
 * @3714 = tube carre
 * 正式上线之后需要 更改url 重新更改 format id
 */

/**
 * create  a  shortcode to search  product
 */

#1 register a shortcode
function register_shortcodes(){
    add_shortcode('filter-product-customize','need_fields');
}

#2 find result
function need_fields () {
    ob_start();
     echo '
    <div>
        <form method="post" name="linkShop" >
            <table>
                <tr>
                    <td><label for="nuance">Nuance : </label></td>
                    <td><label for="format">Format : </label></td>
                    <td><label for="epaisseur">Epaisseur : </label></td>
                    <td><label for="diameter">Diameter/Largrue/Cote : </label></td>
                    <td><label for="longueur">Longueur : </label></td>
                    <td rowspan="2"><input type="button" id="search-product" name="search-product" value=" Rechercher"/></td>
                </tr>
                <tr>
                    <td><input type="text" id="nuance" name="nuance" placeholder="" /></td>
                    <td>
                        <input type="text" id="format" placeholder="Format" />
                        <input type="hidden" id="format-hide" name="format-hide" />
                        <div id="format_select" style="display: none;"><select id="select-formats" ><option value="" selected></option></select></div>
                    </td>
                    <td><input type="text" id="epaisseur" name="epaisseur" placeholder="Epaisseur"/></td>
                    <td><input type="text" id="diameter" name="diameter" placeholder="Diameter/Largrue/Cote"/></td>
                    <td><input type="text" id="longueur" name="longueur" placeholder="Longueur"/></td>
                </tr>
            </table>
        </form>
    </div>';

    return ob_get_clean();
}

add_action('init','register_shortcodes');


add_action('wp_ajax_nopriv_select-format','select_format_callback');
add_action('wp_ajax_select-format','select_format_callback');
//add_action('init','select_format_callback');
function select_format_callback(){
    global $wpdb;
    # code....  format  product_tag
    # http://chutetest.test/shop/?37094_tax_product_tag%5B0%5D=2518&37094_orderby=column_6&37094_results_per_page=25&37094_order=ASC&37094_device=laptop&37094_filtered=true
    # http://chutetest.test/shop/?37094_tax_product_tag[0]=2518&37094_orderby=column_6&37094_results_per_page=25&37094_order=ASC&37094_device=laptop&37094_filtered=true
    $formatSql = $wpdb->prepare("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = '%s'",'product_tag');
//    $selectStr = '<select id="select-formats">';
    $selectStr = '';
    $idRes = $wpdb->get_results($formatSql);
    foreach ($idRes as $idVal) {
        $nameSql = $wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id = %d ", $idVal->term_id );
//        print_r($nameSql);die;
        $name = $wpdb->get_var($nameSql);
//        echo $name;die;
        $selectStr .= '<option value="'.$idVal->term_id.'">'.$name.'</option>';
    }
//    $selectStr .= '</select>';
    exit(json_encode(['code'=>0,'msg'=>$selectStr]));
//    exit($selectStr);
}

add_action('wp_ajax_nopriv_link-to-shop','link_to_shop_callback');
add_action('wp_ajax_link-to-shop','link_to_shop_callback');
function link_to_shop_callback(){
    global $wpdb;
    $nuance = $_POST['nuance'];
    $format = $_POST['format'];
    $epaisseur = $_POST['epaisseur'];
    $diamieter = $_POST['diamieter'];
    $longueur = $_POST['longueur'];
    if(!empty($nuance)){
        $nuanceUrl = '37094_search_1='.$nuance.'&';
    }else{
        $nuanceUrl = '';
    }

    if(!empty($format)){
        $formatUrl = '37094_tax_product_tag[0]='.$format.'&';
    }else{
        $formatUrl = '';
    }
    if(!empty($epaisseur)){
        $epaisseurUrl = '37094_cf_Epaisseur_range_min='.$epaisseur.'&';
    }else{
        $epaisseurUrl = '';
    }
    if(!empty($diamieter)){
        $diamieterUrl = '37094_cf_Diameter/Largrue/Cote_range_min='.$diamieter.'&';
    }else{
        $diamieterUrl = '';
    }
    if(!empty($longueur)){
        $longueurUrl = '37094_cf_Longueur_range_min='.$longueur.'';
    }else{
        $longueurUrl = '';
    }
    $header_url = 'http://chutetest.test/shop/';
    $first = '?';
    $complete_url = $header_url.$first.$nuanceUrl.$formatUrl.$epaisseurUrl.$diamieterUrl.$longueurUrl;
    if($complete_url == $header_url ){
        exit(json_encode(['code'=>0,'msg'=>'Vous devez saisir les critères de filtrage']));
    }else{
        exit(json_encode(['code'=>1,'msg'=>$complete_url]));
    }

}


//add_action( 'woocommerce_cart_calculate_fees', 'woo_ccpu_fee');
function woo_ccpu_fee() {
    global $woocommerce;
    global $wpdb;
    $fee = 0;
    $three = 3.81;
    $seven = 7.62;
    foreach(WC()->cart->get_cart() as $key => $item){

        $product_id = $item['product_id'];
        $sql = $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = $product_id AND meta_key = '_product_attributes'");
        $proRes = $wpdb->get_var($sql);
        $num = substr_count($proRes,'pa_ccpu');
        if($num == 0){
            $item['certificate']['name'] = __('Certificat de conformité Quali Chutes @ 3.81 €','woocommerce');
            $item['certificate']['price'] = 3.81;
            $fee += $three;
        }else{
            $sql = $wpdb->prepare("SELECT name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN wp_term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE wp_term_relationships.object_id = $product_id AND $wpdb->term_taxonomy.taxonomy = 'pa_ccpu'");
            $ccpu = $wpdb->get_var($sql);
            if ($ccpu === '0' ){
                $item['certificate']['name'] = __('Certificat de conformité Quali Chutes @ 3.81 €','woocommerce');
                $item['certificate']['price'] = 3.81;
                $fee += $three;
            }else{
                if($ccpu === 'N/A'){
                    $item['certificate']['name'] = __('	 CCPU selon disponibilité @ 7.62 €','woocommerce');
                    $item['certificate']['price'] = 7.62;
                }else{
                    $item['certificate']['name'] = __(' CCPU 3.1.B (Certificat de contrôle produit par l\'usine) @ 7.62 €','woocommerce');
                    $item['certificate']['price'] = 7.62;
                }
                $fee += $seven;
            }
        }
    }
    $woocommerce->cart->add_fee( __('Certificate', 'woocommerce'), $fee );
}

//add_action('wp_ajax_nopriv_sub-ccpu-price','sub_ccpu_price_callback');
//add_action('wp_ajax_sub-ccpu-price','sub_ccpu_price_callback');
function sub_ccpu_price_callback(){

    $price = $_POST['price'];
    $ids = $_POST['ids'];
//    print_r($ids);die;
    $priceSum = array_sum($price);


    foreach(WC()->cart->get_cart() as $key => $item){
        if(in_array($item['product_id'],$ids)){
            $item['certificate'] = 1;
        }else{
            $item['certificate'] = 0;
        }
    }

    exit(json_encode(['code'=>1,'msg'=>$priceSum]));
}

// add  customer  fields
//add_action('woocommerce_before_add_to_cart_button', 'add_hide_fields', 10);
function add_hide_fields(){
    ?>
    <div class="product_ccpu-field">
        <input type="hidden" name="certificate" class="certificate" value="W97096">
    </div>
    <?php
}

//add_filter('woocommerce_add_cart_item_data', 'add_certificate_to_cart_data', 1, 10);
function add_certificate_to_cart_data ($cart_item_data, $product_id){
    global $woocommerce;
    $new_value = [];
//    print_r($_POST);die;
    if (isset($_POST[ 'certificate' ])) {
        $new_value[ 'pro_certificate' ] = $_POST[ 'certificate' ];

        if (empty($cart_item_data)) {
            return $new_value;
        } else {
            return array_merge($cart_item_data, $new_value);
        }
    }

    return $cart_item_data;

}

//add_filter('woocommerce_get_cart_item_from_session', 'get_cart_data_form_session', 1, 3);
function get_cart_data_form_session($item, $values, $key){
    if (array_key_exists('pro_certificate', $values)) {
        $item[ 'pro_certificate' ] = $values[ 'pro_certificate' ];
    }

    return $item;
}

//add_filter('woocommerce_cart_item_name', 'generate_display_string', 1, 3);
function generate_display_string($product_name, $values, $cart_item_key){
    if (array_key_exists('pro_certificate', $values)) {
        $return_string = $product_name . '<br /><span>' . $values[ 'pro_certificate' ] . '</span>';

        return $return_string;
    }
    return $product_name;
}

//add_action('woocommerce_add_order_item_meta', 'add_data_to_order', 1, 2);
function add_data_to_order($item_id, $values){
    global $woocommerce, $wpdb;
    wc_add_order_item_meta($item_id, 'pro_certificate', $values[ 'pro_certificate' ]);
}

//add_action( 'woocommerce_before_calculate_totals', 'set_customier_total', 1, 1 );
function set_customier_total( $cart_object ) {
    foreach ( $cart_object->cart_contents as $cart_item_key => $value ) {
        $value['data']->set_price($value['data']->get_price());
    }
}

add_action('wp_ajax_nopriv_add-customize-field-to-certificate','add_to_certificate_callback');
add_action('wp_ajax_add-customize-field-to-certificate','add_to_certificate_callback');
function add_to_certificate_callback(){
    global $wpdb , $woocommerce ;
    $product_id = $_POST['product_id'];
    $certificate = $_POST['certificate'];
    $sku = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_sku' AND post_id = $product_id");
//    if($certificate == 'null' )
//        $certificateValue = $certificate.' ( chute #'.$sku.' )';
    $certificateValue =  ($certificate == 'null' )?' ( chute #'.$sku.' )' : $certificate.' ( chute #'.$sku.' )';
//    var_dump($certificate);
    if ($certificate === 'null'){
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = '0'");
        $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $post_id ");
        $certificateValue =  ($certificateOldValue == '') ? $certificateValue : $certificateOldValue.' | '.$certificateValue;
    }elseif ($certificate === 'N/A' ) {
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'N/A'");
        $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $post_id ");
        $certificateValue =  ($certificateOldValue == '') ? $certificateValue : $certificateOldValue.' | '.$certificateValue;
    }else{
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'CCPU'");
        $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $post_id ");
        $certificateValue =  ($certificateOldValue == '') ? $certificateValue : $certificateOldValue.' | '.$certificateValue;
    }
//    $certificateArray = explode("|",$certificateValue);
//    $certificateValue = implode("|",array_unique($certificateArray));
    update_post_meta($post_id,'_certificate',$certificateValue);

    exit(json_encode(['code'=>1,'msg'=>'disabled="disabled"']));
}
add_action('init','empty_cart');
function empty_cart(){
    global $wpdb;
    if (!is_admin()){
        if ( WC()->cart->get_cart_contents_count() == 0 ){
            $post_0_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = '0'");
            $post_na_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'N/A'");
            $post_ccpu_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'CCPU'");
            update_post_meta($post_0_id,'_certificate', '');
            update_post_meta($post_na_id,'_certificate', '');
            update_post_meta($post_ccpu_id,'_certificate', '');
        }
    }

}

add_action('woocommerce_cart_item_removed','remove_certificate');
function remove_certificate(){
    global $woocommerce , $wpdb ;
//    print_r(WC()->cart->get_removed_cart_contents());die;
    $remove_cart_item = WC()->cart->get_removed_cart_contents();
    foreach ($remove_cart_item as $item) {
        $post_id = $item['product_id'];

        // get ccpu and sku  ,generate  new  string by id
        $sku = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_sku' AND post_id = $post_id ");
        $ccpu = $wpdb->get_var("SELECT name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN wp_term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE wp_term_relationships.object_id = $post_id AND $wpdb->term_taxonomy.taxonomy = 'pa_ccpu'");
        if ($ccpu == '' || $ccpu === '0'){
            $certificateStr = '( chute #'.$sku.' )';
            $certificate_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = '0'");
            $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $certificate_id ");
        }else{
            $certificateStr = $ccpu.' ( chute #'.$sku.' )';
            if ($ccpu === 'N/A'){
                $certificate_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'N/A'");
                $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $certificate_id ");
            }else{
                $certificate_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content = 'CCPU'");
                $certificateOldValue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_certificate' AND post_id = $certificate_id ");
            }
        }

        // update certificate  customize fields '_certificate
        $certificateArr = explode('|',$certificateOldValue);
        array_unique($certificateArr);
        $key = array_search($certificateStr,$certificateArr);
        unset($certificateArr[$key]);
        $certificateValue = implode("|",$certificateArr);
        update_post_meta($certificate_id,'_certificate',$certificateValue);

        // update cart certificate quantity
        foreach (WC()->cart->get_cart() as $cart) {
            if($cart['product_id'] == $certificate_id ){
                WC()->cart->set_quantity($cart['key'],$cart['quantity']-1);
            }
        }
    }
	
}

function generate_chutes_json()
{
    print_r('hello world!!');die;
    global $wpdb, $woocommerce;
    $productAllData = array();
    $selectSql = $wpdb->prepare("SELECT ID , post_title as chute_name FROM $wpdb->posts WHERE post_type = %s ", 'product');
    $result = $wpdb->get_results($selectSql, 'OBJECT');
    foreach ($result as $res_val) {
        $data_arr = array();
        $goods_infoSql = $wpdb->prepare("SELECT $wpdb->postmeta.* FROM $wpdb->postmeta WHERE $wpdb->postmeta.post_id = %d",$res_val->ID);
        $goods_info = $wpdb->get_results($goods_infoSql, 'OBJECT');
        $keys = array();
        foreach ($goods_info as $goodKey => $goodVal) {
            array_push($keys, $goodVal->meta_key);
        }
        if (in_array('_sku', $keys)) :
            foreach ($goods_info as $goodKey => $goodVal) {
                if ($goodVal->meta_key == '_weight') $data_arr['weight'] = $goodVal->meta_value;
                if ($goodVal->meta_key == 'diameter_largeur_cote') $data_arr['diameter'] = $goodVal->meta_value;
                if ($goodVal->meta_key == 'epaisseur') $data_arr['epaisseur'] = $goodVal->meta_value;
                if ($goodVal->meta_key == 'longueur') $data_arr['longueur'] = $goodVal->meta_value;
                if ($goodVal->meta_key == '_price') $data_arr['prixht'] = $goodVal->meta_value;
                if ($goodVal->meta_key == '_sku') $data_arr['chute_id'] = $goodVal->meta_value;
            }
            $cate_infoSql = $wpdb->prepare("SELECT $wpdb->terms.name as cate FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN $wpdb->term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE $wpdb->term_taxonomy.taxonomy = %s AND $wpdb->term_relationships.object_id = %d ", array('product_cat', $res_val->ID));
            $cate = $wpdb->get_var($cate_infoSql);
            $data_arr['cate'] = $cate;
            $parent_cateSql = $wpdb->prepare("SELECT name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id WHERE $wpdb->term_taxonomy.term_id = (SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = (SELECT term_id FROM $wpdb->terms WHERE name = %s ORDER BY term_id ASC LIMIT 1 ))", $cate);
            $parent = $wpdb->get_var($parent_cateSql);
            $data_arr['parents'] = $parent;
            $shape_infoSql = $wpdb->prepare("SELECT $wpdb->terms.name as shape FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id LEFT JOIN $wpdb->term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id WHERE $wpdb->term_taxonomy.taxonomy = %s AND $wpdb->term_relationships.object_id = %d ", array('product_tag', $res_val->ID));
            $shape = $wpdb->get_var($shape_infoSql);
            $data_arr['shape'] = $shape;
            $data_arr['name'] = $res_val->chute_name;
        endif;
//        echo '<pre>';print_r(json_encode($data_arr));echo '</pre>';die;
        $productAllData[$res_val->ID] = json_encode($data_arr);
        if (json_last_error() !== 0 ) {
            echo json_last_error_msg().'<hr>'.$res_val->ID.'<br/>';
        }
    }
    $product_all_json = json_encode($productAllData);

    /*return $product_all_json;*/
    $newF = fopen( dirname(__DIR__).'/../uploads/qualichutes_chute.json','w+');
    fwrite($newF, $product_all_json);
    fclose($newF);
}
add_action('chute_json', 'generate_chutes_json');


function chutejson_shortcodes()
{
    add_shortcode('qualichute_json', 'call_chute_hook');
}

function call_chute_hook(){
    do_action('chute_json');
}
add_action('init', 'chutejson_shortcodes');
