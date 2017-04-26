define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    var email2 = ko.observable('');
    

    return {
        email : email2,
        activate: function(){
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=authStatus', 
                function(data, status) {
                if( status == 'success' && data.auth ) { 
                    router.reset()
                          .deactivate();                    
                    app.setRoot('logged-in');
                }
            },'json');           
        },
        sendEmail : function(formElement) {
            var postData = $(formElement).serializeArray();          
             
                 $.post(settings.BASE_URL + 'back-end/util.php?func_name=sendEmail', postData,
                    function(data, status) {

                    // console.log(data);

                    if( status == 'success') {
                        if(data.state == true){ 
                            $('#sectionA #message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            ' + data.user_verify  +'</div>');
                        	
                        	setTimeout(function(){
                                router.navigate('#home');
                            },1500);
                            
                        	
                            }
                        else{
                            $('#sectionA #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            <strong>Error! </strong>' + data.user_verify  +'</div>');
                            }
                        }
                    

                 },'json');
                
            // console.log(1);
        }
    };
});
