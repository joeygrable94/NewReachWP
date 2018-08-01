// GRUNT
module.exports = function(grunt) {

	// directories
	var themeName = 'newreach';
	var theme = {
		root: './wp-content/themes/' + themeName
	};
	// development
	var dev	= {
		root: './dev_stack',
		sass: '/SASSy/src/sass',
		css: '/css',
		js: '/js',
		vendors: '/vendors'
	};
	// production
	var dist = {
		root: theme.root+'/assets',
		css: '/css',
		images: '/images',
		js: '/js'
	};

	// initial config
	grunt.initConfig({

		// load package
		pkg: grunt.file.readJSON('package.json'),

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

		// compile, convert & compress sass
		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				files: [{
					expand: true,
					cwd: dev.root+dev.sass,
					src: ['*.scss'],
					dest: dev.root+dev.css,
					ext: '.dev.css'
				}]
			},
			dist: {
				options: {
					style: 'compressed'
				},
				files: [{
					expand: true,
					cwd: dev.root+dev.sass,
					src: ['*.scss'],
					dest: dist.root+dist.css,
					ext: '.min.css'
				}]
			}
		},

		// lint JS for errors
		jshint: {
			files: [
				'gruntfile.js',
				dev.root+dev.js+'/vendors/*.js',
				dev.root+dev.js+'/src/*.js',
				dev.root+dev.js+'/test/*.js',
			],
			options: {
				esversion: 6,
				globals: {
					jQuery: true
				}
			}
		},

		// concat all js files
		concat: {
			options: {
				separator: '\n\n\n\n\n/** ================================================== **/\n'
			},
			dist: {
				src: [
					dev.root+dev.js+'/vendors/*.js',
					dev.root+dev.js+'/src/*.js',
					dev.root+dev.js+'/test/*.js',
				],
				dest: dev.root+dev.js+'/concatenated/'+themeName+'.js'
			}
		},

		// convert JS ES6 to ES5 compatible
		babel: {
			options: {
				sourceMap: true,
				presets: ['env']
			},
			dist: {
				files: [{
					expand: true,
					cwd: dev.root+dev.js+'/concatenated',
					src: ['**/*.js'],
					dest: dev.root+dev.js+'/compiled',
					ext: '.compiled.js'
				}]
			}
		},

		// compress JS
		uglify: {
			options: {
				mangle: true
			},
			build : {
				src : [
					dev.root+dev.js+'/compiled/'+themeName+'.compiled.js'
				],
				dest: dist.root+dist.js+'/'+themeName+'.min.js',
			}
		},

		// watcher
		watch: {
			css: {
				files: [dev.root+dev.sass+'/**/*.scss'],
				tasks: ['sass']
			},
			js: {
				files: [dev.root+dev.js+'/**/*.js'],
				tasks: ['jshint', 'concat', 'babel']
			}
		}

	});

	// load plugins
	require('load-grunt-tasks')(grunt);
	grunt.loadNpmTasks('grunt-babel');

	// register tasks
	grunt.registerTask('default', [
		'sass',
		'jshint',
		'concat',
		'babel',
		'uglify'
	]);

};