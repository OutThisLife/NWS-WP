requirejs.config
	baseUrl: '/wp/wp-content/themes/replaceMe/assets/js/'
	urlArgs: "bust=#{(new Date()).getTime()}"

	paths:
		jquery: ['//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min']
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1/angular']

		ngSanitize: ['//ajax.googleapis.com/ajax/libs/angularjs/1/angular-sanitize']
		ngTouch: ['//ajax.googleapis.com/ajax/libs/angularjs/1/angular-touch']

		async: ['library/async']
		controllers: ['controllers']
		services: ['services']
		directives: ['directives']
		filters: ['filters']

	shim:
		angular: exports: 'angular'
		jquery: exports: '$'

		ngSanitize: ['angular']
		ngTouch: ['angular']

		controllers: ['angular']
		services: ['angular']
		directives: ['angular']
		filters: ['angular']

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