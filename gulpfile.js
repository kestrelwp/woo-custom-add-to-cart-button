const pluginData = {
    name: 'Custom Add To Cart Button for WooCommerce',
    libNamespace: 'Barn2\\WCB_Lib',
    libIncludes: ['Plugin/Plugin.php', 'Plugin/Simple_Plugin.php', 'Plugin/Admin/Admin_Links.php', 'Registerable.php', 'Conditional.php', 'Service.php',
        'Service_Container.php', 'Service_Provider.php', 'Translatable.php', 'Util.php']
};

const { src, dest, watch, series, parallel } = require( 'gulp' );

const fs = require( 'fs' ),
    barn2build = getBarn2Build();

function getBarn2Build() {
    var build;

    if ( fs.existsSync( '../barn2-lib/build' ) ) {
        build = require( '../barn2-lib/build/gulpfile-common' );
    } else if ( process.env.BARN2_LIB ) {
        build = require( process.env.BARN2_LIB + '/build/gulpfile-common' );
    } else {
        throw new Error( "Error: please set the BARN2_LIB environment variable to path of Barn2 Library project" );
    }
    build.setupBuild( pluginData );
    return build;
}

function test( cb ) {
    console.log( 'All looks good.' );
    cb();
}

module.exports = {
    default: test,
    build: barn2build.buildPlugin,
    assets: barn2build.buildAssets,
    library: barn2build.updateLibrary,
    zip: barn2build.createZipFile,
    release: barn2build.releaseFreePlugin,
    pluginTesting: barn2build.updatePluginTesting,
    watch: () => {
        watch( 'assets/scss/**/*.scss', barn2build.compileSass );
    }
};
