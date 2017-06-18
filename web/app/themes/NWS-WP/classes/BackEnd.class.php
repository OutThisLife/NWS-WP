<?php
/**
 * LC
 *
 * Controls back-end deliveries
 */

class BackEnd extends BaseTheme {
	protected static $options, $post;

	public function __construct() {
		self::$options = get_option('r');
	}

	protected function _setting(array $tabs) {
		new Settings($this, $tabs);
	}

	protected function _shortcode(array $callback) {
		foreach ($callback AS $key => $cb)
			add_shortcode($key, $cb);
	}

	protected function _menu(array $menu) {
		register_nav_menus($menu);
	}

	protected function _imagesize(array $args) {
		foreach ($args AS $key => $value)
			add_image_size($key, $value[0], $value[1], $value[2]);
	}

	protected function _widget(array $args) {
		$WC = new WidgetCreator($args);
		eval($WC->render());
	}

	// -----------------------------------------------

	public static function getChildren() {
		$children = null;

		if (DevTests::isBlog())
			$children = self::getCategories();

		else $children = wp_list_pages([
			'title_li' => null,
			'child_of' => self::getRootParent(),
			'depth' => 1,
			'echo' => false,
		]);

		return $children;
	}

	public static function getCategories() {
		$categories = null;

		$classes = (is_home() || is_page(BLOG)) ? 'current-cat' : null;

		$categories .= '<li class="'. $classes .'"><a href="'. get_permalink(BLOG) .'">View All</a></li>';
		$categories .= wp_list_categories([
			'title_li' => null,
			'depth' => 1,
			'echo' => false,
		]);

		return $categories;
	}

	public static function getTerms($tax) {
		$categories = null;

		$curTerm = is_tax() ? get_queried_object()->term_id : 0;
		$parent = is_tax() ? get_queried_object()->parent : 0;

		$terms = get_terms($tax, [
			'parent' => $parent,
			'hide_empty' => false,
		]);

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

	public static function getMenu($name, $settings = []) {
		$defaults = [
			'theme_location' => $name,
			'container' => null,
			'items_wrap' => '%3$s',
		];

		wp_nav_menu(array_merge($settings, $defaults));
	}

	public static function getMenuLabel($name) {
		$locations = get_nav_menu_locations();

		if (isset($locations[$name])) {
			$obj = wp_get_nav_menu_object($locations[$name]);
			return $obj->name;
		}
	}

	public static function getOption($option) {
		return do_shortcode(self::$options[$option]);
	}

	public static function getPostType($type, $settings = []) {
		$default = [
			'post_type' => $type,
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		];

		return new WP_Query(array_merge($default, $settings));
	}

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

	public static function getRootTitle() {
		$title = null;

		if (DevTests::isBlog())
			$title = get_the_title(BLOG);

		else $title = get_the_title(self::getRootParent());

		return $title;
	}

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

	public static function getArchiveData() {
		if (!($type = get_post_type())):
			$tax = get_queried_object()->taxonomy;
			$taxData = get_taxonomy($tax);
			$type = $taxData->object_type[0];

		else:
			$tax = get_object_taxonomies($type);
			$tax = $tax[0];

		endif;

		return (object) [
			'type' => $type,
			'taxonomy' => $tax,
		];
	}

	public static function getAdjacentPost($dir = 'prev', $type = 'post', $sameCategory = false) {
		global $post, $wpdb;

		if (empty($post) || !$type) return false;

		$curDate = $post->post_date;

		$join = '';
		$adjacent = $dir == 'prev' ? 'previous' : 'next';
		$op = $dir == 'prev' ? '<' : '>';
		$order = $dir == 'prev' ? 'DESC' : 'ASC';

		$join = apply_filters("get_{$adjacent}_post_join", $join, $sameCategory);
		$where = apply_filters("get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.post_date $op %s AND p.post_type IN('{$type}') AND p.post_status = 'publish'", $curDate), $sameCategory);
		$sort = apply_filters("get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1");

		$query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
		$query_key = 'adjacent_post_' . md5($query);

		$result = wp_cache_get($query_key, 'counts');

		if ($result) return $result;

		$result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
		if (!$result) $result = '';

		wp_cache_set($query_key, $result, 'counts');

		return $result;
	}
}