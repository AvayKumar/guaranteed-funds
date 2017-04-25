define(['knockout'], function(ko) {
  	return {
        BASE_URL : 'http://localhost/guaranteed-funds/',   
    	loggedIn : ko.observable(false),
        user_name : ko.observable(''),
    	getRoutes : function() {
    		return [
                { route: ['', 'home'],       moduleId: 'home/index',        title: 'Home',        nav: false },
                { route: 'signup',	         moduleId: 'signup/index',       title: 'Join Now',   nav: false },
                { route: 'login',  			 moduleId: 'login/index',        title: 'Sign In',    nav: false },
                { route: 'dashboard',   	 moduleId: 'dashboard/index',    title: 'Dashboard',  nav: false },
                { route: 'transactions',     moduleId: 'transactions/index', title: 'Transactions', nav: false },
                { route: 'plans',            moduleId: 'plans/index',        title: 'Plans',      nav: false},
                { route: 'support',          moduleId: 'support/index',      title: 'Support',    nav: false},
                { route: 'report',           moduleId: 'report/index',       title: 'Report',    nav: false},
                { route: 'recover',          moduleId: 'recover/index',      title: 'Recover',   nav: false },
                { route: 'forgot',           moduleId: 'forgot/index',       title: 'Forgot',     nav: false },
                { route: 'profile',          moduleId: 'profile/index',      title: 'profile',    nav: false }
            ]
    	}
	};
});