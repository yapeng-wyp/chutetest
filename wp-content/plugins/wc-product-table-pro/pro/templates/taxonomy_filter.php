<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( empty( $taxonomy ) ){
  return;
}

$taxonomy_object = get_taxonomy( $taxonomy );

$table_data = wcpt_get_table_data();
$table_id = $table_data['id'];

$input_field_name = $table_id . '_tax_' . $taxonomy;

// pre-selected
if( $pre_selected = wcpt_get_nav_filter( 'taxonomy', $taxonomy ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[$input_field_name] = $_REQUEST[$input_field_name] = $pre_selected['values'];
	}else{
		// remove
		wcpt_clear_nav_filter( 'taxonomy', $taxonomy );
	}
}

// $dropdown_options will be used for priting on front end
$dropdown_options = array();

if( empty( $hide_empty ) ){
	$hide_empty = false;
}

// get tax terms
$terms = get_terms( array(
	'taxonomy' => $taxonomy,
	'hide_empty' => $hide_empty,
	'object' => array('product'),
) );

if( is_wp_error( $terms ) || ! $terms ){
	return;
}

if(
	empty( $display_type ) ||
	( ! empty( $position ) && $position === 'left_sidebar' )
){
  $display_type = 'dropdown';
}

if( empty( $single ) ){
  $single = false;
}

if( $display_type == 'dropdown' ){
  $container_html_class = 'wcpt-dropdown wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-dropdown-label';
  $options_container_html_class = 'wcpt-dropdown-menu';
  $single_option_container_html_class = 'wcpt-dropdown-option';

  if( empty( $heading ) ){
    $heading = $taxonomy_object->labels->name;
  }

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

$heading = str_replace('[taxonomy]', $taxonomy_object->labels->name, $heading);

// filter is applied
if(
	// isset
	! empty( $_REQUEST[$input_field_name] ) &&
	// not empty arr
	! (
		gettype( $_REQUEST[$input_field_name] ) == 'array' &&
		! array_filter( $_REQUEST[$input_field_name] )
	)
){
	$container_html_class .= ' wcpt-filter-open';
}

if( ! empty( $accordion_always_open ) ){
	$container_html_class .= ' wcpt-filter-open';
}

// excludes array
$excludes_arr = array();
if( ! empty( $exclude_terms ) ){
	$excludes_arr = preg_split( '/\r\n|\r|\n/', $exclude_terms );
}

// build dropdown array
foreach( $terms as $term ){

	// exclude
	if( 
		in_array( $term->name, $excludes_arr ) ||
		in_array( $term->slug, $excludes_arr )
	){
		continue;
	}

	// relabel
	if( isset( $relabels ) ){

		//-- look for a matching rule
		$match = false;
		foreach( $relabels as $rule ){

			// skip default
			if( wcpt_is_default_relabel($rule) ){
				continue;
			}			

			if( 
				wp_specialchars_decode( $term->name ) == $rule['term'] ||
				(
					function_exists('icl_object_id') &&
					! empty( $rule['ttid'] ) &&
					$term->term_taxonomy_id == icl_object_id( $rule['ttid'], $taxonomy, false )
				)
			){
				$term->label = str_replace( '[term]', $term->name, wcpt_parse_2( $rule['label'] ) );
				if( ! empty( $rule['clear_label'] ) ){
					$term->clear_label = $rule['clear_label'];
				}
				$match = true;
			}
		}
	}

	if( ! isset( $term->label ) ){
		$term->label = apply_filters( 'wcpt_term_name_in_navigation_filter', $term->name, $term );
	}

	// option must have value field
	$term->value = $term->term_taxonomy_id;

	// add term in dropdown options
	$dropdown_options[] = $term;

}

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

// heading format when option is selected 
if( empty( $heading_format__op_selected ) ){
	$heading_format__op_selected = 'only_heading';
}	

// search filter options
$search_placeholder_attr = '';
if(
	$display_type == 'dropdown' &&
	! empty( $search_enabled )
){
	if( empty( $search_placeholder ) ){
		$search_placeholder = '';
	}

	$search_placeholder = str_replace( '[taxonomy]', $taxonomy_object->labels->name, $search_placeholder );

	$search_placeholder_attr = ' data-wcpt-search-filter-options-placeholder="'. esc_attr( $search_placeholder ) .'" ';
}

?>
<div 
	class="<?php echo $container_html_class; ?>" 
	data-wcpt-filter="taxonomy" 
	data-wcpt-taxonomy="<?php echo $taxonomy; ?>"
	data-wcpt-heading_format__op_selected = "<?php echo $heading_format__op_selected; ?>"			
	<?php echo $search_placeholder_attr; ?>
>
	<div class="wcpt-filter-heading">
		<!-- label -->
	  <span class="<?php echo $heading_html_class; ?>"><?php echo wcpt_parse_2($heading); ?></span>

		<!-- active count -->
	  <?php if( ! empty( $_GET[$input_field_name] ) && ! $single ){
		?>
	  <span class="wcpt-active-count"><?php echo count( $_GET[$input_field_name] ); ?></span>
		<?php } ?>

	  <!-- loader icon -->
		<?php 
			if( $dynamic_filter_lazy_load ){
				wcpt_icon('loader', 'wcpt--dynamic-filters--loading-filter__loading-icon'); 
			}
		?>		

	  <!-- icon -->
	  <?php wcpt_icon('chevron-down'); ?>
	</div>

	<!-- options menu -->
	<div class="wcpt-hierarchy <?php echo $options_container_html_class; ?>">

	<?php
		// "Show all" option
		if( 
			$single && 
			! wcpt_is_template_empty($show_all_label)
		){
			if(
				empty( $_GET[$input_field_name] ) ||
				! count( $_GET[$input_field_name] ) ||
				( count( $_GET[$input_field_name] ) == 1 && ! $_GET[$input_field_name][0] )
			){
				$checked = true;
			}else{
				$checked = false;
			}

			?>
			<label class="wcpt-show-all-option <?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>" data-wcpt-value="">
				<input type="radio" value="" class="wcpt-filter-checkbox" <?php echo $checked ? ' checked="checked" ' : ''; ?> name="<?php echo $input_field_name; ?>[]"><?php echo wcpt_parse_2($show_all_label); ?>
			</label>
			<?php
		}
	?>

	<?php if( $display_type == 'dropdown' ){

		foreach( $dropdown_options as $option  ){
			$option = apply_filters( 'wcpt_nav_filter_option', $option, 'taxonomy', array('taxonomy' => $taxonomy) );
		}		

		wcpt_include_taxonomy_walker();
		$walker = new WCPT_Taxonomy_Walker(array(
			'field_name' => $input_field_name,
			'exclude' => $excludes_arr,
			'single' => $single,
			'hide_empty' => $hide_empty,
			'taxonomy' => $taxonomy,
			'operator' => empty( $operator ) ? 'IN' : $operator,
			'pre_open_depth' => ! empty( $pre_open_depth ) ? (int) $pre_open_depth : 0,
			'option_class' => $single_option_container_html_class,
		));
		echo $walker->walk( $dropdown_options, 0 );

	}else{

		if( ! empty( $dropdown_options ) ){

			foreach ( $dropdown_options as $option ) {
				// option was selected or not?
				$option = (array) $option;

				if(
					! empty( $_GET[ $input_field_name ] ) &&
					(
						$_GET[ $input_field_name ] == $option['value'] ||
						(
							is_array( $_GET[ $input_field_name ] ) &&
							in_array( $option['value'], $_GET[ $input_field_name ] )
						)
					)
				){

					$checked = true;

					// use filter in query
					$filter_info = array(
						'filter'      => 'taxonomy',
						'values'      => array( $option['value'] ),
						'taxonomy'    => $taxonomy,
						'operator'    => ! empty( $operator ) ? $operator : 'IN',
						'clear_label' => $taxonomy_object->labels->name,
					);

					if( ! empty( $option['clear_label'] ) ){
						$filter_info['clear_labels_2'] = array(
							$option['value'] => str_replace( array( '[option]', '[filter]' ), array( $option['name'], $taxonomy_object->labels->name ), $option['clear_label'] ),
						);
					}else{
						$filter_info['clear_labels_2'] = array(
							$option['value'] => $taxonomy_object->labels->name . ' : ' .$option['name'],
						);
					}

					wcpt_update_user_filters( $filter_info, $single );

				}else{
					$checked = false;
				}

				?>
				<label class="<?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>" data-wcpt-slug="<?php echo $option['slug']; ?>" data-wcpt-value="<?php echo $option['value']; ?>">
					<input type="<?php echo $single ? 'radio' : 'checkbox'; ?>" value="<?php echo $option['value']; ?>" class="wcpt-filter-checkbox" <?php echo $checked ? ' checked="checked" ' : ''; ?> name="<?php echo $input_field_name; ?>[]" data-wcpt-clear-filter-label="<?php echo esc_attr( $option['name'] ); ?>"><?php echo $option['label']; ?>
				</label>
				<?php
			}
		}

	} ?>
  </div>

</div>
