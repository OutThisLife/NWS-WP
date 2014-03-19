app = angular.module 'app.controllers', []

winObj = $(window)

$body = $('html, body')
$container = $('#container')

# Main site controller
app.controller 'MainCtrl', ['$scope', '$timeout', '$compile', '$pages', ($scope, $timeout, $compile, $pages) ->
	###
		Style helpers to use around the site
	###

	# Transform prefix
	$scope.transform = (-> 
		prefix = Modernizr.prefixed 'transform'
		prefix = prefix.replace /([A-Z])/g, (str, m1) -> "-#{m1.toLowerCase()}"
		prefix.replace /^ms-/, '-ms-'
	)($scope.transform)

	# Dimensions we will use, everywhere.
	setDimensions = ->
		$scope.$apply ->
			$scope.winWidth = winObj.width()
			$scope.winHeight = winObj.height()
			$scope.scrollTop = winObj.scrollTop()
			$scope.scrollLeft = winObj.scrollLeft()

	# Square it up.
	$scope.sq = -> {
		width: $scope.winWidth
		height: $scope.winHeight
	}

	$timeout -> setDimensions()
	winObj.on 'scroll resize orientationchange', setDimensions

	# Set the very basic mobile menu variables
	$scope.mobile = {}

	# Toggle the mobile status
	$scope.mobile.toggle = -> $scope.mobile.status = if $scope.mobile.status is 'closed' then 'open' else 'closed'
	$('#content').on 'click touchend', -> $scope.$apply -> $scope.mobile.status = 'closed'

	## -- ##

	###
		Setup page fetching (remove if un-needed)
	###
	$page = $('#page')

	$scope.goToPage = (uri) ->
		$pages.fetch(uri).then (response) ->
			$page.empty().append response.data
			$compile($page.contents())($scope)

	$scope.$on '$locationChangeSuccess', (e, newUrl) -> $scope.goToPage newUrl

	# Bind all links to utilize goToPage
	$body.on 'click tap', '[href][target!="_blank"][href!="javascript:;"]', (e) ->
		el = $(e.target)
			
		if el.is 'a'
			$a = el

		else $a = el.parents 'a'

		href = $a.attr 'href'

		return unless href?
		return if href.match /mailto/
		return if /\.(?:jpg|jpeg|gif|png)$/i.test href
		return unless href.match location.origin

		e.preventDefault()
		e.stopPropagation()

		$scope.goToPage href

	# Go ahead and start caching all pages
	$timeout ->
		$('#header [href]').each ->
			href = $(@).attr 'href'
			return unless href.match location.origin
			
			$pages.fetch href, false
]