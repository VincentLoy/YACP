/*jslint node: true, for */

'use strict';

let gulp = require(`gulp`),
    del = require(`del`),
    sass = require(`gulp-sass`),
    babel = require(`gulp-babel`),
    browserSpecificPrefixer = require(`gulp-autoprefixer`),
    cssCompressor = require('gulp-csso'),
    jsCompressor = require(`gulp-uglify`),
    imageCompressor = require(`gulp-imagemin`),
    tempCache = require(`gulp-cache`),
    browserSync = require(`browser-sync`),
    sourcemaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    replace = require('gulp-string-replace'),
    reload = browserSync.reload,
    proxyServer = `wordpress.local`,
    browserChoice = `default`;

const JS_BACK_FILES = [
    // libs
    './node_modules/flatpickr/dist/flatpickr.js',
    // custom
    './assets/dev/js/back/main.js',
];

const JS_FRONT_FILES = [
    // libs

    // custom
];


gulp.task(`build:scss`, function () {
    gulp.src(`assets/dev/styles/yacp_backend.scss`)
        .pipe(sass({
            outputStyle: `nested`,
            precision: 10
        }).on(`error`, sass.logError))
        .pipe(browserSpecificPrefixer({
            browsers: [`last 2 versions`]
        }))
        .pipe(cssCompressor({
            restructure: false,
        }))
        .pipe(gulp.dest(`assets/dist`));

    return gulp.src(`assets/dev/styles/yacp_frontend.scss`)
        .pipe(sass({
            outputStyle: `compressed`,
            precision: 10
        }).on(`error`, sass.logError))
        .pipe(cssCompressor({
            restructure: false,
        }))
        .pipe(gulp.dest(`assets/dist`));
});


gulp.task(`build:es6`, function () {
    gulp.src(JS_BACK_FILES)
        .pipe(concat('yacp.backend.js'))
        .pipe(babel())
        // .pipe(jsCompressor())
        .pipe(gulp.dest('assets/dist'));

    return gulp.src(JS_FRONT_FILES)
        .pipe(concat('yacp.front.js'))
        .pipe(babel())
        .pipe(jsCompressor())
        .pipe(gulp.dest(`assets/dist`));
});

/**
 * COMPRESS THEN COPY IMAGES TO THE PRODUCTION FOLDER
 *
 * This task sources all the images in the dev/img folder, compresses them based on
 * the settings in the object passed to imageCompressor, then copies the final
 * compressed images to the prod/img folder.
 */
gulp.task(`build:img`, function () {
    return gulp.src(`assets/dev/img/**/*`)
        .pipe(tempCache(
            imageCompressor({
                optimizationLevel: 3, // For PNG files. Accepts 0 – 7; 3 is default.
                progressive: true,    // For JPG files.
                multipass: false,     // For SVG files. Set to true for compression.
                interlaced: false     // For GIF files. Set to true for compression.
            })
        ))
        .pipe(gulp.dest(`assets/dist/img`));
});


/**
 * BUILD
 *
 * Meant for building a production version of your project, this task simply invokes
 * other pre-defined tasks.
 */
gulp.task(`build`, [
    `build:scss`,
    `build:es6`,
    `build:img`,
]);


gulp.task(`serve`, [`build:scss`, `build:es6`, 'build:img'], function () {
    browserSync({
        notify: true,
        port: 9000,
        reloadDelay: 100,
        browser: browserChoice,
        proxy: proxyServer,
    });

    gulp.watch(`assets/dev/js/**/*.js`, ['build:es6'])
        .on(`change`, reload);

    gulp.watch(`assets/dev/styles/**/*`, ['build:scss'])
        .on(`change`, reload);

    gulp.watch(`assets/dev/img/**/*`, ['build:img'])
        .on(`change`, reload);

    gulp.watch('./**/*.php')
        .on('change', reload);
});
