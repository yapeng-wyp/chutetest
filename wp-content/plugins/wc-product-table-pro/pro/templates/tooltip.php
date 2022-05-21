<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! $label ){
	return;
}

$tc_selector = '[id] > .wcpt-tooltip-content-wrapper > .wcpt-tooltip-content';

// arrow color
if(
	! empty( $style[$tc_selector] ) &&
	! empty( $style[$tc_selector]['background-color'] )
){
	$arrow_color = $style[$tc_selector]['background-color'];
}else{
	$arrow_color = '#ddd'; // default arrow color
}

$width = '200px';
if( ! empty( $popup_enabled ) ){
	$html_class .= ' wcpt-tooltip--popup-enabled ';
	$trigger = 'click';

	$width = '400px';	
}

$arrow_border_width = '0';
$arrow_border_color = 'transparent';

if(	! empty( $style[ $tc_selector ] ) ){

	if( ! empty( $style[$tc_selector]['width'] ) ){
		$width = trim( $style[$tc_selector]['width'] );
		if( 'px' !== substr( $width, -2 ) ){
			$width .= 'px';
		}
	}	

	if( ! empty( $style[$tc_selector]['border-width'] ) ){
		$arrow_border_width = $style[$tc_selector]['border-width'];
	}

	if( ! empty( $style[$tc_selector]['border-color'] ) ){
		$arrow_border_color = $style[$tc_selector]['border-color'];
	}

}

if( 
	empty( $hover_permitted ) &&
	(
		empty( $trigger ) ||
		$trigger === 'hover'
	)
){
	$html_class .= ' wcpt-tooltip--hover-disabled ';
}

if( 
	! empty( $trigger ) &&
	$trigger === 'click'
){
	$html_class .= ' wcpt-tooltip--open-on-click ';
}

?>
<span class="wcpt-tooltip <?php echo $html_class; ?>">
	<span class="wcpt-tooltip-label">
		<?php echo wcpt_parse_2( $label ); ?>
	</span>
	<span class="wcpt-tooltip-content-wrapper" style="width: <?php echo $width; ?>;">
		<span class="wcpt-tooltip-content">

			<!-- close -->
			<!-- <svg class="wcpt-tooltip-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg> -->

			<!-- arrow -->
			<svg class="wcpt-tooltip-arrow" viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
				<path d="M 0 100 L 200 100 L 100 0 z" fill="<?php echo $arrow_color; ?>" stroke-width="0"></path>
				<polyline points="0,100 100,10 200,100" style="fill:none;stroke:<?php echo $arrow_border_color;?>;stroke-width: <?php echo (float) $arrow_border_width * 10;?>;" stroke-linejoin="round"></polyline>
			</svg>
			<?php echo wcpt_parse_2( $content ); ?>
		</span>
	</span>

</span>
