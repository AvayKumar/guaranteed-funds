define(['durandal/app', 'durandal/system', 'plugins/router', 'knockout', 'settings'], function (app, system, router, ko, settings) {

    function validate(postData){
        if(postData[2].value.length != 11 )    
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
                if( status == 'success' && !data.auth ) { 
                    router.reset()
                          .deactivate();                    
                    app.setRoot('logged-out');
                }
            },'json');           
        },
        sendMail : function(formElement) {
             var postData = $(formElement).serializeArray();
             console.log( postData );

            if(validate(postData)){

             $.post(settings.BASE_URL + 'back-end/report.php', postData, function(data, status) {
                if( status == 'success' ) {

                    console.log(data);
                    if( data.status ) {
                        $(formElement)[0].reset();
                        $('#message').empty();
                        $('#support').slideDown();
                        setTimeout(function(){
                            $('#support').slideUp();
                        }, 10000);
                    }
                }
            },'json');
         }
         else { 
                $('#message').empty().html('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>Error! </strong>' + error +'</div>');
             }

            $('html,body').animate({scrollTop:0},'fast'); 
         
        }
    };
});