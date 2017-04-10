﻿define(['durandal/app', 'durandal/system', 'plugins/router', 'knockout', 'settings'], function (app, system, router, ko, settings) {
    return {
        login : function(formElement) {
			 var postData = $(formElement).serializeArray();
			 console.log( postData );

             $.post(settings.BASE_URL + 'back-end/login.php', postData, function(data, status) {
             	if( status == 'success' ) {

                    console.log(data);
                    if(data.blocked) {
                        router.navigate('support');
                        return;
                    }

                    if( !data.status ) {
                        $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' + data.user_verify +'</div>');                    
                    } else if( data.status ) {
                        
                        settings.loggedIn(true);
                        settings.user_name(data.u_name);
                        router.mapUnknownRoutes('dashboard/index', 'not-found');

                        if(data.loop_exist)
                            router.navigate('dashboard');
                        else    
                            router.navigate('plans');
                    }
                }
            },'json');
        }
    }
});
