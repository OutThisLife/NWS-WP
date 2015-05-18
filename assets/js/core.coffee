requirejs.config
	baseUrl: '/wp/wp-content/themes/NWS-WP/'
	urlArgs: "bust=#{(new Date()).getTime()}"
	waitTimeout: 0

	paths:
		angular: 'bower_components/angular/angular.min',
		ngTouch: 'bower_components/angular-touch/angular-touch.min'
		ngSanitize: 'bower_components/angular-sanitize/angular-sanitize.min'

		controllers: 'assets/js/controllers'
		factories: 'assets/js/factories'
		directives: 'assets/js/directives'
		services: 'assets/js/services'
		filters: 'assets/js/filters'

	shim:
		ngTouch: ['angular']
		ngSanitize: ['angular']

		controllers: ['angular']
		factories: ['angular']
		directives: ['angular']
		services: ['angular']
		filters: ['angular']

require [
	'ngTouch',

	'controllers',
	'directives',
	'services',
], ->
	angular.element(document).ready ->
		angular.module 'app', [
			'ngTouch',

			'app.controllers',
			'app.directives',
			'app.services',
		]

		angular.bootstrap document, ['app']