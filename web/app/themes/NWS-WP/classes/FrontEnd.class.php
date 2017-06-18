<?php
/**
 * matties
 *
 * Controls front-end deliveries
 */

class FrontEnd extends BaseTheme {
	public function __construct() {}

	protected function _sidebar($name) {
		register_sidebar([
			'name' => $name,
			'id' => sanitize_key($name),
		]);
	}

	protected function _script($src) {
		if (DevTests::isAdmin()) return;

		wp_enqueue_script(
			sanitize_key($src),
			$src,
			false,
			'1.0',
			true
		);
	}

	protected function _style($src) {
		if (DevTests::isAdmin()) return;

		wp_enqueue_style(
			sanitize_key($src),
			$src,
			false,
			'1.0'
		);
	}

	// -----------------------------------------------

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

	public static function parseGallery($content) {
		preg_match('/\[gallery.*ids=.(.*).\]/', $content, $ids);
		return explode(',', $ids[1]);
	}

	public static function typekit($id) {
		return <<<S
<script src="//use.typekit.net/{$id}.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
S;
	}

	public static function getTitle() {
		echo '<title>', wp_title('|', true, 'right'), '</title>';
	}

	public static function getImg($id, $size, $class = '') {
		return wp_get_attachment_image($id, $size, false, [
			'itemprop' => 'image',
			'class' => $class,
		]);
	}

	public static function getSrc($id, $size) {
		$src = wp_get_attachment_image_src($id, $size);
		return $src[0];
	}

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

	public static function extractYT($str) {
		preg_match('/v\=(.*)$/', $str, $results);
		return $results[1];
	}

	public static function extractVimeo($str) {
		preg_match('/\.com\/(.*)$/', $str, $results);
		return $results[1];
	}

	public static function svg($icon) {
		ob_start();

		echo '<span class="', $icon, '">';
		include locate_template('assets/img/' . $icon . '.svg');
		echo '</span>';

		return ob_get_clean();
	}

	public static function inlineSVG($url) {
		ob_start();

		$path = pathinfo($url);
		$icon = $path['filename'];

		echo '<span class="', $icon, '">';
		echo file_get_contents($url);
		echo '</span>';

		return ob_get_clean();
	}
}