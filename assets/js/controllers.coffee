app = angular.module 'app.controllers', []

winObj = $(window)

$body = $('html, body')
$container = $('#container')

# Main site controller
app.controller 'MainCtrl', ['$scope', '$timeout', ($scope, $timeout) ->
	# These dimensions will be used throughout the site
	$scope.transform = (-> 
		prefix = Modernizr.prefixed 'transform'
		prefix = prefix.replace /([A-Z])/g, (str, m1) -> "-#{m1.toLowerCase()}"
		prefix.replace /^ms-/, '-ms-'
	)($scope.transform)

	setDimensions = ->
		$scope.$apply ->
			$scope.winWidth = winObj.width()
			$scope.winHeight = winObj.height()
			$scope.scrollTop = winObj.scrollTop()
			$scope.scrollLeft = winObj.scrollLeft()

	$timeout -> setDimensions()
	winObj.on 'scroll resize orientationchange', setDimensions

	# Handle the mobile menu variables here
	$scope.mobile = {}
	$scope.mobile.$nav = angular.element '#mobile-dd'

	# Toggle the mobile status
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	angular.element('#content').on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'
]