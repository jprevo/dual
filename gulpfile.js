var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var ts = require('gulp-typescript');
var concatCss = require('gulp-concat-css');
var argv = require('yargs').argv;

gulp.task('less', function() {
    return gulp.src('./Resources/private/less/*.less')
        .pipe(less())
        .pipe(concatCss('dual.css'))
        .pipe(gulp.dest('./Resources/public/css'));
});

gulp.task('typescript', function() {
    return gulp.src('./Resources/private/typescript/*.ts')
        .pipe(ts({
            noImplicitAny: true,
            out: 'dual.js'
        }))
        .pipe(gulp.dest('./Resources/public/js/'));
});

gulp.task('watch', function() {
    if (argv.watch) {
        gulp.watch('./Resources/private/less/*.less', ['less']);
        gulp.watch('./Resources/private/typescript/*.ts', ['typescript']);
    }
});

gulp.task('default', ['less', 'typescript', 'watch']);