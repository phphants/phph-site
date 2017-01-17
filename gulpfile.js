var gulp = require('gulp');
var gulpif = require('gulp-if');
var sass = require("gulp-sass");
var cleanCss = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var config = {
    minify: true,
    paths: {
        css: [
            'public-src/third-party/bootstrap-3.3.7/css/bootstrap.css',
            'public-src/third-party/font-awesome-4.7.0/css/font-awesome.css',
            'public-src/third-party/bootstrap-social/bootstrap-social.css',
            'public-src/third-party/lazy-youtube/style.css',
            'public-src/phphants/scss/**/*.scss'
        ],
        js: [
            'public-src/phphants/js/**/*.js'
        ]
    },
    allTasks: [
        'styles',
        'scripts'
    ]
};

gulp.task('default', ['build'], function () {
    gulp.watch(config.paths.scss, ['styles']);
    gulp.watch(config.paths.js, ['scripts']);
});

gulp.task('build', config.allTasks, function () {
    gulp.src('public-src/third-party/font-awesome-4.7.0/fonts/*')
        .pipe(gulp.dest('public/fonts/'));
});

gulp.task('styles', function () {
    gulp.src(config.paths.css)
        .pipe(gulpif(/[.]scss$/, sass().on('error', sass.logError)))
        .pipe(concat('styles.min.css'))
        .pipe(gulpif(config.minify, cleanCss()))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('scripts', function () {
    gulp.src(config.paths.js)
        .pipe(concat('scripts.min.js'))
        .pipe(gulpif(config.minify, uglify()))
        .pipe(gulp.dest('public/js/'));
});
