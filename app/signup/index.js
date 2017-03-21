define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    var error = '';

    function validate(postData){
        if(postData[1].value == postData[2].value)
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
        if(postData[5].value.length != 10 )    
            {
                error = ('Contact number must be of 10 digits');
                return false;
            }
        return true;    
    };
    return {
		doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();
        			
		  	 console.log(postData);
             if(validate(postData)){
                 $.post(settings.BASE_URL + 'back-end/signup.php', postData,
                    function(data, status){
                 	  console.log(data);
                 	  console.log(status);
                    if(data.state == 'true'){
                        settings.loggedIn(true);
                        settings.user_name(data.u_name);                    
                        router.navigate('plans');
                    }
                },'json');
             }
            else{
                $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' + error +'</div>');
             }
        }
    };
});
