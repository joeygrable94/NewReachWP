// GRUNT
module.exports = function(grunt) {

	// directories
	let theme	= {
		root: '/wp-content/themes/NewReach'
	};
	// development
	let dev		= {
		root: '/dev_stack',
		sass: '/sassy',
		js: '/js',
		vendors: '/vendors'
	};
	// production
	let dist	= {
		root: theme.root + theme.name'/assets',
	};

	console.log(theme);

	// configure tasks
	grunt.initConfig({

		// settings
		pkg: grunt.file.readJSON('package.json'),

		// copy
		/*copy: {
			dist: {
				src: 'readme.txt',
				dest: 'README.md'
			}
        },*/

        // GOOGLE FONTS
		/*curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?key=*******',
				dest: 'assets/vendor/google-fonts-source.json'
			}
		}*/

		// localization
		/*makepot: {
			target: {
				options: {
					include: [
						'path/to/some/file.php'
					],
					type: 'wp-theme' // `wp-theme` or `wp-plugin`
				}
			}
		},*/

		// JS LINT
		/*jshint: {
			files: [
				'assets/js/filename.js',
				'assets/dynamic/paths/**//*.js' ################### FIX PATH
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
		},*/

		// SASS
		/*sass: {
			dist: {
				options: {
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
					report: 'gzip'
				},
				files: {
					'assets/js/filename.min.js' : [
						'assets/path/to/file.js',
						'assets/path/to/another/file.js',
						'assets/dynamic/paths/**//*.js' ################### FIX PATH
					]
				}
			},
			dev: {
				options: {
					beautify: true,
					compress: false,
					mangle: false
				},
				files: {
					'assets/js/filename.js' : [
						'assets/path/to/file.js',
						'assets/path/to/another/file.js',
						'assets/dynamic/paths/**//*.js' ################### FIX PATH
					]
				}
			}
		},*/

		// watch tasks
		/*watch: {
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
		},*/

	});

	// load tasks
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-curl');
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


