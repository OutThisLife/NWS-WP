app = angular.module 'app.directives', []

# Reusable slideshow
app.directive 'ngSlideshow', ['$interval', ($interval) ->
	restrict: 'A'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1

		$scope.$watch 'current', (nv) ->
			return unless nv?
			$scope.current = nv % $scope.max
	]

	link: (scope, el, attrs) ->
		scope.max = el.find('.slide').length - 1

		if attrs.autoplay?
			$interval ->
				scope.next()
			, attrs.autoplay
]