const { join, resolve } = require('path')
const { copySync, removeSync } = require('fs-extra')
const mix = require('laravel-mix')
// require('laravel-mix-versionhash')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix
    .js('resources/js/app.js', 'public/js').vue({
        extractStyles: false
    })
    .sass('resources/sass/app.scss', 'public/css')

    .disableNotifications()