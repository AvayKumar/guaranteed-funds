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
  <div class="row">
    <div class="container col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
      <br />
      <?php
           if(isset($_POST['login'])){
              require '../back-end/require/connection.inc.php';
             
              $sql = "SELECT `admin_email`, `admin_password`, `admin_id` FROM `admin` WHERE `admin_email` = '{$_POST['email']}'";
              $res = mysqli_query($connection, $sql);

              if($res)
                $row = mysqli_fetch_assoc($res);
              
              if( $res && mysqli_num_rows($res) == 0) {
                  
                 ?>
                 <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><strong>Invalid Email! </strong></div>
              
              <?php

              }
              else 
              {
                
                if( password_verify(trim($_POST['password']), $row['admin_password']) ) {
                    session_start();
                    $_SESSION['admin_id']=$row['admin_id'];
                    header('location:./index.php');
                }
                else{

                ?>
              
                <div class="alert alert-danger alert-dismissible" style="margin-top: 20px" role="alert"><strong>Incorrect Password! </strong></div>              
              
                <?php
     
               }

             } 

            }

          ?>

        <div class="panel panel-primary" style="margin-top: 30px">
            <div class="panel-heading">
                <h1>Login</h1>
            </div>
            <form method='POST'>
            <div class="panel-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user" style="width: auto"></i>
                        </span>
                        <input type="email" id="txtUsuario" runat="server" type="text" class="form-control" name="email" placeholder="Email Id" required="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-lock" style="width: auto"></i>
                        </span>
                        <input id="txtSenha" runat="server" type="password" class="form-control" name="password" placeholder="Password" required="" />
                    </div>
                </div>
                <button type="submit" id="btnLogin" runat="server" name="login" class="btn btn-primary"  style="width: 100%">
                    Login <i class="glyphicon glyphicon-log-in"></i>
                </button>
            </div>
            </form>
        </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
</body>
</html>

