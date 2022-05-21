<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '<span class="wcpt-price-wrapper '. $html_class .'">' . $product->get_price_html() . '</span>';
?>
