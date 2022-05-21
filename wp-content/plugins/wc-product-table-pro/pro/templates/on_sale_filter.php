<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

$table_data = wcpt_get_table_data();
$table_id = $table_data['id'];
$input_field_name = $table_id . '_on_sale';

// pre-selected

if( $pre_selected = wcpt_get_nav_filter( 'on_sale' ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[ $input_field_name ] = $_REQUEST[ $input_field_name ] = $pre_selected['value'];

	}else{
		// remove
		wcpt_clear_nav_filter( 'on_sale' );
	}
}

// process
$filter = array(
	'filter' => 'on_sale',
	'value' => false,
);

if( ! empty( $_GET[ $input_field_name ] ) ){
	$filter['value'] = true;
	$checked = true;

	// use filter in query
	wcpt_update_user_filters( $filter, true );

	// filter modified
	$container_html_class .= ' wcpt-filter-open';

}else{
	$checked = false;
}

if( ! empty( $accordion_always_open ) ){
	$container_html_class .= ' wcpt-filter-open';
}

$option = apply_filters( 
	'wcpt_nav_filter_option', 
	array(
		'label' => empty( $on_sale_label ) ? __( 'Only on sale items', 'wc-product-table' ) : wcpt_parse_2( $on_sale_label ),
		'value' => 'true',
	),
	'on_sale',
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
<div class="<?php echo $container_html_class; ?>" data-wcpt-filter="on_sale">

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
			data-wcpt-value="true"
		>
		<input 
			type="checkbox" 
			value="true" 
			class="wcpt-filter-checkbox" 
			<?php echo $checked ? ' checked="checked" ' : ''; ?> 
			name="<?php echo $input_field_name; ?>" 
		/><span><?php echo $option['label']; ?></span>
    </label>
  </div>
</div>
