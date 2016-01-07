gulp = require 'gulp'

watch = require 'gulp-watch'
concat = require 'gulp-concat'

sass = require 'gulp-sass'
coffee = require 'gulp-coffee'

uglify = require 'gulp-uglify'
cssmin = require 'gulp-cssmin'
imagemin = require 'gulp-imagemin'

livereload = require 'gulp-livereload'
runSequence = require 'run-sequence'

# -----------------------------------------------
# SASS/CSS

gulp.task 'sass', ->
	gulp.src 'assets/css/core.sass'
		.pipe sass()
		.pipe gulp.dest('assets/css')

gulp.task 'compile-css', ->
	gulp.src [
		'bower_components/materialize/dist/css/materialize.min.css',
		'assets/css/core.css'
	]
		.pipe concat('core.min.css')
		.pipe cssmin()
		.pipe gulp.dest('assets/css')
		.pipe livereload()

gulp.task 'do-css', -> runSequence 'sass', 'compile-css'

# -----------------------------------------------
# COFFEE/JS

gulp.task 'coffee', ->
	gulp.src ['assets/js/*.coffee']
		.pipe coffee()
		.pipe concat('all.js')
		.pipe gulp.dest('assets/js')

gulp.task 'compile-js', ->
	gulp.src [
		'bower_components/angular/angular.js',
		'bower_components/angular-touch/angular-touch.js',
		'bower_components/angular-sanitize/angular-sanitize.js',

		'assets/js/library/modernizr.js',
		'bower_components/lodash/lodash.js',
		'bower_components/materialize/js/waves.js',
		'bower_components/velocity/velocity.js',

		'assets/js/all.js',
	]
		.pipe concat('core.min.js')
		.pipe uglify()
		.pipe gulp.dest('assets/js')
		.pipe livereload()

gulp.task 'do-js', -> runSequence 'coffee', 'compile-js'

# -----------------------------------------------
# IMAGES

gulp.task 'imagemin', ->
	opts =
		progressive: true
		svgoPlugins: removeViewBox: false

	gulp.src 'assets/images/*'
		.pipe imagemin(opts)
		.pipe gulp.dest('assets/images')

# -----------------------------------------------
# EYE

gulp.task 'watch', ->
	livereload.listen()

	gulp.watch 'assets/js/*.coffee', ['do-js']
	gulp.watch 'assets/css/*.sass', ['do-css']
	gulp.watch ['*.php', '*/*.php'], livereload.reload