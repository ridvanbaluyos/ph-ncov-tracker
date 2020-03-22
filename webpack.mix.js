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

mix.styles(
    [
        'resources/assets/css/app.css',
        'resources/assets/css/sb-admin-2.css',
    ],
    'public/css/all.css'
);

mix.js(
    [
        'resources/assets/js/bootstrap.js',
        'resources/assets/js/app.js',
        'resources/assets/js/sb-admin-2.js',
    ],
    'public/js/all.js'
);

mix.copy('resources/assets/vendor', 'public/vendor');
mix.copy('resources/assets/img', 'public/img');
mix.copy('resources/assets/scss', 'public/scss');

if (mix.config.inProduction) {
    mix.version();
}
