define(['durandal/app', 'durandal/system', 'plugins/router', 'knockout', 'settings'], function (app, system, router, ko, settings) {
    return {
        sendMail : function(formElement) {
             var postData = $(formElement).serializeArray();
             console.log( postData );

             $.post(settings.BASE_URL + 'back-end/support.php', postData, function(data, status) {
                if( status == 'success' ) {

                    console.log(data);
                    if( data.status ) {
                        $(formElement)[0].reset();
                        $('#support').slideDown();
                        setTimeout(function(){
                            $('#support').slideUp();
                        }, 10000);
                    }
                }
            },'json');
        }
    };
});