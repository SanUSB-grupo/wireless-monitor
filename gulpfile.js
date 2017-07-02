// enable or disable notifications
process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');
require('./gulp-custom-tasks/main.js');
var inProduction = elixir.config.production;

var replace = require('gulp-replace-task');
var minimist = require('minimist');
var gutil = require('gulp-util');
var gitUserInfo = require('git-user-info');
var rename = require('gulp-regex-rename');

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
        'jquery/dist/jquery.js',
        'bootstrap/dist/js/bootstrap.js',
        'mustache.js/mustache.js',
        'jquery-knob/js/jquery.knob.js',
        'moment/min/moment-with-locales.js',
        'chart.js/dist/Chart.js'
    ], 'public/vendor/vendor.js', vendor);

    mix.styles([
        'bootswatch/flatly/bootstrap.css',
        'balloon.css/balloon.css',
        '../assets/css/AdminLTE-boxes.css',
        '../assets/css/custom-fonts.css',
        '../assets/css/app.css',
    ], 'public/vendor/vendor.css', vendor);

    mix.scripts([
        'requirejs/require.js'
    ], 'public/js/require.js', vendor);

    mix.scripts([
        'lity/dist/lity.js'
    ], 'public/js/welcome.js', vendor);

    mix.styles([
        'lity/dist/lity.css',
        '../assets/css/welcome.css'
    ], 'public/css/welcome.css', vendor);

    mix.version([
        'public/js/monitors/index.js',
        'public/vendor/vendor.js',
        'public/vendor/vendor.css',
        'public/js/require.js',
        'public/js/monitors/show-main.js',
        'public/js/monitors/monitor.js',
        'public/js/monitors/timeout.js',
        'public/js/welcome.js',
        'public/css/welcome.css'
    ]);

    mix.browserSync({
        proxy: "localhost:8000"
    });

    // custom commands
    mix.copyMustache('./packages/**/*.mustache', './public/templates');
    mix.copyComponents('./packages/**/components/*.js',
        './public/js/monitors/components', {inProduction: inProduction});
});

var options = minimist(process.argv.slice(2));

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

gulp.task('create-plugin', function () {
    if (!options.vendor || !options.plugin) {
        gutil.log(
            gutil.colors.red.bold(
                '\n\nUsage: gulp create-plugin --vendor <vendor> --plugin <plugin>\n'
            ),
            gutil.colors.bold(
                '\nExample:\n\tgulp create-plugin --vendor sanusb --plugin temperature'
            )
        );
        return;
    }
    var git = gitUserInfo();
    var plugin = options.plugin.toLowerCase();
    var vendor = options.vendor.toLowerCase();

    var files = [
        './package-template/composer.json',
        './package-template/src/migrations/insert_plugin_monitor.php',
        './package-template/src/Http/Controllers/PluginController.php',
        './package-template/src/assets/components/plugin.js',
        './package-template/src/storage/json-schema/plugin.json',
        './package-template/src/storage/json-schema/plugin-example.json',
        './package-template/src/assets/templates/plugin/index.mustache',
        './package-template/src/assets/templates/plugin/show.mustache',
        './package-template/src/Providers/PluginServiceProvider.php',
        './package-template/src/views/save.blade.php',
        './package-template/phpunit.xml',
        './package-template/tests/migrations/DatabaseTest.php',
        './package-template/tests/controllers/PluginControllerTest.php',
    ];
    gulp.src(files, {base: './package-template'})
        .pipe(rename(/Plugin/, capitalize(plugin)).on('error', gutil.log))
        .pipe(rename(/plugin/, plugin).on('error', gutil.log))
        .pipe(replace({
            patterns: [
                {
                    match: 'vendor',
                    replacement: vendor
                },
                {
                    match: 'Vendor',
                    replacement: capitalize(vendor)
                },
                {
                    match: 'plugin',
                    replacement: plugin
                },
                {
                    match: 'Plugin',
                    replacement: capitalize(plugin)
                },
                {
                    match: 'git_username',
                    replacement: git.name
                },
                {
                    match: 'git_email',
                    replacement: git.email
                }
            ]
        }))
        .pipe(gulp.dest('./packages/' + vendor + '/' + plugin));
});
