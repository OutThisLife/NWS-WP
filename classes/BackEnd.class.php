<?php
/**
 * replaceMe
 *
 * Controls back-end deliveries
 */

class BackEnd extends BaseTheme {
	protected static $options, $post;

	public function __construct() {
		global $post;

		self::$post = $post;
		self::$options = get_option('r');
	}

	/**
	 * Creates a setting page with tabs
	 */
	protected function _setting(array $tabs) {
		new Settings($this, $tabs);
	}

	/**
	 * Creates an individual shortcode using callbacks
	 */
	protected function _shortcode($callback) {
		add_shortcode(key($callback), current($callback));
	}

	// -----------------------------------------------

	/**
	 * getChildren
	 */
	public static function getChildren() {
		$children = wp_list_pages(array(
			'title_li' => null,
			'child_of' => $this->getRootParent(),
			'depth' => 1,
			'echo' => false
		));

		return !empty($children) ? $children : false;
	}

	/**
	 * getMenu
	 */
	public static function getMenu($name, $settings = array()) {
		$defaults = array(
			'theme_location' => $name,
			'container' => null,
			'items_wrap' => '%3$s',
		);

		wp_nav_menu(array_merge($settings, $defaults));
	}

	/**
	 * getRootParent
	 */
	public static function getRootParent() {
		$parent = self::$post->ID;

		if (self::$post->post_parent)	{
			$ancestors = get_post_ancestors(self::$post->ID);
			$root = count($ancestors)-1;
			$parent = $ancestors[$root];
		}

		return $parent;
	}

	/** 
	 * getRootTitle
	 */
	public static function getRootTitle() {
		return get_the_title(self::getRootParent());
	}

	/**
	 * getOption
	 */
	public static function getOption($option) {
		return do_shortcode(self::$options[$option]);
	}
}