<?php
/**
 * replaceMe
 *
 * Main Functions
 */

require_once 'classes/sys/autoloader.php';

$tmpl = new BaseTheme();
$tmpl->debug(0)->adminBar(0)

// -----------------------------------------------

/**
 * Set up our front-end systems
 */

# Stylesheets
->addStyles(array(
	get_bloginfo('stylesheet_url'),
	assetDir . '/css/core.css',
))

# Scripts
->addScripts(array(
	assetDir . '/js/core.js',
))

// -----------------------------------------------

/**
 * Set up our back-end systems
 */

# Settings
->addSettings(array(array(
	'General' => array(
		'phone' => array(
			'name' => 'Phone #',
			'type' => 'text',
			'desc' => 'This will be used on the ...',
		),

		'test2' => array(
			'name' => 'test #',
			'type' => 'text',
			'desc' => 'This will be used on the ...',
		),
	),

	'Footer' => array(
		'scripts' => array(
			'name' => 'Extra Scripts',
			'type' => 'textarea',
			'desc' => 'If used, these scripts will be loaded in the footer. Put things like Google Analytics in here.',
		),
	),
)))

# Shortcodes
->addShortcodes(array(array(
	# [phone]
	'phone' => function() {
		return BackEnd::getOption('phone');
	},
)))

// -----------------------------------------------

# Render the theme.
->render();

if (DevTests::isDeveloper()) exit;