<?php
/**
 * matties
 *
 * This will handle WP_Query loops & quick snippet grabbing
 */

class Template {
	public static function loop($callback, $query) {
		$result = BackEnd::getPostType('', $query);

		if ($result->have_posts())
		while ($result->have_posts()):
			$result->the_post();

			if (is_callable($callback)) $callback();

			elseif (file_exists(TEMPLATEPATH .'/build-'. $callback .'.php'))
				get_template_part('build', $callback);

			else throw new Exception(__METHOD__ .' - '. $callback .' is not a valid callback.');
		endwhile;
		wp_reset_query();
	}

	public static function partial($partial) {
		$file = TEMPLATEPATH .'/partials/'. $partial;

		if (
			file_exists($file)
			&& is_readable($file)
		) include $file;

		else throw new Exception(__METHOD__ .' - '. $file .' does not exist or is not readable.');
	}
}