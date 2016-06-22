module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        // define a string to put between each file in the concatenated output
        //separator: '; '
      },
      js: {
        // the files to concatenate
        src: [
          //'node_modules/bootstrap/dist/js/**/*.js',
          'js/src/**/*.js'
        ],
        // the location of the resulting JS file
        dest: 'js/<%= pkg.name %>.js'
      },
    },
    uglify: {
      options: {
        // the banner is inserted at the top of the output
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      js: {
        files: {
          'js/<%= pkg.name %>.min.js': ['<%= concat.js.dest %>']
        }
      },
    },
    less:{
      development:{
        files:{
          "css/<%= pkg.name %>.css" : "less/style.less"
        }
      },
    },
    cssmin: {
      css:{
        src: 'css/<%= pkg.name %>.css',
        dest: 'css/<%= pkg.name %>.min.css'
      }
    },
    watch:{
      css:{
        files: ['less/**/*.less'],
        tasks: ['less', 'cssmin', 'shell:clearStyle'],
      },
      js:{
        files: ['js/src/**/*.js'],
        tasks: ['concat', 'uglify', 'shell:clearStyle'],
      },
      templates:{
        files: ['**/*.php', 'preprocess/**/*.php'],
        tasks: ['shell:clearRegistry']
      }
    },
    shell:{
      options:{
        stderr: true
      },
      clearStyle:{
        command: 'drush cc css-js; notify-send "CSS/JS cache cleared."'
      },
      clearRegistry:{
        command: 'drush cc registry; drush cc theme-registry; notify-send "Registry cache cleared."'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-css');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', ['concat', 'uglify', 'less', 'cssmin', 'shell']);


};
