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

if( 
	$img && 
	! empty( $html_title_source ) 
){
	$html_title = '';
	switch ( $html_title_source ) {
		case 'custom_field':
			if( ! empty( $custom_field_html_title ) ){
				$html_title = get_post_meta( $product->get_id(), $custom_field_html_title, true );
			}
			break;
		
		case 'media_library':
			$html_title = get_the_title( $media_id );
			break;

		case 'custom':
			if( ! empty( $custom_html_title ) ){
				$html_title = esc_attr($custom_html_title);
			}
			break;	

		default:
			break;
	}

	if( $html_title ){
		$img = str_replace( '<img', '<img title="' . $html_title . '" ', $img );
	}
}

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
