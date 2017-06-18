<?php
/**
 * matties
 *
 * Autoload classes for this theme
 */

require_once TEMPLATEPATH . '/classes/config.php';

function autoload($className) {
	$file = TEMPLATEPATH .'/classes/'. $className .'.class.php';

	if (
		!class_exists($className)
		&& is_readable($file)
	) require_once $file;
}

spl_autoload_register('autoload');