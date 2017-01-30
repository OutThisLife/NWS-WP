const
  gulp = require('gulp'),
  gutil = require('gulp-util'),
  notify = require('gulp-notify'),

  source = require('vinyl-source-stream'),
  buffer = require('vinyl-buffer'),

  sass = require('gulp-sass'),
  cssmin = require('gulp-cssmin'),
  sourcemaps = require('gulp-sourcemaps'),
  uglify = require('gulp-uglify'),
  fileinclude = require('gulp-file-include'),

  browserify = require('browserify'),
  watchify = require('watchify'),
  babel = require('babelify'),
  livereload = require('gulp-livereload')

// --------------------------------------------------

gulp.task('sass', () => {
	gulp.src('assets/css/main.sass')
	.pipe(sass().on('error', sass.logError))
	.pipe(cssmin())
	.pipe(gulp.dest('assets/css/dist'))
	.pipe(livereload())
})

gulp.task('browserify', (watch) => {
	const bundler = watchify(browserify('assets/js/main.js'), {
		debug: true
	}).transform(babel)

	const rebundle = () => {
		bundler.bundle()
		.on('error', (err) => {
			console.error(err)
		})
		.pipe(source('main.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init({
			loadMaps: true
		}))
		.pipe(gulp.dest('assets/js/dist'))
		.pipe(livereload())
	}

	bundler.on('update', () => {
		gutil.log('Rebundling')
		rebundle()
	})

	rebundle()
})

// --------------------------------------------------

gulp.task('default', () => {
	livereload.listen()

	gulp.run('browserify')
	gulp.watch(['assets/css/**/*.sass'], ['sass'])
})