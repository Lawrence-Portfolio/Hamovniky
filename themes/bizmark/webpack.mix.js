const mix = require('laravel-mix')
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

const jsFileList = [
   'build/js/common',
   'pages/index',
   'pages/property/property-listing',
   'pages/property/property-card',
   'pages/articles/articles-listing'
];

const sassFileList = [
   'build/scss/common',
   'pages/index',
   'pages/info/about-us',
   'pages/info/contacts',
   'pages/articles/articles-listing',
   'pages/articles/articles-card',
   'pages/services/services-listing',
   'pages/services/services-card',
   'pages/property/property-listing',
   'pages/property/property-card'
];

mix.setPublicPath('assets/')

jsFileList.forEach(fileName => mix.js(`./${fileName}.js`, 'js'));

sassFileList.forEach(fileName => mix.sass(`./${fileName}.scss`, 'css')
   .options({
      processCssUrls: false
   }));

mix.version()