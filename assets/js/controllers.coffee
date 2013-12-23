app = angular.module 'app.controllers', []

# Main site controller
app.controller 'MainCtrl', ['$scope', ($scope) ->
	# Handle the mobile menu variables here
	$scope.mobile = {}
	$scope.mobile.$nav = angular.element '#mobile-dd'

	# Toggle the mobile status
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	angular.element('#content').on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'
]