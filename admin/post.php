<?php 
  
	session_start();
	if(!isset($_SESSION['admin_id'])){
	  header('location:./login.php');
	}  

	require '../back-end/require/connection.inc.php'; 

	if(isset($_POST['btnPost'])){
		$time_stamp = date('Y-m-d H:i:s');
		$sql="INSERT INTO `post`(`content`, `time`) VALUES ('".$_POST['postText']."','$time_stamp')";
		$res=mysqli_query($connection,$sql);					
	}

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

  <?php
  if(isset($_POST['del'])){
    for( $i=0;$i<sizeof($_POST['del']);$i++ ) 
    {      
      $sql_histDel="DELETE FROM `post` WHERE `pid`='{$_POST['del'][$i]}'";
      $res_histDel=mysqli_query($connection,$sql_histDel);
    }
  }
    $sql_histShow="SELECT * FROM `post`";
    $res_histShow=mysqli_query($connection,$sql_histShow);

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post
        <small>Control panel</small>
      </h1>
    </section>

    <section class="content">
      <div class="row ">
    

    <?php
    if(isset($_POST['btnPost'])) {
    	if($res){
    ?>	

	    <div class="alert alert-success alert-dismissible" style="margin-top: 20px" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Posted successfully!</strong>
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
    
    <div class="col-xs-12">
        <form method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Enter the post</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Text Editor</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              
              <form>
                <textarea class="textarea" name="postText" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required ></textarea>
              </form>
            </div>
          </div>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <input type="submit" class="btn btn-primary" value='post' id="postBtn" name="btnPost">
            </div><!-- /.box-footer -->
          </div><!-- box -->
        </form>
    </div><!-- col-xs-12 -->
    </div>
  </section>
    
  <section class="content-header">
      <h1>
        Posted
        <small>Control panel</small>
      </h1>
    </section>

    <section class="content">
      <div class="row ">
       <div class="col-xs-12">
        <form method="post">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Post History</h3>
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
                      <th>time</th>
                      <th>Content</th>
                    </tr>
                  </thead>
                  <tbody>
              <?php
                while($row = mysqli_fetch_assoc($res_histShow)){
              ?>
                    <tr>
                      <td><input type="checkbox" name="del[]" class="chk" value='<?php echo $row['pid']?>'/>&nbsp;</td>
                      <td><?php echo $row['time']?></td>
                      <td><?php echo $row['content']?></td>
                    </tr>
              <?php
                }
        ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer clearfix">
              <input type="submit" class="btn btn-primary" value='Delete' id="delBtn" name="btnDel" disabled>

            </div><!-- /.box-footer -->
          </div><!-- box -->
        </form>
    </div><!-- col-xs-12 -->
    </div>
    </section>

  </div>

  <!-- /.content-wrapper -->


  <?php require 'components/footer/footer.php' ?>

</div>
<!-- ./wrapper -->

<?php require 'components/footer/scripts.php' ?>

<script>
$("input[type='checkbox']").on('change', function(){
  console.log($('input[type=\'checkbox\']:checked').size() ); 
  $('#delBtn').attr("disabled", $('input[type=\'checkbox\']:checked').size() == 0);
});

</script>

</body>
</html>
