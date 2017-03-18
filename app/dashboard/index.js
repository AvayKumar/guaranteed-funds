define(['durandal/app', 'durandal/system', 'plugins/router', 'flipdown'], function (app, system, router) {
    return {
		attached : function() {
	       $('#timer').flipcountdown({size:"lg"});
        },

        activate: function(){
        	$.post('http://localhost/guaranteed-funds/back-end/dashboard.php',
                function(data, status) {
             	console.log(data);
             	console.log(status);

             	if(data.status == "false")
             		router.navigate('login');
            },'json');
        }

        
    }
});
