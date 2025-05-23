const gulp = require('gulp');
const connet = require('gulp-connect');

// Servir archivos desde la carpeta src
gulp.task('serve', function() {
    connet.server({
        root: 'src', 
        livereload: true,
        port: 8080
    });
});

// Recargar navegador cuando cambia HTML
gulp.task('html', function() {
    return gulp.src('./src/*.html')
    .pipe(connet.reloas());
});

// Escuchar cabios
gulp.task('watch', function() {
    gulp.watch(['./src/*.html'], gulp.series('html'));
});

// Tarea por defecto
gulp.task('default', gulp.parallel('serve', 'watch'));