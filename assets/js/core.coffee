# Require JS config.
requirejs.config
	# Change this per your environment
	baseUrl: '/wp/wp-content/themes/NWS-WP/assets/js/' # Talasan [dev]
	# baseUrl: '/wp-content/themes/replaceMe/assets/js/' # Production and staging
	
	urlArgs: "bust=#{(new Date()).getTime()}"
	
	paths:
		# CDN powered
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular']
		jquery: ['//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min']
		hammer: ['//cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.6/jquery.hammer.min']
		mousewheel: ['//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.6/jquery.mousewheel.min']

		# Local
		controllers: ['controllers']
		services: ['services']
		directives: ['directives']
		filters: ['filters']
		hoverintent: ['library/hoverIntent']

	shim: 
		angular: exports: 'angular'
		controllers: ['angular']
		services: ['angular']
		directives: ['angular']
		filters: ['angular']
		hoverintent: ['jquery']

	priority: ['angular', 'jquery']

require [
	'jquery', 
	'angular', 
	'controllers', 
	'directives',
], ($, angular) ->
	angular.element(document).ready ->
		angular.module 'app', [
			'app.controllers',
			'app.directives',
		]

		angular.bootstrap document, ['app']