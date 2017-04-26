define(['durandal/app', 'durandal/system', 'plugins/router', 'knockout', 'settings'], function (app, system, router, ko, settings) {
    return {

        activate: function() {
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=authStatus', 
                function(data, status) {
                if( status == 'success' && data.auth ) { 
                    settings.user_name(data.user_name);
                    router.reset();
                    router.deactivate();                    
                    app.setRoot('logged-in');
                }   
            },'json');           
        },

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
                    
                        $('html,body').animate({scrollTop:0},'fast');
                        
                    } else if( data.status ) {
                        settings.user_name(data.u_name);
                        router.reset();
                        router.deactivate();                    
                        app.setRoot('logged-in');
                    }
                }
            },'json');
        }
    }
});
