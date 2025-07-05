const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const browserSync = require('browser-sync').create();

// Tarea para compilar SCSS a CSS
gulp.task('sass', function () {
  return gulp.src('src/scss/**/*.scss') // lee todos los .scss
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('src/css'))     // guarda el CSS compilado
    .pipe(browserSync.stream());    // inyecta cambios sin recargar toda la página
});

// Tarea para iniciar BrowserSync con PHP
gulp.task('serve', function () {
  browserSync.init({
    proxy: 'localhost:8000', // Servidor PHP que debés correr aparte
    open: true
  });

  gulp.watch('src/scss/**/*.scss', gulp.series('sass')); // observa cambios SCSS
  gulp.watch(['*.php', '**/*.php']).on('change', browserSync.reload); // observa cambios PHP
});

// Tarea por defecto (lo que corre con "gulp")
gulp.task('default', gulp.series('sass', 'serve'));
