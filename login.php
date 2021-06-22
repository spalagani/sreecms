<?php 
session_start();
include("conn.php");
if(isset($_SESSION['user']) && $_SESSION['user'] != '')
{
  header("location:index.php");
  exit;
}
if(isset($_POST['logflag']) && $_POST['logflag'] == 'y' ){


  if(isset($_POST['cookie']) && $_POST['cookie'] == 'y')
  {

    setcookie('luser', $_POST['username'], time() + (86400 * 30), "/");
    setcookie('lpass', $_POST['password'], time() + (86400 * 30), "/");


  }
  else
  {
    unset($_COOKIE['luser']);
      unset($_COOKIE['lpass']);
      setcookie('luser', null, -1, '/');
      setcookie('lpass', null, -1, '/');
  }

$sql = "select * from loginusers where lu_username='".$_POST['username']."' and lu_password='".$_POST['password']."'";
  $rs = mysqli_query($conn,$sql);
  $rno = mysqli_num_rows($rs);
    
  if($rno == 1 )
  {
    $row = $rs->fetch_array(MYSQLI_ASSOC);
    $_SESSION['user']=$row;
    $_SESSION['lu_role']=$row["lu_role"];
    $_SESSION['lu_id']=$row["lu_id"];
    header("location:index.php");
    exit;
  }
  else{

    $_SESSION['emsg']="Wrong password.";
    header("location:login.php");
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
    <a href="<?php echo $serverurl ?>"><img src="sree-broadband-logo.png"  style="
    width: 75%;
"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
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
        <input type="text" class="form-control" name="username" placeholder="Username" <?php if(isset($_COOKIE['luser'])) echo "value='".$_COOKIE['luser']."'"; ?>>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" <?php if(isset($_COOKIE['lpass'])) echo "value='".$_COOKIE['lpass']."'"; ?>>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="cookie" <?php if(isset($_COOKIE['luser'])) echo "checked"; ?> value="y"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div><input type="hidden" name="logflag" value="y">
    </form>
<!--

    <a href="forgot-password.php">I forgot my password</a><br>
    <a href="register.php" class="text-center">Register a new membership</a>
    
-->
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
