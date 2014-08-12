app = angular.module 'app.directives', []

raf = (-> (
	window.requestAnimationFrame or window.webkitRequestAnimationFrame or window.mozRequestAnimationFrame or window.oRequestAnimationFrame or window.msRequestAnimationFrame or (callback) -> window.setTimeout callback, 1
))()

# ------------------------------------------------------------------

app.directive 'ngScope', -> scope: true

# ------------------------------------------------------------------

app.directive 'ngSlideshow', ['$interval', ($interval) ->
	restrict: 'A'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1

		$scope.$watch 'current', (nv) ->
			return unless nv?

			nv = 0 if nv > $scope.max
			nv = $scope.max if nv < 0
			$scope.current = nv

		autoplayInt = null
		$scope.autoplay = (ms) ->
			autoplayInt = $interval ->
				$scope.next()
			, ms

		$scope.stop = -> $interval.cancel autoplayInt
	]

	link: (scope, el, attrs) ->
		scope.$slides = el.find '.slide'
		scope.max = scope.$slides.length || 1
]