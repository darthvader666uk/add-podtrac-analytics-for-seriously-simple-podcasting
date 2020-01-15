var gulp            = require('gulp');
var wpPot           = require('gulp-wp-pot');
var plumber         = require('gulp-plumber');
var clean           = require('gulp-clean');
var runSequence     = require('run-sequence');
var zip             = require('gulp-zip');
var colorize        = require('chalk');
var abort_on_error  = true;

// set clean paths
var cleanPaths = [
	'dist/*',
	'podtrac-analytics-for-seriously-simple-podcasting.zip'
];

/* ==Start Gulp Process=== */
gulp.copy = function(src,dest) {
	return gulp.src(src, {base:"."})
	.pipe(plumber(reportError))
	.pipe(gulp.dest(dest));
};

/*== Clean Dist and Zip ==*/
gulp.task('clean', function(){
	return gulp.src(cleanPaths)
	.pipe(plumber(reportError))
	.pipe(clean({force:true}));
});

/* ==Moving Src to Dist=== */
gulp.task('move_src', function(){
	return gulp.src('src/**')
	.pipe(plumber(reportError))
	.pipe(gulp.dest('dist'));
});

/*== Configuring Zip ==*/

//for normal build
gulp.task('copy_for_zip', function(){
	return gulp.src('dist/**')
	.pipe(plumber(reportError))
	.pipe(gulp.dest('podtrac-analytics-for-seriously-simple-podcasting'));
	
});

gulp.task('build_zip', function(){
	return gulp.src('podtrac-analytics-for-seriously-simple-podcasting/**/*', { base : "." })
	.pipe(plumber(reportError))
	.pipe(zip('podtrac-analytics-for-seriously-simple-podcasting.zip'))
	.pipe(gulp.dest('.'));
});

gulp.task('clean_zip', function() {
	return gulp.src('podtrac-analytics-for-seriously-simple-podcasting', {read: false}).pipe(clean())
	.pipe(plumber(reportError));
});

/*== Building the files ==*/
gulp.task('default', function(done){
    runSequence('clean',
                ['move_src'],
                done
        );
});

gulp.task('build', function(done){
    runSequence('default',
                done
        );
});

gulp.task('zip', function(done){
    runSequence('clean',
                ['move_src'],
                ['copy_for_zip'],
                ['build_zip'],
                ['clean_zip'],
                done
        );
});

/*== Watch ==*/
gulp.task('php', function(done){
	runSequence('move_src', done);
});

gulp.task('watch', function(){
    var phpwatcher = gulp.watch('src/**', { interval: 500 }, function(event) {
		console.log('File ' + colorize.cyan(get_relative_file_path(event.path)) + ' was ' + colorize.magenta(event.type) + ' and ' + colorize.gray('moved') + ' to ' + colorize.gray('dist'));
		return gulp.src(event.path, {base: 'src'})
		  .pipe(plumber(reportError))
		  .pipe(gulp.dest('dist'));
	});
});

// get the relative path of a file in the src folder
var get_relative_file_path = function (path) {
	var path_parts = path.split('podtrac-analytics-for-seriously-simples-podcasting/src');
	return path_parts[1] || path;
}

/*== Error Reporting ==*/
var reportError = function (error) {
    var lineNumber = (error.lineNumber) ? 'LINE ' + error.lineNumber + ' -- ' : '';
    var report = '';
    var chalk = gutil.colors.white.bgRed;

    // Shows a pop when errors
    notify({
        title: 'Task Failed [' + error.plugin + ']',
        message: lineNumber + 'See console.',
        sound: 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
    }).write(error);

    report += chalk('GULP TASK:') + ' [' + error.plugin + ']\n';
    report += chalk('PROB:') + ' ' + error.message + '\n';
    if (error.lineNumber) { report += chalk('LINE:') + ' ' + error.lineNumber + '\n'; }
	if (error.fileName)   { report += chalk('FILE:') + ' ' + error.fileName + '\n'; }
	console.error(report);
    if (abort_on_error) process.exit(1);
}