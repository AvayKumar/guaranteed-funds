define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings', 'flipdown'], function (app, ko, system, router, settings) {

	var payment_received = ko.observable('');
	var payment_made = ko.observable('');		
    var amount = ko.observable('');
    var referral_bonus = ko.observable('');
    var can_submit = ko.observable(false);
    var post = ko.observable('');

    return {
    	pay_received : payment_received,
    	pay_made : payment_made,
    	amount_received : amount,
    	bonus : referral_bonus,
        canSubmit : can_submit,
        
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
		attached : function() {

            $(function(){

                $.post(settings.BASE_URL + 'back-end/dashboard.php', function(data, status) {

                    console.log(data);

                    if(status == 'success' && data.auth ) {

                        if(data.route_to_package || !data.loop_exist){
                            router.navigate('plans');
                            return;
                        }

                        payment_received(data.pay_received);
                        payment_made(data.pay_made);
                        amount(data.amount_recv);
                        referral_bonus(data.bonus);


                        for(var j=0; j<data.numberPost; j++){

                        $('#notification').append($('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>' + data.content[j] +'</strong></div>'));                    

                        }    

                        if( (data.don).length > 0 ) {
                            for(var i=0; i<(data.don).length; i++) {
                                var buttonMessage =  data.don[i].fileName ?'Awaiting Confirmation':'Upload';
                                $('#receivers')
                                .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
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
                                                        <tr>\
                                                          <td><strong>Bank</strong></td>\
                                                          <td>' + data.don[i].bank + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>AccName</strong></td>\
                                                          <td>' + data.don[i].accnt_name + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>AccNumber</strong></td>\
                                                          <td>' + data.don[i].accnt_number + '</td>\
                                                        </tr>\
                                                      </tbody>\
                                                    </table>\
                                                    <h4><span class="label label-warning">Pay Before</span></h4>\
                                                    <div id="timer' + i + '" style="margin-bottom: 10px;"></div>\
                                                    <div class="panel-footer" style="background-color: #FFFFFF">\
                                                        <button class="btn btn-submit btn-block upload' + ( data.don[i].fileName ? ' disabled btn-warning' : '') + '"  role="button" data-amount="' + data.don[i].amount + '">'+buttonMessage+' <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></button>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>'));
                                var now = new Date();
                                console.log(now.toString());
                                if( data.don[i].time_left ) {
                                    now.setSeconds(now.getSeconds() + parseInt(data.don[i].time_left.s) );
                                    now.setMinutes(now.getMinutes() + parseInt(data.don[i].time_left.m) );
                                    now.setHours(now.getHours() + parseInt(data.don[i].time_left.h) );
                                    now.setDate(now.getDate() + parseInt(data.don[i].time_left.d));
                                    
                                    console.log(now.toString());

                                    var month = now.getMonth() < 10 ?'0' + (now.getMonth()+1): (now.getMonth()+1);
                                    var date = now.getDate() < 10 ?'0' + now.getDate() : now.getDate();
                                    var hrs = now.getHours() < 10 ?'0' + now.getHours() : now.getHours();
                                    var mins = now.getMinutes() < 10 ?'0' + now.getMinutes() : now.getMinutes();
                                    var sec = now.getSeconds() < 10 ?'0' + now.getSeconds() : now.getSeconds();

                                    console.log(month + '/' + date + '/' + now.getFullYear() + ' ' + hrs + ':' + mins + ':' + sec);
                                    $('#timer' + i).flipcountdown({
                                        size:'sm',
                                        beforeDateTime: month + '/' + date + '/' + now.getFullYear() + ' ' + hrs + ':' + mins + ':' + sec
                                    });
                                }
                            }
                            $('.receivers').fadeIn();
                        }

                        if( (data.rec).length > 0 ) {
                            for(var i=0; i<(data.rec).length; i++) {
                            var fileStatus = data.rec[i].fileName ? '':' disabled';  
                            var buttonMessage =  data.rec[i].fileName ? 'Confirm Payment':'Waiting for payment';    
                                $('#donors')
                            .append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                            <div class="panel panel-success timer-panel">\
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
                                                        <tr>\
                                                          <td><strong>Bank</strong></td>\
                                                          <td>' + data.rec[i].bank + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>AccName</strong></td>\
                                                          <td>' + data.rec[i].accnt_name + '</td>\
                                                        </tr>\
                                                        <tr>\
                                                          <td><strong>AccNumber</strong></td>\
                                                          <td>' + data.rec[i].accnt_number + '</td>\
                                                        </tr>\
                                                      </tbody>\
                                                    </table>\
                                                    <div id="timer' + i + '" style="margin-bottom: 10px;"></div>\
                                                    <div class="panel-footer" style="background-color: #FFFFFF">\
                                                        <button data-tid="' + data.rec[i].tid + '" data-amount="' + data.rec[i].amount + '" class="cnfrm btn btn-submit btn-block'+ fileStatus + '" href="#" role="button">'+ buttonMessage +'</button>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>'));
                            }
                            $('.donors').fadeIn();
                        }

                        if( (data.wait).length > 0 ) {

                        for(var i=0; i<(data.wait).length; i++) {
                                $('#waiting')
                                    .append('<div class="col-xs-12 col-sm-6 col-md-4">\
                                                <div class="panel panel-success timer-panel">\
                                                    <div class="panel-heading"> <h3 class="panel-title">Package : ' + data.wait[i].amount + '</h3> </div>\
                                                    <div class="panel-body text-center">\
                                                        <div class="well well-sm"><h4 style="color: black;">Waiting to be merged <i class="fa fa-clock-o fa-lg" aria-hidden="trie"></i> </h4>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                            </div>');
                            }
                            $('.waiting').fadeIn();
                        }
                        
                        $('#data-loader').fadeOut();
                        $('button.upload').click(function(){
                            if( !$(this).hasClass('disabled') ) {
                                $('#fileUpload form')
                                .remove('#fileUpload form input[name="package"]')
                                .append('<input type="hidden" value="' + $(this).attr('data-amount') + '" name="package">');
                                $('#fileUpload').modal({show: true});
                            }
                        });

                        $('button.cnfrm').click(function(){
                            var _this = this;
                            console.log();
                            if(!$(this).hasClass('disabled')) {
                                $.post(settings.BASE_URL + 'back-end/util.php?func_name=confirmPayment', {'tid':$(this).attr('data-tid'), 'amount':$(this).attr('data-amount')}, 
                                    function(data, status) {
                                        console.log(data);
                                        if(status == 'success' && data.success){
                                            console.log('Exe');
                                            $(_this).addClass('disabled btn-info')
                                                   .removeClass('btn-primary').text('Confirmed').unbind();
                                        }
                                }, 'json');
                            }
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
            });

        }
    }

});
