var gulp     = require('gulp');
var elixir   = require('laravel-elixir');
var semantic = {
	watch: require('./public/semantic/tasks/watch'),
	build: require('./public/semantic/tasks/build')
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

elixir(function(mix) {
    //mix.sass('app.scss');
});

gulp.task('watch ui', semantic.watch);
gulp.task('build ui', semantic.build);