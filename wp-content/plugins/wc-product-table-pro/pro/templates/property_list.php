<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

ob_start();

if( empty( $initial_reveal ) ){
	$initial_reveal = 4;
}

if( empty( $columns ) ){
	$columns = 1;
}

$html_class .= ' wcpt-property-list--' . $columns . '-column ';

if( ! empty( $label_above_value_enabled ) ){
	$html_class .= ' wcpt-property-list--label-above-value ';	
}

$hide_toggle = true;

?>
<div class="wcpt-pl-inner">
	<?php
		$displayed = 0;
		foreach( $rows as $row ){
			if( wcpt_condition( $row['condition'] ) ){
				$displayed++;

				if( $displayed > $initial_reveal ){
					$hide_class = ' wcpt-tg-hide ';
					$hide_toggle = false;

				}else{
					$hide_class = '';

				}

				echo '<div class="wcpt-pl-row '. $hide_class .'">';
					echo '<span class="wcpt-property-name">' . wcpt_parse_2( $row['property_name'] ) . '</span>';
					echo '<span class="wcpt-property-value">' . wcpt_parse_2( $row['property_value'] ) . '</span>';
				echo '</div>';
			}
		}
	?>
</div>
<?php

$template = ob_get_clean();

$toggle_class = '';
$toggle_mkp = '';

if( ! $hide_toggle ){
	$toggle_class = 'wcpt-toggle wcpt-tg-off';
	$toggle_on = '<span class="wcpt-tg-on-label">'. wcpt_parse_2( $show_more_label ) .'</span>';
	$toggle_off = '<span class="wcpt-tg-off-label">'. wcpt_parse_2( $show_less_label ) .'</span>';
	ob_start();
	wcpt_icon('chevron-down', 'wcpt-toggle-rotate');
	$toggle_icon = ob_get_clean();
	$toggle_mkp = '<span class="wcpt-tg-trigger">'. $toggle_icon . $toggle_on . $toggle_off .'</span>';
}

echo '<span class="wcpt-property-list '. $toggle_class . ' ' . $html_class .'">'.  $template . $toggle_mkp . '</span>';
