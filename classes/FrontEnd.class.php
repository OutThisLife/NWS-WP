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
		if (is_admin()) return;

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
	 * frontUriHash
	 *
	 * Redirects all URI's to the front with a hashtag.
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
}