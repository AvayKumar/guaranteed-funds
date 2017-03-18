define(['durandal/app', 'durandal/system', 'plugins/router', 'settings', 'flipdown'], function (app, system, router, settings) {
    return {
    	activate : function() {
            $.post(settings.BASE_URL + 'back-end/', function(data, status) {
             	if( status == 'success' ) {
                    console.log(data);
					if(data.status == 'ok' && !data.authenticated) {
                        router.navigate('login');
                    }
                }
            },'json');
    	},
		attached : function() {
	       	$('#timer').flipcountdown({size:"lg"});
        }
    }
});
