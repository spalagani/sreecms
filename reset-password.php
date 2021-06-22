<?php 
session_start();
include("conn.php");
if( isset($_GET['email']) && $_GET['email'] != "" ){
  $s = "select * from users where email = '".$_GET['email']."' and password = '".md5('HotDogPolice@13')."'";
  $srs = mysqli_query($conn,$s);
  $sno = mysqli_num_rows($srs);

  if( $sno == 0){
   echo "Link Expired";
  exit;
  }
}
else if(isset($_SESSION['user']) && $_SESSION['user']!= "")
{
  header("location:index.php");
  exit;
}
else{

  header("location:login.php");
  exit;

}
if( isset($_POST['password']) && $_POST['password'] != "" ){
  
      if( $_POST['password'] == $_POST['repassword']){

         $u= "update users set password = '".md5($_POST['password'])."' where email = '".$_GET['email']."'";
     mysqli_query($conn,$u);
       $_SESSION['smsg'] = "Password changed successfully.";
  header("location:login.php");
  exit; 

      }
      else{

        $_SESSION['emsg'] = "Password do not match.";
  header("location:reset-password.php?email=".$_GET['email']);
  exit; 
      }

    

     
       
     
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo $serverurl ?>"><b>Shree</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Set New password.</p>
 <?php
          if( isset($_SESSION['emsg']) && $_SESSION['emsg'] != '' ){

              
          ?>
          <div class="alert alert-error">
                    
                    <?php echo $_SESSION['emsg'];$_SESSION['emsg']=''; ?>
                  </div>
                  <?php
                    }
                  ?>
                   
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="New Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="repassword" placeholder="Re-type Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
        </div>
        <!-- /.col -->
      </div><input type="hidden" name="logflag" value="y">
    </form>


  

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo $serverurl ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $serverurl ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
