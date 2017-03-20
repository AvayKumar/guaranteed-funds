define(['plugins/router', 'knockout', 'settings'], function (router, ko, settings) {
    var logged_in = ko.observable(false);
    var not_logged_in = ko.observable(true);

    return {
        router: router,
        loggedIn: logged_in,
        notLoggedIn: not_logged_in,
        signOut: function() {
            settings.loggedIn(false);
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=signOut', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                    router.navigate('home');
                }

            },'json');
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

            $.post(settings.BASE_URL + 'back-end/util.php?func_name=authStatus', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                    if( data.auth ) {  
                        settings.loggedIn(true);
                        router.navigate('dashboard');
                    }
                }

            },'json');

            return router;
        }
    };
});