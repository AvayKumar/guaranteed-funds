define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings', 'flipdown'], function (app, ko, system, router, settings) {

	var payment_received = ko.observable('');
	var payment_made = ko.observable('');		
    var amount = ko.observable('');
    var referral_bonus = ko.observable('');
    return {
    	pay_received : payment_received,
    	pay_made : payment_made,
    	amount_received : amount,
    	bonus : referral_bonus,
    	activate : function() {
            $('#data-loader').show();
            $.post(settings.BASE_URL + 'back-end/dashboard.php', function(data, status) {
             	console.log(data);
             	console.log(status);
             	if(data.status == "true") {	
					payment_received(data.pay_received);
					payment_made(data.pay_made);
					amount(data.amount_recv);
					referral_bonus(data.bonus);
             	}
             	
                if(data.status == "false"){
             		router.navigate('login');
                } 
                else {
                    settings.loggedIn(true);
                }

             	if(data.route_to_package == "true")
             		{
                        router.navigate('plans');
                    }
                $('#data-loader').fadeOut();
            },'json');


            
        },
		attached : function() {
	       $('#timer').flipcountdown({size:"lg"});
        }
    }

});
