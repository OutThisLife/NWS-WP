<?php
/**
 * replaceMe
 *
 * Autoload classes for this theme
 */

function autoload($className) {
	$file = TEMPLATEPATH .'/classes/'. $className .'.class.php';

	if (
		!class_exists($className)
		&& is_readable($file)
	) require_once $file;
}

spl_autoload_register('autoload');