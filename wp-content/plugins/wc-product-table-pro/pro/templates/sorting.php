<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// only loop
if( ! empty( $GLOBALS['wcpt_table_data']['query']['sc_attrs']['_only_loop'] ) ){
	return;
}

if( empty( $meta_key ) ){
	$meta_key = false;
}

if( empty( $orderby_attribute ) ){
	$orderby_attribute = false;
}

if( empty( $orderby_taxonomy ) ){
	$orderby_taxonomy = false;
}

extract( wcpt_get_sorting_html_classes( $orderby, $meta_key, $orderby_attribute, $orderby_taxonomy ) );

?>
<div
	class="wcpt-sorting-icons <?php echo $html_class . ' ' . $sorting_class; ?>"
	data-wcpt-orderby="<?php echo $orderby; ?>"
	data-wcpt-meta-key="<?php echo esc_attr( $meta_key ); ?>"
>
	<div class="wcpt-sorting-asc-icon wcpt-sorting-icon <?php echo $sorting_class_asc; ?>"></div>
	<div class="wcpt-sorting-desc-icon wcpt-sorting-icon <?php echo $sorting_class_desc; ?>"></div>
</div>
