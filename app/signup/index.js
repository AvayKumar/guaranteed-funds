define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    return {
		doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();
			
			 console.log( postData );

             $.post(settings.BASE_URL + 'back-end/signup.php', postData,
                function(data, status){
             	  console.log(data);
             	  console.log(status);
                if(data.state == 'true')
                    router.navigate('plans');
            },'json');
        }
    }
});
