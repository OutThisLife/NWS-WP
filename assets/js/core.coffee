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
	isMobile = ua.match(/(Android|iPhone|BlackBerry|Opera Mini)/i)
	isTablet = ua.match(/(iPad|Kindle)/i)

	# Get the 'proper' window height
	winHeight = -> window.innerHeight || winObj.height()
	winWidth = -> window.innerWidth || winObj.width()

	# Smart resize + orientation change wrapper
	winChange = (cb) ->
		winObj.resize -> cb()
		winObj.bind 'orientationchange', -> cb()

	###
		Homepage Slideshow
	###
	if ($slideshow = $('#slideshow')).length is 1
		class Slideshow
			constructor: ->
				@$slideshow = $slideshow
				@$slides = @$slideshow.find('.slide')

				@max = @$slides.length - 1
				@current = 0

			# Automates our slideshow
			autoplay: ->
				return if @max is 0
				@interval = setInterval =>
					@next()
				, 6000
				@

			clear: -> clearInterval @interval

			# Quickly takes us to a slide
			goToSlide: (i) ->
				@clear() if @interval?
				i = 0 if i > @max
				i = @max if i < 0

				@$slides.removeClass('active')
				@$slides.eq(i).addClass('active')

				if @$navA?
					@$navA.removeClass('active')
					@$navA.eq(i).addClass('active')

				@current = i
				@autoplay()
				@

			next: -> @goToSlide @current + 1
			prev: -> @goToSlide @current - 1

			# Build and bind the pager systems
			buildPager: ->
				@$nav = $('#slidePager')
				@$nav.append('<a href="javascript:;" />') for i in [0..@max]
				@$navA = @$nav.find('a')

				@$navA.on 'click tap', (e) => @goToSlide $(e.target).index()
				@

		SS = new Slideshow
		SS.goToSlide 0