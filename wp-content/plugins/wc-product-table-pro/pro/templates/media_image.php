<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! empty( $use_external_source ) && ! empty( $external_source ) ){
	echo '<div class="wcpt-external-image-wrapper '. $html_class .'"><img class="wcpt-external-image" src="'. $external_source .'" /></div>';
	return;
}

// prepare params
if( empty( $media_id ) ){
	$media_id = $id;
}

if( empty( $size )  ){
  $size = 'thumbnail';
}

$attributes = array();

$img = wp_get_attachment_image( $media_id, $size, false, $attributes );

if( ! empty( $label ) ){
	$label = '<br><span class="wcpt-image-label">'. $label .'</span>';
}else{
	$label = '';
}

if( ! empty( $style ) && ! empty( $style['[id]'] ) && ! empty( $style['[id]']['width'] ) ){
	$html_class .= ' wcpt-excuse-max-width ';
}

if( ! empty( $img ) ){
	echo '<div class="wcpt-media-image-wrapper '. $html_class .'">'. $img . $label . '</div>';
}
