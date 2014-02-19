app = angular.module 'app.services', []

# Fetch a page by uri
app.service '$pages', ['$http', '$q', '$location', ($http, $q, $location) ->
	# Fetch a page by its URI
	fetch: (uri) ->
		deferred = $q.defer()

		$http 
			method: 'POST'
			url: uri
			cache: true
			headers: 
				'REQUEST_WITH': 'xmlhttprequest'

		.success (response, status, headers, config) ->
			results = []
			results.data = response
			results.headers = headers()

			# Set our new 'history' result
			$location.path uri.replace /^(?:\/\/|[^\/]+)*\//, ''
			$location.absUrl uri
			window.document.title = results.headers['title']

			# Resolve
			deferred.resolve results

		.error (data, status) -> deferred.reject data, status

		deferred.promise
]