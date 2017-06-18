<?php
/*
 * matties
 *
 * Template Name: Redirect To First Child
 */

the_post();

$children = get_pages([
	'child_of' => get_the_ID(),
	'sort_column' => 'menu_order',
]);

wp_redirect(get_permalink($children[0]), 301);