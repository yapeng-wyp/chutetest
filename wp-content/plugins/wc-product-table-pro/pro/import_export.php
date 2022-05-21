<?php
add_action( 'admin_notices', 'wcpt_handle_import_export_errors' );
function wcpt_handle_import_export_errors() {
  if( empty( $GLOBALS['wcpt_import_export_error'] ) ){
    if( ! empty( $_REQUEST['wcpt_import_export_nonce'] ) ){
      ?>
      <div class="notice notice-success">
        <p><strong>WCPT:</strong> Uploaded data was imported successfully!</p>
      </div>
      <?php      
    }

    return;
  }
  ?>
  <div class="notice notice-error">
    <p><strong>WCPT Error:</strong> Import failed! <?php echo $GLOBALS['wcpt_import_export_error']; ?></p>
  </div>
  <?php
}

add_action('admin_init', 'wcpt_handle_import_export');
function wcpt_handle_import_export(){
  if(
    empty( $_POST['wcpt_import_export_nonce'] ) ||
    ! wp_verify_nonce( $_POST['wcpt_import_export_nonce'], 'wcpt_import_export' ) ||    
    empty( $_POST['wcpt_context'] ) ||
    empty( $_POST['wcpt_action'] )
  ){
    return;
  }

  $errors = array();
  
  // export
  if( $_POST['wcpt_action'] === 'export' ){

    // export tables
    if( $_POST['wcpt_context'] === 'tables' ){
      $filename= 'wcpt_tables.json';
      $data = array(
        'context' => 'tables'
      );

      $args = array(
        'posts_per_page' => -1,
        'post_type' => 'wc_product_table',
        'post_status' => 'publish',
      );

      if( ! empty( $_REQUEST['wcpt_export_id'] ) ){
        $args['post__in'] = array_map( 'intval', explode(',', $_REQUEST['wcpt_export_id']) );
      }

      $query = new WP_Query($args);

      if( $query->have_posts() ){
        while( $query->have_posts() ){
          $query->the_post();

          $id = get_the_id();
          $table_settings = wcpt_get_table_data($id);
          $table_settings['title'] = get_the_title();
          if( ! empty( $table_settings['query']['category'] ) ){
            // note slugs to help locate them during import
            $table_settings['query']['category_export'] = array();
            foreach( $table_settings['query']['category'] as $category_id ){
              $term = get_term( $category_id, 'product_cat' );
              $table_settings['query']['category_export'][] = $term->slug;
            }
          }
          $data[] = $table_settings;
        }
      }

    // export settings
    }else{
      $filename= 'wcpt_settings.json';
      $data = wcpt_get_settings_data();

      // remove license key
      if( 
        ! empty( $data['pro_license'] ) &&
        ! empty( $data['pro_license']['key'] )
      ){
        $data['pro_license']['key'] = '';
      }

      // note each table's slug, to use it during import as IDs will be useless
      if( ! empty( $data['archive_override'] ) ){
        wcpt_export_helper__replace_table_ids( $data['archive_override'] );
      }

      $data['context'] = 'settings';
    }

    $data['version'] = WCPT_VERSION;

    $content = json_encode($data);

    $handle = fopen($filename, 'w');
    fwrite($handle, $content);
    fclose($handle);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    ignore_user_abort(true);
    unlink($filename);

    exit;

  // import
  }else{

    if (
      empty( $_FILES['wcpt_import_file'] ) ||
      $_FILES['wcpt_import_file']['error'] !== UPLOAD_ERR_OK ||
      ! is_uploaded_file( $_FILES['wcpt_import_file']['tmp_name'] )
    ){
      $GLOBALS['wcpt_import_export_error'] = 'Please upload the import file using the import form.';
      return;
    }

    $content = trim( file_get_contents( $_FILES['wcpt_import_file']['tmp_name'] ) );

    if( ! $content ){
      $GLOBALS['wcpt_import_export_error'] = 'The import file was empty.';
      return;
    }

    $data = json_decode( $content, true );

    if( json_last_error() !== JSON_ERROR_NONE ){
      $GLOBALS['wcpt_import_export_error'] = 'The import file is corrupted.';
      return;
    }

    if( version_compare( WCPT_VERSION, $data['version'] ) == -1 ){
      $GLOBALS['wcpt_import_export_error'] = 'You are trying to import from WCPT PRO version '. $data['version'] .' to version '. WCPT_VERSION .'. This is not allowed because importing from a future version of the plugin can lead to malfunction. Please update WCPT PRO on this site to at least '. $data['version'] .' in order to import this data.';
      return;
    }

    // import tables
    if( $_POST['wcpt_context'] === 'tables' ){

      unset( $data['version'] );

      if( $data['context'] !== 'tables' ){
        $GLOBALS['wcpt_import_export_error'] = 'Import failed! You are using the wrong file to import table data here. You need to use the "wcpt_tables.json" file to import tables here. Instead you are using the "wcpt_settings.json" file which is meant to import the plugin\'s overall settings. Please use the correct file and try again.';
        return;
      }else{
        unset( $data['context'] );
      }
      
      foreach( $data as $table_settings ){
        $id = wp_insert_post(array(
          'post_title'  => wp_strip_all_tags( ! empty( $table_settings['title'] ) ? $table_settings['title'] : '' ),
          'post_status' => 'publish',
          'post_type'   => 'wc_product_table',
        ));

        if( ! empty( $table_settings['query']['category_export'] ) ){
          $table_settings['query']['category'] = array();
          foreach( $table_settings['query']['category_export'] as $cat_slug ){
            if( $term = get_term_by('slug', $cat_slug, 'product_cat') ){
              $table_settings['query']['category'][] = (int) $term->term_taxonomy_id;
            }
          }
        }
        
        if( $id && ! is_wp_error($id) ){
          update_post_meta( $id, 'wcpt_data', addslashes( json_encode($table_settings) ) );
        }
      }

    // import settings
    }else{
      if( $data['context'] !== 'settings' ){
        $GLOBALS['wcpt_import_export_error'] = 'Import failed! You are using the wrong file to import plugin settings here. You need to use the "wcpt_settings.json" file to import the overall settings here. Instead you are using the "wcpt_tables.json" file which is meant to import the tables. Please use the correct file and try again.';
        return;
      }else{
        unset( $data['context'] );
      }

      // license key persistence
      // -- get current key
      $license_key = '';
      $current_settings = wcpt_get_settings_data();
      if( 
        ! empty( $current_settings['pro_license'] ) &&
        ! empty( $current_settings['pro_license']['key'] ) 
      ){
        $license_key = $current_settings['pro_license']['key'];
      }

      // -- set key on new data
      if( empty( $data['pro_license'] ) ){
        $data['pro_license'] = array();
      }
      $data['pro_license']['key'] = $license_key;

      // use the table slugs to discover IDs
      if( ! empty( $data['archive_override'] ) ){
        wcpt_import_helper__replace_table_slugs( $data['archive_override'] );
      }

      $content = addslashes( json_encode( $data ) );
      update_option( 'wcpt_settings', apply_filters( 'wcpt_global_settings', $content ) );

    }

  }

}

// recursively iterate over settings and replace table IDs with slugs in _export keys
function wcpt_export_helper__replace_table_ids( &$arr ){
  $remove = array();
  foreach( $arr as $key => &$val ){
    if( 
      in_array( $key, array( 'default', 'table_id', 'search', 'shop' ) ) &&
      is_numeric( $val )
    ){
      $post = get_post( (int) $val ); 
      $arr[$key . '_export'] = $post->post_name;

      $remove[] = $key;

    }else if( gettype($val) == 'array' ){
      wcpt_export_helper__replace_table_ids( $val );
    }
  }

  foreach( $remove as $remove_key ){
    unset( $arr[ $remove_key ] );
  }
}

// recursively iterate over settings and replace table slugs in _export keys with IDs
function wcpt_import_helper__replace_table_slugs( &$arr ){
  $remove = array();
  foreach( $arr as $key => &$val ){
    if( substr( $key, -7 ) === '_export' ){
      if ( $post = get_page_by_path( $val, OBJECT, 'wc_product_table' ) ){
        $arr[substr( $key, 0, -7 )] = $post->ID;
      }
      $remove[] = $key;

    }else if( gettype($val) == 'array' ){
      wcpt_import_helper__replace_table_slugs( $val );
    }
  }

  foreach( $remove as $remove_key ){
    unset( $arr[ $remove_key ] );
  }
}