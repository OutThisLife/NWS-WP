module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		sass: {
			options: {
				style: 'compressed'
			},

			all: {
				expand: true,
				cwd: './assets/css/',
				src: ['*.sass'],
				dest: './assets/css/',
				ext: '.css'
			}
		},

		coffee: {
			all: {
				expand: true,
				flatten: true,
				cwd: './assets/js/',
				src: ['*.coffee'],
				dest: './assets/js/',
				ext: '.js'
			}
		},

		uglify: {
			options: {
				mangle: true
			},

			all: {
				expand: true,
				cwd: './assets/js/',
				src: ['*.js'],
				dest: './assets/js/',
				ext: '.js'
			}
		},

		watch: {
			css: {
				files: ['./assets/css/*.sass'],
				tasks: ['sass']
			},

			coffee: {
				files: ['./assets/js/*.coffee'],
				tasks: ['coffee']
			},

			js: {
				files: ['./assets/js/*.js'],
				tasks: ['newer:uglify']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-newer');

	grunt.registerTask('default', ['watch', 'sass', 'coffee', 'uglify']);
}