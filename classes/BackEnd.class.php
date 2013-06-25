<?php
/**
 * replaceMe
 *
 * Controls back-end deliveries
 */

class BackEnd extends BaseTheme {
	protected static $options, $post;

	public function __construct() {
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
	protected function _shortcode(array $callback) {
		foreach ($callback AS $key => $cb)
			add_shortcode($key, $cb);
	}

	/**
	 * Adds a nav menu
	 */
	protected function _menu(array $menu) {
		register_nav_menus($menu);
	}

	/**
	 * Adds an image size
	 */
	protected function _imagesize(array $args) {
		foreach ($args AS $key => $value)
			add_image_size($key, $value[0], $value[1], $value[2]);
	}

	// -----------------------------------------------

	/**
	 * getChildren
	 */
	public static function getChildren() {
		$children = wp_list_pages(array(
			'title_li' => null,
			'child_of' => self::getRootParent(),
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
		global $post;
		$parent = $post->ID;

		if ($post->post_parent)	{
			$ancestors = get_post_ancestors($post->ID);
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