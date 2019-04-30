/*jslint node: true, for */

'use strict';

let gulp = require('gulp'),
    sass = require('gulp-sass'),
    babel = require('gulp-babel'),
    phplint = require('gulp-phplint'),
    phpcs = require('gulp-phpcs'),
    browserSpecificPrefixer = require('gulp-autoprefixer'),
    cssCompressor = require('gulp-csso'),
    jsCompressor = require('gulp-uglify'),
    browserSync = require('browser-sync'),
    concat = require('gulp-concat'),
    reload = browserSync.reload,
    proxyServer = 'wordpress.local',
    pipeline = require('readable-stream').pipeline,
    browserChoice = 'default';

const JS_BACK_FILES = [
    // libs
    './node_modules/flatpickr/dist/flatpickr.js',
    // custom
    './assets/dev/js/back/main.js',
];

const JS_FRONT_FILES = [
    // libs
    './node_modules/simplycountdown.js/dist/simplyCountdown.min.js',
    // custom
];

const JS_DEMO_FILES = [
    // libs
    './node_modules/basiclightbox/dist/basicLightbox.min.js',
    './demo/js/app.js',
    // custom
];

const YACP_THEMES = [
    'assets/dev/styles/themes/yacp-simple-white.scss',
    'assets/dev/styles/themes/yacp-simple-black.scss',
];

gulp.task('build:themes', function () {
   Array.prototype.forEach.call(YACP_THEMES, (theme) => {
       gulp.src(theme)
           .pipe(sass({
               outputStyle: 'nested',
               precision: 10
           }).on('error', sass.logError))
           .pipe(browserSpecificPrefixer({
               browsers: ['last 2 versions']
           }))
           .pipe(cssCompressor({
               restructure: false,
           }))
           .pipe(gulp.dest('assets/dist/themes'));
   });
});

gulp.task('build:scss', function () {
    gulp.src('assets/dev/styles/yacp_backend.scss')
        .pipe(sass({
            outputStyle: 'nested',
            precision: 10
        }).on('error', sass.logError))
        .pipe(browserSpecificPrefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(cssCompressor({
            restructure: false,
        }))
        .pipe(gulp.dest('assets/dist'));

    return gulp.src('assets/dev/styles/yacp_frontend.scss')
        .pipe(sass({
            outputStyle: 'compressed',
            precision: 10
        }).on('error', sass.logError))
        .pipe(cssCompressor({
            restructure: false,
        }))
        .pipe(gulp.dest('assets/dist'));
});

gulp.task('build:demo:scss', function () {
    return gulp.src('./demo/styles/scss/style.scss')
        .pipe(sass({
            outputStyle: 'compressed',
            precision: 10
        }).on('error', sass.logError))
        .pipe(cssCompressor({
            restructure: false,
        }))
        .pipe(gulp.dest('demo/styles'));
});


gulp.task('build:back:es6', function () {
    return gulp.src(JS_BACK_FILES)
        .pipe(concat('yacp.backend.js'))
        .pipe(babel())
        .pipe(jsCompressor())
        .pipe(gulp.dest('assets/dist'));
});

gulp.task('build:front:es6', function () {
    return pipeline(
        gulp.src(JS_FRONT_FILES),
        concat('yacp.front.js'),
        babel(),
        jsCompressor(),
        gulp.dest('assets/dist')
    );
});

gulp.task('build:demo:es6', function () {
    return pipeline(
        gulp.src(JS_DEMO_FILES),
        concat('app.min.js'),
        babel({
            presets: ['@babel/env']
        }),
        jsCompressor(),
        gulp.dest('demo/js')
    );
});

gulp.task('lint:php', function() {
    return gulp.src(['./libs/**/*.php'])
        .pipe(phplint());
});

gulp.task('phpcs', function () {
    return gulp.src(['./libs/**/*.php'])
        // Validate files using PHP Code Sniffer
        .pipe(phpcs({
            bin: './vendor/bin/phpcs',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        // Log all problems that was found
        .pipe(phpcs.reporter('log'));
});

gulp.task('check:php', ['lint:php', 'phpcs']);

/**
 * BUILD
 *
 * Meant for building a production version of your project, this task simply invokes
 * other pre-defined tasks.
 */
gulp.task('build', [
    'build:scss',
    'build:front:es6',
    'build:back:es6'
]);


gulp.task('serve', ['build:scss', 'build:themes', 'build:front:es6', 'build:back:es6'], function () {
    browserSync({
        notify: true,
        port: 9000,
        reloadDelay: 100,
        browser: browserChoice,
        proxy: proxyServer,
    });

    gulp.watch('./assets/dev/js/**/*.js', ['build:front:es6', 'build:back:es6'])
        .on('change', reload);

    gulp.watch('./assets/dev/styles/**/*', ['build:scss', 'build:themes'])
        .on('change', reload);

    gulp.watch('./**/*.php')
        .on('change', reload);
});

gulp.task('serve:demo', ['build:demo:scss', 'build:demo:es6'], function () {
    browserSync({
        notify: true,
        port: 9000,
        reloadDelay: 100,
        browser: browserChoice,
        server: {
            baseDir: './'
        }
    });

    gulp.watch('./index.html').on('change', reload);
    gulp.watch('./demo/js/app.js', ['build:demo:es6'])
        .on('change', reload);
    gulp.watch('./demo/styles/scss/**/*', ['build:demo:scss'])
        .on('change', reload);
});

gulp.task('default', ['serve']);