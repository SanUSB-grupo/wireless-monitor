var elixir = require('laravel-elixir');
require('laravel-elixir-webpack-official');
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
    mix.webpack([
        'monitors/index.jsx'
    ], 'public/js/monitors/index.js');

    mix.styles([
        'AdminLTE-boxes.css'
    ], 'public/css/boxes.css');

    mix.version(['public/js/monitors/index.js', 'public/css/boxes.css']);

    mix.sass('app.scss');
});
