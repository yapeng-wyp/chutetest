<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( empty( $field_name ) ){
  return;
}

$table_id = $GLOBALS['wcpt_table_data']['id'];

$input_field_name = $table_id . '_cf_' . str_replace(' ', '_', $field_name);

// pre-selected
if( $pre_selected = wcpt_get_nav_filter( 'custom_field', $field_name ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[$input_field_name] = $_REQUEST[$input_field_name] = $pre_selected['values'];
	}else{
		// remove
		wcpt_clear_nav_filter( 'custom_field', $field_name );
	}
}

if(
	empty( $display_type ) ||
	( ! empty( $position ) && $position === 'left_sidebar' ) // force in left sidebar
){
  $display_type = 'dropdown';
}

if( empty( $single ) ){
  $single = false;
}

// $dropdown_options will be used for priting on front end
$dropdown_options = array();

// manual options
if( empty( $compare ) ){
	$compare = 'IN';
}

if( empty( $field_type__exact_match ) ){
	$field_type__exact_match = 'CHAR';
}

if( empty( $order__exact_match ) ){
	$order__exact_match = 'ASC';
}

if( empty( $manual_options ) ){

	if( 
		! empty( $manager ) &&
		$manager == 'acf' &&
		! empty( $acf_field_type ) &&
		$acf_field_type = 'choice' &&
		! empty( $acf_choices )
	){
		$manual_options = wcpt_generate_custom_field_options_from_acf_choices($acf_choices);
	}else{
		$manual_options = wcpt_auto_generate_custom_field_options($field_name, $field_type__exact_match, $order__exact_match );
	}
	
}

if( $compare == 'IN' ){
// exact match

	if( empty( $manual_options ) ){
		$manual_options = array();
	}

	foreach( $manual_options as $option ){
		// ensure label is present and parse it
		if( ! empty( $option['label'] ) ){
			$option['label'] = wcpt_parse_2( $option['label'] );
		}else{
			$option['label'] = $option['value'];
		}

		$option['label'] =  str_replace( '[custom_field_value]', $option['value'], $option['label'] );

		$dropdown_options[] = $option;
	}

}else if( $compare == 'BETWEEN' ){
// within range

	if( empty( $range_options ) ){
		$range_options = array();
	}

	$input_field_name = $table_id . '_cf_' . str_replace(' ', '_', $field_name) . '_range';

	$min_input_field_name = $input_field_name . '_min';
	$max_input_field_name = $input_field_name . '_max';

	$selected_min = ! empty( $_GET[ $min_input_field_name ] ) ? $_GET[ $min_input_field_name ] : '';
	$selected_max = ! empty( $_GET[ $max_input_field_name ] ) ? $_GET[ $max_input_field_name ] : '';

	foreach( $range_options as $option ){

		if( empty( $option['min_value'] ) && empty( $option['max_value'] ) ){
			continue;
		}

		// ensure label is present and parse it
		if( ! empty( $option['label'] ) ){
			$option['label'] = wcpt_parse_2( $option['label'] );
		}else{
			$option['label'] = $option['min_value'] . ' - ' . $option['max_value'];
		}

		$placeholder = '[custom_field_value]';
		$placeholder_value = '';
		if( empty( $option['min_value'] ) ){
			$placeholder_value = $option['max_value'];
			$option['min_value'] = '';
		}else if( empty( $option['max_value'] ) ){
			$placeholder_value = $option['min_value'];
			$option['max_value'] = '';
		}else{
			$placeholder_value = $option['min_value'] . ' - ' . $option['max_value'];
		}

		if( empty( $option['label'] ) ){
			$option['label'] = $placeholder_value;
		}

		$option['label'] =  str_replace(
			array( '[min]', '[max]', $placeholder ),
			array( $option['min_value'], $option['max_value'], $placeholder_value ),
			$option['label']
		);

		$dropdown_options[] = $option;

		// get selected
		if( $selected_min == $option['min_value'] && $selected_max == $option['max_value'] ){
			$selected_range_option = $option;
		}

	}

}

if( $display_type == 'dropdown' ){
  $container_html_class = 'wcpt-dropdown wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-dropdown-label';
  $options_container_html_class = 'wcpt-dropdown-menu';
  $single_option_container_html_class = 'wcpt-dropdown-option';

  if( empty( $heading ) ){
    $heading = $field_name;
	}

}else{
  $container_html_class = 'wcpt-options-'. $display_type .' wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-options-heading';
  $options_container_html_class = 'wcpt-options';
  $single_option_container_html_class = 'wcpt-option';

  if( empty( $heading ) ){
    $heading = '';
	}
	
	if( ! empty( $heading_separate_line ) )	{
		$container_html_class .= ' wcpt-heading-separate-line ';
	}
}

// comparison operator
if( $compare == 'BETWEEN' ){
	$container_html_class .= ' wcpt-range-filter';
}

// heading row
if( ! $heading = wcpt_parse_2( $heading ) ){
	$container_html_class .= ' wcpt-no-heading wcpt-filter-open';
}

// min max 
if( $compare == 'BETWEEN' ){
	if( 
		! isset( $min ) || 
		! isset( $max ) 
	){
		$range = wcpt_get_post_meta_min_max( $field_name );

		if( ! isset( $min ) ){
			$min = $range['min'];
		}

		if( ! isset( $max ) ){
			$max = $range['max'];
		}
	}
}

// open filter accordion
if( ! empty( $_REQUEST[ $table_id . '_cf_' . str_replace(' ', '_', $field_name) ] ) ){
	$container_html_class .= ' wcpt-filter-open';
}

if( 
	$compare == 'BETWEEN' &&
	(
		(
			! empty( $_REQUEST[ $table_id . '_cf_' . str_replace(' ', '_', $field_name) . '_range_min' ] ) &&
			$_REQUEST[ $table_id . '_cf_' . str_replace(' ', '_', $field_name) . '_range_min' ] != $min
		) ||
		(
			! empty( $_REQUEST[ $table_id . '_cf_' . str_replace(' ', '_', $field_name) . '_range_max' ] ) &&
			$_REQUEST[ $table_id . '_cf_' . str_replace(' ', '_', $field_name) . '_range_max' ] != $max
		)
	)
){
	$container_html_class .= ' wcpt-filter-open';
}

if( ! empty( $accordion_always_open ) ){
	$container_html_class .= ' wcpt-filter-open';
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
	$search_placeholder_attr = ' data-wcpt-search-filter-options-placeholder="'. esc_attr( $search_placeholder ) .'" ';
}

?>
<div 
	class="<?php echo $container_html_class; ?>" 
	data-wcpt-filter="custom_field" 
	data-wcpt-heading_format__op_selected = "<?php echo $heading_format__op_selected; ?>"	
	data-wcpt-meta-key="<?php echo $field_name; ?>"
	<?php echo $search_placeholder_attr; ?>	
>

	<div class="wcpt-filter-heading">
		<!-- label -->
	  <span class="<?php echo $heading_html_class; ?>"><?php echo wcpt_parse_2( $heading );?></span>
		<!-- active count -->
	  <?php if( $compare == 'IN' && ! empty( $_GET[$input_field_name] ) && ! $single ){
		?>
	  <span class="wcpt-active-count"><?php echo count( $_GET[$input_field_name] ); ?></span>
		<?php } ?>
	  <!-- icon -->
	  <?php wcpt_icon('chevron-down'); ?>
	</div>

  <!-- options menu -->
  <div class="<?php echo $options_container_html_class; ?>">
		<?php
	    $input_field_name = $table_id . '_cf_' . str_replace(' ', '_', $field_name);

			if( $compare == 'BETWEEN' ){
				$input_field_name .= '_range';
			}

			// show all option
			if( 
				! empty( $dropdown_options ) &&
				(
					$compare == 'BETWEEN' || 
					( 
						$compare == 'IN' && 
						$single 
					) &&
					! wcpt_is_template_empty($show_all_label)	
				)
			){

				if(
					(
						empty( $_GET[ $input_field_name ] ) ||
						( 
							$_GET[$input_field_name] === array("") ||
							$_GET[$input_field_name] === "option_1"
						)
					) && 
					(
						(
							empty( $selected_min ) && 
							empty( $selected_max ) 
						) ||
						(
							isset( $selected_min ) &&
							isset( $selected_max ) &&

							$selected_min == $min &&
							$selected_max == $max
						)
					)
				){
					$checked = ' checked="checked" ';
				}else{
					$checked = '';
				}

				?>
				<label class="<?php echo $single_option_container_html_class; ?>">
					<!-- radio -->
					<input
						type="radio"
						value=""
						class="wcpt-filter-radio" <?php echo $checked; ?>
						name="<?php echo $input_field_name . ( $compare == 'IN' ? "[]" : "" ); ?>"
						data-wcpt-range-min=""
						data-wcpt-range-max=""
						<?php echo $checked; ?>
					><span><?php echo wcpt_parse_2( $show_all_label ) ?></span>
				</label>
				<?php
			}


    	if( $compare == 'IN' ){
			// exact match

			if( ! empty( $_GET[ $input_field_name ] ) ){
				if( is_array( $_GET[ $input_field_name ] ) ){
					$_GET[ $input_field_name ] = array_map( 'stripslashes', $_GET[ $input_field_name ] );
				}else{
					$_GET[ $input_field_name ] = stripslashes($_GET[ $input_field_name ]);
				}
			}

	      if( ! empty( $dropdown_options ) ){

	        foreach ( $dropdown_options as $option ) {

	          // option was selected or not?
	          if(
	            ! empty( $_GET[ $input_field_name ] ) &&
	            (
	              (
	                is_array( $_GET[ $input_field_name ] ) &&
	                in_array( strtolower( $option['value'] ), array_map( 'strtolower', $_GET[ $input_field_name ] )  )
	              ) ||
								(
									! is_array( $_GET[ $input_field_name ] ) &&
									strtolower( $_GET[ $input_field_name ] ) == strtolower( $option['value'] )
								)
	            )
	          ){

	            $selected = ' checked="checked" ';

	            // use filter in query
	            $filter_info = array(
	              'filter'        => 'custom_field',
	              'meta_key'      => $field_name,
	              'values'        => array( strtolower( $option['value'] ) ),
	              'compare'       => ! empty( $compare ) ? $compare : 'IN',
	              'clear_label'   => $field_name,
	            );

							
							// ACF clear label
							$option_value_2 = $option['value'];

							if( 
								! empty( $manager ) &&
								$manager == 'acf' &&
								! empty( $acf_field_type ) &&
								$acf_field_type = 'choice' &&
								! empty( $acf_choices )
							){
								foreach( wcpt_generate_custom_field_options_from_acf_choices($acf_choices) as $_option ){
									if( strtolower( $_option['value'] ) == strtolower( $option['value'] ) ){
										$option_value_2 = $_option['label'];
									}
								}
							}

							if( ! empty( $option['clear_label'] ) ){
								$filter_info['clear_labels_2'] = array(
									strtolower($option['value']) => $option['clear_label'],
								);
							}else if( ! empty( $clear_label_template ) ){
								$search = array(
									'[custom_field]',
									'[selected_value]'
								);
								
								$replace = array(
									$field_name,
									$option_value_2
								);

								$filter_info['clear_labels_2'] = array(
									strtolower($option['value']) => str_replace( $search, $replace, $clear_label_template ),
								);

							}else{
								$filter_info['clear_labels_2'] = array(
									strtolower($option['value']) => ucwords( $field_name ) . ' : ' . $option_value_2,
								);
							}

	            wcpt_update_user_filters( $filter_info, $single );

	          }else{
	            $selected = '';
	          }

	          ?>
	          <label class="<?php echo $single_option_container_html_class; ?>" data-wcpt-value="<?php echo esc_html( strtolower($option['value']) ); ?>">
	            <input name="<?php echo $input_field_name; ?>[]" type="<?php echo $single ? 'radio' : 'checkbox'; ?>" value="<?php echo esc_html( strtolower($option['value']) ); ?>" class="filter-checkbox" <?php echo $selected; ?>
							><span><?php echo wcpt_parse_2( $option['label'] ); ?></span>
	          </label>
	          <?php
	        }
        }

			}else if( $compare == 'BETWEEN' ){
			// within range

				$min_input_field_name = $input_field_name . '_min';
	      $max_input_field_name = $input_field_name . '_max';

	      $selected_min = ! empty( $_GET[ $min_input_field_name ] ) ? $_GET[ $min_input_field_name ] : '';
	      $selected_max = ! empty( $_GET[ $max_input_field_name ] ) ? $_GET[ $max_input_field_name ] : '';

				// use filter in query
				if( '' !== $selected_min || '' !== $selected_max ){

					if( $selected_min !== $selected_max ){
						$value = ( $selected_min ? $selected_min : 0 ) . ( $selected_max ? ' - ' . $selected_max : '+' );
					}else{
						$value = $selected_min;
					}

					if( empty( $field_type ) ){
						$field_type = '';
					}

					// if( ! empty( $range_slider_enabled ) ){
					// 	$field_type = 'DECIMAL';
					// }

					$filter_info = array(
						'filter'      => 'custom_field',
	          'meta_key'    => $field_name,
		        'values'      => array( $value ),
		        'min'     		=> $selected_min,
		        'max'     		=> $selected_max,
            'compare'     => ! empty( $compare ) ? $compare : 'IN',
		        'clear_label' => $field_name,
						// 'type'				=> $field_type,
						'type'				=> 'DECIMAL(10, 3)',
		      );

					// clear label
					if( ! empty( $selected_range_option ) && ! empty( $selected_range_option['clear_label'] ) ){
						$filter_info['clear_labels_2'] = array(
							$value => $selected_range_option['clear_label'],
						);
					}else{
						$filter_info['clear_labels_2'] = array(
							$value => ucwords( $field_name ) . ' : ' . $value,
						);

						if( empty( $selected_min ) ){
							if( empty( $no_min_clear_label ) ){
								$no_min_clear_label = '[filter] : Upto [max]';
							}
							$clear_label = $no_min_clear_label;

						}else if( empty( $selected_max ) ){
							if( empty( $no_max_clear_label ) ){
								$no_max_clear_label = '[filter] : [min]+';
							}
							$clear_label = $no_max_clear_label;

						}else{
							if( empty( $min_max_clear_label ) ){
								$min_max_clear_label = '[filter] : [min] - [max]';
							}
							$clear_label = $min_max_clear_label;

						}

						$clear_label =  str_replace(
							array( '[filter]', '[min]', '[max]' ),
							array( $field_name, $selected_min, $selected_max ),
							$clear_label
						);

						$filter_info['clear_labels_2'] = array(
							$value => $clear_label,
						);

					}

		      wcpt_update_user_filters( $filter_info, true );
				}

				if( ! empty( $dropdown_options ) ){

	        foreach ( $dropdown_options as $option_index => $option ) {

	          if( empty( $option['min_value'] ) ){
	            $option['min_value']  = '';
	          }

	          if( empty( $option['max_value'] ) ){
	            $option['max_value']  = '';
	          }

	          // option was selected or not?
	          if(
	            (float) $option['min_value'] == $selected_min &&
	            (float) $option['max_value'] == $selected_max
	          ){

	            $selected = ' checked="checked" ';

	          }else{
	            $selected = '';
	          }

	          ?>
	          <label class="<?php echo $single_option_container_html_class; ?>">
	            <!-- radio -->
	            <input
	              type="radio"
	              value="option_<?php echo $option_index; ?>"
	              class="wcpt-filter-radio" <?php echo $selected; ?>
	              name="<?php echo $input_field_name; ?>"
	              data-wcpt-range-min="<?php echo ! empty( $option['min_value'] ) ? $option['min_value'] : ''; ?>"
	              data-wcpt-range-max="<?php echo ! empty( $option['max_value'] ) ? $option['max_value'] : ''; ?>"
	            ><span><?php echo ! empty( $option['label'] ) ? $option['label'] : 'Range option'; ?></span>
	          </label>
	          <?php
	        }
	      }

				// min-max input option
				$html_maybe_hide_class = '';

				if( empty( $step ) ){
					$step = 1;
				}

				// remove unnecesarily applied range nav filter
				if(  
					isset( $_GET[ $min_input_field_name ] ) &&
					$_GET[ $min_input_field_name ] == $min &&
					isset( $_GET[ $max_input_field_name ] ) &&
					$_GET[ $max_input_field_name ] == $max
				){
					unset( $_GET[ $min_input_field_name ] );
					unset( $_GET[ $max_input_field_name ] );

					wcpt_clear_nav_filter( 'custom_field', $field_name );
				}

	      if( empty( $custom_min_max_enabled ) ){
					$html_maybe_hide_class = 'wcpt-hide';

	      }else{

					if( ! empty( $range_slider_enabled ) ){

						if( $selected_min === '' ){
							$selected_min = $min;
						}
			
						if( $selected_max === '' ){
							$selected_max = $max;
						}

					}

				}

				$actual_max = $max;				
				if( // max fix
					! empty( $min ) && 
					is_float( $min ) 
				){ 
					$max = $max + 1;
				}
				
				?>

				<div class="wcpt-range-options-main <?php echo $single_option_container_html_class . ' ' . $html_maybe_hide_class; ?>">
					<input 
						type="number" 
						class="wcpt-range-input-min" 
						name="<?php echo $min_input_field_name; ?>" 
						value="<?php echo esc_attr( $selected_min ); ?>" 
						placeholder="<?php echo ! empty( $min_label ) ? $min_label : 'Min'; ?>" 
						min="<?php echo $min; ?>" 
						max="<?php echo $max; ?>" 
						data-wcpt-actual-max="<?php echo $actual_max; ?>"  						
						step="<?php echo $step; ?>"
					>
					<span class="wcpt-range-input-separator">
						<?php echo ! empty( $to_label ) ? $to_label : 'to'; ?>
					</span>
					<input 
						type="number" 
						class="wcpt-range-input-max" 
						name="<?php echo $max_input_field_name; ?>" 
						value="<?php echo esc_attr( $selected_max ); ?>" 
						placeholder="<?php echo ! empty( $max_label ) ? $max_label : 'Max'; ?>" 
						min="<?php echo $min; ?>" 
						max="<?php echo $max; ?>" 
						data-wcpt-actual-max="<?php echo $actual_max; ?>"  
						step="<?php echo $step; ?>"
					>
					<span class="wcpt-range-submit-button">
						<?php echo ! empty( $go_label ) ? $go_label : 'GO'; ?>
					</span>

					<?php if( ! empty( $range_slider_enabled ) ): ?>
					<div class="wcpt-range-slider-wrapper">
						<input 
							type="range" 
							class="wcpt-range-slider" 
							min="<?php echo $min; ?>" 
							max="<?php echo $actual_max; ?>" 
							step="<?php echo $step; ?>" 
							value="<?php echo esc_attr( $selected_min . ',' . $selected_max ); ?>"
							data-wcpt-initial-value="<?php echo esc_attr( $selected_min . ',' . $selected_max ); ?>"
						/>
					</div>
					<?php endif; ?>
				</div>

				<?php

			}
    ?>

  </div>
</div>
