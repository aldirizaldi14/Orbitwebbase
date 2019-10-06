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

mix.js([
        'resources/js/app.js',
    ], 'public/js/app.js')
    .scripts([
        'public/themes/metronic/util.js',
        'public/themes/metronic/app.js',
        'public/themes/metronic/general/datatable/datatable.js',
        'public/themes/metronic/general/dropdown.js',
        'public/themes/metronic/general/header.js',
        'public/themes/metronic/general/menu.js',
        'public/themes/metronic/general/offcanvas.js',
        'public/themes/metronic/general/portlet.js',
        'public/themes/metronic/general/quicksearch.js',
        'public/themes/metronic/general/scroll-top.js',
        'public/themes/metronic/general/toggle.js',
        'public/themes/metronic/general/wizard.js',
        'public/themes/metronic/layout.js',
        'public/themes/metronic/main.js',
        'public/themes/metronic/quick-sidebar.js'
    ], 'public/js/vendors.js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
        'node_modules/select2/dist/css/select2.css',
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',
        'node_modules/sweetalert2/dist/sweetalert2.min.css',
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
        'node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
        'node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css',
    ],  'public/css/vendors.css');
