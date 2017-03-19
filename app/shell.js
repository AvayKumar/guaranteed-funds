define(['plugins/router', 'knockout', 'settings'], function (router, ko, settings) {
    var logged_in = ko.observable(false);
    var not_logged_in = ko.observable(true);

    return {
        router: router,
        loggedIn: logged_in,
        notLoggedIn: not_logged_in,
        signOut: function() {
            settings.loggedIn(false);
            router.navigate('home');
        },
        activate: function () {

            router.map( settings.getRoutes() )
            .buildNavigationModel()
            .mapUnknownRoutes('hello/index', 'not-found')
            .activate();

            router.on('router:navigation:complete', function(){
                logged_in(settings.loggedIn());
                not_logged_in(!settings.loggedIn());
            });
            return router;
        }
    };
});