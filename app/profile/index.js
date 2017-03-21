define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    return {
    new_pass : ko.observable(),
    conf_new_pass : ko.observable(),
    	doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();			 
			 console.log( postData );             
             
             if(this.new_pass() == this.conf_new_pass()){
                 $.post(settings.BASE_URL + 'back-end/profile.php', postData,
                    function(data, status){
                 	  console.log(data);
                 	  console.log(status);
                      if(data.state == "false"){
                        $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error ! </strong>' + data.log +'</div>');
                     }
                     else
                     {
                       $('#message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Cool ! </strong>' + data.log +'</div>'); 
                     }
                     
                },'json');
            }
            else{
                console.log('password_mismatch');
                $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' +'Password mismatch'  +'</div>');
            }
        
        }
    };
});
