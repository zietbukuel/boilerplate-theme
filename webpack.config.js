const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const fs = require( 'fs' );

/**
 * Custom Webpack Plugin to prepend the WordPress theme metadata header
 * and write the final compiled stylesheet to the theme root style.css.
 */
class WordPressThemeHeaderPlugin {
    apply( compiler ) {
        compiler.hooks.afterEmit.tap( 'WordPressThemeHeaderPlugin', ( compilation ) => {
            const headerPath = path.resolve( __dirname, 'src/theme/header.txt' );
            const compiledStylePath = path.resolve( __dirname, 'build/style-style.css' );
            const destStylePath = path.resolve( __dirname, 'style.css' );

            if ( fs.existsSync( compiledStylePath ) ) {
                let header = '';
                if ( fs.existsSync( headerPath ) ) {
                    header = fs.readFileSync( headerPath, 'utf8' );
                }
                const css = fs.readFileSync( compiledStylePath, 'utf8' );
                
                // Write concatenated output directly to theme root style.css
                fs.writeFileSync( destStylePath, header + '\n' + css );
            }
        } );
    }
}

module.exports = {
    ...defaultConfig,
    entry: {
        'hero-section': './src/blocks/hero-section/index.js',
        'feature-grid': './src/blocks/feature-grid/index.js',
        'main': './src/js/main.js',
        'editor': './src/js/editor.js',
        'style': './src/theme/style.scss', // Compile main theme styles
    },
    output: {
        path: path.resolve( __dirname, 'build' ),
        filename: '[name].js',
    },
    plugins: [
        ...defaultConfig.plugins,
        new WordPressThemeHeaderPlugin(),
    ],
};
