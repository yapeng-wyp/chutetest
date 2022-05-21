<?php
/**
 * ArileWP child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */


add_action('wp_enqueue_scripts', 'my_enqueue_assets');
function my_enqueue_assets()
{

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

}