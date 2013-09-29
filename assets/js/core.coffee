# Core Coffee
jQuery ($) ->
	# Base variables
	winObj = $(window)
	docObj = $(document)
	window.App = {}

	$body = $('body, html')
	$header = $('#header')
	$footer = $('#footer')
	
	easingType = 'easeInOutExpo'

	# Keycodes
	RIGHT = 39
	LEFT = 37
	UP = 38
	DOWN = 40
	EXIT = 27

	# Device testing
	ua = navigator.userAgent
	isMobile = ua.match /(Android|iPhone|BlackBerry|Opera Mini)/i
	isTablet = ua.match /(iPad|Kindle)/i

	# Get the 'proper' window height
	winHeight = -> window.innerHeight || winObj.height()
	winWidth = -> window.innerWidth || winObj.width()

	# Smart resize + orientation change wrapper]
	winChanges = []
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

	###
		Section jumping via window.app
	###
	window.App.goTo = (el) ->
		el = $(el)

		o = $header.outerHeight()
		o = 0 if isMobile

		$body.stop(1, 1).animate
			scrollTop: el.offset().top - o
		, 800, easingType

	###
		Get an elements propertie
	###
	getItemProp = (el) ->
		scrollT = winObj.scrollTop()
		scrollL = winObj.scrollLeft()
		o = el.offset()

		return {
			left: o.left - scrollL
			top: o.top - scrollT
			width: el.outerWidth()
			height: el.outerHeight()
		}

	### ----------------------------------------------- ###

	###
		Homepage Slideshow
	###
	class Slideshow
		constructor: (@$slideshow) ->
			@$slides = @$slideshow.find '.slide'

			@max = @$slides.length
			@current = 0

		# Automates our slideshow
		autoplay: ->
			return if @max is 0
			@interval = setInterval =>
				@next()
			, @$slideshow.data().speed
			@

		clear: -> clearInterval @interval

		# Quickly takes us to a slide
		goToSlide: (i) ->
			@clear() if @interval?
			i = i % @max

			@$slides.removeClass 'active'
			@$slides.eq(i).addClass 'active'

			if @$navA?
				@$navA.removeClass 'active'
				@$navA.eq(i).addClass 'active'

			@current = i
			@autoplay()
			@

		next: -> @goToSlide @current + 1
		prev: -> @goToSlide @current - 1

		# Build and bind the pager systems
		buildPager: ->
			return unless (@$nav = @$slideshow.find('[data-pager]')).length is 1
			@$nav.append '<a href="javascript:;" />' for i in [0..@max-1]

			@$navA = @$nav.find 'a'
			@$navA.on 'click tap', (e) => @goToSlide $(e.target).index()
			@

	$('[data-slideshow]').each -> new Slideshow $(@)

	### ----------------------------------------------- ###

	###
		Do all winChanges in one go
	###
	winChange -> cb() for cb in winChanges