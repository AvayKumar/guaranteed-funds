define(['durandal/app', 'durandal/system', 'plugins/router','knockout', 'settings'], function (app, system, router, ko, settings) {
    
    var formData = ko.observable();

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    };
    
    return {
        // token : ko.observable(''),
        // email : ko.observable(''),
        pwd : ko.observable(''),
        cpwd : ko.observable(''),
    
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

        newPassword : function(formElement) {
            var postData = $(formElement).serializeArray();          
             console.log( postData );

             var token=getParameterByName('t');
             var user=getParameterByName('u');
             
             postData.push({name:'token',value:token});  
             postData.push({name:'user',value:user});  
             
             if(this.pwd()!=this.cpwd()){
                    
                    $('#sectionA #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                    <span aria-hidden="true">&times;</span></button>\
                    <strong>Error! </strong>' + 'Password mismatch' +'</div>');
                    
             }
             else{
                 $.post(settings.BASE_URL + 'back-end/util.php?func_name=changePassword', postData,
                    function(data, status) {

                    console.log(data);

                    if( status == 'success') {
                        if(data.state == true){ 
                            $('#sectionA #message').empty().html('<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            <strong>Congrats! </strong>' + data.log  +'</div>');
                            
                            setTimeout(function(){
                                router.navigate('#login');
                            },1500);
                                
                            }
                        else{
                            $('#sectionA #message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span></button>\
                            <strong>Error! </strong>' + data.log  +'</div>');
                            }
                        }
                    

                 },'json');
            }
        }
    };
});
