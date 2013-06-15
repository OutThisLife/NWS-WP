<?php
/**
 * replaceMe
 *
 * Single to test for certain, specific, conditions
 */

class DevTests {
	/**
	 * isDeveloper
	 */
	public static function isDeveloper() {
		return in_array($_SERVER['REMOTE_ADDR'], array(
			'208.64.74.173', # Talasan
		));
	}

	/**
	 * isMobile
	 */
	public static function isMobile() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(Android|iPhone|BlackBerry|Opera Mini)/i', 
			$ua
		);
	}

	/**
	 * isTablet
	 */
	public static function isTablet() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(iPad|Kindle|Tablet)/i', 
			$ua
		);
	}

	/**
	 * isDevice
	 */
	public static function isDevice() {
		return self::isMobile() || self::isTablet();
	}
}