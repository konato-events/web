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

  //TODO: enable this only in production environment, and only if needed
  //use something like this in the template file: <script src="{{ elixir('js/app.js') }}"></script>
  //mix.version(['css/styles.css', 'js/app.js']);
});