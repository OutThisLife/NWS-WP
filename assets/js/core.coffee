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
# Require JS config.
requirejs.config
	paths:
		# CDN powered
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.min']
		jquery: ['//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min']
		hammer: ['//cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.5/jquery.hammer.min']

		# Local
		controllers: ['/wp/wp-content/themes/NWS-WP/assets/js/controllers']
		services: ['/wp/wp-content/themes/NWS-WP/assets/js/services']
		directives: ['/wp/wp-content/themes/NWS-WP/assets/js/directives']
		filters: ['/wp/wp-content/themes/NWS-WP/assets/js/filters']
		hoverintent: ['/wp/wp-content/themes/NWS-WP/assets/js/library/hoverIntent']

	shim: 
		angular: exports: 'angular'
		controllers: ['angular']
		services: ['angular']
		directives: ['angular']
		filters: ['angular']
		hoverintent: ['jquery']

	priority: ['angular']

require ['jquery', 'angular', 'controllers', 'directives'], ($, ajs) ->
	ajs.module 'app', [
		'app.controllers',
		'app.directives'
	]