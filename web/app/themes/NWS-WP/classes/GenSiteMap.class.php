<?php
/**
 * matties
 *
 * Build a sitemap like so:
 * ['title' => 'Parent Page Title', 'children' => ['page1', 'page2', 'page3']],
 * ['title' => 'Single Page Title'],
 */

class GenSiteMap {
	private $sitemap;

	public function __construct(array $sitemap) {
		$this->sitemap = $sitemap;
		$this->iterateAndCreate();
	}

	private function iterateAndCreate() {
		foreach ($this->sitemap AS $page):
			$_id = $this->addPage($page['title']);

			if ($children = $page['children'])
			foreach ($children AS $i => $child)
				$this->addPage($child, ($i + 1), $_id);
		endforeach;
	}

	private function addPage($title, $order = 0, $parent = 0) {
		if ($page = get_page_by_title($title))
			$res = $page->ID;

		else $res = wp_insert_post([
			'post_title' => $title,
			'post_content' => file_get_contents(TEMPLATEPATH .'/partials/page.html'),
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $parent,
			'menu_order' => $order,
		]);

		return $res;
	}
}