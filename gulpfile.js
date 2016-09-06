// enable or disable notifications
process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');

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

var vendor = './resources/vendor/';

elixir(function(mix) {
    mix.scripts([
        'monitors/index.js'
    ], 'public/js/monitors/index.js');

    mix.scripts([
        'monitors/show-main.js'
    ], 'public/js/monitors/show-main.js');

    mix.scripts([
        'monitors/monitor.js'
    ], 'public/js/monitors/monitor.js');

    mix.scripts([
        'monitors/timeout.js'
    ], 'public/js/monitors/timeout.js');

    mix.scripts([
        'monitors/components/temperature.js'
    ], 'public/js/monitors/components/temperature.js');

    mix.scripts([
        'jquery/dist/jquery.js',
        'bootstrap/dist/js/bootstrap.js',
        'mustache.js/mustache.js',
        'jquery-knob/js/jquery.knob.js',
        'chartist/dist/chartist.js',
        'moment/min/moment-with-locales.js'
    ], 'public/vendor/vendor.js', vendor);

    mix.styles([
        'bootswatch/flatly/bootstrap.css',
        'balloon.css/balloon.css',
        'chartist/dist/chartist.css',
        '../assets/css/AdminLTE-boxes.css',
    ], 'public/vendor/vendor.css', vendor);

    mix.scripts([
        'requirejs/require.js'
    ], 'public/js/require.js', vendor);

    mix.version([
        'public/js/monitors/index.js',
        'public/vendor/vendor.js',
        'public/vendor/vendor.css',
        'public/js/require.js',
        'public/js/monitors/show-main.js',
        'public/js/monitors/monitor.js',
        'public/js/monitors/components/temperature.js',
        'public/js/monitors/timeout.js',
    ]);

    mix.sass('app.scss');

    mix.copy('./resources/assets/templates/**/*.mustache', './public/templates');
});
