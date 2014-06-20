requirejs.config
	baseUrl: '/wp/wp-content/themes/replaceMe/assets/js/'
	urlArgs: "bust=#{(new Date()).getTime()}"

	paths:
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular']

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