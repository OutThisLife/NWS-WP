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
	'//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.3/css/normalize.min.css',
	'//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.3/css/foundation.min.css',
	assetDir . '/css/core.css',
))

# Image sizes
->addImageSizes(array(array(
	//
)))

# Sidebars
->addSidebars(array(
	//
))

// -----------------------------------------------

/**
 * Set up our back-end systems
 */

# Menus
->addMenus(array(array(
	'header' => 'Header Menu',
	'footer' => 'Footer Menu',
)))

# Settings
->addSettings(array(array(
	'General' => array(
		'phone' => array(
			'name' => 'Phone #',
			'type' => 'text',
			'desc' => 'Use [phone] to retrieve this value.',
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

# Widgets
->addWidgets(array(
	# Just a test box
	array(
		'id' => 'testbox',
		'title' => 'testbox',
		'desc' => 'Keep a secret!',
		'fields' => array(
			array(
				'name' => 'title',
				'id' => 'title',
				'type' => 'text',
			),
		),

		'output' => '',
	),
))

// -----------------------------------------------

# Render the theme.
->render();

// -----------------------------------------------