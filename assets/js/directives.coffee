app = angular.module 'app.directives', []

# Hover intent
app.directive 'ngHoverintent', ->
	restrict: 'EA'
	scope: true
	link: (scope, el, attrs) ->
		require ['hoverintent'], ->
			el.find('li').hoverIntent
				timeout: attrs.timeout
				
				over: ->
					el = $(@)
					el.add($ul).addClass 'over' if ($ul = el.find('> .sub-menu')).length is 1

				out: ->
					el = $(@)
					el.add($ul).removeClass 'over' if ($ul = el.find('> .sub-menu')).length is 1

# Reusable slideshow
app.directive 'ngSlideshow', ->
	restrict: 'EA'
	scope: true
	controller: ['$scope', ($scope) ->
		# Go to a specific slide
		$scope.goToSlide = (i) ->
			i = i % $scope.max
			return if i is $scope.current

			$slide = $scope.$slides.eq i
			$curSlide = $scope.$slides.eq $scope.current

			# Make previous slides accessible
			if i < $scope.current and $scope.current isnt $scope.max - 1 or $scope.current < i and i is 0
				$curSlide.attr 'class', 'slide active next'
				$slide.attr 'class', 'noanim slide previous'

			# Make the next slide accessible.
			else
				$curSlide.attr 'class', 'slide active previous'
				$slide.attr 'class', 'noanim slide next'

			clearTimeout $scope.intWait
			$scope.intWait = setTimeout =>
				$slide.removeClass 'noanim'

				$curSlide.removeClass 'active'
				$slide.addClass 'active'
			, 100

			$scope.current = i

		$scope.next = -> $scope.goToSlide $scope.current + 1
		$scope.prev = -> $scope.goToSlide $scope.current - 1

	]

	# Set up the data for the controller to utilize.
	link: (scope, el, attr) ->
		scope.el = el
		scope.$slides = el.find '.slide'

		scope.max = scope.$slides.length
		scope.current = -1

		require ['hammer'], ->
			hammer = scope.el.hammer()
			hammer.on 'swipeleft', -> scope.next()
			hammer.on 'swiperight', -> scope.prev()

		scope.goToSlide 0