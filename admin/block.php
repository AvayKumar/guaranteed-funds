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
        Blocked Users
        <small>Control panel</small>
      </h1>
    </section>

    

    <section class="content">
      <div class="row">
      <?php 
      
      if( isset($_POST['unblock']) ) {
        
        for($i=0;$i<sizeof($_POST['unblock']);$i++) {
          $sql="UPDATE `user` SET `user_blocked`='0' WHERE `user_id`='{$_POST['unblock'][$i]}'";
          $res=mysqli_query($connection,$sql);
        }

          if(sizeof($_POST['unblock']) && $res) {
          
          ?>
            <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Congrats! Unblocked</strong>
            </div>

          <?php
          } else {
          ?>    
            <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>
            </div>
          <?php  
          }      
      }

      $sql_user = "SELECT * FROM `user` WHERE user_blocked = '1'";
      $res_user = mysqli_query($connection,$sql_user);
      
      if($res_user) {

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
                ?>
                    
                    <tr>
                      <td><input type="checkbox" name="unblock[]" class="chk" value='<?php echo $row['user_id']?>'/>&nbsp;</td>
                      <td><?php echo $row['user_id']?></td>
                      <td><?php echo $row['user_name']?></td>
                      <td><?php echo $row['user_email']?></td>
                      <td><?php echo $row['user_refemail']?></td>
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
                <input type="submit" class="btn btn-primary" value='Unblock' id="checkBtn" disabled>
              </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </form>
      </div>
      </div><!-- /.row -->
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
});
</script>




</body>
</html>

