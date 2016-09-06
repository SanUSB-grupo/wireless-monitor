
var Elixir = require('laravel-elixir');
var gulp = require('gulp');
var flatten = require('gulp-flatten');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');

var Task = Elixir.Task;

Elixir.extend('copyMustache', function(src, output, options) {
    new Task('copy-mustache', function() {
        return gulp.src(src)
            .pipe(flatten({includeParents: -1}))
            .pipe(gulp.dest(output));
    })
    .watch(src);
});

Elixir.extend('copyComponents', function (src, output, options) {
    var inProduction = options.inProduction;
    new Task('copy-components', function () {
        return gulp.src(src)
            .pipe(flatten())
            .pipe(gulpif(inProduction, uglify()))
            .pipe(gulp.dest(output));
    })
    .watch(src);
});
