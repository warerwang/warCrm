var gulp = require('gulp');
var gutil = require('gulp-util');
var bower = require('bower');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var rename = require('gulp-rename');
var sh = require('shelljs');
var $ = require('gulp-load-plugins')();
var debug = require('gulp-debug');
var watch = require('gulp-watch');
var paths = {
  sass: ['./scss/**/*.scss'],
  coffee: ['./www/coffeeScript/**/*.coffee']
};

gulp.task('default', ['sass']);

gulp.task('sass', function(done) {
  gulp.src(paths.sass)
	.pipe(debug())
    .pipe(sass({
      errLogToConsole: true
    }))
    .pipe(gulp.dest('./www/css/'))
    .pipe(minifyCss({
      keepSpecialComments: 0
    }))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(gulp.dest('./www/css/'))
    .on('end', done);
});

gulp.task('watch', function() {
    gulp.watch(paths.sass, ['sass']);
	gulp.watch(paths.coffee, ['scripts']);
});

gulp.task('install', ['git-check'], function() {
  return bower.commands.install()
    .on('log', function(data) {
      gutil.log('bower', gutil.colors.cyan(data.id), data.message);
    });
});

gulp.task('git-check', function(done) {
  if (!sh.which('git')) {
    console.log(
      '  ' + gutil.colors.red('Git is not installed.'),
      '\n  Git, the version control system, is required to download Ionic.',
      '\n  Download git here:', gutil.colors.cyan('http://git-scm.com/downloads') + '.',
      '\n  Once git is installed, run \'' + gutil.colors.cyan('gulp install') + '\' again.'
    );
    process.exit(1);
  }
  done();
});
var errorHandler = function(title) {
	return function(err) {
		gutil.log(gutil.colors.red('[' + title + ']'), err.toString());
		this.emit('end');
	};
};
gulp.task('scripts', function () {
	return gulp.src('./www/coffeeScript/**/**/*.coffee')
		.pipe($.sourcemaps.init())
		.pipe($.coffeelint())
		.pipe($.coffeelint.reporter())
		.pipe($.coffee()).on('error', errorHandler('CoffeeScript'))
		.pipe($.sourcemaps.write())
		.pipe(gulp.dest('./www/js/'))
		.pipe(debug())
		.pipe($.size());
});