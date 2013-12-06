<?php
/**
 * replaceMe
 *
 * Controls front-end deliveries
 */

// -----------------------------------------------

class FrontEnd extends BaseTheme {
	public function __construct() {}

	/**
	 * Adds a sidebar
	 */
	protected function _sidebar($name) {
		register_sidebar(array(
			'name' => $name,
			'id' => sanitize_key($name),
		));
	}

	/**
	 * Adds a script
	 */
	protected function _script($src) {
		if (is_admin()) return;

		wp_enqueue_script(
			sanitize_key($src),
			$src,
			false,
			'1.0',
			true
		);
	}

	/**
	 * Adds a style
	 */
	protected function _style($src) {
		if (is_admin()) return;
		
		wp_enqueue_style(
			sanitize_key($src),
			$src,
			false,
			'1.0'
		);
	}

	// -----------------------------------------------

	/**
	 * truncate
	 */
	public static function truncate(
		$string, $limit, 
		$break = ' ', $pad = '&hellip;'
	) {
		if (strlen($string) <= $limit) return $string;

		$string = substr($string, 0, $limit);

		if (false !== ($breakpoint = strrpos($string, $break)))
			$string = substr($string, 0, $breakpoint);

		return $string . $pad;
	}

	/**
	 * parseGallery
	 */
	public static function parseGallery($content) {
		preg_match('/\[gallery.*ids=.(.*).\]/', $content, $ids);
		return explode(',', $ids[1]);
	}

	/**
	 * typekit
	 */
	public static function typekit($id) {
		return <<<S
<script src="//use.typekit.net/{$id}.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
S;
	}

	/**
	 * getTitle
	 */
	public static function getTitle() {
		echo '<title>', wp_title('|', true, 'right'), '</title>';
	}

	/**
	 * frontUriHash
	 */
	public static function frontUriHash() {
		$home = get_settings('home');
		$path = parse_url($home);

		$goTo = $home;
		$goTo .= '#'.str_replace(
			$path['path'].'/', 
			'/', 
			$_SERVER['REQUEST_URI']
		);

		$goTo = str_replace('#/', '/#', $goTo);

		return $goTo;
	}

	/**
	 * getImg
	 */
	public static function getImg($id, $size) {
		return wp_get_attachment_image($id, $size);
	}

	/**
	 * formatPhone
	 */
	public static function formatPhone($phone) {
		$phone = preg_replace('/[^0-9]/', '', $phone);

		if (strlen($phone) > 10) {
			$countryCode = substr($phone, 0, strlen($phone) - 10);
			$areaCode = substr($phone, -10, 3);
			$nextThree = substr($phone, -7, 3);
			$lastFour = substr($phone, -4, 4);

			$phone = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}

		else if (strlen($phone) == 10) {
			$areaCode = substr($phone, 0, 3);
			$nextThree = substr($phone, 3, 3);
			$lastFour = substr($phone, 6, 4);

			$phone = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}

		else if (strlen($phone) == 7) {
			$nextThree = substr($phone, 0, 3);
			$lastFour = substr($phone, 3, 4);

			$phone = $nextThree.'-'.$lastFour;
		}

		return $phone;
	}
}