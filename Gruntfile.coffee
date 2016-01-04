module.exports = (grunt) ->
	grunt.initConfig
		pkg: grunt.file.readJSON('package.json'),

		# SASS
		sass: dist:
			options:
				style: 'compressed'
				trace: true

			files: 'assets/css/core.css': 'assets/css/*.sass'

		# COFFEE
		coffee: compile: files: 'assets/js/app.js': 'assets/js/*.coffee'

		# UGLIFYJS
		uglify: my_target: files: 'assets/js/app.min.js': [
			'bower_components/angular/angular.min.js',
			'bower_components/angular-touch/angular-touch.min.js',
			'bower_components/angular-sanitize/angular-sanitize.min',

			'assets/js/library/modernizr.min.js',
			'bower_components/lodash/lodash.min.js',
			'bower_components/materialize/js/waves.js',
			'bower_components/velocity/velocity.js',

			'assets/js/app.js',
		]

		# CSSMIN
		cssmin: target: files: 'assets/css/core.min.css': [
			'bower_components/materialize/dist/css/materialize.min.css',
			'assets/css/*.css',
		]

		# WATCHER
		watch:
			css:
				files: '**/*.sass'
				tasks: ['sass', 'cssmin']
				options: livereload: 35729

			js:
				files: '**/*.coffee'
				tasks: ['coffee', 'uglify']
				options: livereload: 35729

			php:
				files: ['**/*.php']
				options: livereload: 35729

	grunt.loadNpmTasks 'grunt-contrib-sass'
	grunt.loadNpmTasks 'grunt-contrib-watch'
	grunt.loadNpmTasks 'grunt-contrib-coffee'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-cssmin'

	grunt.registerTask 'default', ['watch']
	grunt.registerTask 'snap', ['htmlSnapshot']