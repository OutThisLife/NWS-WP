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
->addStyles(array(
	'//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.3/css/normalize.min.css',
	'//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.3/css/foundation.min.css',
	assetDir . '/css/core.css',
))

->addImageSizes(array(array(
	//
)))

->addSidebars(array(
	//
))

// -----------------------------------------------

/**
 * Set up our back-end systems
 */
->addMenus(array(array(
	'header' => 'Header Menu',
	'footer' => 'Footer Menu',
)))

->addSettings(array(array(
	# General settings tab
	'General' => array(
		'phone' => array(
			'name' => 'Phone #',
			'type' => 'text',
			'desc' => 'Use [phone] to retrieve this value.',
		),
	),

	# Footer settings tab
	'Footer' => array(
		'scripts' => array(
			'name' => 'Extra Scripts',
			'type' => 'textarea',
			'desc' => 'If used, these scripts will be loaded in the footer. Put things like Google Analytics in here.',
		),
	),
)))

->addShortcodes(array(array(
	# [phone]
	'phone' => function() {
		return BackEnd::getOption('phone');
	},
)))

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

->render();

// -----------------------------------------------