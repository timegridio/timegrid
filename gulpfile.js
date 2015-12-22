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

    mix.copy([
        './bower_components/bootstrap-select/dist/js/i18n/*.min.js',
    ], 'public/js/bootstrap-select/i18n');

    mix.scripts([
        './bower_components/bootstrap-select/dist/js/bootstrap-select.min.js',
    ], 'public/js/forms.js');

    mix.styles([
        './bower_components/tooltipster/css/themes/tooltipster-light.css',
        './bower_components/tooltipster/css/tooltipster.css',
        './bower_components/animate.css/animate.min.css',
    ], 'public/css/styles.css');

    mix.styles([
        './bower_components/bootstrap-select/dist/css/bootstrap-select.min.css',
    ], 'public/css/forms.css');

});
