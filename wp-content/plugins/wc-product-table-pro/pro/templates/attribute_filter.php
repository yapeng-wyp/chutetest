<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( empty( $attribute_name ) ){
  return;
}

$table_id = $GLOBALS['wcpt_table_data']['id'];

$taxonomy = 'pa_' . $attribute_name;

$input_field_name = $table_id . '_attr_' . $taxonomy;

// pre-selected
if( $pre_selected = wcpt_get_nav_filter( 'attribute', $taxonomy ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[$input_field_name] = $_REQUEST[$input_field_name] = $pre_selected['values'];
	}else{
		// remove
		wcpt_clear_nav_filter( 'attribute', $taxonomy );
	}
}

// $dropdown_options will be used for priting on front end
$dropdown_options = array();

// get tax terms
$table_data = wcpt_get_table_data();
$term_args = array(
	'taxonomy' => $taxonomy,
	'hide_empty' => false,
);

// -- limit to ids defined in sc
if( 
	! empty( $table_data['query']['sc_attrs'] ) &&
	! empty( $table_data['query']['sc_attrs']['ids'] )
){
	$term_args['object_ids'] = array_map( 'trim', explode( ',', $table_data['query']['sc_attrs']['ids'] ) );
}
$terms = get_terms( $term_args );

// excludes array
$excludes_arr = array();
if( ! empty( $exclude_terms ) ){
	$excludes_arr = preg_split( '/\r\n|\r|\n/', $exclude_terms );
}
if( ! empty( $_GET[$table_id .'_exclude_attribute_'. $taxonomy ] ) ){
	$excludes_arr = $_GET[$table_id .'_exclude_attribute_'. $taxonomy ];
}

$excludes_arr = array_map( 'trim', array_map( 'strtolower', $excludes_arr ) );

// build dropdown array
foreach( $terms as $term ){

	$term = (array) $term;

	// exclude
	if( in_array( strtolower( $term['name'] ), $excludes_arr ) ){
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
				wp_specialchars_decode( $term['name'] ) == $rule['term'] ||
				(
					function_exists('icl_object_id') &&
					! empty( $rule['ttid'] ) &&
					$term['term_taxonomy_id'] == icl_object_id( $rule['ttid'], $taxonomy, false )
				)
			){
				$term['label'] = str_replace( '[term]', $term['name'], wcpt_parse_2( $rule['label'] ) );
				if( ! empty( $rule['clear_label'] ) ){
					$term['clear_label'] = $rule['clear_label'];
				}
				$match = true;
			}
		}
	}

	if( ! isset( $term['label'] ) ){
		$term['label'] = $term['name'];
	}

	if( ! $match ){
		$term_name = apply_filters( 'wcpt_term_name_in_navigation_filter', $term['label'], $term );
		$term['label'] = '<div class="wcpt-item-row"><span class="wcpt-text">'. $term_name .'</span></div>';

	}	

	// option must have value field
	$term['value'] = $term['term_taxonomy_id'];

	$dropdown_options[] = $term;

}

$dropdown_options = apply_filters('wcpt_taxonomy_filter_options', $dropdown_options, $taxonomy);

if( ! $dropdown_options ){
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
    $heading = wc_attribute_label( $taxonomy );
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

	$search_placeholder = str_replace( '[attribute]', wc_attribute_label( $taxonomy ), $search_placeholder );

	$search_placeholder_attr = ' data-wcpt-search-filter-options-placeholder="'. esc_attr( $search_placeholder ) .'" ';
}

?>
<div 
	class="<?php echo $container_html_class; ?>" 
	data-wcpt-filter="attribute" 
	data-wcpt-heading_format__op_selected = "<?php echo $heading_format__op_selected; ?>"
	data-wcpt-taxonomy="<?php echo $taxonomy; ?>"
	<?php echo $search_placeholder_attr; ?>	
>

	<div class="wcpt-filter-heading">
	  <!-- label -->
	  <?php if( ! empty( $heading ) ){
			$heading = str_replace( '[attribute]', wc_attribute_label( $taxonomy ), wcpt_parse_2( $heading ) );
		?>
	  <span class="<?php echo $heading_html_class; ?>"><?php echo $heading; ?></span>
		<?php } ?>

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

	  <!-- toggle icon -->
	  <?php wcpt_icon('chevron-down'); ?>
	</div>

  <!-- options menu -->
  <div class="<?php echo $options_container_html_class; ?>">
    <?php
      if( ! empty( $dropdown_options ) ){

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

				if( empty( $GLOBALS['wcpt_filter_count'] ) ){
					$GLOBALS['wcpt_filter_count'] = array();
				}

				global $wcpt_filter_count;

        foreach ( $dropdown_options as $option ) {

					$option = apply_filters( 'wcpt_nav_filter_option', $option, 'attribute', array('taxonomy' => $taxonomy) );

          // option was selected or not?
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
              'filter'      => 'attribute',
              'values'      => array( $option['value'] ),
              'taxonomy'    => $taxonomy,
              'operator'    => ! empty( $operator ) ? $operator : 'IN',
              'clear_label' => wc_attribute_label( $taxonomy ),
            );

						if( ! empty( $option['clear_label'] ) ){
							$filter_info['clear_labels_2'] = array(
								$option['value'] => str_replace( array( '[option]', '[filter]' ), array( $option['name'], wc_attribute_label( $taxonomy ) ), $option['clear_label'] ),
							);
						}else{
							$filter_info['clear_labels_2'] = array(
								$option['value'] => wc_attribute_label( $taxonomy ) . ' : ' .$option['name'],
							);
						}

            wcpt_update_user_filters( $filter_info, $single );

          }else{
            $checked = false;
          }

          ?>
          <label class="<?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>" data-wcpt-slug="<?php echo $option['slug']; ?>" data-wcpt-value="<?php echo $option['value']; ?>">
            <input
							type="<?php echo $single ? 'radio' : 'checkbox'; ?>"
							value="<?php echo $option['value']; ?>"
							class="wcpt-filter-checkbox" <?php echo $checked ? ' checked="checked" ' : ''; ?>
							name="<?php echo $input_field_name; ?>[]"
							data-wcpt-clear-filter-label="<?php echo esc_attr( $option['name'] ); ?>"
						/><span><?php echo $option['label']; ?></span>
          </label>
          <?php
        }
      }
    ?>
  </div>
</div>
