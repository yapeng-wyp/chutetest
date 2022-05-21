<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( get_option('woocommerce_hide_out_of_stock_items', 'no') == 'yes' ){
	return;
}

$table_data = wcpt_get_table_data();

if(
	empty( $display_type ) ||
	( ! empty( $position ) && $position === 'left_sidebar' )
 ){
  $display_type = 'dropdown';
}

if( $display_type == 'dropdown' ){
  $container_html_class = 'wcpt-dropdown wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-dropdown-label';
  $options_container_html_class = 'wcpt-dropdown-menu';
  $single_option_container_html_class = 'wcpt-dropdown-option';

}else{
  $container_html_class = 'wcpt-options-row wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-options-heading';
  $options_container_html_class = 'wcpt-options';
  $single_option_container_html_class = 'wcpt-option';

}

// heading row
if( ! $heading = wcpt_parse_2( $heading ) ){
	$container_html_class .= ' wcpt-no-heading wcpt-filter-open';
}

$table_id = $table_data['id'];
$input_field_name = $table_id . '_availability';

// pre-selected
if( $pre_selected = wcpt_get_nav_filter( 'availability' ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[$input_field_name] = $_REQUEST[$input_field_name] = $pre_selected['operator'];

	}else{
		// remove
		wcpt_clear_nav_filter( 'availability' );
	}
}

// process
$input_field_name = $GLOBALS['wcpt_table_data']['id'] . '_availability';
$original_filter = wcpt_get_nav_filter('availability');

if( ! $original_filter ){
	$original_filter = $current_filter = array(
		'filter' => 'availability',
		'operator' => 'ALSO',
	);
}else{
	$current_filter = $original_filter;
}

if( 
	! empty( $_GET[ $input_field_name ] ) && 
	in_array( 
		strtoupper($_GET[ $input_field_name ]), 
		array( 'ALSO', 'NOT IN' ) 
	) 
){
	$current_filter['operator'] = strtoupper($_GET[ $input_field_name ]);
}

$checked = false;
if( $current_filter['operator'] == 'NOT IN' ){
	$checked = true;
}

// use filter in query
wcpt_update_user_filters( $current_filter, true );

// filter modified

if( $original_filter['operator'] != $current_filter['operator'] ){
	$container_html_class .= ' wcpt-filter-open';
}

if( ! empty( $accordion_always_open ) ){
	$container_html_class .= ' wcpt-filter-open';
}

// filter option hook
$option = apply_filters(
		'wcpt_nav_filter_option', 
		array(
			'value' => 'NOT IN',
			'label' => empty( $hide_label ) ? __( 'Hide out of stock', 'wc-product-table' ) : wcpt_parse_2( $hide_label ),
		), 
		'availability', 
		null
	);

// dynamic filter lazy load
$dynamic_filter_lazy_load = false;
if(  
	! empty( $table_data['query']['sc_attrs']['dynamic_filters_lazy_load'] ) &&
	(
		! empty( $table_data['query']['sc_attrs']['dynamic_recount'] ) ||
		! empty( $table_data['query']['sc_attrs']['dynamic_hide_filters'] )
	)
){
	$dynamic_filter_lazy_load = true;
}

if( $dynamic_filter_lazy_load ){
	$container_html_class.= ' wcpt--dynamic-filters--loading-filter';
}

?>
<div class="<?php echo $container_html_class; ?>" data-wcpt-filter="availability">
	<div class="wcpt-filter-heading">
		<!-- label -->
		<span class="<?php echo $heading_html_class; ?>"><?php echo $heading;?></span>
		
	  <!-- loader icon -->
		<?php 
			if( $dynamic_filter_lazy_load ){
				wcpt_icon('loader', 'wcpt--dynamic-filters--loading-filter__loading-icon'); 
			}
		?>

	  <!-- toggle icon -->
	  <?php wcpt_icon('chevron-down'); ?>
	</div>

  <!-- options menu -->
  <div class="<?php echo $options_container_html_class; ?>">
    <label
			class="<?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>"
			data-wcpt-value="<?php echo $option['value']; ?>"
		>
			<input 
				type="checkbox" 
				value="NOT IN" 
				data-wcpt-reverse-value="ALSO" 
				class="wcpt-filter-checkbox" <?php echo $checked ? ' checked="checked" ' : ''; ?> name="<?php echo $input_field_name; ?>"
			><span><?php echo $option['label']; ?></span>
    </label>
  </div>
</div>