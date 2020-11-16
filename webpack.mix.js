const mix = require('laravel-mix');
require('laravel-mix-alias');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/swagger.js', 'public/js')
    // .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'resources/mdb/js/jquery-3.4.1.min.js',
        'resources/mdb/js/popper.min.js',
        'resources/mdb/js/bootstrap.min.js',
        'resources/mdb/js/mdb.min.js'
    ], 'public/js/all.js')
    .styles([
        'resources/mdb/css/bootstrap.css',
        'resources/mdb/css/mdb.min.css',
        'resources/mdb/css/style.css',
        'resources/mdb/css/addons/flag.css',
        'resources/css/vue-multiselect.min.css',
        'resources/css/app.css'
    ], 'public/css/all.css')
    .alias({
        'components' : '/resources/js/Components',
        'store' : '/resources/js/Store',
    });
