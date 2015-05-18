app = angular.module 'app.directives', []

raf = (-> (
	window.requestAnimationFrame or window.webkitRequestAnimationFrame or window.mozRequestAnimationFrame or window.oRequestAnimationFrame or window.msRequestAnimationFrame or (callback) -> window.setTimeout callback, 1
))()

# ------------------------------------------------------------------

app.directive 'qScope', -> scope: true