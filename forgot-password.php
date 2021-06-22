<?php 
session_start();
include("conn.php");
require_once("PHPMailer/class.phpmailer.php");

if(isset($_SESSION['user']) && $_SESSION['user'] != '')
{
  header("location:index.php");
  exit;
} 
if( isset($_POST['email']) && $_POST['email'] != ""){
   $sql = "select * from users where email = '".$_POST['email']."'";
     $rs = mysqli_query($conn,$sql);
     $rno = mysqli_num_rows($rs);

     if($rno == 0){
        $_SESSION['emsg'] .= " Email doesn't exists.";
        header("location:forgot-password.php");
        exit;
     }
     else if($rno == 1){

        $row = $rs->fetch_array(MYSQLI_ASSOC);

       $u = "update users set password = '".md5('HotDogPolice@13')."' where email = '".$row['email']."'";
        mysqli_query($conn,$u);
 $message = "Reset Password";
        $mail_body = '
              <table style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
                <tr>
                  <td>Hi,<br /><br /></td>
                </tr>
                <tr>
                  <td>Follow the link to reset password. <a href="'.$serverurl.'reset-password.php?email='.$row['email'].'">Reset</a></td>
                </tr>
                
                
              </table>';
              
              


             $mail = new PHPMailer(); 

    // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //$mail->SMTPAuth = true; // authentication enabled
   $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 25; // or 587
    $mail->IsHTML(true);
    $mail->Username = "frimbee@gmail.com";
    $mail->Password = "MaxPayne@13";
    $mail->SetFrom("noreply@thrivetech.com");
    $mail->Subject = "Reset Password Link";
   
    $mail->AddAddress("kparimal13@gmail.com");
   $mail->Body = $mail_body;
   $headers .= "X-Mailer: Drupal\n"; 
    $headers .= 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    // In production :: $mail->AddAddress($email);
    mail($row['email'], $message, $mail_body, $headers); 
//$mail->AddAddress($row['email']); 
     if(!$mail->Send()) {
  $_SESSION['emsg'] = "Mail not sent. Try again.";
  header("location:forgot-password.php");
  exit;
     } else {
       
       $_SESSION['smsg'] = "Mail Sent. check your inbox/spam/junk folder.";
  header("location:forgot-password.php");
  exit; 

     }
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
    <p class="login-box-msg">We'll send Recovery link to Email.</p>
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
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send Email</button>
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
