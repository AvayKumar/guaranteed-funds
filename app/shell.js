define(['plugins/router', 'knockout', 'settings'], function (router, ko, settings) {
    var show_log_out = ko.observable(false);
    return {
        router: router,
        showLogOut: show_log_out,
        signOut: function() {
            console.log('Signed Out');
        },
        activate: function () {
            router.map( settings.getRoutes() )
            .buildNavigationModel()
            .mapUnknownRoutes('hello/index', 'not-found')
            .activate();

            router.on('router:navigation:complete', function(){
                show_log_out(settings.loggedIn());
            });
            return router;
        }
    };
});