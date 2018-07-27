// GRUNT
module.exports = function(grunt) {

	// directories
	let dir = {
		'theme': '/wp-content/themes/NewReach',
		'sassy': {
			'dev': '/assets/sassy/',
			'prod': '/assets/css/',
		},
		'js': {
			'dev': '/assets/js/dev/',
			'prod': '/assets/js/',
		},
	}

	// configure tasks
	grunt.initConfig({

		// settings
		pkg: grunt.file.readJSON('package.json'),

		// copy
		copy: {
			dist: {
				src: 'readme.txt',
				dest: 'README.md'
			}
        },

        // GOOGLE FONTS
		/*curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?key=*******',
				dest: 'assets/vendor/google-fonts-source.json'
			}
		}*/

		// localization
		makepot: {
			target: {
				options: {
					include: [
						'path/to/some/file.php'
					],
					type: 'wp-theme' // `wp-theme` or `wp-plugin`
				}
			}
		},

		// JS LINT
		jshint: {
			files: [
				'assets/js/filename.js',
				'assets/dynamic/paths/**/*.js'
			],
			options: {
				expr: true,
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},

		// SASS
		sass: {
			dist: {
				options: {
					banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.css <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
					style: 'compressed'
				},
				files: [{
					expand: true,
					cwd: 'assets/scss',
					src: [
						'*.scss'
					],
					dest: 'assets/css',
					ext: '.min.css'
				}]
			},
			dev: {
				options: {
					banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.css <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
					style: 'expanded'
				},
				files: [{
					expand: true,
					cwd: 'assets/scss',
					src: [
						'*.scss'
					],
					dest: 'assets/css',
					ext: '.css'
				}]
			}
		},

		// JS MINIFY
		uglify: {
			dist: {
				options: {
					banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
					report: 'gzip'
				},
				files: {
					'assets/js/filename.min.js' : [
						'assets/path/to/file.js',
						'assets/path/to/another/file.js',
						'assets/dynamic/paths/**/*.js'
					]
				}
			},
			dev: {
				options: {
					banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
					beautify: true,
					compress: false,
					mangle: false
				},
				files: {
					'assets/js/filename.js' : [
						'assets/path/to/file.js',
						'assets/path/to/another/file.js',
						'assets/dynamic/paths/**/*.js'
					]
				}
			}
		},

		// watch tasks
		watch: {
			// JS
			js: {
				files: 'path/to/sass/*.less',
				tasks: [
					'uglify',
					'jshint'
				]
			},
			// SASS
			sass: {
				files: 'path/to/sass/*.less',
				tasks: 'sass'
			}
		},

	});

	// load tasks
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	//grunt.loadNpmTasks('grunt-curl');
	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// register tasks
	grunt.registerTask('default', [
		'jshint',
		'uglify:dev',
		'uglify:dist',
		'sass:dev',
		'sass:dist',
		'makepot',
		'copy'
	]);
	// google fonts
	/*grunt.registerTask('googlefonts', [
		'curl:google-fonts-source'
	]);*/

}


