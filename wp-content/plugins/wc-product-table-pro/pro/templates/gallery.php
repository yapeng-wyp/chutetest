<?php	
$html_class .= ' wcpt-gallery ';

if( empty( $max_images ) ){
	$max_images = 3;
}

if( empty( $image_width ) ){
	$image_width = 40;
}	

if( empty( $see_more_label ) ){
	$see_more_label = '+{n} more';
}	

if( empty( $include_featured ) ){
	$include_featured = false;
}	else {
	$html_class .= ' wcpt-gallery--include-featured ';	
}

// photoswipe options
$pswp_ops = esc_attr( json_encode(apply_filters(
	'woocommerce_single_product_photoswipe_options',
	array(
		'shareEl'               => false,
		'closeOnScroll'         => false,
		'history'               => false,
		'hideAnimationDuration' => 0,
		'showAnimationDuration' => 0,
	)
)));

// gallery items
$items = array();
$full_size = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
$images = array();

if( $featured_image_id = get_post_thumbnail_id( $product->get_id() ) ){
	$images[] = $featured_image_id;
}

$gallery_image_ids = $product->get_gallery_image_ids();
if( 
	! $gallery_image_ids &&
	! $include_featured
){
	return; // no gallery
}else{
	$images = array_merge( $images, $gallery_image_ids );
}

foreach( $images as $attachment_id ){
	$full_src = wp_get_attachment_image_src( $attachment_id, $full_size );
	$items[] = array(
		'src' 	=> $full_src[0],
		'w'   	=> $full_src[1],
		'h'   	=> $full_src[2],
		'title' => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true )
	);
}
$pswp_items = esc_attr( json_encode($items) );

$max_images = (int) $max_images;
if( ! $max_images ){
	$max_images = $_max_images;
}

$image_width = (int) $image_width;
if( 
	! $image_width ||
	$image_width == 40
){
	$image_width = false;
}

if( ! empty( $offset_zoom_enabled ) ){
	$html_class .= ' wcpt-gallery--offset-zoom-enabled ';
}

?>
<div 
	class="<?php echo $html_class; ?>"
	data-wcpt-photoswipe-options="<?php echo $pswp_ops; ?>"
	data-wcpt-photoswipe-items="<?php echo $pswp_items; ?>"    
>
<?php 
$print_image_ids = $include_featured ? $images : $gallery_image_ids;
foreach( $print_image_ids as $key=> $attachment_id ) {
	if( $key == $max_images ){
		break;
	}

	$thumb_src = wp_get_attachment_image_src( $attachment_id );
	$full_src = wp_get_attachment_image_src( $attachment_id, $full_size );

	$offset_zoom_attrs = '';
	if( ! empty( $offset_zoom_enabled ) ){
		$offset_zoom_attrs = ' data-wcpt-offset-zoom-image-src="'. $full_src[0] .'" ';
		$offset_zoom_attrs .= ' data-wcpt-offset-zoom-image-html-class="wcpt-'. $id .'--offset-zoom-image" ';
	}

	?><div 
		class="wcpt-gallery__item-wrapper"
		<?php if( $image_width ){ echo 'style="width: '. $image_width .'px;"'; } ?>
		<?php echo $offset_zoom_attrs; ?>
	><img 
			class="wcpt-gallery__item"
			data-wcpt-gallery-item="<?php echo $key; ?>"			
			src="<?php echo $thumb_src[0]; ?>"
	/></div><?php 
}

$len = count( $print_image_ids );
if( $len > $max_images ){
	$diff = $len - $max_images;
	$locale_code = strtolower( get_locale() );
	if( ! empty( $atts[ 'see_more_label_' . $locale_code ] ) ){
		$see_more_label = $atts[ 'see_more_label_' . $locale_code ];
	}
	?><a 
		href="#"
		class="wcpt-gallery__see-more-label"
	><?php echo str_replace('{n}', $diff, $see_more_label); ?></a><?php
}
?>
</div>