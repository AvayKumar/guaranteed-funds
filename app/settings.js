define(['knockout'], function(ko) {
  	return {
        BASE_URL : 'http://192.168.0.5/guaranteed-funds/',   
    	loggedIn : ko.observable(false),
    	getRoutes : function() {
    		return [
                { route: ['', 'home'],       moduleId: 'home/index',        title: 'Home',      nav: false },
                { route: 'signup',	         moduleId: 'signup/index',       title: 'Join Now',  nav: false },
                { route: 'login',  			 moduleId: 'login/index',        title: 'Sign In',    nav: false },
                { route: 'dashboard',   	 moduleId: 'dashboard/index',    title: 'Dashboard', nav: false },
                { route: 'plans',            moduleId: 'plans/index',        title: 'Plans',     nav: false}
            ]
    	}
	};
});