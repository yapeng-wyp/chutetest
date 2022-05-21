<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$table_id = $GLOBALS['wcpt_table_data']['id'];

$input_field_name = $table_id . '_rating';

// pre-selected
if( $pre_selected = wcpt_get_nav_filter( 'rating' ) ){
	if( empty( $_GET[$table_id . '_filtered'] ) ){
		// apply
		$_GET[$input_field_name] = $_REQUEST[$input_field_name] = $pre_selected['values'];
	}else{
		// remove
		wcpt_clear_nav_filter( 'rating' );
	}
}

// $dropdown_options will be used for priting on front end
$dropdown_options =& $rating_options;

if(
	empty( $display_type ) ||
	( ! empty( $position ) && $position === 'left_sidebar' )
){
  $display_type = 'dropdown';
}

$single = true;

if( $display_type == 'dropdown' ){
  $container_html_class = 'wcpt-dropdown wcpt-filter ' . $html_class;
  $heading_html_class = 'wcpt-dropdown-label';
  $options_container_html_class = 'wcpt-dropdown-menu';
  $single_option_container_html_class = 'wcpt-dropdown-option';

  if( empty( $heading ) ){
    $heading = __('Rating', 'wc-product-filter');
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

// heading format when option is selected 
if( empty( $heading_format__op_selected ) ){
	$heading_format__op_selected = 'only_heading';
}
?>
<div 
	class="<?php echo $container_html_class; ?>" 
	data-wcpt-filter="rating"
	data-wcpt-heading_format__op_selected = "<?php echo $heading_format__op_selected; ?>"	
>

	<div class="wcpt-filter-heading">
	  <!-- label -->
	  <span class="<?php echo $heading_html_class; ?>"><?php echo $heading; ?></span>

		<!-- active count -->
		<!--
	  <?php if( ! empty( $_GET[$input_field_name] ) ){
		?>
	  <span class="wcpt-active-count"><?php echo count( $_GET[$input_field_name] ); ?></span>
		<?php } ?>
		-->

	  <!-- icon -->
	  <?php wcpt_icon('chevron-down'); ?>
	</div>

  <!-- options menu -->
  <div class="<?php echo $options_container_html_class; ?>">
    <?php
      if( ! empty( $dropdown_options ) ){

				// "Show all" option
				if( $single ){
					if(
						empty( $_GET[$input_field_name] ) ||
						! count( $_GET[$input_field_name] ) ||
						( count( $_GET[$input_field_name] ) == 1 && ! $_GET[$input_field_name][0] )
					){
						$checked = true;
					}else{
						$checked = false;
					}

					if( empty( $show_all_label ) ){
						$show_all_label = __( 'Show all', 'wc-product-table' );
					}

					?>
					<label class="wcpt-show-all-option <?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>" data-wcpt-value="">
						<input type="radio" value="" class="wcpt-filter-radio" <?php echo $checked ? ' checked="checked" ' : ''; ?> name="<?php echo $input_field_name; ?>[]"><?php echo wcpt_parse_2($show_all_label); ?>
					</label>
					<?php
				}

        foreach ( $dropdown_options as $option ) {
					if( empty( $option['enabled'] ) ){
						continue;
					}

          // option was selected or not?
          if(
            ! empty( $_GET[ $input_field_name ] ) &&
						in_array( (int) $option['value'], $_GET[ $input_field_name ] )
          ){

            $checked = true;

            // use filter in query
            $filter_info = array(
              'filter'      => 'rating',
              'values'      => array( $option['value'] ),
              'clear_label' => ! empty( $option['clear_label'] ) ? $option['clear_label'] : $option['value'],
							'clear_labels_2' => array( $option['value']=> __( 'Rating : '. $option['value'], 'wc-product-table' ) ),
            );

						if( ! empty( $option['clear_label'] ) ){
							$filter_info['clear_labels_2'] = array( $option['value']=> $filter_info['clear_label'] );
						}else{
							$filter_info['clear_labels_2'] = array( $option['value']=> __( 'Rating', 'woocommerce' ) . ' : ' . $option['value'] );
						}

            wcpt_update_user_filters( $filter_info, $single );

          }else{
            $checked = false;
          }

          ?>
          <label
						class="<?php echo $single_option_container_html_class; ?> <?php echo $checked ? 'wcpt-active' : ''; ?>"
						data-wcpt-value="<?php echo $option['value']; ?>"
					>
            <input
							type="<?php echo $single ? 'radio' : 'checkbox'; ?>"
							value="<?php echo $option['value']; ?>"
							class="wcpt-filter-radio" <?php echo $checked ? ' checked="checked" ' : ''; ?>
							name="<?php echo $input_field_name; ?>[]"
							data-wcpt-clear-filter-label="<?php echo esc_attr( $option['value'] . ' stars' ); ?>"
						><?php

							$rating_number = (int) $option['value'];

							$full_stars  = floor( $rating_number );

							$dec = $rating_number - $full_stars;

							if( $dec < .25 ){
								$half_stars = 0;

							}else if( $dec > .75 ){
								$half_stars = 0;
								++$full_stars;

							}else{
								$half_stars = 1;

							}

							$empty_stars = 5 - $full_stars - $half_stars;

							ob_start();
							foreach ( array( $full_stars, $half_stars, $empty_stars ) as $key => $star_type ) {
							    while ($star_type) {
						        if ($key === 0) {
											?><i class="wcpt-star wcpt-star-full">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FFC107"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
											</i><?php
						        } else if ($key === 1) {
											?><i class="wcpt-star wcpt-star-half">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FFC107"><polygon points="12 2 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#aaa"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77"></polygon></svg>
											</i><?php
						        } else {
											?><i class="wcpt-star wcpt-star-empty">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FFC107"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
											</i><?php
						        }

						        --$star_type;
							    }
							}
							$rating_stars = ob_get_clean();

							echo '<span><span class="wcpt-rating-stars">' . $rating_stars . '</span> ' . $option['label'] . '</span>';
						?>
          </label>
          <?php
        }

      }
    ?>
  </div>
</div>
