define(['durandal/app', 'durandal/system', 'plugins/router', 'settings'], function (app, system, router, settings) {
    return {
    	activate : function () {

            $.post(settings.BASE_URL + 'back-end/plans.php', function(data, status) {
             	if( status == 'success' ) {
                    console.log(data);
                    if(data.status == 'false')
                        router.navigate('login');
                }
            },'json');

    	},

    	selectPackage : function(amount) {			
            $.post(settings.BASE_URL + 'back-end/plans.php', {'package' : amount} ,function(data, status) {
             	if( status == 'success' ) {
                    console.log(data);
                }
                if(data.route_to_dashboard == 'true')
                     router.navigate('dashboard');
                 else {
                        $('#plan_message')
                            .empty().text(data.message).slideDown();
                        
                        $('html,body').animate({scrollTop:0},'fast');
                 }
            },'json');

    	}
    }
});
