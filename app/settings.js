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
                { route: 'about',            moduleId: 'about/index',        title: 'About Us',   nav: false },
                { route: 'faq',              moduleId: 'faq/index',          title: 'FAQ',        nav: false },
                { route: 'profile',          moduleId: 'profile/index',      title: 'profile',    nav: false }
            ]
    	}
	};
});