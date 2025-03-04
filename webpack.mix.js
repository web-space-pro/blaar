const mix = require('laravel-mix');

mix
    .js('assets/src/js/app.js', 'assets/dist/js')
    .sass('assets/src/scss/app.scss', 'assets/dist/css')
    .copy('assets/src/js/plugins', 'assets/dist/js/plugins')
    .copy('assets/src/fonts', 'assets/dist/fonts')
    .options({
        processCssUrls: false,
        postCss: [require('tailwindcss')],

    })