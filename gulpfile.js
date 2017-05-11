var gulp = require('gulp');
var less = require('gulp-less');
var concatCss = require('gulp-concat-css');
var concatJs = require('gulp-concat');
var argv = require('yargs').argv;

gulp.task('less', function() {
    return gulp.src('./Resources/private/less/*.less')
        .pipe(less())
        .pipe(concatCss('dual.css'))
        .pipe(gulp.dest('./Resources/public/css'));
});

gulp.task('javascript', function() {
    return gulp.src('./Resources/private/javascript/*.js')
        .pipe(concatJs('dual.js'))
        .pipe(gulp.dest('./Resources/public/js'));
});

gulp.task('watch', function() {
    if (argv.watch) {
        gulp.watch('./Resources/private/less/*.less', ['less']);
        gulp.watch('./Resources/private/javascript/*.js', ['javascript']);
    }
});

gulp.task('default', ['less', 'javascript', 'watch']);