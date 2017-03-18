define(['durandal/app', 'durandal/system', 'plugins/router', 'knockout', 'settings'], function (app, system, router, ko, settings) {
    return {
        
        login : function(formElement) {
			 var postData = $(formElement).serializeArray();
			 console.log( postData );

             $.post(settings.BASE_URL + 'back-end/login.php', postData, function(data, status) {
             	if( status == 'success' ) {
                    console.log(data);

                    if(data.status == 'error') {
                        $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' + data.message +'</div>');
                    
                    } else if(data.status == 'ok') {
                        settings.loggedIn(true);
                        router.deactivate();
                        router.map( settings.getRoutes() )
                        .mapUnknownRoutes('dashboard/index', 'not-found');
                        router.activate();

                        if(data.loop == 'exists')
                            router.navigate('dashboard');
                        else    
                            router.navigate('plans');
                    }
                }
            },'json');
        }

    }
});
