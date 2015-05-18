app = angular.module 'app.directives', []

raf = (-> (
	window.requestAnimationFrame or window.webkitRequestAnimationFrame or window.mozRequestAnimationFrame or window.oRequestAnimationFrame or window.msRequestAnimationFrame or (callback) -> window.setTimeout callback, 1
))()

# ------------------------------------------------------------------

app.directive 'qScope', -> scope: true

# ------------------------------------------------------------------

app.directive 'slideshow', ['$interval', ($interval) ->
	restrict: 'E'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1

		$scope.$watch 'current', (nv, ov) ->
			return unless nv?
			return if nv is ov

			nv = 0 if nv > $scope.max - 1
			nv = $scope.max - 1 if nv < 0
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