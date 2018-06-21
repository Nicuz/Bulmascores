var gulp = require( 'gulp' );

var sass = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var sourcemaps = require( 'gulp-sourcemaps' );
var rename = require( 'gulp-rename' );
var browsersync = require( 'browser-sync' ).create();
var wppot = require('gulp-wp-pot');

// VARIABLES
const WORDPRESS = {
  localDomain: 'http://nicuz.local',
  textdomain: 'bulmascores',
  admin: 'Domenico Majorana <nico.majorana@gmail.com>',
  team: 'Domenico Majorana <nico.majorana@gmail.com>'
}

const PATHS = {
  styles: {
    src: './assets/sass/**/*.sass',
    dest: './assets/css/',
    min: './assets/css/*.min.css'
  },
  php: {
    src: './**/*.php'
  },
  scripts: {
    src: './assets/js/*.js'
  }
};

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
gulp.task('sass', function () {
  return gulp.src( PATHS.styles.src )
    .pipe( sass( { outputStyle: 'compressed' } ).on( 'error', sass.logError ) )
    .pipe( sourcemaps.init())
    .pipe( autoprefixer( { browsers: BROWSERS } ) )
    .pipe( rename({suffix: '.min' }))
    .pipe( sourcemaps.write( './' ))
    .pipe( gulp.dest( PATHS.styles.dest ))
});

//BROWSER LIVE PREVIEW
gulp.task( 'browsersync', function() {
    var files = [
      PATHS.styles.min,
      PATHS.scripts.src,
      PATHS.php.src
    ];

    browsersync.init( files, {
        proxy: WORDPRESS.localDomain,
        open: false
    });
});

//GENERATE TRANSLATION FILE
gulp.task( 'wppot', function() {
	return gulp.src( PATHS.php.src )
		.pipe( wppot( {
				domain: WORDPRESS.textdomain,
				lastTranslator: WORDPRESS.admin,
				team: WORDPRESS.team
			})
		)
		.pipe( gulp.dest( './languages/' + WORDPRESS.textdomain + '.pot' ) )
});

function watchFiles() {
  gulp.watch( PATHS.styles.src, gulp.parallel( 'sass' )) ;
  gulp.watch( PATHS.php.src, gulp.parallel( 'wppot' ) );
}

gulp.task( 'default', gulp.parallel( 'sass', 'browsersync', watchFiles ) );
