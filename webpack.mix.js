const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/front/front.js', 'public/js')
    .js('resources/js/back/back.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });

// mix.js('resources/js/back/front.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .options({
//         processCssUrls: false
//     });