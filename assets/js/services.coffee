app = angular.module 'app.services', []

app.config ['$httpProvider', ($httpProvider) ->
	$httpProvider.defaults.transformRequest = (data) ->
		return data if data is undefined
		return jQuery.param data

	$httpProvider.defaults.headers.common["X-Request-With"] = 'XMLHttpRequest'
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8'
]

# ------------------------------------------------------------------

app.service '$xhr', ['$http', '$q', ($http, $q) ->
	fetch: (uri, method = 'GET', params = {}) ->
		deferred = $q.defer()

		config =
			method: method
			url: uri
			cache: false

		if method is 'POST'
			config.dataType = 'json'
			config.data = params

		x = $http config
		x.error (data, status) -> deferred.reject data, status

		x.success (response, status, headers, config) ->
			results = []
			results.data = response
			deferred.resolve results

		deferred.promise
]