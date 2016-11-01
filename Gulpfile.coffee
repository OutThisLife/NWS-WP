source = require 'vinyl-source-stream'
buffer = require 'vinyl-buffer'

gulp = require 'gulp'
gulpif = require 'gulp-if'
sass = require 'gulp-sass'
gutil = require 'gulp-util'
uglify = require 'gulp-uglify'
cssmin = require 'gulp-cssmin'
imagemin = require 'gulp-imagemin'
rename = require 'gulp-rename'

browserify = require 'browserify'
babelify = require 'babelify'
watchify = require 'watchify'

livereload = require 'gulp-livereload'

# -----------------------------------------------

buildScript = (watch) ->
	props = {
		entries: ['assets/js/main.js']
		debug: false
		transform: [babelify.configure({
			presets: ['es2015', 'react']
		})]
	}

	bundler = browserify props
	bundler = watchify bundler if watch

	rebundle = ->
		stream = bundler.bundle()

		stream
			.on 'error', (e) -> console.log e.message
			.pipe source('main.js')
			.pipe buffer()
			.pipe uglify()
			.pipe rename('bundle.js')
			.pipe gulp.dest('assets/js')
			.pipe livereload()

	bundler.on 'update', ->
		rebundle()
		gutil.log 'Rebundle...'

	rebundle()

# -----------------------------------------------

gulp.task 'sass', ->
	gulp.src 'assets/css/main.sass'
		.pipe sass().on('error', sass.logError)
		.pipe rename('bundle.css')
		.pipe cssmin()
		.pipe gulp.dest('assets/css')
		.pipe livereload()

gulp.task 'js', -> buildScript false

gulp.task 'images', ->
	gulp.src('assets/img/*.{jpg,png}')
		.pipe imagemin({
			progressive: true
		})
		.pipe gulp.dest('assets/img')
		.pipe livereload()

gulp.task 'htmlphp', -> gulp.src(['*.php', '*.html']).pipe livereload()

# -----------------------------------------------

gulp.task 'default', ->
	livereload.listen()
	buildScript true

	gulp.watch ['assets/css/**/*.sass'], ['sass']
	gulp.watch ['*.php', '*.html'], ['htmlphp']