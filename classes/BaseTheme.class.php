<?php
/**
 * replaceMe
 *
 * Builds the skeleton of the theme and extends out factory-style
 */

// -----------------------------------------------

class BaseTheme {
	public $front, $back;
	private $vars = array();

	/**
	 * Initial theme setup
	 */
	public function __construct() {
		$this->loadFiles();

		$this->front = new FrontEnd();
		$this->back = new BackEnd();
	}

	# Load required files
	private function loadFiles() {
		require_once 'config.php';
	}

	# Set up debugging
	public function debug($bool = false) {
		error_reporting(E_ALL);
		ini_set('display_errors', $bool);

		return $this;
	}

	# Control admin bar
	public function adminBar($bool = false) {
		show_admin_bar($bool);

		return $this;
	}

	/**
	 * All addXYZ will use __call
	 */
	public function __call($name, array $args) {
		if (!strstr($name, 'add')) return;
		$this->vars[$name] = $args;

		return $this;
	}

	/**
	 * Render the 'known' variables
	 */
	public function render() {
		return array_walk($this->vars, array($this, 'sort'));
	}

	/**
	 * Sort through the variable names and call the related method
	 */
	private function sort($values, $key) {
		$method = NULL;
		$values = $values[0];

		# Construct the method name out of the key
		$key = strtolower($key);
		$key = str_replace('add', '', $key);
		$method = '_' . substr($key, 0, -1);

		# Test the method vs FrontEnd + BackEnd
		if (method_exists($this->front, $method))
			$class =& $this->front;

		elseif (method_exists($this->back, $method))
			$class =& $this->back;

		else throw new Exception(__METHOD__ .' - '. $method .' does not exist.');

		# Map the method to the array and bam.
		array_map(array($class, $method), $values);
	}
}