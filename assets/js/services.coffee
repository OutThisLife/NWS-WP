app = angular.module 'app.services', []

app.service '$pages', ['$http', '$q', '$location', ($http, $q, $location) ->
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

			deferred.resolve results

		.error (data, status) -> deferred.reject data, status

		deferred.promise
]