<?php
/**
 * replaceMe
 *
 * This will handle: building in loops & quick snippet grabbing
 */

class Template {
	/**
	 * Retrieves a snippet file
	 */
	public static function get($snippet) {
		$file = TEMPLATEPATH .'/classes/snippets/'. $snippet .'.php';

		if (
			file_exists($file)
			&& is_readable($file)
		) include $file;

		else throw new Exception(__METHOD__ .' - '. $file .' does not exist or is not readable.');
	}

	/**
	 * Creates a loop and utilizes get_template_part to throw it into the mix.
	 */
	public static function loop($callback, $query) {
		$result = new WP_Query($query);

		if ($result->have_posts())
		while ($result->have_posts()):
			$result->the_post();

			# Is it a function? Use it.
			if (is_callable($callback)) $callback();

			# Does the build-file exist? Use it.
			elseif (file_exists(TEMPLATEPATH .'/build-'. $callback .'.php'))
				get_template_part('build', $callback);

			# Otherwise, throw an exception!
			else throw new Exception(__METHOD__ .' - '. $callback .' is not a valid callback.');
		endwhile; wp_reset_query();
	}
}