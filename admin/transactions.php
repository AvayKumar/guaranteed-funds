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
      <h1>
        Transactions
        <small>Control panel</small>
      </h1>
    </section>

    

    <section  class="content">
        <div class="row">
            <div class="col-xs-12">
            <?php 
              
                
            $sql_match = "SELECT * FROM `transaction_details` WHERE `user_id_receiver` IS NOT NULL AND `have_paid`='1'";
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
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Transactions</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tranasction Id</th>
                                        <th>Donor Id</th>
                                        <th>Receiver Id</th>
                                        <th>Amount</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                while($row = mysqli_fetch_assoc($res_match)){
                            ?>
                                    <tr>
                                      <td><?php echo $row['transaction_id']?></td>
                                      <td><?php echo $row['user_id_donor']?></td>
                                      <td><?php echo $row['user_id_receiver']?></td>
                                      <td><?php echo $row['amount']?></td>
                                      <td><?php echo $row['time_stamp']?></td>
                                    </tr>
                            <?php
                              }
                }
            ?>    
                                </tbody>
                            </table>
                      </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->      
            </div>
        </div> 
    <!--match control panel  -->
    </section>
  </div><!-- /.content-wrapper -->


  <?php require 'components/footer/footer.php' ?>

</div>
<!-- ./wrapper -->

<?php require 'components/footer/scripts.php' ?>

</body>
</html>
