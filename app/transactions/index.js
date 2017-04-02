define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings'], function (app, ko, system, router, settings) {

	return{
		activate: function(){
			$.post(settings.BASE_URL + 'back-end/transactions.php', 
                function(data, status) {

                console.log(data);
                // console.log(data.transaction[0].amount);

                if( status == 'success' && data.success ) { 
                    if( data.auth )                          
                        settings.loggedIn(true);
                    else {
                        router.navigate('login');
                    }
                }
            },'json');
                  
		},

		attached: function(){
			$.post(settings.BASE_URL + 'back-end/transactions.php', function(data, status) {

                console.log(data);
               

                if( status == 'success' && data.success ) { 
                        if( (data.transactionD).length > 0 ) {
                            for(var i=0; i<(data.transactionD).length; i++) {
                                
                                $('#donors')
                                .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
                                                <div class="panel-heading"> <h3 class="panel-title">Transaction Id : ' + data.transactionD[i].t_id + '</h3> </div>\
                                                <div class="panel-body text-center">\
                                                    <table class="table table-bordered table-striped">\
                                                      <tbody>\
                                                        <tr>\
                                                          <td><strong>Name</strong></td>\
                                                          <td>' + data.transactionD[i].receiver + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Amount</strong></td>\
                                                          <td>' + data.transactionD[i].amount + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Paid</strong></td>\
                                                          <td>' + data.transactionD[i].paid + '</td>\
                                                        </tr>\
                                                      </tbody>\
                                                    </table>\
                                                </div>\
                                            </div>\
                                        </div>'));
                                }
                    }

                    if( (data.transactionR).length > 0 ) {
                            for(var i=0; i<(data.transactionR).length; i++) {
                                
                                $('#receivers')
                                .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
                                                <div class="panel-heading"> <h3 class="panel-title">Transaction Id : ' + data.transactionR[i].t_id + '</h3> </div>\
                                                <div class="panel-body text-center">\
                                                    <table class="table table-bordered table-striped">\
                                                      <tbody>\
                                                        <tr>\
                                                          <td><strong>Name</strong></td>\
                                                          <td>' + data.transactionR[i].donor + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Amount</strong></td>\
                                                          <td>' + data.transactionR[i].amount + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Paid</strong></td>\
                                                          <td>' + data.transactionR[i].paid + '</td>\
                                                        </tr>\
                                                      </tbody>\
                                                    </table>\
                                                </div>\
                                            </div>\
                                        </div>'));
                                }
                    }

                }
            },'json');
            
		}


	};
});