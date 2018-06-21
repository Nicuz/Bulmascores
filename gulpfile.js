var gulp = require( 'gulp' );

var sass = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var sourcemaps = require( 'gulp-sourcemaps' );
var rename = require( 'gulp-rename' );
var browsersync = require( 'browser-sync' ).create();

// VARIABLES
var localDomain = 'http://nicuz.local';
var sassFiles =  './assets/sass/**/*.sass';
var cssFiles = './assets/css/';
const BROWSERS = [
    'last 2 version',
    '> 1%',
    'ie >= 9',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4',
    'bb >= 10'
];

//SASS TO MIN.CSS
gulp.task('sass', function (done) {
  return gulp.src(sassFiles)
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(sourcemaps.init())
    .pipe(autoprefixer({browsers: BROWSERS}))
    .pipe(rename({suffix: '.min' }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(cssFiles))
});

//BROWSER LIVE PREVIEW
gulp.task('browsersync', function() {
    var files = [
      './assets/css/*.min.css',
      './assets/js/*.js',
      './**/*.php'
    ];

    browsersync.init(files, {
        proxy: localDomain,
        open: false
    });
});

gulp.task('default', ['sass', 'browsersync'], function(){
  gulp.watch(sassFiles, ['sass']);
});
