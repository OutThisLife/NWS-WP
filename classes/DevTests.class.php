<?php
/**
 * replaceMe
 *
 * Single to test for certain, specific, conditions
 */

class DevTests {
	/**
	 * Check if client is a 'developer'. Add your IP to this list if you want to use this fn.
	 */
	public static function isDeveloper() {
		return in_array($_SERVER['REMOTE_ADDR'], array(
			'208.64.74.173', # Talasan
		));
	}

	/**
	 * Checks if client is on a mobile device
	 */
	public static function isMobile() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(Android|iPhone|BlackBerry|Opera Mini)/i', 
			$ua
		);
	}

	/**
	 * Checks if client is on a tablet
	 */
	public static function isTablet() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(iPad|Kindle|Tablet)/i', 
			$ua
		);
	}

	/**
	 * Checks vs both mobile and tablet
	 */
	public static function isDevice() {
		return self::isMobile() || self::isTablet();
	}

	/**
	 * Check if the request is pjax
	 */
	public static function isAjax() {
		return $_SERVER['HTTP_X_PJAX'] === 'true';
	}

	/**
	 * Check if we're on the admin page or login page
	 */
	public static function isAdmin() {
		return (
			is_admin()
			|| (
				in_array($GLOBALS['pagenow'], array(
					'wp-login.php',
					'wp-register.php',
				))
			)
		);
	}
}