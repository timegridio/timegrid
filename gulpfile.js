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

    mix.copy([
        './bower_components/AdminLTE/plugins/iCheck/square/*.png',
    ], 'public/css/iCheck/');

    mix.styles([
        './bower_components/AdminLTE/plugins/iCheck/square/blue.css'
    ], 'public/css/iCheck/icheck.min.css');

    mix.scripts([
        './bower_components/AdminLTE/plugins/iCheck/icheck.min.js',
    ], 'public/js/iCheck/icheck.min.js');

    mix.styles([
        './bower_components/bootstrap/dist/css/bootstrap.min.css',
        './bower_components/AdminLTE/dist/css/AdminLTE.css',
        './bower_components/AdminLTE/dist/css/skins/skin-blue.css',
        './bower_components/AdminLTE/plugins/iCheck/square/blue.css'
    ], 'public/css/app.min.css');

    mix.scripts([
        './bower_components/jquery/dist/jquery.min.js',
        './bower_components/AdminLTE/plugins/iCheck/icheck.min.js',
        './bower_components/bootstrap/dist/js/bootstrap.min.js',
        './bower_components/AdminLTE/dist/js/app.min.js',
        './bower_components/tooltipster/js/jquery.tooltipster.min.js'
    ], 'public/js/app.min.js');

    mix.styles([
        // './bower_components/bootstrap/dist/css/bootstrap.min.css',
        './bower_components/tooltipster/css/themes/tooltipster-light.css',
        './bower_components/tooltipster/css/tooltipster.css',
        './bower_components/animate.css/animate.min.css',
    ], 'public/css/styles.css');

    // News Helpers

    mix.scripts([
        './bower_components/jquery-bootstrap-newsbox/dist/jquery.bootstrap.newsbox.min.js',
    ], 'public/js/newsbox.js');

    // Form Helpers

    mix.scripts([
        './bower_components/select2/dist/js/select2.full.min.js',
        './bower_components/bootstrap-validator/dist/validator.min.js',
        './bower_components/speakingurl/speakingurl.min.js',
        './bower_components/jquery-slugify/dist/slugify.min.js',
        './bower_components/bootstrap-list-filter/bootstrap-list-filter.min.js',
        './bower_components/mjolnic-bootstrap-colorpicker/bootstrap-colorpicker-2.3.0/dist/js/bootstrap-colorpicker.min.js'
    ], 'public/js/forms.js');

    mix.copy([
        './bower_components/select2/dist/js/i18n/*.min.js',
    ], 'public/js/select2/i18n');

    mix.copy([
        './bower_components/mjolnic-bootstrap-colorpicker/bootstrap-colorpicker-2.3.0/dist/img/',
    ], 'public/img/');
    

    mix.styles([
        './bower_components/select2/dist/css/select2.min.css',
        './bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
        './bower_components/mjolnic-bootstrap-colorpicker/bootstrap-colorpicker-2.3.0/dist/css/bootstrap-colorpicker.min.css',
    ], 'public/css/forms.css');

    // Highlight

    mix.scripts([
        './bower_components/jquery-highlighttextarea/jquery.highlighttextarea.min.js',
    ], 'public/js/highlight.js');

    mix.styles([
        './bower_components/jquery-highlighttextarea/jquery.highlighttextarea.min.css',
    ], 'public/css/highlight.css');

    // Date & Time Helpers

    mix.scripts([
        './bower_components/moment/min/moment-with-locales.min.js',
        './bower_components/moment-timezone/builds/moment-timezone.min.js',
        // './bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        './bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js',
        './bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        './bower_components/fullcalendar/dist/fullcalendar.min.js',
        './bower_components/fullcalendar/dist/lang-all.js',
    ], 'public/js/datetime.js');

    mix.styles([
        // './bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        './bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        './bower_components/bootstrap-timepicker/css/timepicker.less',
        './bower_components/fullcalendar/dist/fullcalendar.min.css',
    ], 'public/css/datetime.css');

    // Tour Helpers

    mix.scripts([
        './bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js',
    ], 'public/js/tour.js');

    mix.styles([
        './bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css',
    ], 'public/css/tour.css');

});
