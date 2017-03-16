define(['plugins/router'], function (router) {
    return {
        router: router,
        activate: function () {
            return router.map([
                { route: ['', 'home'],                          moduleId: 'hello/index',                title: 'Join Now',              nav: true },
                { route: 'signup',                              moduleId: 'signup/index',               title: 'Join Now',              nav: true },
                { route: 'login',                               moduleId: 'login/index',                title: 'Sign In',               nav: true },
                { route: 'dashboard',                           moduleId: 'dashboard/index',            title: 'Dashboard',             nav: false}
            ]).buildNavigationModel()
              .mapUnknownRoutes('hello/index', 'not-found')
              .activate();
        }
    };
});