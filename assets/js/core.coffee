requirejs.config
	baseUrl: '/wp/wp-content/themes/replaceMe/assets/js/'
	urlArgs: "bust=#{(new Date()).getTime()}"
	waitTimeout: 0

require [
	'controllers',
	'directives',
	'services',
], ->
	angular.element(document).ready ->
		angular.module 'app', [
			'app.controllers',
			'app.directives',
			'app.services',
		]

		angular.bootstrap document, ['app']