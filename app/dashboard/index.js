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
            $(function(){

                $.post(settings.BASE_URL + 'back-end/dashboard.php', function(data, status) {

                    console.log(data);

                    if(status == 'success' && data.auth ) {
                        payment_received(data.pay_received);
                        payment_made(data.pay_made);
                        amount(data.amount_recv);
                        referral_bonus(data.bonus);

                        if(data.route_to_package){
                            router.navigate('plans');
                            return;
                        }

                        for(var j=0; j<data.numberPost; j++) {

                        $('#notification').append($('<div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span></button>\
                        <strong>' + data.content[j] +'</strong></div>'));                    
                        }    

                        if( (data.plan).length > 0 ) {

                            var now = new Date();

                            for(var i=0; i<(data.plan).length; i++) {
                                $('#to-match').append($('<div class="col-xs-12 col-sm-6 col-md-4">\
                                                            <div class="panel panel-success timer-panel">\
                                                                <div class="panel-heading"> <h3 class="panel-title">Package : ' + data.plan[i].amount + '</h3> </div>\
                                                                <div class="panel-body text-center">\
                                                                    <div id="to-timer' + i + '" class="well well-sm"></div>\
                                                                </div>\
                                                            </div>\
                                                        </div>'));

                                now.setSeconds(now.getSeconds() + parseInt(data.plan[i].time_left.s) );
                                now.setMinutes(now.getMinutes() + parseInt(data.plan[i].time_left.m) );
                                now.setHours(now.getHours() + parseInt(data.plan[i].time_left.h) );
                                now.setDate(now.getDate() + parseInt(data.plan[i].time_left.d));
                                
                                console.log(now.toString());

                                var month = now.getMonth() < 10 ?'0' + (now.getMonth()+1): (now.getMonth()+1);
                                var date = now.getDate() < 10 ?'0' + now.getDate() : now.getDate();
                                var hrs = now.getHours() < 10 ?'0' + now.getHours() : now.getHours();
                                var mins = now.getMinutes() < 10 ?'0' + now.getMinutes() : now.getMinutes();
                                var sec = now.getSeconds() < 10 ?'0' + now.getSeconds() : now.getSeconds();

                                console.log(month + '/' + date + '/' + now.getFullYear() + ' ' + hrs + ':' + mins + ':' + sec);

                                $('#to-timer' + i).flipcountdown({
                                    size:'sm',
                                    beforeDateTime: month + '/' + date + '/' + now.getFullYear() + ' ' + hrs + ':' + mins + ':' + sec
                                });

                            }

                            $('.to-match').fadeIn();

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
                                                        <button class="btn btn-submit btn-block upload' + ( data.don[i].fileName ? ' disabled btn-warning' : '') + '"  role="button" data-amount="' + data.don[i].amount + '">'+buttonMessage+' <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></button>' +
                                                        (!data.don[i].time_upload?'<button class="btn btn-cancel btn-block cancel btn-warning"  role="button" data-tid="' + data.don[i].tid + '">'+'cancel'+' <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>':'') +
                                                    '</div>\
                                                </div>\
                                            </div>\
                                        </div>'));

                                var now = new Date();                                
                                console.log(now.toString());


                                if( data.don[i].time_upload ) {
                                    now.setSeconds( parseInt(data.don[i].time_upload.s) );
                                    now.setMinutes( parseInt(data.don[i].time_upload.m) );
                                    now.setHours( parseInt(data.don[i].time_upload.h) );
                                    // now.setDate( parseInt(data.don[i].time_upload.d) );
                                    
                                    console.log(now.toString());
                                    
                                    // var month = now.getMonth() < 10 ?'0' + (now.getMonth()+1): (now.getMonth()+1);
                                    var date = data.don[i].time_upload.d = '0' ?'00': now.getDate();
                                    var hrs = now.getHours() < 10 ?'0' + now.getHours() : now.getHours();
                                    var mins = now.getMinutes() < 10 ?'0' + now.getMinutes() : now.getMinutes();
                                    var sec = now.getSeconds() < 10 ?'0' + now.getSeconds() : now.getSeconds();

                                    console.log(date + ':' + hrs + ':' + mins + ':' + sec);
                                    
                                    var FreezeTime = date + ':' + hrs + ':' + mins + ':' + sec;
                                    
                                    $('#timer' + i).flipcountdown({
                                        size:'sm',
                                        autoUpdate: false,
                                        tick: function(){            
                                             return FreezeTime;
                                        }
                                    });

                                }
                                else if( data.don[i].time_left ) {
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

                                    
                                    // var FreezeTime = '00'+ ':' + hrs + ':' + mins + ':' + sec;
                                    // $('#timer' + i).flipcountdown({
                                    //     size:'sm',
                                    //     // beforeDateTime: month + '/' + date + '/' + now.getFullYear() + ' ' + hrs + ':' + mins + ':' + sec
                                    //     tick: function(){
                                            
                                    //         return FreezeTime;
                                    //     }
                                    // });
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
                                                        <button data-tid="' + data.rec[i].tid + '" data-amount="' + data.rec[i].amount + '" class="cnfrm btn btn-submit btn-block'+ fileStatus + '" href="#" role="button">'+ buttonMessage +'</button>'
                                                        +
                                                        (data.rec[i].fileName?'<a href="back-end/uploads/'+ data.rec[i].fileValue+'" download class="btn btn-cancel btn-block download btn-warning"  role="button" data-file="' + data.rec[i].fileValue + '">'+'Download File'+' <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>':'') +
                                                    '</div>\
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


                        $('button.cancel').click(function(){
                            console.log($(this).attr('data-tid'));
                            var that=this;
                            $('#cancelPay form')
                                .remove('#cancelPay form input[name="tid"]')
                                .append('<input type="hidden" value="' + $(that).attr('data-tid') + '" name="tid">');
                            $('#cancelPay').modal({show: true});    
                        });

                        $('button.cnfrm').click(function(){
                            var _this = this;
                            // console.log();
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

                        $('button.download').click(function(){
                            console.log($(this).attr('data-file'));

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
