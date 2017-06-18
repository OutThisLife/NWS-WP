<?php
/**
 * matties
 *
 * Dynamically creates WP widgets via addWidgets()
 */

if (class_exists('WidgetCreator')) return;

class WidgetCreator {

	private $data;
	public $widgetName;

	public function __construct(array $data) {
		$this->data =& $data;
		$this->widgetName = $this->parseTitle($data['title']);

		$this->forms = $this->createForms();
		$this->updateFields = $this->updateFields();
	}

	public function __get($value) {
		if (($res = $this->data[$value]) !== NULL)
			return $res;

		else return NULL;
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	// -----------------------------------------------

	private function createForms() {
		$tmp = NULL;

		foreach ($this->data['fields'] AS &$r) {
			extract($r);

			$tmp .= "<p><label for=\"<?=\$this->get_field_id(\"$id\")?>\">$name</label>";

			$meta = <<<S
			class="widefat"
			id="<?=\$this->get_field_id("$id")?>"
			name="<?=\$this->get_field_name("$id")?>"
S;
			$value = <<<S
			value="<?=htmlentities(\$instance["$id"])?>"
S;

			switch ($type) {
				case 'text':
					$tmp .= "<input type=\"text\" $meta $value />";
				break;

				case 'textarea':
					$tmp .= "<textarea $meta><?=htmlentities(\$instance['$id'])?></textarea>";
				break;

				case 'checkbox':
					$tmp .= "<input type=\"checkbox\" $meta />";
				break;

				case 'select':
					$tmp .= "<select $meta>";

					foreach ($options AS &$option) {
						$tmp .= <<<S
						<option <?php selected(\$instance['$id'], '$option') ?>>$option</option>
S;
					}

					$tmp .= '</select>';
				break;
			}
		}

		$tmp .= '</p>';

		return $tmp;
	}

	private function updateFields() {
		$tmp = NULL;

		foreach ($this->data['fields'] AS &$r) {
			$id = $r['id'];
			$tmp .= "\$instance['$id'] = strip_tags(\$new_instance['$id'], \"<strong><b><i><a><u><s><br><p><img><iframe><ul><li><ol><em>\");";
		}

		return $tmp;
	}

	private function parseTitle($str) {
		return 'WC_'.str_replace(' ', '_', $str);
	}

	final public function render() {
		return <<<S
class $this->widgetName extends WP_Widget {
	function __construct() {
		parent::WP_Widget(
			'$this->widgetName',
			'$this->title',
			['description' => '$this->desc']
		);
	}

	function widget(\$args, \$instance) {
		extract(\$args);
		\$title = apply_filters('widget_title', \$instance['title']);

		extract(\$instance);
		?>$this->output<?php
	}

	function update(\$new_instance, \$old_instance) {
		\$instance = \$old_instance;
		$this->updateFields

		return \$instance;
	}

	function form(\$instance) {
		\$defaults = ['title' => 'My Title'];

		\$instance = wp_parse_args(\$instance, \$defaults);

		?>$this->forms<?php
	}
}

register_widget('$this->widgetName');
S;
	}
}