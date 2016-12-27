<?php
/**
 * LC
 *
 * Single to test for certain, specific, conditions
 */

class DevTests {
	public static function isDeveloper() {
		return in_array($_SERVER['REMOTE_ADDR'], [
			'208.64.74.173', # Talasan
		]);
	}

	public static function isMobile() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(Android|iPhone|BlackBerry|Opera Mini)/i',
			$ua
		);
	}

	public static function isTablet() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		return preg_match(
			'/(iPad|Kindle|Tablet)/i',
			$ua
		);
	}

	public static function isDevice() {
		return self::isMobile() || self::isTablet();
	}

	public static function isAjax() {
		return (
			$_SERVER['HTTP_X_PJAX'] === 'true'
			|| strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
		);
	}

	public static function isAdmin() {
		return (
			is_admin()
			|| in_array($GLOBALS['pagenow'], ['wp-login.php','wp-register.php'])
		);
	}

	public static function isBlog() {
		return (
			is_home()
			|| is_archive()
			|| is_singular('post')
			|| is_search()
		);
	}

	public static function isCrawler() {
		return (
			isset($_SERVER['HTTP_USER_AGENT'])
			&& preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])
		);
	}

	public static function showPage() {
		if (
			self::isAjax()
			|| self::isCrawler()
			|| self::isDevice()
			// || self::isDeveloper()
		) {
			Header('Title: '.  wp_title('|', false, 'right'));
			return true;
		}

		else return false;
	}

	public static function showWrapper() {
		return (
			self::isCrawler()
			|| self::isDevice()
			// || self::isDeveloper()
		);
	}
}