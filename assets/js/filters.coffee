app = angular.module 'app.filters', []

# ------------------------------------------------------------------

app.filter 'trust', ['$sce', ($sce) ->
	(src) -> $sce.trustAsResourceUrl src
]

# ------------------------------------------------------------------

app.filter 'nl2br', -> (text) -> text.replace /\n/g, '<br />' if text?

# ------------------------------------------------------------------

app.filter 'reverse', -> (obj) -> obj.slice().reverse()

# ------------------------------------------------------------------

app.filter 'objLength', -> (obj) ->
	i = 1
	i++ for z of obj
	i

# ------------------------------------------------------------------

app.filter 'parseUrl', ->
	pattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/gi

	(text, target = '_blank') ->
		angular.forEach text.match(pattern), (url) ->
			text = text.replace url, "<a target=#{target} href=#{url}>#{url}</a>"
		text