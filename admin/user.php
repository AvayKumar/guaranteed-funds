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

</head><body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php require 'components/header/header_main.php' ?>

<?php require 'components/header/side_bar.php' ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>Control panel</small>
      </h1>
    </section>

    

    <section class="content">
    <div class="row">
    <?php 
    
    if( isset($_POST['block']) ) {
      
      for($i=0;$i<sizeof($_POST['block']);$i++)
        {
          //echo $i;
        $sql="UPDATE `user` SET `user_blocked`='1' WHERE `user_id`='{$_POST['block'][$i]}'";
        $res=mysqli_query($connection,$sql);

        // $sql_block2 = "UPDATE `transaction_details` SET `user_id_receiver`= NULL WHERE `user_id_donor`='{$_POST['block'][$i]}' AND `have_paid`='0'";
        // $res_block2=mysqli_query($connection,$sql_block2);

        // $sql_block3 = "UPDATE `transaction_details` SET `user_id_receiver`=NULL WHERE `user_id_receiver`='{$_POST['block'][$i]}' AND `have_paid`='0'";
        // $res_block3 = mysqli_query($connection,$sql_block3);
        
        $sql_block2 = "DELETE FROM `transaction_details` WHERE `user_id_donor`='{$_POST['block'][$i]}' AND `have_paid`='0'";
        $res_block2=mysqli_query($connection,$sql_block2);

        $sql_block3 = "UPDATE `transaction_details` SET `user_id_receiver`=NULL WHERE `user_id_receiver`='{$_POST['block'][$i]}' AND `have_paid`='0'";
        $res_block3 = mysqli_query($connection,$sql_block3);



        }

        
        if(sizeof($_POST['block']) && $res)
          {
        
        ?>
          <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Congrats! blocked</strong>
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

    
    $sql_user = "SELECT * FROM `user` WHERE `user_blocked` = '0'";
    $res_user = mysqli_query($connection,$sql_user);
    
    if($res_user){
      ?>
      <form method='post'>
      <div class="col-xs-12">
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
                        <td><input type="checkbox" name="block[]" class="chk" value='<?php echo $row['user_id']?>'/>&nbsp;</td>
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
              </div><!-- /.box-body -->
              <div class="box-footer clearfix">            
                <input type="submit" class="btn btn-primary" value='Block' id="blockBtn" disabled>
              </div>
            </div><!-- /.box -->
          </div>
      </form>
    </div><!-- /.row --> 
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
  $('#blockBtn').attr("disabled", $('input[type=\'checkbox\']:checked').size() == 0);
});
</script>



</body>
</html>
