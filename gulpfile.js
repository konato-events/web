var gulp     = require('gulp');
var elixir   = require('laravel-elixir');
var semantic = {
  watch: require('./resources/assets/semantic/tasks/watch'),
  build: require('./resources/assets/semantic/tasks/build')
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('watch-ui', semantic.watch);
gulp.task('build-ui', semantic.build);

elixir(function(mix) {
  mix.task('build-ui');
});