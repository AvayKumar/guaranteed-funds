define(['durandal/app', 'durandal/system', 'knockout'], function (app, system, ko) {
    return {
		doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();
			
			 console.log( postData );

             $.post('http://localhost/test/back-end/signup.php', postData,
                function(data, status) {
             	console.log(data);
             	console.log(status);
            },'json');
        }
    }
});
