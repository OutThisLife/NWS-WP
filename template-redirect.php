<?php
/*
 * replaceMe
 *
 * Template Name: Redirect To First Child
 */

the_post();

$children = get_pages(array(
	'child_of' => $post->ID,
	'sort_column' => 'menu_order',
));

wp_redirect(get_permalink($children[0]));