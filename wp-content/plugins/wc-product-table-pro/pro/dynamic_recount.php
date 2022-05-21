<?php
// disable if product variation table
add_filter('wcpt_shortcode_attributes', 'wcpt__dynamic_filter__remove_shortcode_attribute');
function wcpt__dynamic_filter__remove_shortcode_attribute( $atts ){
  if( ! empty( $atts['product_variations'] ) ){
    unset( $atts['dynamic_recount'] );
    unset( $atts['dynamic_hide_filters'] );
  }
  
  if( ! array_intersect( array('dynamic_recount', 'dynamic_hide_filters'), array_keys( $atts ) ) ){
    unset( $atts['dynamic_filters_lazy_load'] );
  }

  return $atts;
}

// container gets lazy load attrs
add_filter('wcpt_container_html_attributes', 'wcpt__dynamic_filter__container_html_attributes');
function wcpt__dynamic_filter__container_html_attributes($attr){
  $table_data = wcpt_get_table_data();
  if( ! empty( $table_data['query']['sc_attrs']['dynamic_filters_lazy_load'] ) ){
    ob_start();
    $key = wcpt__dynamic_filter__get_key();
    $filter_data = wcpt_session()->get( $key );    
    ?>
    data-wcpt--dynamic-filters-lazy-load--key="<?php echo wp_hash( $key ); ?>"
    data-wcpt--dynamic-filters-lazy-load--filter-options="<?php echo esc_attr( json_encode( $filter_data['options'] ) ); ?>"
    <?php
    $attr .= ob_get_clean();
  }
  return $attr;
}

// dynamic recount
add_action('wcpt_parse_attributes', 'wcpt__dynamic_filter__init', 10, 1);
function wcpt__dynamic_filter__init($attributes){
  $table_data = wcpt_get_table_data();
 
	if( 
    empty( $table_data['query']['sc_attrs'] ) ||
    ! empty( $table_data['query']['sc_attrs']['_return_query_args'] ) ||
    (
      empty( $table_data['query']['sc_attrs']['dynamic_recount'] ) && 
      empty( $table_data['query']['sc_attrs']['dynamic_hide_filters'] )
    )
	){
   	// remove filters applied by prev table
		remove_filter('wcpt_nav_filter_option', 'wcpt__dynamic_filter__gather_option');
    remove_filter('wcpt_nav_filter_option', 'wcpt__dynamic_filter__add_placeholders');
    remove_filter('wcpt_query_args', 'wcpt__dynamic_filter__cache_results', 200, 1);    
    remove_filter('wcpt_navigation', 'wcpt__dynamic_filter__modify_nav');

		return $attributes;
  }

	// add filters
  // -- get each filter option
  add_filter('wcpt_nav_filter_option', 'wcpt__dynamic_filter__gather_option', 100, 3);  
  // -- add count placeholder if not lazy load and counts are required
  if( 
    empty( $table_data['query']['sc_attrs']['dynamic_filters_lazy_load'] ) &&
    ! empty( $table_data['query']['sc_attrs']['dynamic_recount'] )
  ){
    add_filter('wcpt_nav_filter_option', 'wcpt__dynamic_filter__add_placeholders', 100, 3);
  }
  // -- cache results and count requirements in sessions var
  add_filter('wcpt_query_args', 'wcpt__dynamic_filter__cache_results', 200, 1);
  // -- modify the nav if not lazy load
  if( empty( $table_data['query']['sc_attrs']['dynamic_filters_lazy_load'] ) ){
    add_filter('wcpt_navigation', 'wcpt__dynamic_filter__modify_nav', 100, 1);
  }

	return $attributes;
}

function wcpt__dynamic_filter__get_key(){
  $table_data = wcpt_get_table_data();
  $id = $table_data['id'];
  $sc_attrs = $table_data['query']['sc_attrs'];
  $user_filters = isset( $GLOBALS['wcpt_user_filters'] ) ? $GLOBALS['wcpt_user_filters'] : '';  

  $string = $id . json_encode( $sc_attrs ) . json_encode( $user_filters );
  if( ! empty( $_GET['lang'] ) ){
    $string .= '&lang=' . $_GET['lang'];
  }

  return $string;
}

function wcpt__dynamic_filter__cache_results( $query_args ){
  $table_data = wcpt_get_table_data();
  $sc_attrs = $table_data['query']['sc_attrs'];
  $key = wcpt__dynamic_filter__get_key();
  
  if( 
    ! empty( $sc_attrs['dynamic_hide_filters'] ) &&
    ! empty( $sc_attrs['dynamic_recount'] )
  ){
    $type = 'both';
  }

  if( 
    empty( $sc_attrs['dynamic_hide_filters'] ) &&
    ! empty( $sc_attrs['dynamic_recount'] )
  ){
    $type = 'count';
  }

  if( 
    ! empty( $sc_attrs['dynamic_hide_filters'] ) &&
    empty( $sc_attrs['dynamic_recount'] )
  ){
    $type = 'hide';
  }

  $cached = wcpt_session()->get( $key );
  $fresh_options = ! empty( $GLOBALS['wcpt__dynamic_filter__options'] ) ? $GLOBALS['wcpt__dynamic_filter__options'] : array();

  if( 
    empty( $cached ) ||
    count( $cached['options'] ) < count( $fresh_options ) ||
    ! empty( $_GET['wcpt__dynamic_filter__recache'] )
  ){
    $_query_args = $query_args;
    $_query_args['posts_per_page'] = -1;
    $_query_args['fields'] = 'ids';

    $query = new WP_Query($_query_args);

    wcpt_session()->set( $key, array(
      'results' => $query->posts,
      'options' => $fresh_options,
      'type' => $type,
      'table_id' => $table_data['id'],
      'sc_attrs' => $sc_attrs,
      'query_args' => $query_args,
    ) );
  }

  return $query_args;
}

add_action( 'wc_ajax_wcpt__dynamic_filter__lazy_load', 'wcpt__dynamic_filter__lazy_load' );
function wcpt__dynamic_filter__lazy_load(){
  $filter_data = wcpt_session()->get( $_REQUEST['wcpt__dynamic_filter__key'], false, false );

  if( 
    ! is_array( $filter_data ) ||
    ! isset( $filter_data['results'] ) ||
    ! isset( $filter_data['type'] ) ||
    ! isset( $filter_data['table_id'] ) ||
    ! isset( $filter_data['sc_attrs'] ) ||
    ! isset( $filter_data['query_args'] )
  ){ 
    die();
  }

  // fix transit mangled data
  foreach(  $_REQUEST['wcpt__dynamic_filter__options'] as &$option ){
    if( $option['value'] === 'false' ){ 
      $option['value'] = false;
    }
  }

  $options = wcpt__dynamic_filter__verify_options( $_REQUEST['wcpt__dynamic_filter__options'], $filter_data['options'] );

  if( ! $options ){ // security
    die(); // attempting to access nav options that weren't available to frontend
  }

  wcpt__dynamic_filter__add_count( $_REQUEST['wcpt__dynamic_filter__options'], $filter_data['results'], $filter_data['type'], $filter_data['table_id'], $filter_data['sc_attrs'], $filter_data['query_args'] );

  // add style and script if hiding empty filter options
  // if( in_array( $filter_data['type'], array( 'both', 'hide' ) ) ){
    $combined = wcpt__dynamic_filter__get_script_and_style( $_REQUEST['wcpt__dynamic_filter__options'], $filter_data['table_id'], $filter_data['type'] );
  // }

  echo json_encode(array(
    'options' => $_REQUEST['wcpt__dynamic_filter__options'],
    'style' => $combined['style'],
    'script' => $combined['script'],
  ));

  die();
}

// verify options
function wcpt__dynamic_filter__verify_options( $dubious, $original ){
  if( 
    gettype( $dubious ) !== 'array' ||
    ! count( $dubious )
  ){
    return false;
  }

  $result = true;  

  $cause = ''; // debug

  foreach( $dubious as $dubious_option ){
    $found = false;

    foreach( $original as $original_option ){
      if( 
        $dubious_option['filter'] == $original_option['filter'] &&
        $dubious_option['value'] == $original_option['value'] &&
        (
          (
            empty( $dubious_option['taxonomy'] ) &&
            empty( $original_option['taxonomy'] )
          ) ||
          $dubious_option['taxonomy'] == $original_option['taxonomy']
        )
      ){
        $found = true;
        break;
      }

      // debug
      if( $dubious_option['filter'] != $original_option['filter'] ){
        $cause .= ' "filter" ';
      }

      if( $dubious_option['value'] != $original_option['value'] ){
        $cause .= ' "value" ';
      }

      if( $dubious_option['taxonomy'] != $original_option['taxonomy'] ){
        $cause .= ' "taxonomy" ';
      }
    }    

    if( ! $found ){
      $result = false;
      break;
    }
  }

  return $result;
}

// gather option
function wcpt__dynamic_filter__gather_option( $option, $filter, $params= null ){
  if( empty( $GLOBALS['wcpt__dynamic_filter__options'] ) ){
    $GLOBALS['wcpt__dynamic_filter__options'] = array();
  }

  $value = gettype($option) === 'object' ? $option->value : $option['value'];
  $placeholder = '%%' . $value . '%%';

  // replace non-unique values 
  if( $filter === 'availability' ){
    $placeholder = '%%_availability_%%'; // real value was (bool) true
  }
  if( $filter === 'on_sale' ){
    $placeholder = '%%_on_sale_%%'; // real value was 'NO IN'
  }  

  $GLOBALS['wcpt__dynamic_filter__options'][] = array(
    'filter' 	    => $filter,
    'value'		    => $value,
    'taxonomy'    => ! empty( $params ) && ! empty( $params['taxonomy'] ) ? $params['taxonomy'] : null,
    'placeholder' => $placeholder,
  );

  if( gettype( $option ) == 'array' ){
    $option[ 'placeholder' ] = $placeholder;
  }else if( gettype( $option ) == 'object' ){
    $option->placeholder = $placeholder;
  }

  return $option;
}

// add placeholder
function wcpt__dynamic_filter__add_placeholders( $option, $filter, $params= null ){

  $table_data = wcpt_get_table_data();

  if( gettype( $option ) == 'array' ){
    $option['label'] .= $option[ 'placeholder' ];
  }else if( gettype( $option ) == 'object' ){
    $option->label .= $option->placeholder;
  }

  return $option;
}

// get styles
function wcpt__dynamic_filter__get_script_and_style( $options, $table_id, $type ){

  $hide_selectors = array();

  $taxonomies = array();
  $keep_taxonomy = array();
  $hide_taxonomies = array();

  $availability_exists = false; 
  $on_sale_exists = false; 

  $keep_availability = false;
  $keep_on_sale = false;

  foreach( $options as $option ){

    // record existing filter taxononomy / type

    // -- taxonomy
    if( ! empty( $option['taxonomy'] ) && 
      ! in_array( $option['taxonomy'], $taxonomies ) 
    ){
      $taxonomies[] = $option['taxonomy'];
    }

    // -- availability
    if( $option['filter'] == 'availability' ){
      $availability_exists = true;
    }

    // -- on sale
    if( $option['filter'] == 'on_sale' ){
      $on_sale_exists = true;
    }
    
    // hide option
    if( ! $option['count'] ){
      $hide_selectors[] = ' [data-wcpt-filter="'. $option['filter'] .'"].wcpt-filter [data-wcpt-value="'. $option['value'] .'"]'; 

    // spare entire filter if an option has count
    }else{

      // -- taxonomies
      if( ! in_array( $option['taxonomy'], $keep_taxonomy ) ){
        $keep_taxonomy[] = $option['taxonomy'];      
      }

      // -- availability
      if( $option['filter'] === 'availability' ){
        $keep_availability = true;
      }
      
      // -- on sale      
      if( $option['filter'] === 'on_sale' ){
        $keep_on_sale = true;
      }

    }

  }

  // hide entire filters

  // -- taxonomy
  $hide_taxonomies = array_diff( $taxonomies, $keep_taxonomy );
  foreach( $hide_taxonomies as $taxonomy ){
    $hide_selectors[] = ' .wcpt-filter[data-wcpt-taxonomy="' . $taxonomy . '"] ';
  }

  // -- availability
  if( 
    $availability_exists &&
    ! $keep_availability 
  ){
    $hide_selectors[] = ' .wcpt-filter[data-wcpt-filter="availability"] ';    
  }

  // -- on sale
  if( 
    $on_sale_exists &&
    ! $keep_on_sale 
  ){
    $hide_selectors[] = ' .wcpt-filter[data-wcpt-filter="on_sale"] ';    
  }  

  $style = '';
  $script = '';

  if( count( $hide_selectors ) ){
    $hide_selectors = '.wcpt-' . $table_id . ' ' . implode( ', .wcpt-' . $table_id . ' ', $hide_selectors ) . ',  [data-wcpt-table-id="' . $table_id . '"].wcpt-nav-modal ' . implode( ', [data-wcpt-table-id="' . $table_id . '"].wcpt-nav-modal ', $hide_selectors );

    if( in_array( $type, array( 'both', 'hide' ) ) ){    
      $style = '<style id="'. wp_hash( wcpt__dynamic_filter__get_key() ) .'"> '. $hide_selectors .'{ display: none !important; } </style>';
    }

    $script= '<script id="'. wp_hash( wcpt__dynamic_filter__get_key() ) .'">jQuery(function($){ $(\''. $hide_selectors .'\').addClass("wcpt-disabled-by-dynamic-filter").children("input").prop({"checked": false, "disabled": true}); })</script>';
  }

  return array( 
    'style'=> $style, 
    'script'=> $script 
  );
}

// replace placeholders
function wcpt__dynamic_filter__replace_placeholders( &$nav_markup, $options ){
  foreach( $options as $option ){
    $nav_markup = str_replace( $option['placeholder'], ' <span class="wcpt-count" style="color: #999;">('. $option['count'].')</span>', $nav_markup );
  }

}

// modify the nav
function wcpt__dynamic_filter__modify_nav( $nav_markup ){
  $filter_data = wcpt_session()->get( wcpt__dynamic_filter__get_key() );
  
  if( empty( $filter_data['options'] ) ){
    return $nav_markup;
  }

  wcpt__dynamic_filter__add_count( $filter_data['options'], $filter_data['results'], $filter_data['type'], $filter_data['table_id'], $filter_data['sc_attrs'], $filter_data['query_args'] );

  // replace placeholders if recounting filter options
  if( in_array( $filter_data['type'], array( 'both', 'count' ) ) ){
    wcpt__dynamic_filter__replace_placeholders( $nav_markup, $filter_data['options'] );
  }

  // add styles if hiding empty filter options
  // if( in_array( $filter_data['type'], array( 'both', 'hide' ) ) ){
    $combined = wcpt__dynamic_filter__get_script_and_style( $filter_data['options'], $filter_data['table_id'], $filter_data['type'] );
    $nav_markup = $combined['style'] . $combined['script'] . $nav_markup;
  // }  

  return $nav_markup;
}

// supplement the options data with potential result count for each
function wcpt__dynamic_filter__add_count( &$options, $results, $type, $table_id, $sc_attrs, $query_args ){

  $query_args['posts_per_page'] = -1;
  $query_args['fields'] = 'ids';  

  $attribute_relation__or = false;
  if(
    ! empty( $sc_attrs['attribute_relation'] ) && 
    strtoupper( $sc_attrs['attribute_relation'] ) === 'OR' &&
    ! empty( $query_args['tax_query']['wcpt_attributes__or'] )
  ){
    $attribute_relation__or = true;
  }

  // max result count
  if( $type !== array('hide') ){
    $max_count = 200;    
  }else{
    $max_count = 1;
  }

  $post_ids = $results;

  $attribute_taxonomies = array();
  if( ! empty( $query_args['tax_query'] ) ){

    if( $attribute_relation__or ){
      foreach( $query_args['tax_query']['wcpt_attributes__or'] as $arr ){
        if( is_array( $arr ) && ! empty( $arr['taxonomy'] ) ){
          $attribute_taxonomies[] = $arr['taxonomy'];
        }
      }
    }else{
      foreach( $query_args['tax_query'] as $arr ){
        if( is_array( $arr ) && ! empty( $arr['taxonomy'] ) ){
          $attribute_taxonomies[] = $arr['taxonomy'];
        }
      }
    }
  }

  $category_filtering = false;
  if( ! empty( $query_args['tax_query'] ) ){
    foreach( $query_args['tax_query'] as $arr ){
      if(
        is_array( $arr ) && 
        ! empty( $arr['taxonomy'] ) &&
        $arr['taxonomy'] == 'product_cat'
      ){
        $category_filtering = true;
        break;
      }
    }
  }

  foreach( $options as &$option ){

    // attribute
    if( $option['filter'] == 'attribute' ){

      if( $attribute_relation__or ){
        $_query_args = $query_args;
        unset( $_query_args['tax_query']['wcpt_attributes__or'] );
        $_query_args['tax_query'][] = array(
          'taxonomy' => $option['taxonomy'],
          'field'    => 'term_taxonomy_id',
          'terms'    => $option['value'],
        );
        $query = new WP_Query( $_query_args );
        $_count = $query->post_count;

      }else{

        // attr not in use 
        if( ! in_array( $option['taxonomy'], $attribute_taxonomies ) ){
          $_post_ids = $post_ids;
          
          // attr in use
        }else{

          if( empty( $sans_taxonomy ) ){ // taxonomy_1 => post ids without any taxonomy_1 term selected
            $sans_taxonomy = array();
          }

          if( empty( $sans_taxonomy[ $option['taxonomy'] ] ) ){

            // re-build tax_query without this taxonomy            
            $_query_args = $query_args;
            $_tax_query = array();

            foreach( $_query_args['tax_query'] as $key => $val ){
              if( $key === 'relation' ){
                $_tax_query['relation'] = $val;                
              }else if( $val['taxonomy'] !== $option['taxonomy'] ){
                $_tax_query[] = $val;
              }
            }

            $_tax_query['relation'] = 'AND';
            $_query_args['tax_query'] = $_tax_query;

            // get results for original query but without this taxonomy 
            $query = new WP_Query( $_query_args );
            $sans_taxonomy[ $option['taxonomy'] ] = $query->posts;
          }

          $_post_ids = $sans_taxonomy[ $option['taxonomy'] ];

        }

        // how many products from the original result coincide with this term?
        if( count( $_post_ids ) ){
          global $wpdb;
          $query = "
            SELECT DISTINCT object_id 
            FROM $wpdb->term_relationships
            WHERE object_id IN (". implode( ', ', $_post_ids ) .") AND
            term_taxonomy_id = {$option['value']}
            LIMIT ". ($max_count + 1);
  
          $_count = count( $wpdb->get_col( $query ) );          
  
        }else{
          $_count = 0;
        }

      }

      // does this filter option have a count?
      $count = $_count > $max_count ? $max_count . '+' : $_count;

    // taxonomy
    }else if( $option['filter'] == 'taxonomy' ){

      // taxonomy not in use 
      if( ! in_array( $option['taxonomy'], $attribute_taxonomies ) ){
        $_post_ids = $post_ids;

      // taxonomy in use
      }else{

        if( empty( $sans_taxonomy ) ){ // taxonomy_1 => post ids without any taxonomy_1 term selected
          $sans_taxonomy = array();
        }

        if( empty( $sans_taxonomy[ $option['taxonomy'] ] ) ){

          // re-build tax_query without this taxonomy            
          $_query_args = $query_args;
          $_tax_query = array();

          foreach( $_query_args['tax_query'] as $key => $val ){
            if( $key === 'relation' ){
              $_tax_query['relation'] = $val;                
            }else if( $val['taxonomy'] !== $option['taxonomy'] ){
              $_tax_query[] = $val;
            }
          }

          $_tax_query['relation'] = 'AND';
          $_query_args['tax_query'] = $_tax_query;

          // get results for original query but without this taxonomy 
          $query = new WP_Query( $_query_args );
          $sans_taxonomy[ $option['taxonomy'] ] = $query->posts;
        }

        $_post_ids = $sans_taxonomy[ $option['taxonomy'] ];
      }

      // how many products from the original result coincide with this term?
      if( count( $_post_ids ) ){
        global $wpdb;
        $query = "
          SELECT DISTINCT object_id 
          FROM $wpdb->term_relationships
          WHERE object_id IN (". implode( ', ', $_post_ids ) .") AND
          term_taxonomy_id = {$option['value']}
          LIMIT ". ($max_count + 1);

        $_count = count( $wpdb->get_col( $query ) );          

      }else{
        $_count = 0;
      }

      // does this filter option have a count?
      $count = $_count > $max_count ? $max_count . '+' : $_count;

    // category
    }else if( $option['filter'] == 'category' ){

      // cat not in use 
      if( ! $category_filtering ){
        $_post_ids = $post_ids ? $post_ids : array(0);

      // cat in use 
      }else{

        // $sans_category stores results without category filter applied
        if( empty( $sans_category ) ){
          $_query_args = $query_args;
          $_tax_query = array();              

          // for each taxonomy ... 
          foreach( $_query_args['tax_query'] as $key => $val ){
            // ... keep relation and 
            if( $key === 'relation' ){
              $_tax_query['relation'] = $val;
              
            // .... all taxonomies except current taxonomy              
            }else if( $val['taxonomy'] !== $option['taxonomy'] ){
              $_tax_query[] = $val;
            }
          }

          $_query_args['tax_query'] = $_tax_query;

          $query = new WP_Query( $_query_args );
          $sans_category = $query->posts;
        }

        $_post_ids = $sans_category;

      }

      // check term and child terms against current post ids
      global $wpdb;
      $query = "
        SELECT term_id 
        FROM $wpdb->term_taxonomy
        WHERE term_taxonomy_id = ". (int) $option['value'] ."
        LIMIT 1 ";

      $term_id = $wpdb->get_var( $query );

      $term_ids = array( $term_id );

      if( $children = get_term_children( $term_id, $option['taxonomy'] ) ){
        $term_ids = array_merge( $children, $term_ids );
      }

      global $wpdb;
      $query = "
        SELECT term_taxonomy_id 
        FROM $wpdb->term_taxonomy
        WHERE term_id IN (". implode( ', ', $term_ids ) .")";

      $term_taxonomy_ids = $wpdb->get_col( $query );

      if( 
        count( $_post_ids ) &&
        count( $term_taxonomy_ids )
      ){
        global $wpdb;
        $query = "
          SELECT DISTINCT object_id 
          FROM $wpdb->term_relationships
          WHERE object_id IN (". implode( ', ', $_post_ids ) .") AND
          term_taxonomy_id IN (" . implode( ', ', $term_taxonomy_ids ) . ")
          LIMIT ". ($max_count + 1);
  
        $_count = count( $wpdb->get_col( $query ) );

      }else{
        $_count = 0;
      }

      // does this filter option have a count?
      $count = $_count > $max_count ? $max_count . '+' : $_count;

    // on sale
    } else if( $option['filter'] == 'on_sale' ){

      // does this filter option have a count?
      $count = count( array_intersect( wc_get_product_ids_on_sale(), $post_ids ) );

    // availability
    } else if( $option['filter'] == 'availability' ){

      $product_visibility_terms  = wc_get_product_visibility_term_ids();

      if( count( $post_ids ) ){
        $query = new WP_Query( array(
          'post_type' => 'product',
          'posts_per_page' => ($max_count + 1),
          'post__in' => $post_ids,
          'fields' => 'ids',
          'tax_query' => array(
            array(
              'taxonomy' 	=> 'product_visibility',
              'field'    => 'term_taxonomy_id',
              'terms'			=> array( $product_visibility_terms['outofstock'] ),
              'operator'	=> $option['value'],
            ),
          ),
        ) );

        // does this filter option have a count?
        $count = $query->post_count > $max_count ? $max_count . '+' : $query->post_count;

      }else{
        $count = 0;

      }

    }

    $option['count'] = $count;
  }
  unset( $option );

  return $options;
}