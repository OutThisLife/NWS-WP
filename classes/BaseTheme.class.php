<?php
/**
 * replaceMe
 *
 * Builds the skeleton of the theme
 */

// -----------------------------------------------

class BaseTheme {
	public $front, $back;
	private $vars = array();

	public function __construct() {
		$this->front = new FrontEnd();
		$this->back = new BackEnd();
	}

	public function debug($bool = false) {
		error_reporting(E_ALL);
		ini_set('display_errors', $bool);

		return $this;
	}

	public function adminBar($bool = false) {
		if (!is_admin()) show_admin_bar($bool);
		return $this;
	}

	public function __call($name, array $args) {
		if (!strstr($name, 'add')) return;
		$this->vars[$name] = $args;

		return $this;
	}

	public function render() {
		return array_walk($this->vars, array($this, 'sortDynamicMethod'));
	}

	private function sortDynamicMethod($values, $key) {
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

		array_map(array($class, $method), $values);
	}
}