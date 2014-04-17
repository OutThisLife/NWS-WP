app = angular.module 'app.directives', []

# Hover intent
app.directive 'ngHoverintent', ->
	restrict: 'A'
	scope: true
	link: (scope, el, attrs) ->
		require ['hoverintent'], ->
			set = (el, fn) -> el.add($ul)[fn]('over') if ($ul = el.find('> ul')).length is 1

			el.find('li').hoverIntent
				interval: 5
				timeout: 25
				over: -> set $(@), 'addClass'
				out: -> set $(@), 'removeClass'

# Reusable slideshow
app.directive 'ngSlideshow', ['$interval', ($interval) ->
	restrict: 'A'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1

		# Keep it in line
		$scope.$watch 'current', (nv) ->
			return unless nv?
			$scope.current = nv % $scope.max
	]

	# Set up the data for the controller to utilize.
	link: (scope, el, attrs) ->
		scope.max = el.find('.slide').length - 1

		# Autoplay?
		if attrs.autoplay?
			$interval ->
				scope.next()
			, attrs.autoplay
]