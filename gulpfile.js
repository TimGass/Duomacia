var gulp = require("gulp");
var sass = require('gulp-sass');

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

gulp.task("sass", function(){
  gulp.src("./resources/assets/sass/**/*.scss")
    .pipe(sass.sync().on("error", sass.logError))
    .pipe(gulp.dest("./public/css"));
});

gulp.task('copy', function(){
  gulp.src('./resources/assets/images/**/*')
    .pipe(gulp.dest('./public/images'));
});

gulp.task('watch', function() {
    gulp.watch(["./resources/assets/images/**/*"], ["copy"]);
  gulp.watch(['./resources/assets/sass/**/*.scss'], ['sass']);
});

gulp.task("default", ["copy", "sass"]);
