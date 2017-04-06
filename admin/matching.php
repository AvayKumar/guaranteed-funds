<?php require '../back-end/require/connection.inc.php' ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Guaranteed Funds</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
    <?php require 'components/header/styles.php';?>

</head><body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php require 'components/header/header_main.php' ?>

<?php require 'components/header/side_bar.php' ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="container">
      <h1>
        Matched
        <small>Control panel</small>
      </h1>
      </div>
    </section>

    

    <section>
    <div class="container">
    <div class="row">
    <?php 
    if( isset($_POST['unmatch']) ) {
      
      for($i=0;$i<sizeof($_POST['unmatch']);$i++)
        {
          //echo $i;
        $sql="UPDATE `transaction_details` SET `user_id_receiver`=NULL WHERE `transaction_id`='{$_POST['unmatch'][$i]}'";
        $res=mysqli_multi_query($connection,$sql);
        }

        
        if(sizeof($_POST['unmatch']) && $res)
          {
        
        ?>
          <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Unmatched succefully!</strong>
          </div>

        <?php
          }
          else
          {
        ?>    
          <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
          </div>

        <?php  
          }      
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
    if($res_match){
      ?>
      <form method="post">
      <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
          <thead>
          <tr>
              <th>Select</th>
              <th>Tranasction Id</th>
              <th>Donor Id</th>
              <th>Receiver Id</th>
              <th>Amount</th>
              <th>Time</th>
              <th>Status</th>
            </tr>
            </thead>
            <tbody>
          <?php
      while($row = mysqli_fetch_assoc($res_match)){
        // echo $row['transaction_id']." ".$row['user_id_donor']." ".$row['user_id_receiver'].'</br>';
        ?>
            
            <tr>
              <td><input type="checkbox" name="unmatch[]" class="chk" value='<?php echo $row['transaction_id']?>'/>&nbsp;</td>
              <td><?php echo $row['transaction_id']?></td>
              <td><?php echo $row['user_id_donor']?></td>
              <td><?php echo $row['user_id_receiver']==NULL?'Not Matched':$row['user_id_receiver']?></td>
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
        <input type="submit" class="btn btn-primary" value='Unmatch' id="checkBtn" disabled>
      </div>
      </form>

    </div> 
    </div>
    <!--match control panel  -->

    <section class="content-header">
     <div class="container">
      <h1>
        Match
        <small>Control panel</small>
      </h1>
    
    <?php
    if( isset($_POST['match1']) && isset($_POST['match2']) ) {
      
      $time_stamp = date('Y-m-d H:i:s');

      $sql_matching="UPDATE `transaction_details` SET `user_id_receiver`='{$_POST['match2']}',`time_stamp` = '{$time_stamp}' WHERE `transaction_id`='{$_POST['match1']}'";
      $res_matching=mysqli_query($connection,$sql_matching);
    
      if($res_matching){
    
    ?>
    <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Paired succefully!</strong>
    </div>

    <?php
    }
    else{
    ?>
    <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
    </div>
        
    <?php   
      }
    }
    ?>

      </div>
    </section>

    <section>
    <div class="container">
    <div class="row">    
    <div class="col-xs-12">
      <select class="form-control" id="package">
        <option value = '10000'>10,000</option>
        <option value = '30000'>30,000</option>
        <option value = '100000'>100,000</option>
        <option value = '200000'>200,000</option>
        <option value = '500000'>500,000</option>
      </select>
    </div>
    <form method="post">
      <div class="col-xs-6">
      <div class="table-responsive">
          <table class="table table-striped">
          <thead>
          <tr>
              <th>Select</th>
              <th>Donor Id</th>
            </tr>
          </thead>
          <tbody>
      <?php

        if( !isset($_GET['amount']) ){
          $_GET['amount']='10000';
        }

        $sql_donor="SELECT t.user_id_donor AS `user_id_donor`,t.transaction_id AS `transaction_id` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor=u.user_id WHERE t.user_id_receiver IS NULL AND t.amount='{$_GET['amount']}' AND u.user_blocked='0'";
        $res_donor=mysqli_query($connection,$sql_donor);
        while($row = mysqli_fetch_assoc($res_donor)){
        // echo $row['transaction_id']." ".$row['user_id_donor']." ".$row['user_id_receiver'].'</br>';
      ?>      
          <tr>
            <td><input type="radio" name="match1" class="radio" value='<?php echo $row['transaction_id']?>'/>&nbsp;</td>
            <td><?php echo $row['user_id_donor'];?></td>
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
       <table class="table table-striped">
          <thead>
          <tr>
              <th>Select</th>
              <th>Receiver Id</th>
            </tr>
          </thead>
          <tbody>
        <?php
          $sql_receiver="SELECT t.user_id_donor AS `user_id_donor` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor = u.user_id WHERE t.user_id_receiver IS NOT NULL AND t.have_paid ='1' AND t.amount ='{$_GET['amount']}' AND t.received_count < '2' AND u.user_blocked='0'";
          $res_receiver=mysqli_query($connection,$sql_receiver);

          while($row = mysqli_fetch_assoc($res_receiver)){
        ?>      
          <tr>
            <td><input type="radio" name="match2" class="radio" value='<?php echo $row['user_id_donor']?>'/>&nbsp;</td>
            <td><?php echo $row['user_id_donor'];?></td>
          </tr>
    
        <?php
      }
        ?>
          </tbody>
    </table>
    </div>
    </div>

    <div class="container">
    <input type="submit" class="btn btn-primary" value='Pair' id="radioBtn" disabled>
    </div>  

    </form>
    </div>
    </div>
    </section>
    

    </section>
  </div>

  <!-- /.content-wrapper -->


  <?php require 'components/footer/footer.php' ?>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script type="text/javascript">
$("input[type='checkbox']").on('change', function(){
  console.log($('input[type=\'checkbox\']:checked').size() ); 
  $('#checkBtn').attr("disabled", $('input[type=\'checkbox\']:checked').size() == 0);
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
