<?php
/**
 * matties
 *
 * Build and render the theme options page
 */

class Settings {
	private $tabs = [];

	public function __construct(BackEnd $b, array $tabs) {
		$this->tabs = $tabs;

		add_action('admin_init', [$this, 'initSettings']);
		add_action('admin_menu', [$this, 'settingsMenu']);
	}

	public function initSettings() {
		register_setting('nws_settings', 'r');
	}

	public function settingsMenu() {
		add_theme_page(
			'Theme Options',
			'Theme Options',
			'edit_theme_options',
			'theme_options',
			[$this, 'settingsHtml']
		);
	}

	private function buildTabs() {
		$html = null;

		foreach ($this->tabs AS $name => $options):
			$slug = sanitize_title($name);
			$html .= '<a class="nav-tab" href="#'. $slug .'">'. $name .'</a>';
		endforeach;

		return $html;
	}

	private function buildSettings() {
		$html = null;

		foreach ($this->tabs AS $name => $options):
			$slug = sanitize_title($name);
			$html .= '<tbody data-tab="#'. $slug .'">';

			# Output each option
			foreach ($options AS $o):
				$name = $o['name'];
				$slug = sanitize_title($name);
				$type = sanitize_title($o['type']);
				$desc = sanitize_text_field($o['desc']);

				$value = BackEnd::getOption($slug);

				# Build the input type (text, textarea)
				switch ($type):
					case 'text':
						$field = <<<S
<input
	id="r[{$slug}]"
	class="regular-text"
	type="text"
	name="r[{$slug}]"
	placeholder="Enter value&hellip;"
	value="{$value}" />
S;
					break;

					case 'textarea':
						$field = <<<S
<textarea
	id="r[{$slug}]"
	cols="90"
	rows="5"
	name="r[{$slug}]"
	placeholder="Enter value&hellip;">{$value}</textarea>
S;
					break;
				endswitch;

				# Parse the HTML for this option
				$html .= <<<S
<tr>
	<th>
		<label for="{$slug}">{$name}</label>
	</th>

	<td>
		{$field}
		<br />
		<span class="description">{$desc}</span>
	</td>
</tr>
S;
			endforeach;
		endforeach;

		return $html;
	}

	public function settingsHtml() {
		$alert = isset($_REQUEST['settings-updated'])
			? '<div class="updated fade"><p><strong>Options Saved</strong></p></div>'
			: null;

		$icon = get_screen_icon();

		# Print out all the settings with the functions above.
		print <<<S
<script>
(function($) {
	$(function() {
		var curHash = null,
			\$nav = jQuery('.nav-tab-wrapper'),
			\$navA = \$nav.find('a'),
			\$table = jQuery('.form-table');

		function setTab(\$tab) {
			if (
				\$tab === curHash
				|| \$tab === undefined
			) return;

			curHash = \$tab;
			\$a = \$nav.find('[href="'+curHash+'"]');

			\$navA.removeClass('nav-tab-active');
			\$a.addClass('nav-tab-active');

			\$table.find('tbody').hide();
			\$table.find('tbody[data-tab="'+\$tab+'"]').show();
		};

		if (!location.hash) setTab(\$navA.eq(0).attr('href'));

		setInterval(function() {
			if (hash = location.hash) setTab(hash);
		}, 50);
	});
})(jQuery);
</script>

<div class="wrap">
	{$icon} <h2>Theme Options</h2>

	<form method="post" action="options.php">
		<p class="submit">
			<input type="submit" class="button-primary" value="Save Options" />
		</p>

		<h2 class="nav-tab-wrapper">
			{$this->buildTabs()}
		</h2>

		{$alert}
S;
		# Break for the settings fields.
		settings_fields('nws_settings');

		# Continue on!
		print <<<S
		<table class="form-table">
			{$this->buildSettings()}
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="Save Options" />
		</p>
	</form>
</div>
S;
	}
}