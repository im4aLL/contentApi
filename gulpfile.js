var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var reload      = browserSync.reload;
var sass        = require('gulp-sass');
var source      = require('vinyl-source-stream');
var browserify  = require('browserify');

var uglify      = require('gulp-uglify');
var rename      = require("gulp-rename");
var minifyCss   = require('gulp-minify-css');
// var buffer   = require('vinyl-buffer'); // .pipe(buffer()) use buffer if you want to uglify JS on browserify on fly event
var autoprefixer = require('gulp-autoprefixer');

var watch = require('gulp-watch');

var config = {
    sass: {
        source: './resources/assets/sass/admin/admin.scss',
        dist: './public/assets/admin',
        fileName: 'admin.css',
        minifiedFileName: 'admin.min.css',
        watch: './resources/assets/sass/**/*.scss'
    },
    js: {
        source: './resources/assets/js/admin/admin.js',
        dist: './public/assets/admin',
        fileName: 'admin.js',
        minifiedFileName: 'admin.min.js',
        watch: './resources/assets/js/**/*.js'
    },
    sync: {
        //server: {
        //    baseDir: "./"
        //}
        proxy: "local.laravel.com"
    }
};


// sass to css
gulp.task('sass', function () {
    gulp.src(config.sass.source)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(config.sass.dist))
        .pipe(browserSync.stream());
});

// browserify
gulp.task('browserify', function() {
    return browserify({ entries: [config.js.source] })
        .bundle()
        .pipe(source(config.js.fileName))
        .pipe(gulp.dest(config.js.dist))
        .pipe(browserSync.stream());
});

// default task adn watch
gulp.task('serve', ['sass', 'browserify'], function() {
    browserSync.init(config.sync);

    watch(config.sass.watch, function(){
        gulp.start('sass');
    });

    watch(config.js.watch, function(){
        gulp.start('browserify');
    });

    watch('app/**/*.php', function(){
        reload();
    });

    watch('resources/**/*.php', function(){
        reload();
    });
});

// default task
gulp.task('default', ['serve']);

// gulp build and minify things
gulp.task('build', ['browserify'], function(){
    gulp.src(config.js.dist + '/' + config.js.fileName)
        .pipe(uglify())
        .pipe(rename(config.js.minifiedFileName))
        .pipe(gulp.dest(config.js.dist));

    gulp.src(config.sass.dist + '/' + config.sass.fileName)
        .pipe(autoprefixer({
            browsers: ['FF > 5', 'Safari > 4', 'Opera >= 12'],
            cascade: false
        }))
        .pipe(minifyCss())
        .pipe(rename(config.sass.minifiedFileName))
        .pipe(gulp.dest(config.sass.dist));
});
