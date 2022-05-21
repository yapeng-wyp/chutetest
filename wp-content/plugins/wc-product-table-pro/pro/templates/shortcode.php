<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( empty( $shortcode ) ){
	return;
}

$shortcode = wcpt_general_placeholders__parse( $shortcode, 'shortcode' ); 

if( $markup = do_shortcode( $shortcode ) ){
	echo '<div class="wcpt-shortcode '. $html_class .'">'.  do_shortcode( $shortcode ) .'</div>';
}

