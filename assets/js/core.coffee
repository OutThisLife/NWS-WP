app = angular.module 'app', ['ngSanitize']

# Base variables
winObj = angular.element window
docObj = angular.element document
window.App = {}

$body = angular.element 'body, html'
$header = angular.element '#header'
$footer = angular.element '#footer'

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

### ----------------------------------------------- ###
# Services/factories

### ----------------------------------------------- ###
# Directives

# Hover intent
app.directive 'ngHoverintent', ->
	restrict: 'EA'
	scope: true
	link: (scope, el, attrs) ->
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

		hammer = scope.el.hammer()
		hammer.on 'swipeleft', -> scope.next()
		hammer.on 'swiperight', -> scope.prev()

		scope.goToSlide 0

### ----------------------------------------------- ###
# Filters