define(['durandal/app', 'plugins/router', 'knockout', 'settings'], function (app, router, ko, settings) {

    return {
        router: router,
        signOut: function() {
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=signOut', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                    router.reset();
                    router.deactivate();                    
                    app.setRoot('logged-out');
                }

            },'json');
        },

        activate: function () {

            router.map([
                { route: 'dashboard',        moduleId: 'dashboard/index',    title: 'Dashboard',    nav: true},
                { route: 'transactions',     moduleId: 'transactions/index', title: 'Transactions', nav: true},
                { route: 'plans',            moduleId: 'plans/index',        title: 'Plans',        nav: false},
                { route: 'support',          moduleId: 'support/index',      title: 'Support',      nav: false},
                { route: 'report',           moduleId: 'report/index',       title: 'Report',       nav: true},
                { route: 'profile',          moduleId: 'profile/index',      title: 'profile',      nav: false }
            ]).buildNavigationModel()
              .mapUnknownRoutes('dashboard/index', 'dashboard')
              .activate();

            return router;
        },
        attached: function() {
            if(settings.routeTo() != '#login') {
                router.navigate(settings.routeTo());
            }
            $('#user-name').text(settings.user_name());
        }
    };
});