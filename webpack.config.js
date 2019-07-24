var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .addEntry('app', './assets/js/main.js')
    .addEntry('musicfile', './assets/js/musicfile.js')
    .addEntry('viewmusicfile', './assets/js/viewmusicfile.js')
    .addEntry('viewmember', './assets/js/viewmember.js')
    .addEntry('bootstrap-vue', './assets/js/bootstrap-vue.js')
    .addEntry('viewtypeahead', './assets/js/viewtypeahead.js')
    .addEntry('newprojectform', './assets/js/newprojectform.js')
    .addEntry('artistbandprofile', './assets/js/artistbandprofile.js')
    .addEntry('newprojectformregularjs', './assets/js/newprojectformregularjs.js')
    .addEntry('artistbandproject', './assets/js/artistbandproject.js')
    .addEntry('settingsprofile', './assets/js/settingsprofile.js')
    .addEntry('projectbyartist', './assets/js/projectbyartist.js')
    .addEntry('home', './assets/js/home.js')
    .enableVueLoader()
    .enableSassLoader()

;

module.exports = Encore.getWebpackConfig();