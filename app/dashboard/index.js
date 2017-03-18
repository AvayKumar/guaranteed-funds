define(['durandal/app', 'durandal/system', 'plugins/router', 'settings', 'flipdown'], function (app, system, router, settings) {
    return {
    	activate : function() {
            $.post(settings.BASE_URL + 'back-end/dashboard.php', function(data, status) {
             	console.log(data);
             	console.log(status);

             	if(data.status == "false")
             		router.navigate('login');
            },'json');    	
        },
		attached : function() {
	       $('#timer').flipcountdown({size:"lg"});
        }
    }
    
});
