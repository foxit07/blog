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



mix.js('resources/admin/assets/scripts/index.js', 'public/js/admin/admin.js')
   .sass('resources/admin/assets/styles/index.scss', 'public/css/admin/admin.css');

mix.copy('resources/admin/assets/static/fonts/icons/fontawesome', 'public/fonts');
mix.copy('resources/admin/assets/static/fonts/icons/themify', 'public/fonts');
mix.copy('resources/admin/assets/static/images/datatables', 'public/images');
mix.copy('resources/admin/assets/static/images', 'public/images');

