<?php
/**
 * matties
 *
 * Various definitions to help development.
 */

# Enable thumbnails
add_theme_support('post-thumbnails');

# Set JPEG quality to 100%
add_filter('jpeg_quality', function() { return 100; });

# Fix YOAST + w3tc bug
add_filter('wpseo_robots', function($robots) {
	return 'index,follow';
});

# Force open robots.txt for WP (plugins fail miserably at this)
add_filter('robots_txt', function($output, $public) {
	return '
User-agent: *
Disallow: /wp-admin/
Disallow: /wp-includes/';
});

// -----------------------------------------------

# Assets directory
DEFINE('assetDir', get_template_directory_uri() . '/assets');
DEFINE('bowerDir', get_template_directory_uri() . '/bower_components');
DEFINE('relPath', '');

DEFINE('ASSET_VERSION',
	filemtime(get_template_directory() . '/assets/css/dist/main.css')
	+ filemtime(get_template_directory() . '/assets/js/dist/main.js')
);

# Time format for the_time()
DEFINE('tFormat', 'M d, Y');

# Various page IDs
DEFINE('HOME', get_home_url());
// DEFINE('BLOG', xyz);