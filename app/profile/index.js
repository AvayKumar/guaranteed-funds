define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    var formData = ko.observable();
    var name2 = ko.observable('1');
    var contact2 = ko.observable('2');
    var account_name2 = ko.observable('3');
    var account_number2 = ko.observable('4');
    var email2 = ko.observable('5');
    var bank_name2 = ko.observable('6');


    return {
        new_pass : ko.observable(),
        conf_new_pass : ko.observable(),
        
        name : name2,
        contact : contact2,
        account_name : account_name2,
        account_number : account_number2,
        email : email2,
        bank_name : bank_name2,
        activate : function(){
            console.log('?');
            $.post(settings.BASE_URL + 'back-end/util.php?func_name=authStatus2', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                    if( data.auth ) {  
                        formData = data;
                        
                        name2(data.user_name);
                        contact2(data.phone);
                        account_name2(data.account_name);
                        account_number2(data.account_number);
                        email2(data.email);
                        bank_name2(data.bank_name);

                        settings.loggedIn(true);
                    } else {
                        router.navigate('login');
                    }
                }
            },'json');
            

        },
    	doSomething : function(formElement) {
			 var postData = $(formElement).serializeArray();			 
			 console.log( postData );             
             if(this.new_pass() == this.conf_new_pass()){
                 $.post(settings.BASE_URL + 'back-end/profile.php', postData,
                    function(data, status){
                 	  console.log(data);
                 	  console.log(status);
                      if(data.state == "false"){
                        $('#sectionB #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error ! </strong>' + data.log +'</div>');
                     }
                     else
                     {
                       $('#sectionB #message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Cool ! </strong>' + data.log +'</div>'); 
                     }
                     
                },'json');
            }
            else{
                console.log('password_mismatch');
                $('#sectionB #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' +'Password mismatch'  +'</div>');
            }
        
        },

        editDetails : function(formElement)
        {
            var postData = $(formElement).serializeArray();          
             //console.log( postData );  

             $.post(settings.BASE_URL + 'back-end/util.php?func_name=editProfile', postData,
                function(data, status) {

                console.log(data);

                if( status == 'success') {
                    if(data.state == true){ 
                        $('#sectionA #message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Cool! </strong>' + data.log  +'</div>');
                        }
                    else{
                        $('#sectionA #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Cool! </strong>' + data.log  +'</div>');
                        }
                    }
                

            },'json');
             
            // console.log(1);
        }
    };
});
