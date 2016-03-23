var gulp = require("gulp");
var sass = require('gulp-sass');
var sourcemaps = require("gulp-sourcemaps");
var concat = require("gulp-concat");
var babel = require("gulp-babel");
var uglify = require("gulp-uglify");
var browserify = require("browserify");
var babelify = require("babelify");
var source = require("vinyl-source-stream");
var buffer = require("vinyl-buffer");
var glob = require("glob");
var watchify = require("watchify");
var plumber = require("gulp-plumber");
var stream = require("event-stream");
var gutil = require("gulp-util");

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
 function bundle(file){
   var srcval = file.replace("resources/js/", "");
   return browserify({entries: [file], debug: true})
   .transform(babelify, {presets: ["es2015"]})
   .bundle()
   .on("error", function(err){
     gutil.beep();
     gutil.log(err.toString());
     this.emit("end");
   })
   .pipe(source(srcval))
   .pipe(buffer())
   .pipe(uglify())
   .pipe(gulp.dest("public/js"));
 }

gulp.task("sass", function(){
  gulp.src("resources/assets/sass/**/*.scss")
    .pipe(sass.sync().on("error", sass.logError))
    .pipe(gulp.dest("./public/css"));
});

gulp.task("babel", function (done) {
  glob("resources/js/**/*.js", function(err, files){
    if(err){
      done(err);
    }
    var tasks = files.map(bundle);
    stream.merge(tasks).on("end", done);
  });
});

gulp.task('copy', function(){
  gulp.src('./resources/assets/images/**/*')
    .pipe(gulp.dest('./public/images'));
  gulp.src('./resources/assets/fonts/**/*')
    .pipe(gulp.dest('./public/fonts'));
});

gulp.task('watch', function() {
    gulp.watch(["./resources/assets/images/**/*"], ["copy"]);
    gulp.watch(["./resources/assets/fonts/**/*"], ["copy"]);
    gulp.watch(['./resources/assets/sass/**/*.scss'], ['sass']);
    gulp.watch(["./resources/js/**/*.js"], ["babel"]);
});

gulp.task("default", ["copy", "sass", "babel"]);
