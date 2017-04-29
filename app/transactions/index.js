define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings'], function (app, ko, system, router, settings) {

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
		attached: function(){
			$.post(settings.BASE_URL + 'back-end/transactions.php', function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                        if( (data.tidD).length > 0 ) {
                            for(var i=0; i<(data.tidD).length; i++) {
                                
                                $('#donors')
                                .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
                                                <div class="panel-heading"> <h3 class="panel-title">Transaction Id : ' + data.tidD[i].t_id + '</h3> </div>\
                                                <div class="panel-body text-center">\
                                                    <table class="table table-bordered table-striped">\
                                                      <tbody>\
                                                        <tr>\
                                                          <td><strong>Name</strong></td>\
                                                          <td>' + data.tidD[i].receiver + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Amount</strong></td>\
                                                          <td>' + data.tidD[i].amount + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Phone</strong></td>\
                                                          <td>' + data.tidD[i].phone + '</td>\
                                                        </tr>\
                                                      </tbody>\
                                                    </table>\
                                                </div>\
                                            </div>\
                                        </div>'));
                                }
                    }

                    if( (data.tidR).length > 0 ) {
                            for(var i=0; i<(data.tidR).length; i++) {
                                
                                $('#receivers')
                                .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
                                                <div class="panel-heading"> <h3 class="panel-title">Transaction Id : ' + data.tidR[i].t_id + '</h3> </div>\
                                                <div class="panel-body text-center">\
                                                    <table class="table table-bordered table-striped">\
                                                      <tbody>\
                                                        <tr>\
                                                          <td><strong>Name</strong></td>\
                                                          <td>' + data.tidR[i].donor + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Amount</strong></td>\
                                                          <td>' + data.tidR[i].amount + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>Phone</strong></td>\
                                                          <td>' + data.tidR[i].phone + '</td>\
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