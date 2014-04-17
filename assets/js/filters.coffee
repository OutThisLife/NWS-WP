app = angular.module 'app.filters', []

# Newline to <br />
app.filter 'nl2br', -> (text) -> text.replace /\n/g, '<br />' if text?