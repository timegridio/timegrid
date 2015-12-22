var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');

    mix.scripts([
        './bower_components/jquery/dist/jquery.min.js',
        './bower_components/bootstrap/dist/js/bootstrap.min.js',
        './bower_components/tooltipster/js/jquery.tooltipster.min.js'
    ], 'public/js/app.js');

    mix.styles([
        './bower_components/tooltipster/css/themes/tooltipster-light.css',
        './bower_components/tooltipster/css/tooltipster.css',
        './bower_components/animate.css/animate.min.css',
    ], 'public/css/styles.css');

});
