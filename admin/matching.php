<?php 
  
session_start();
if(!isset($_SESSION['admin_id'])){

  header('location:./login.php');

}  

require '../back-end/require/connection.inc.php' 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Guaranteed Funds</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <?php require 'components/header/styles.php';?>

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">


<?php require 'components/header/header_main.php' ?>

<?php require 'components/header/side_bar.php' ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Matched
        <small>Control panel</small>
      </h1>
    </section>

    <section class="content">
      <div class="row">
    <?php 
    if( isset($_POST['unmatch'])) {
      
      for($i=0;$i<sizeof($_POST['unmatch']);$i++) {
          //echo $i;
        if( isset($_POST['btnUnmatch'])) {
          $sql="UPDATE `transaction_details` SET `user_id_receiver`=NULL WHERE `transaction_id`='{$_POST['unmatch'][$i]}'";
          $res=mysqli_multi_query($connection,$sql);
        } else if( isset($_POST['btnPaid'])){

          $sql_confirmPay = "UPDATE `transaction_details` SET `have_paid`='1' WHERE `transaction_id`='{$_POST['unmatch'][$i]}'";
          $result_confirmPay = mysqli_query($connection, $sql_confirmPay);
          
          $sql = "SELECT `user_id_receiver`, `amount` FROM `transaction_details` WHERE `transaction_id`='{$_POST['unmatch'][$i]}'";
          $res = mysqli_query($connection,$sql);
          if($res) {
              $row = mysqli_fetch_assoc($res);
              $sql_updateReceive = "UPDATE `transaction_details` SET `received_count` = `received_count` + 1 WHERE amount = '{$row['amount']}' AND user_id_donor = '{$row['user_id_receiver']}' AND `received_count` < 2";
              $result_updateReceive = mysqli_query($connection, $sql_updateReceive);             
          }

        } 
        
      }

      if(isset($_POST['btnPaid']) && (!$res || !$result_updateReceive) ){
    ?>
          
        <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
        </div>

    <?php
      } else if(isset($_POST['btnPaid']) && $res && $result_updateReceive){
    ?>

        <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Confirm Paid!</strong>
        </div>

    <?php

      } else if( isset($_POST['btnUnmatch']) && sizeof($_POST['unmatch']) && $res ) {

    ?>
          <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Unmatched succefully!</strong>
          </div>

    <?php
      } else {
    ?>    
          <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
          </div>

    <?php  
      }      
    }
    $sql_user = "SELECT `user_email`, `user_id` FROM `user`";
    $res_user = mysqli_query($connection,$sql_user);

    $userMap = array();

    

    while($row=mysqli_fetch_assoc($res_user)){
      $userMap[$row['user_id']]=$row['user_email'];
    }
      
    $sql_match = "SELECT * FROM `transaction_details` WHERE `user_id_receiver` IS NOT NULL AND `have_paid`='0'";
    $res_match = mysqli_query($connection, $sql_match);
    
    // $sql_user = "SELECT * FROM `user`";
    // $res_user = mysqli_query($connection,$sql_user);
    // if($res_user){
    //   $map = array();
    //   while($row = mysqli_fetch_assoc($res_user)){
    //     $map[$row['user_id']] = $row['user_email'];
    //   }
    // }
    if($res_match) {
      ?>
    <div class="col-xs-12">
        <form method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Select</th>
                      <th>Tranasction Id</th>
                      <th>Donor Id</th>
                      <th>Donor Email</th>
                      <th>Receiver Id</th>
                      <th>Receiver Email</th>
                      <th>Amount</th>
                      <th>Time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
              <?php
                while($row = mysqli_fetch_assoc($res_match)){
              ?>
                    <tr>
                      <td><input type="checkbox" name="unmatch[]" class="chk" value='<?php echo $row['transaction_id']?>'/>&nbsp;</td>
                      <td><?php echo $row['transaction_id']?></td>
                      <td><?php echo $row['user_id_donor']?></td>
                      <td><?php echo $userMap[$row['user_id_donor']]?></td>
                      <td><?php echo $row['user_id_receiver']?></td>
                      <td><?php echo $userMap[$row['user_id_receiver']]?></td>
                      <td><?php echo $row['amount']?></td>
                      <td><?php echo $row['time_stamp']?></td>
                      <td>Pending</td>
                    </tr>
              <?php
                }
        }
        ?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <input type="submit" class="btn btn-primary" value='Unmatch' id="checkBtn" name="btnUnmatch" disabled>
              <input type="submit" class="btn btn-primary" value='Mark Paid' id="checkBtn2" name="btnPaid" disabled>
            </div><!-- /.box-footer -->
          </div><!-- box -->
        </form>
    </div><!-- col-xs-12 -->
    </div>
  </section>

  <!--match control panel  -->
  <section class="content-header">
    <h1>
      Match
      <small>Control panel</small>
    </h1>
    <?php
      if( isset($_POST['match1']) && isset($_POST['match2']) ) {
        
        $time_stamp = date('Y-m-d H:i:s');

        $sql_matching="UPDATE `transaction_details` SET `user_id_receiver`='{$_POST['match2']}',`time_stamp` = '{$time_stamp}' WHERE `transaction_id`='{$_POST['match1']}'";
        $res_matching=mysqli_query($connection,$sql_matching);
      
        if($res_matching) {    
    ?>
    <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Paired succefully!</strong>
    </div>

    <?php
        } else {
    ?>
    <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
    </div>
        
    <?php   
      }
    }
    ?>
    </section>

    <section class="content">
      <form method="post">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Monthly Recap Report</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">    
            <div class="col-xs-12">
              <div class="form-group">
                <select class="form-control" id="package">
                  <option value = '10000'>10,000</option>
                  <option value = '30000'>30,000</option>
                  <option value = '100000'>100,000</option>
                  <option value = '200000'>200,000</option>
                  <option value = '500000'>500,000</option>
                </select>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="table-responsive">
                <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Select</th>
                            <th>Donor Id</th>
                            <th>Donor Email</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                        if( !isset($_GET['amount']) ){
                          $_GET['amount']='10000';
                        }

                        $sql_donor="SELECT t.user_id_donor AS `user_id_donor`,t.transaction_id AS `transaction_id`, u.user_email AS `user_email` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor=u.user_id WHERE t.user_id_receiver IS NULL AND t.amount='{$_GET['amount']}' AND u.user_blocked='0'";
                        $res_donor=mysqli_query($connection,$sql_donor);
                        while($row = mysqli_fetch_assoc($res_donor)){
                      ?>
                        <tr>
                          <td><input type="radio" name="match1" class="radio" value='<?php echo $row['transaction_id']?>'/>&nbsp;</td>
                          <td><?php echo $row['user_id_donor'];?></td>
                          <td><?php echo $row['user_email'];?></td>
                        </tr>

                    <?php
                        }
                    ?>    
                      </tbody>
                    </table>
                </div>
              </div>

      <?php
      if( isset($_POST['match1']) && isset($_POST['match2']) ) {
        
        $time_stamp = date('Y-m-d H:i:s');

        $sql_matching="UPDATE `transaction_details` SET `user_id_receiver`='{$_POST['match2']}',`time_stamp` = '{$time_stamp}' WHERE `transaction_id`='{$_POST['match1']}'";
        $res_matching=mysqli_query($connection,$sql_matching);
        //print_r($res_matching); 
      }
      ?>
            <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                      <th>Select</th>
                      <th>Receiver Id</th>
                      <th>Receiver Email</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    // $sql_receiver="SELECT t.user_id_donor AS `user_id_donor`, u.user_email AS `user_email` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor = u.user_id WHERE t.user_id_receiver IS NOT NULL AND t.have_paid ='1' AND t.amount ='{$_GET['amount']}' AND t.received_count < '2' AND u.user_blocked='0'";
                    
                    $sql_receiver="SELECT t.user_id_donor AS `user_id_donor`, u.user_email AS `user_email` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor = u.user_id  WHERE  t.have_paid ='1' AND t.amount ='{$_GET['amount']}' AND t.received_count < '2' AND u.user_blocked='0' AND `user_id_donor` NOT IN ( SELECT `user_id_receiver` AS `user_id_donor` FROM `transaction_details`  WHERE `user_id_receiver`IS NOT NULL AND `amount`='{$_GET['amount']}' AND `have_paid`='0' GROUP BY `user_id_receiver` HAVING count(*) = '2' )";



                    $res_receiver=mysqli_query($connection,$sql_receiver);

                    ?> 
                    <tr>
                      <td><input type="radio" name="match2" class="radio" value='0'/>&nbsp;</td>
                      <td>0</td>                          
                      <td><?php echo $userMap[0]?></td>
                    </tr>
                    <?php  


                    while($row = mysqli_fetch_assoc($res_receiver)){
                  ?>      
                    <tr>
                      <td><input type="radio" name="match2" class="radio" value='<?php echo $row['user_id_donor']?>'/>&nbsp;</td>
                      <td><?php echo $row['user_id_donor'];?></td>
                      <td><?php echo $row['user_email'];?></td>
                    </tr>
              
                  <?php
                }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
        <div class="box-footer clearfix">
          <input type="submit" class="btn btn-primary" value='Pair' id="radioBtn" disabled>
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </form>
  </section>
    
  </div>

  <!-- /.content-wrapper -->


  <?php require 'components/footer/footer.php' ?>

</div>
<!-- ./wrapper -->

<?php require 'components/footer/scripts.php' ?>

<script type="text/javascript">
$("input[type='checkbox']").on('change', function(){
  console.log($('input[type=\'checkbox\']:checked').size() ); 
  $('#checkBtn').attr("disabled", $('input[type=\'checkbox\']:checked').size() == 0);
  $('#checkBtn2').attr("disabled", $('input[type=\'checkbox\']:checked').size() == 0);
});

$("input[type='radio']").on('change', function(){
  console.log($('input[type=\'radio\']:checked').size() ); 
  $('#radioBtn').attr("disabled", $('input[type=\'radio\']:checked').size() <2 );
});

$("select").on('change', function(e){
  console.log(this.value); 
  window.location.href='matching.php?amount='+this.value;
});

window.onload = function(){  
  $('#package > option[value=\'<?php echo $_GET['amount']; ?>\']').prop('selected',true);
};

</script>

</body>
</html>
