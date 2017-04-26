define(['durandal/app', 'plugins/router', 'knockout', 'settings'], 
        function (app, router, ko, settings) {
    
    return {
        router: router,
        signOut: function() {
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=signOut', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) {
                    app.setRoot('logged-in');
                }

            },'json');
        },

        activate: function () {

            router.map([
                { route: ['', 'home'],       moduleId: 'home/index',         title: 'Home',       nav: false},
                { route: 'signup',           moduleId: 'signup/index',       title: 'Join Now',   nav: true },
                { route: 'login',            moduleId: 'login/index',        title: 'Sign In',    nav: true },
                { route: 'forgot',           moduleId: 'forgot/index',       title: 'Forgot',     nav: false},
                { route: 'recover',          moduleId: 'recover/index',      title: 'Recover',    nav: false},                
                { route: 'support',          moduleId: 'support/index',      title: 'Support',    nav: false}
            ]).buildNavigationModel()
              .mapUnknownRoutes('home/index', 'not-found')
              .activate();

            return router;
        }
    };
});