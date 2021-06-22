<?php
session_start();
include("conn.php");
if( isset($_POST['subflag']) && $_POST['subflag'] == 'y'){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];
  $cflag = $_POST['terms'];



  $tname = str_replace(' ', '', $name);
  $tusername = str_replace(' ', '', $username);
  $err = 0;

  if( $tname == '' ){

      $_SESSION['emsg'] .= '<p>Name cannot be blank</p>';
      $err = 1;
  }
 if( $tusername == '' ){

      $_SESSION['emsg'] .= '<p>Username cannot be blank</p>';
      $err = 1;
  }
   if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
    $_SESSION['emsg'] .= '<p>Email is invalid</p>';
      $err = 1;   
  }
  $sql = "select * from users where email = '".$email."'";
  $rs = mysqli_query($conn,$sql);
  $rno = mysqli_num_rows($rs);

  if( $rno > 0 ){

       $_SESSION['emsg'] .= '<p>Email already exists</p>';
      $err = 1;
  }
 $sql = "select * from users where username = '".$tusername."'";
  $rs = mysqli_query($conn,$sql);
  $rno = mysqli_num_rows($rs);

  if( $rno > 0 ){

       $_SESSION['emsg'] .= '<p>Username already exists</p>';
      $err = 1;
  }
  if( $password == '' || $repassword == '' ){

    $_SESSION['emsg'] .= '<p>Password cannot be blank</p>';
      $err = 1;

  }

  if( $password != $repassword) {

      $_SESSION['emsg'] .= '<p>Password does not match.</p>';
      $err = 1;
  }
  if( $cflag != 'y'){

    $_SESSION['emsg'] .= '<p>You must accept the terms.</p>';
      $err = 1;

  }
  if( $err == 1 ){

    header("location:register.php");
    exit;

  }
  else{
    
      $ins = "insert into users set name='".$name."', email='".$email."', password='".md5($password)."', username='".$username."', registered_date = '".date('Y-m-d H:i:s')."'";
      $irs = mysqli_query($conn,$ins);

      $_SESSION['smsg'] = 'Registered Successfully. Activation Pending.';
      header("location:register.php");
      exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Registration Page</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="/"><b>Shree</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>
<?php
          if( isset($_SESSION['emsg']) && $_SESSION['emsg'] != '' ){


          ?>
          <div class="alert alert-error">
                    
                    <?php echo $_SESSION['emsg'];$_SESSION['emsg']=''; ?>
                  </div>
                  <?php
                    }
                  ?>
                   <?php
          if( isset($_SESSION['smsg']) && $_SESSION['smsg'] != '' ){


          ?>
          <div class="alert alert-success">
                    
                    <?php echo $_SESSION['smsg'];$_SESSION['smsg']=''; ?>
                  </div>
                  <?php
                    }
                  ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="name" placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control chkthis" autocomplete="new-password" name="email" data-chk="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        
      </div>
        <div class="form-group has-feedback">
        <input type="text" class="form-control chkthis" autocomplete="new-password" data-chk="username" name="username" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback"> 
        <input type="password" class="form-control chkthis" autocomplete="new-password" data-chk="password" name="repassword" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="terms" value="y"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4"><input type="hidden" name="subflag" value="y">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   

    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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

      $(".chkthis").keyup( function(){

       
          var opt = $(this).attr("data-chk");

          if( opt == 'password') 
            var oldp = $("input[name='password']").val();
          else
            var oldp = ''; 
          var val = $(this).val();
          if( val == '')
            val = ' ';
           var arr = { 'opt':opt, 'val':val, 'oldp':oldp};
           
                 $.ajax({
                               type:'POST',
                               url:'response.php',
                               data:arr,
                               success:function(data) {
                                  
                                  
                                 var response = JSON.parse(data);

                                  var cls='muted';
                                
                                  if( response.type == 'success')
                                    cls = 'green';
                                  else
                                    cls = 'red';
                                  $(".removecls").remove();
                                  $("input[data-chk='"+response.chk+"']").before('<p class="text-'+cls+' removecls">'+response.msg+'</p>');
                                  
                                }
                              });

        
       

      });

   

  });
</script>
</body>
</html>
