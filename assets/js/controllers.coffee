app = angular.module 'app.controllers', []

winObj = angular.element window
$body = angular.element 'html, body'
$content = angular.element '#content'

# Main site controller
app.controller 'MainController', ['$scope', '$timeout', ($scope, $timeout) ->
	setDimensions = ->
		$scope.$apply ->
			$scope.winWidth = winObj.width()
			$scope.winHeight = winObj.height()
			$scope.scrollTop = winObj.scrollTop()
			$scope.scrollLeft = winObj.scrollLeft()

	$timeout -> setDimensions()
	winObj.on 'scroll resize orientationchange', setDimensions

	# Set the very basic mobile menu variables
	$scope.mobile = {}
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	$content.on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'
]