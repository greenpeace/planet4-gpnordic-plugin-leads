const gulp = require("gulp");
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const browserSync = require("browser-sync").create();
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("gulp-autoprefixer");
const notifier = require("node-notifier");
const path = require("path");

let sassPaths = [];

/* SASS */
gulp.task(
  "sass",
  gulp.parallel([], () => {
    return gulp
      .src("assets/scss/*.scss")
      .pipe(
        sass({
          includePaths: sassPaths,
          outputStyle: "compressed",
        })
      )
      .on("error", function (e) {
        sass.logError;
        console.log("ERROR", e);
        notifier.notify({
          title: "Error",
          message: "Could not compile scss 🤬",
        });
      })
      .pipe(autoprefixer())
      .pipe(gulp.dest("public/css"))
      .pipe(browserSync.stream());
  })
);

/* Babel */
gulp.task(
  "babel",
  gulp.parallel([], () => {
    return gulp
      .src(["assets/js/**/*.js"])
      .pipe(
        babel({
          presets: ["env"],
        })
      )
      .on("error", function (e) {
        notifier.notify({
          title: "Error",
          message: "Could not compile js 🤯",
          icon: path.join(__dirname, "logo.png"),
        });
        console.log("ERROR", e);
        this.emit("end");
      })
      .pipe(uglify())
      .pipe(gulp.dest("public/js"));
  })
);

/* BrowserSync */
gulp.task(
  "browser-sync",
  gulp.series([], () => {
    // browserSync.init({
    //   open: 'external',
    //   host: 'greenpeace-leads.test',
    //   proxy: 'greenpeace-leads.test',
    //   port: 3000,
    //   https: true,
    // })
  })
);

/* Defalut */
gulp.task(
  "default",
  gulp.parallel(["browser-sync"], (done) => {
    gulp.watch(["assets/scss/**/*.scss"], gulp.series("sass"));
    gulp.watch(["assets/js/**/*.js", "!js/dist/**/*.js"], gulp.series("babel"));
    // gulp.watch('**/*.php').on('change', browserSync.reload)
    done();
  })
);
