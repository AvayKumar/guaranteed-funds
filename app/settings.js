define(['knockout'], function(ko) {
  	return {
        BASE_URL : 'http://localhost/guaranteed-funds/',   
    	loggedIn : ko.observable(false),
    	getRoutes : function() {
    		return [
                { route: ['', 'home'],       moduleId: 'hello/index',        title: 'Home',      nav: false },
                { route: 'signup',	         moduleId: 'signup/index',       title: 'Join Now',  nav: !this.loggedIn() },
                { route: 'login',  			 moduleId: 'login/index',        title: 'Sign In',    nav: !this.loggedIn() },
                { route: 'dashboard',   	 moduleId: 'dashboard/index',    title: 'Dashboard', nav: this.loggedIn() },
                { route: 'plans',            moduleId: 'plans/index',        title: 'Plans',     nav: false}
            ]
    	}
	};
});