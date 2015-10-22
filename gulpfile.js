var gulp     = require('gulp');
var elixir   = require('laravel-elixir');

elixir(function(mix) {
  mix.less([
    'theme-basic.less',
    'theme-konato.less',
    '*.less'
  ], 'public/css/styles.css');

  //mix.styles([
  //  '../../../public/css/theme-basic.css',
  //  '../../../public/css/theme-main.css'
  //], 'public/css/styles.css');

  mix.coffee([
    '*.coffee'
  ], 'public/js/app.js');

  //TODO: enable this only when running `gulp --production`, include `gulp --production` in Heroku build procedure, and ignore build dir/rev-manifest from repository (maybe ignore CSS/JS dev versions as well?)
  //FIXME: ugly enough, although we can reference a custom folder as second argument, it's not used by the PHP helper yet
  //use something like this in the template file: <script src="{{ elixir('js/app.js') }}"></script>
  mix.version(['css/styles.css', 'js/app.js']);
});
