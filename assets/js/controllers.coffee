app = angular.module 'app.controllers', []

# Main site controller
app.controller 'MainCtrl', ['$scope', ($scope) ->
	# Setup re-usable modernizr values to be used in inline styles.
	getPrefix = (str) -> 
		res = str.replace /([A-Z])/g, (str, m1) -> '-'+m1.toLowerCase()
		res.replace /^ms-/, '-ms-'

	$scope.modernizr = {}
	$scope.modernizr.transition = getPrefix Modernizr.prefixed 'transition'
	$scope.modernizr.transform = getPrefix Modernizr.prefixed 'transform'

	# Handle the mobile menu variables here
	$scope.mobile = {}
	$scope.mobile.$nav = angular.element '#mobile-dd'
	$scope.mobile.$link = angular.element 'mobile-dd-link'
	$scope.mobile.$container = angular.element '#container'

	# Toggle the mobile status
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	angular.element('#content').on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'

	# Watch for the change and set the Y position
	$scope.$watch 'mobile.status', (newVal, oldVal) -> $scope.mobile.y = $scope.mobile.$nav.outerHeight()
]