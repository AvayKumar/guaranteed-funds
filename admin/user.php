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
        Users
        <small>Control panel</small>
      </h1>
      </div>
    </section>

    

    <section>
    <div class="container">
    <div class="row">
    <?php 
    
    $sql_user = "SELECT * FROM `user`";
    $res_user = mysqli_query($connection,$sql_user);
    
    if($res_user){
      ?>
      <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
          <thead>
          <tr>
              <th>User Id</th>
              <th>User Name</th>
              <th>User Email</th>
              <th>Referral Email</th>
              <th>Phone</th>
              <th>Referral Amount</th>
            </tr>
            </thead>
            <tbody>
          <?php
      while($row = mysqli_fetch_assoc($res_user)){
        // echo $row['transaction_id']." ".$row['user_id_donor']." ".$row['user_id_receiver'].'</br>';
        ?>
            
            <tr>
              <td><?php echo $row['user_id']?></td>
              <td><?php echo $row['user_name']?></td>
              <td><?php echo $row['user_email']?></td>
              <td><?php echo $row['user_refemail']==NULL?'None':$row['user_refemail']?></td>
              <td><?php echo $row['user_phone']?></td>
              <td><?php echo $row['referral_amount']?></td>
            </tr>
            
           
        <?php
      }
    }
    ?>    
        </tbody>
        </table>
      </div>

    </div> 
    </div>
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
</body>
</html>
