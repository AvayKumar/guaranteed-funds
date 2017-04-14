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

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

<?php require 'components/header/header_main.php' ?>

<?php require 'components/header/side_bar.php' ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <!--match control panel  -->
  <section class="content-header">
    <h1>
      Admin
      <small>New Admin</small>
    </h1>

    <?php
      if( isset($_POST['create']) ) {

        $_POST['email'] = trim( strtolower($_POST['email']) );
        $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $_POST['password1'] = filter_var($_POST['password1']);
        $_POST['password2'] = filter_var($_POST['password2']);
        $_POST['uname']  = filter_var($_POST['uname']);
      
        $sql_email = "SELECT `admin_email` FROM `admin` WHERE `admin_email` = '{$_POST['email']}'";
        $res_email = mysqli_query($connection, $sql_email);
        
        if( $_POST['password1'] != $_POST['password2'] ) {
            echo  '<div class="alert alert-warning alert-dismissible" style="margin-top: 20px" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong> Password do not match
              </div>';
        } else if( $res_email && mysqli_num_rows($res_email) ) {
            echo '<div class="alert alert-error alert-dismissible" style="margin-top: 20px" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong> Email already exists
              </div>';
        } else {
          $pass_hash = password_hash(trim($_POST['password1']), PASSWORD_DEFAULT);
          $sql_insert = "INSERT INTO `admin`(`admin_email`, `admin_name`, `admin_password`) VALUES ('{$_POST['email']}','{$_POST['uname']}','{$pass_hash}')";
          $result_insert = mysqli_query($connection, $sql_insert);
 
          if( $result_insert ) {
            echo '<div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Success!</strong> Admin created
              </div>';
            unset($_POST);
          }
        }
      }
    ?>

  </section>

    <section class="content">
      <form method="post" class="form-horizontal">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Create new admin</h3>
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
                  <label class="control-label col-sm-2" for="uname">User Name:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="uname" name="uname" value="<?php if(isset($_POST['uname'])) { echo $_POST['uname'];}?>" placeholder="Your user name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Email:</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email'];}?>"  placeholder="Your email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Password:</label>
                  <div class="col-sm-10"> 
                    <input type="password" class="form-control" id="pwd" name="password1"  value="<?php if(isset($_POST['password1'])) { echo $_POST['password1'];}?>"  placeholder="Set a password" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd2">Confirm Password:</label>
                  <div class="col-sm-10"> 
                    <input type="password" class="form-control" id="pwd2" name="password2"  value="<?php if(isset($_POST['password2'])) { echo $_POST['password2'];}?>"  placeholder="Confirm password" required>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="box-footer clearfix">
          <input type="submit" class="btn btn-primary" name="create" value='Create'>
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

</body>
</html>