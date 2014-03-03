<?php
/**
 * replaceMe
 *
 * Various definitions to help development.
 */

# Set JPEG quality to 100%
add_filter('jpeg_quality', function() { return 100; });

# Assets directory
DEFINE('assetDir', get_template_directory_uri() . '/assets');

# Relative path
DEFINE('relPath', '');

# Various page IDs
DEFINE('HOME', get_home_url());
// DEFINE('BLOG', xyz);