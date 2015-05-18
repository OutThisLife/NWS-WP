app = angular.module 'app.controllers', []

winObj = angular.element window
docObj = angular.element document

$body = angular.element 'body, html'

# ------------------------------------------------------------------

app.controller 'Main', ['$scope', '$timeout', '$interval', ($scope, $timeout, $interval) ->
	globalDimensions = ->
		$scope.winWidth = winObj.width()
		$scope.winHeight = winObj.height()
		$scope.scrollTop = winObj.scrollTop()

	$timeout globalDimensions
	$interval globalDimensions, 25
]