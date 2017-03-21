define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings', 'flipdown'], function (app, ko, system, router, settings) {

	var payment_received = ko.observable('');
	var payment_made = ko.observable('');		
    var amount = ko.observable('');
    var referral_bonus = ko.observable('');
    var can_submit = ko.observable(false);

    return {
    	pay_received : payment_received,
    	pay_made : payment_made,
    	amount_received : amount,
    	bonus : referral_bonus,
        canSubmit : can_submit,
    	activate : function() {

            $.post(settings.BASE_URL + 'back-end/util.php?func_name=authStatus', 
                function(data, status) {

                console.log(data);

                if( status == 'success' && data.success ) { 
                    if( data.auth ) {  
                        settings.loggedIn(true);
                    } else {
                        router.navigate('login');
                    }
                }

            },'json');
            
        },
		attached : function() {

            $('#data-loader').show();

            $.post(settings.BASE_URL + 'back-end/dashboard.php', function(data, status) {

                console.log(data);

                if(status == 'success') {
                    payment_received(data.pay_received);
                    payment_made(data.pay_made);
                    amount(data.amount_recv);
                    referral_bonus(data.bonus);

                    if(data.route_to_package){
                        router.navigate('plans');
                        return;
                    }

                    if( (data.don).length > 0 ) {
                        for(var i=0; i<(data.don).length; i++) {
                            $('#receivers')
                            .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                        <div class="panel panel-primary timer-panel">\
                                            <div class="panel-heading"> <h3 class="panel-title">Package : ' + data.don[i].amount + '</h3> </div>\
                                            <div class="panel-body text-center">\
                                                <table class="table table-bordered table-striped">\
                                                  <tbody>\
                                                    <tr>\
                                                      <td><strong>Name</strong></td>\
                                                      <td>' + data.don[i].name + '</td>\
                                                    </tr>\
                                                    <tr>\
                                                      <td><strong>Email</strong></td>\
                                                      <td>' + data.don[i].email + '</td>\
                                                    </tr>\
                                                    <tr>\
                                                      <td><strong>Phone</strong></td>\
                                                      <td>' + data.don[i].phone + '</td>\
                                                    </tr>\
                                                  </tbody>\
                                                </table>\
                                                <h4><span class="label label-warning">Pay Before</span></h4>\
                                                <div id="timer' + i + '" style="margin-bottom: 10px;"></div>\
                                                <div class="panel-footer" style="background-color: #FFFFFF">\
                                                    <button class="btn btn-primary btn-block upload"  role="button" data-amount="' + data.don[i].amount + '">Upload <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></button>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>'));
                            $('#timer' + i).flipcountdown({
                                size:'sm',
                                beforeDateTime: data.don[i].time_left
                            });
                        }
                        $('.receivers').fadeIn();
                    }

                    if( (data.rec).length > 0 ) {
                        for(var i=0; i<(data.rec).length; i++) {
                            $('#donors')
                        .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                        <div class="panel panel-primary timer-panel">\
                                            <div class="panel-heading"> <h3 class="panel-title">Package : ' + data.rec[i].amount + '</h3> </div>\
                                            <div class="panel-body text-center">\
                                                <table class="table table-bordered table-striped">\
                                                  <tbody>\
                                                    <tr>\
                                                      <td><strong>Name</strong></td>\
                                                      <td>' + data.rec[i].name + '</td>\
                                                    </tr>\
                                                    <tr>\
                                                      <td><strong>Email</strong></td>\
                                                      <td>' + data.rec[i].email + '</td>\
                                                    </tr>\
                                                    <tr>\
                                                      <td><strong>Phone</strong></td>\
                                                      <td>' + data.rec[i].phone + '</td>\
                                                    </tr>\
                                                  </tbody>\
                                                </table>\
                                                <div id="timer' + i + '" style="margin-bottom: 10px;"></div>\
                                                <div class="panel-footer" style="background-color: #FFFFFF">\
                                                    <button class="btn btn-primary btn-block disabled" href="#" role="button">Waiting for Payment</button>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>'));
                        }
                        $('.donors').fadeIn();
                    }
                    
                    $('#data-loader').fadeOut();
                    $('button.upload').click(function(){
                        //console.log($(this).attr('data-amount'));
                        $('#fileUpload').modal({show: true}); 
                    });
                }

            },'json');

            $('#pay_doc').on('change', function (e) {

                var filesize = (e.currentTarget.files[0].size/1024).toFixed(4); // KB
                if(filesize > 512) {
                    $('#fileUpload div.alert').slideDown();                    
                    can_submit(false);
                } else {
                    $('#fileUpload div.alert').slideUp();                    
                    can_submit(true);
                }
                
            });

        }
    }

});
