angular.element(document).ready ->
	angular.module 'app', [
		'ngTouch',

		'app.controllers',
		'app.directives',
		'app.services',
		'app.filters',
	]

	angular.bootstrap document, ['app']