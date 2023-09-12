let mix = require('laravel-mix');

mix.js('assets/js/index.js', 'dist').setPublicPath('dist')
  .postCss("assets/css/main.css", "assets/css/style.css", [
    require("tailwindcss"),
  ]);
