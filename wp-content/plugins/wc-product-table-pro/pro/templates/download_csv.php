<?php
  $file_name = empty( $file_name ) ? 'products' : rtrim( $file_name, '.csv' );
  $include_all_products = empty( $include_all_products ) ? '' : 'true';

  $GLOBALS['wcpt_csv_json_js_var_name'] = 'wcpt_csv_json_' . rand();
  $GLOBALS['wcpt_csv_headings_js_var_name'] = 'wcpt_csv_headings_' . rand();
  $GLOBALS['wcpt_csv_session_key'] = 'wcpt_csv_' . rand();
  $GLOBALS['wcpt_csv_columns'] = $columns;
  $GLOBALS['wcpt_csv_file_name'] = $file_name;

  if( empty( $label ) ){
    $label = 'CSV Download';

  }else{
    $label = wcpt_parse_2( $label );

  }

?>
<div 
  class="wcpt-csv-download <?php echo $html_class; ?>"
  data-wcpt-json-js-var-name="<?php echo $GLOBALS['wcpt_csv_json_js_var_name']; ?>"
  data-wcpt-headings-js-var-name="<?php echo $GLOBALS['wcpt_csv_headings_js_var_name']; ?>"
  data-wcpt-csv-session-key="<?php echo $GLOBALS['wcpt_csv_session_key']; ?>"
  data-wcpt-csv-include-all-products="<?php echo $include_all_products; ?>"
  data-wcpt-file-name="<?php echo $file_name; ?>"
><?php echo $label; ?></div>
