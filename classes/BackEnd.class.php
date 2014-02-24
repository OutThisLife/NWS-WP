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

	/*
	 * Adds a widget
	 */
	protected function _widget(array $args) {
		$WC = new WidgetCreator($args);
		eval($WC->render());
	}

	// -----------------------------------------------

	/**
	 * getChildren
	 */
	public static function getChildren() {
		# Blog
		if (
			is_home()
			|| is_archive()
			|| is_singular('post')
			|| is_search()
		) return self::getCategories();

		# General pages
		else return wp_list_pages(array(
			'title_li' => null,
			'child_of' => self::getRootParent(),
			'depth' => 1,
			'echo' => false,
		));
	}

	/**
	 * getCategories
	 */
	public static function getCategories() {
		$categories = null;

		$classes = (is_home() || is_page(BLOG)) ? 'current-cat' : null;

		$categories .= '<li class="'. $classes .'"><a href="'. get_permalink(BLOG) .'">View All</a></li>';
		$categories .= wp_list_categories(array(
			'title_li' => null,
			'depth' => 1,
			'echo' => false,
		));

		return $categories;
	}

	/**
	 * getTerms
	 */
	public static function getTerms($tax) {
		$categories = null;

		$curTerm = is_tax() ? get_queried_object()->term_id : 0;
		$parent = is_tax() ? get_queried_object()->parent : 0;

		$terms = get_terms($tax, array(
			'parent' => $parent,
			'hide_empty' => false,
		));

		foreach ($terms AS &$t):
			$class = $curTerm === $t->term_id ? 'current-cat' : '';

			$categories .= '
			<li class="'. $class .'">
				<a href="'. get_term_link($t) .'">'
					. $t->name .
				'</a>
			</li>
			';
		endforeach;

		return $categories;
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
	 * getOption
	 */
	public static function getOption($option) {
		return do_shortcode(self::$options[$option]);
	}

	/**
	 * getPostType
	 */
	public static function getPostType($type, $settings = array()) {
		$default = array(
			'post_type' => $type,
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);

		return new WP_Query(array_merge($default, $settings));
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
	 * getPageDepth
	 */
	public static function getPageDepth() {
		global $wp_query;

		$depth = 0;
		$obj = $wp_query->get_queried_object();
		$pID = $obj->post_parent;

		while ($pID > 0):
			$page = get_page($pID);
			$pID = $page->post_parent;
			$depth++;
		endwhile;

		return $depth;
	}

	/**
	 * getArchiveData
	 */
	public static function getArchiveData() {
		if (!($type = get_post_type())):
			$tax = get_queried_object()->taxonomy;
			$taxData = get_taxonomy($tax);
			$type = $taxData->object_type[0];

		else:
			$tax = get_object_taxonomies($type);
			$tax = $tax[0];
		
		endif;

		return (object) array(
			'type' => $type,
			'taxonomy' => $tax,
		);
	}
}