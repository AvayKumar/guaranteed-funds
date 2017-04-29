define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    var error = '';

    function validate(postData){
        var email1 = ((postData[1].value).trim()).toLowerCase();
        var email2 = ((postData[2].value).trim()).toLowerCase();

        if( email1 == email2 )
            {
                console.log('Email and Refferal email are same');
                error = 'Email and Refferal email are same';
                return false;
            } 
        if (postData[3].value != postData[4].value)     
            {
                error = ('Passwords do not match');
                return false;
            }
        if(postData[5].value.length != 11 )    
            {
                error = ('Contact number must be of 11 digits');
                return false;
            }
        return true;    
    };
    return {
        
        activate: function(){
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

		doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();
        			
		  	 console.log(postData);
             if(validate(postData)){
                 $.post(settings.BASE_URL + 'back-end/signup.php', postData,
                    function(data, status){
                 	  console.log(data);
                 	  console.log(status);
                    if(data.state){
                        settings.loggedIn(true);
                        settings.user_name(data.u_name);
                        
                        $('#message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            <strong>Congrats! </strong>Signed up successfully</div>');
                        
                        $('html,body').animate({scrollTop:0},'fast');

                        setTimeout(function(){
                                router.navigate('#plans');
                            },1500);
                    
                    } else {
                        $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            <strong>Error! </strong>' + data.message +'</div>');

                    }
                },'json');
             } else { 
                $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' + error +'</div>');
                
                // window.scrollTo(0,0);
                $('html,body').animate({scrollTop:0},'fast');
             }
        }
    };
});
