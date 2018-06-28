let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    // 'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'resources/assets/css/bootstrap.min.css',
    'node_modules/font-awesome/css/font-awesome.min.css',
    'node_modules/select2/dist/css/select2.min.css',
    'node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
    'resources/assets/css/style.css',
    
], 'public/css/all.css')
    .js([
        'resources/assets/js/app.js',
        'node_modules/popper.js/dist/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',        
        'node_modules/inputmask/dist/inputmask/jquery.inputmask.js',     
        'node_modules/select2/dist/js/select2.min.js'
    ], 'public/js/all.js');
