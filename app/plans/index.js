define(['durandal/app', 'knockout', 'durandal/system', 'plugins/router', 'settings'], function (app, ko, system, router, settings) {
    
    var plan2 = ko.observable('');

    return {
        plan : plan2,
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
            plan2('₦ '+amount);	
            $('#confirmPlan').modal({show: true});
            
            $('button.confirm').click(function(){                                
                $('#confirmPlan').modal('toggle');

            $.post(settings.BASE_URL + 'back-end/plans.php', {'package' : amount} ,function(data, status) {
             	if( status == 'success' ) {
                    console.log(data);
                }
                if(data.route_to_dashboard == 'true')
                     {                        
                        $('#plan_message')
                            .empty().text(data.message).slideDown();
                        
                        $('html,body').animate({scrollTop:0},'fast')

                        setTimeout(function(){
                            router.navigate('dashboard');                                
                        },1500);

                     }
                 else {
                        $('#plan_message')
                            .empty().text(data.message).slideDown();
                        
                        $('html,body').animate({scrollTop:0},'fast');
                 }
            },'json');

        });

    	}
    }
});
