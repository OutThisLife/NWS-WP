app = angular.module 'app.directives', []

# Hover intent
app.directive 'ngHoverintent', ->
	restrict: 'A'
	scope: true
	link: (scope, el, attrs) ->
		require ['hoverintent'], ->
			set = (el, fn) -> el.add($ul)[fn]('over') if ($ul = el.find('> ul')).length is 1

			el.find('li').hoverIntent
				timeout: 200
				over: -> set $(@), 'addClass'
				out: -> set $(@), 'removeClass'

# Reusable slideshow
app.directive 'ngSlideshow', ->
	restrict: 'A'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1
	]

	# Set up the data for the controller to utilize.
	link: (scope, el) ->
		scope.el = $(el)
		scope.current = 0
		scope.max = $(el).find('figure').length

		require ['hammer'], ->
			hammer = scope.el.hammer()
			hammer.on 'swipeleft', -> scope.next()
			hammer.on 'swiperight', -> scope.prev()