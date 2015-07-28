app = angular.module 'app.directives', []

$body = angular.element 'body, html'
winObj = angular.element window

raf = (-> (
	window.requestAnimationFrame or window.webkitRequestAnimationFrame or window.mozRequestAnimationFrame or window.oRequestAnimationFrame or window.msRequestAnimationFrame or (callback) -> window.setTimeout callback, 1
))()

# ------------------------------------------------------------------

app.directive 'qScope', -> scope: true

# ------------------------------------------------------------------

app.directive 'ngHoverintent', ->
	restrict: 'A'
	scope: true
	link: (scope, el, attrs) ->
		require ['library/hoverIntent'], ->
			set = (el, fn) -> el.add($ul)[fn]('over') if ($ul = el.find('> ul')).length is 1

			el.find('li').hoverIntent
				interval: 5
				timeout: 100
				over: -> set $(@), 'addClass'
				out: -> set $(@), 'removeClass'

# ------------------------------------------------------------------

app.directive 'slideshow', ['$interval', ($interval) ->
	restrict: 'E'
	scope: true
	controller: ['$scope', ($scope) ->
		$scope.next = -> $scope.current += 1
		$scope.prev = -> $scope.current -= 1

		$scope.$watch 'current', (nv, ov) ->
			return unless nv?
			return if ov is nv

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

# ------------------------------------------------------------------

app.directive 'scrollFire', ->
	restrict: 'A'
	scope: false
	link: (scope, el, attrs) ->
		el.on 'inview', (e, visible, x, y) ->
			if visible
				el.removeClass('invisible').addClass 'animated fadeInDown'

		scope.$on '$destroy', -> el.unbind 'inview'

# ------------------------------------------------------------------

app.directive 'bgParallax', ['$timeout', ($timeout) ->
	restrict: 'A'
	scope: false
	link: (scope, el, attrs) ->
		setBgPos = ->
			pos = winObj.scrollTop()
			offset = el.offset().top
			diff = pos - offset

			calc = diff * .8
			bg = "center #{calc}px"

			el.css backgroundPosition: bg

		$timeout setBgPos
		winObj.on 'scroll.bp touchmove.bp', setBgPos
		scope.$on '$destroy', -> winObj.unbind 'scroll.bp touchmove.bp'
]

# ------------------------------------------------------------------

app.directive 'fadeParallax', ['$timeout', ($timeout) ->
	restrict: 'A'
	scope: false
	link: (scope, el, attrs) ->
		setFade = -> el.css opacity: 1 - (winObj.scrollTop() / 500)

		$timeout setFade
		winObj.on 'scroll.fp touchmove.fp', setFade
		scope.$on '$destroy', -> winObj.unbind 'scroll.fp touchmove.fp'
]