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
        'monitors/show.js'
    ], 'public/js/monitors/show.js');

    mix.scripts([
        'mustache.js/mustache.js',
        'jquery-knob/js/jquery.knob.js'
    ], 'public/vendor/vendor.js', vendor);

    mix.styles([
        '../assets/css/AdminLTE-boxes.css',
    ], 'public/vendor/vendor.css', vendor);

    mix.version([
        'public/js/monitors/index.js',
        'public/vendor/vendor.js',
        'public/vendor/vendor.css',
        'public/js/monitors/show.js'
    ]);

    mix.sass('app.scss');
});
