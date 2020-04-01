const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

mix.webpackConfig({ node: { fs: 'empty' }}) // Solve webpack issue

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
   .sass('resources/sass/app.scss', 'public/css');

const moduleFolder = './Modules';

const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p,f)).isDirectory())

let modules = dirs(moduleFolder);

cssArray = [];

cssArray.push('public/css/app.css');

modules.forEach(function(m){
  let js = path.resolve(moduleFolder,m,'Resources','assets','js', 'app.js');
  mix.js(js,'public/js/'+m+'.js');
  let scss = path.resolve(moduleFolder,m,'Resources','assets','sass', 'app.scss');
  mix.sass(scss,'public/css/'+m+'.css');
  cssArray.push('public/css/'+m+'.css');
});

mix.styles(cssArray, 'public/css/all.css');