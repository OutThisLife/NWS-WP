<?php
/**
 * CRM
 *
 * Main Functions
 */

require_once 'classes/sys/autoloader.php';
(new BaseTheme())->debug(0)->adminBar(0)

// -----------------------------------------------

/**
 * Set up the front-end
 */
->addImageSizes([[
	//
]])

// -----------------------------------------------

/**
 * Set up the back-end
 */
->addMenus([[
	'header' => 'Header Menu',
	'footer' => 'Footer Menu',
]])

->addSettings([[
	# General settings tab
	'General' => [
		'phone' => [
			'name' => 'Phone #',
			'type' => 'text',
			'desc' => 'Use [phone] to retrieve this value.',
		],
	],

	# Footer settings tab
	'Footer' => [
		'scripts' => [
			'name' => 'Extra Scripts',
			'type' => 'textarea',
			'desc' => 'If used, these scripts will be loaded in the footer. Put things like Google Analytics in here.',
		],
	],
]])

->addShortcodes([[
	# [phone]
	'phone' => function() {
		return BackEnd::getOption('phone');
	},

	# [button]
	'button' => function($args, $content = '') {
		return '<a href="'. $args['url'] .'" class="btn '. $args['style'] .'">'. $content .'</a>';
	},

	# [grid]
	'grid' => function($args, $content) {
		return '<div class="grid grid-'. $args['cols'] .'">'. do_shortcode($content) .'</div>';
	},

	# [grid_item]
	'grid_item' => function($args, $content) {
		return '<div class="item">'. do_shortcode($content) .'</div>';
	},

	# [lead]
	'lead' => function($args, $content) {
		return '<div class="lead">'. $content .'</div>';
	},

	# [youtube]
	'youtube' => function($args, $content) {
		return '<div class="responsive-video"><iframe width="560" height="315" src="https://www.youtube.com/embed/'. $args['id'] .'" frameborder="0" allowfullscreen></iframe></div>';
	},
]])

// -----------------------------------------------

->render();

// -----------------------------------------------

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('wp_enqueue_scripts', function() {
	if (is_admin()) return;

	wp_deregister_script('wp-embed.min.js');
	wp_deregister_script('wp-embed');
	wp_deregister_script('jquery-migrate');
	wp_deregister_script('embed');
	wp_deregister_script('jquery');
	wp_deregister_script('jquery-easing');

	wp_dequeue_style('page-list-style');
	wp_dequeue_style('yoast-seo-adminbar');
}, 999);

add_filter('excerpt_length', function($length) {
	return 30;
}, 999);

add_filter('upload_mimes', function($mimes) {
	$mimes['svg'] = 'img/svg+xml';

	return $mimes;
});