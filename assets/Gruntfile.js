module.exports = function(grunt){
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		browserify: {
			dist: {
				files: {'scripts/js/dist/allscripts.js': 'scripts/js/src/**/*.js'},
				options: {
					transform: [['babelify', {presets: ['env']}]], 
					browserifyOptions: {
						debug: true
					}
				}
			}
		},
		concat:{
			options:{
				separator: ';',
				banner: '/* <%= pkg.name %> ' + '<%=grunt.template.today("yyyy-mm-dd hh:mm:ss") %> */',
			},
			dist: {
				src: ['scripts/js/src/**/*.js'],
				dest: 'scripts/js/dist/allscripts.js',
			},
		},
		uglify: {
			options:{
				banner: '/* <%= pkg.name %>.min ' + '<%=grunt.template.today("yyyy-mm-dd hh:mm:ss") %> */',
				ie8: true,
			},
			dist: {
				files: {
					'scripts/js/dist/allscripts.min.js': ['scripts/js/dist/allscripts.js'],
				}
			}
		},
		sass: {
			options: {
				style: 'compressed',	
			},
			dist: {
				files: {
					'styles/dist/allstyles.css': 'styles/allstyles.scss',
				}
			}
		}, 
		jshint: {
			files: ['Gruntfile.js', 'scripts/js/src/**/*.js', ],
			options: {
				globals: {
					jQuery: true, 
					console: true, 
					module: true, 
					document: true
				}
			}
		},
		watch: {
			files: ['<%=jshint.files%>', 'styles/allstyles.scss', 'styles/src/**/*.scss'],
			tasks: ['jshint', 'browserify:dist', 'sass']
		}
	});

	grunt.loadNpmTasks('grunt-contrib-concat');	
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-babel');
	grunt.loadNpmTasks('grunt-browserify');

	grunt.registerTask('default', ['jshint', 'browserify:dist', 'uglify', 'sass']);
	
};