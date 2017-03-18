define(['durandal/app', 'durandal/system', 'knockout', 'settings'], function (app, system, ko, settings) {
    return {
		doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();
			
			 console.log( postData );

             $.post(settings.BASE_URL + 'back-end/signup.php', postData,
                function(data, status) {
             	console.log(data);
             	console.log(status);
            },'json');
        }
    }
});
