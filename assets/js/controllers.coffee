app = angular.module 'app.controllers', []

winObj = $(window)

$body = $('html, body')
$container = $('#container')

# Main site controller
app.controller 'MainCtrl', ['$scope', '$timeout', ($scope, $timeout) ->
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

	# Toggle the mobile status
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	$('#content').on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'
]