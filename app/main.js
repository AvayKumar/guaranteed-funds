requirejs.config({
    paths: {
        'text': '../lib/require/text',
        'durandal':'../lib/durandal/js',
        'plugins' : '../lib/durandal/js/plugins',
        'transitions' : '../lib/durandal/js/transitions',
        'knockout': '../lib/knockout/knockout-3.4.0',
        'bootstrap': '../lib/bootstrap/js/bootstrap',
        'flipdown': '../lib/flip-down/jquery.flipcountdown',
        'jquery': '../lib/jquery/jquery-1.9.1',
        'settings': './settings'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery'],
            exports: 'jQuery'
        },
        'flipdown': {
            deps: ['jquery'],
            exports: 'jQuery.flipdown'
        }
    }
});

define(['durandal/system', 'durandal/app', 'durandal/viewLocator', 'bootstrap'], function (system, app, viewLocator) {

    app.title = 'Guaranteed Funds';

    //specify which plugins to install and their configuration
    app.configurePlugins({
        router:true,
        dialog: true,
        widget: {
            kinds: ['expander']
        }
    });

    app.start().then(function () {
        viewLocator.useConvention();
        app.setRoot('logged-out');
    });
});