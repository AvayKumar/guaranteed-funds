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
  <div class="row">
    <div class="container col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
      <br />
        <div class="panel panel-primary" style="margin-top: 100px">
            <div class="panel-heading">
                <h1>Login</h1>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user" style="width: auto"></i>
                        </span>
                        <input id="txtUsuario" runat="server" type="text" class="form-control" name="user" placeholder="Username" required="" />
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
                <button id="btnLogin" runat="server" class="btn btn-primary" style="width: 100%">
                    Login<i class="glyphicon glyphicon-log-in"></i>
                </button>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

</body>
</html>

