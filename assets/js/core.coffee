# Require JS config.
requirejs.config
	# Change this per your environment
	baseUrl: '/wp/wp-content/themes/replaceMe/assets/js/' # Talasan [dev]
	# baseUrl: '/wp-content/themes/replaceMe/assets/js/' # Production and staging
	urlArgs: "bust=#{(new Date()).getTime()}"

	paths:
		# CDN powered
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular']

		# Local
		controllers: ['controllers']
		services: ['services']
		directives: ['directives']
		filters: ['filters']

	shim:
		angular: exports: 'angular'
		controllers: ['angular']
		services: ['angular']
		directives: ['angular']
		filters: ['angular']
		hoverintent: ['jquery']

	priority: ['angular']

require [
	'angular',
	'controllers',
	'directives',
	'services',
], (angular) ->
	angular.element(document).ready ->
		angular.module 'app', [
			'app.controllers',
			'app.directives',
			'app.services',
		]

		angular.bootstrap document, ['app']