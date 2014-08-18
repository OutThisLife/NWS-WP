requirejs.config
	baseUrl: '/wp/wp-content/themes/replaceMe/assets/js/'
	urlArgs: "bust=#{(new Date()).getTime()}"
	waitTimeout: 0

	paths:
		ngSanitize: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.22/angular-sanitize.min']
		ngTouch: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.22/angular-touch.min']
		async: ['library/async']

require [
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