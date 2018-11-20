var gulp = require( 'gulp' ),
	pump = require( 'pump' ),
	minify = require( 'gulp-uglify' ),
	cleancss = require( 'gulp-clean-css' ),
	fs = require( 'fs' ),
	header = require( 'gulp-header' ),
	rename = require( 'gulp-rename' ),
	run = require( 'gulp-run' ),
	debug = require( 'gulp-debug' ),
	checktextdomain = require( 'gulp-checktextdomain' );

const pluginSlug = 'woo-custom-add-to-cart-button';
const textDomain = 'woo-custom-add-to-cart-button';

const zipFile = pluginSlug + '.zip';
const pluginArchive = '/Users/andy/Dropbox/Barn2 Media/Plugins/Plugin archive/';

var getVersion = function() {
	var readme = fs.readFileSync( 'readme.txt', 'utf8' );
	var version = readme.match( /Stable tag\:\s(.*)\s/i );
	return ( 1 in version ) ? version[1] : false;
};

var getCopyright = function() {
	return fs.readFileSync( 'copyright.txt' );
};


function styles( cb ) {
	pump( [
		gulp.src( ['assets/css/**/*.css', '!**/*.min.css'] ),
		cleancss( { compatibility: 'ie9' } ),
		header( getCopyright( ), { 'version': getVersion( ) } ),
		rename( { suffix: '.min' } ),
		gulp.dest( 'assets/css' )
	], cb );
}

function textdomain() {
	return gulp
		.src( '**/*.php' )
		.pipe(
			checktextdomain( {
				text_domain: [textDomain, 'woocommerce'],
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			} )
			);
}

function createZipFile() {
	var zipCommand = `cd .. && rm ${zipFile}; zip -r ${zipFile} ${pluginSlug} -x *vendor* *node_modules* *.git* *.DS_Store *package*.json *gulpfile.js *copyright.txt`;

	return run( zipCommand ).exec();
}

var zip = gulp.series( styles, createZipFile );

function archiveZipFile() {
	var pluginDir = pluginArchive + pluginSlug;

	if ( !fs.existsSync( pluginDir ) ) {
		fs.mkdirSync( pluginDir );
	}
	var deployDir = pluginDir + '/' + getVersion();

	if ( !fs.existsSync( deployDir ) ) {
		fs.mkdirSync( deployDir );
	}

	return gulp.src( zipFile, { cwd: '../' } )
		.pipe( debug() )
		.pipe( gulp.dest( deployDir ) );
}

function copyToSvnFolder() {
	return gulp
		.src( ['**/*', '!./node_modules', '!./.gitignore', '!./copyright.txt', './*.json'] )
		.dest( '../../../wordpress-svn/' + pluginSlug + '/trunk' );
}

var build = gulp.parallel( zip, textdomain );
var release = gulp.series( build, archiveZipFile, copyToSvnFolder );

module.exports = { build: build, release: release, default: build };
