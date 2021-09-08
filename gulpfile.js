var gulp            = require('gulp');
var wpPot           = require('gulp-wp-pot');
var plumber         = require('gulp-plumber');
var clean           = require('gulp-clean');
var runSequence     = require('gulp4-run-sequence');
var colorize        = require('chalk');
var sort 			= require('gulp-sort');
var abort_on_error  = true;

// set clean paths
var cleanPaths = [
	'dist/*'
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
/* ==Translations=== */
gulp.task('pot', function () {
	return gulp.src('src/**/*.php')
	.pipe(plumber(reportError))
	.pipe(sort())
	.pipe(wpPot({
		domain: 'add-podtrac-analytics-for-seriously-simple-podcasting',
		destFile:'add-podtrac-analytics-for-seriously-simple-podcasting.pot'}))
	.pipe(gulp.dest('dist/languages'));
});

/* ==Moving Src to Dist=== */
gulp.task('move_src', function(){
	return gulp.src('src/**')
	.pipe(plumber(reportError))
	.pipe(gulp.dest('dist'));
});

/*== Building the files ==*/
gulp.task('default', function(callback){
    runSequence('clean',
				['move_src'],
				['pot'],
                callback
        );
});

gulp.task('build', function(callback){
    runSequence('default',
	callback
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
	var path_parts = path.split('add-podtrac-analytics-for-seriously-simple-podcasting/src');
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