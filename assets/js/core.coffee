app = angular.module 'app', ['ngSanitize']

# Base variables
winObj = $(window)
docObj = $(document)
window.App = {}

$body = $('body, html')
$header = $('#header')
$footer = $('#footer')

# Helpful keycodes
RIGHT = 39
LEFT = 37
UP = 38
DOWN = 40
EXIT = 27

# Device testing
ua = navigator.userAgent
isMobile = ua.match /(Android|iPhone|BlackBerry|Opera Mini)/i
isTablet = ua.match /(iPad|Kindle)/i

# Get the 'proper' window height/width
winHeight = -> window.innerHeight || winObj.height()
winWidth = -> window.innerWidth || winObj.width()

# Resize + orientation change wrapper
winChange = (cb) -> winObj.bind 'resize load orientationchange', -> cb()

# Transition event names
_transitonEndNames = {
	WebkitTransition: 'webkitTransitionEnd'
	MozTransition: 'transitionend'
	OTransition: 'oTransitionEnd'
	msTransition: 'MSTransitionEnd'
	transition: 'transitionend'
}

_transitionEnd = _transitonEndNames[Modernizr.prefixed('transition')]

# Animation event names
_animationEndNames = {
	WebkitAnimation: 'webkitAnimationEnd'
	MozAnimation: 'animationend'
	OAnimation: 'oAnimationEnd'
	msAnimation: 'MSAnimationEnd'
	animation: 'animationend'
}

_animationEnd = _animationEndNames[Modernizr.prefixed('animation')]

### ----------------------------------------------- ###
# Controllers

# Main site controller
app.controller 'MainCtrl', ['$scope', ($scope) ->
	#
]

### ----------------------------------------------- ###
# Services/factories

### ----------------------------------------------- ###
# Directives

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

		hammer = scope.el.hammer()
		hammer.on 'swipeleft', -> scope.next()
		hammer.on 'swiperight', -> scope.prev()

		scope.goToSlide 0

### ----------------------------------------------- ###
# Filters