<?php
include("../valid.php");
include("../head.php"); 
$dt=date("Y-m-d");
if(isset($_GET['id'])){$id=$_GET['id'];}
$erole1='';$eoptid1='';$ename1='';$eusername1='';$epass1='';$emobile1='';$eemail1='';$eadd1='';$eidprf1='';$checkbox="";
if(isset($_POST['submit']))
{
    if(isset($_POST['roleid'])){$erole1=$_POST['roleid'];}else{$erole1='';}
    if(isset($_POST['opid'])){$eoptid1=$_POST['opid'];}else{$eoptid1='';}
    if(isset($_POST['name'])){$ename1=$_POST['name'];}else{$ename1='';}
    if(isset($_POST['username'])){$eusername1=$_POST['username'];}else{$eusername1='';}
    if(isset($_POST['password'])){$epass1=$_POST['password'];}else{$epass1='';}
    if(isset($_POST['mobile'])){$emobile1=$_POST['mobile'];}else{$emobile1='';}
    if(isset($_POST['email'])){$eemail1=$_POST['email'];}else{$eemail1='';}
    if(isset($_POST['address'])){$eadd1=$_POST['address'];}else{$eadd1='';}
    if(isset($_POST['idproof'])){$eidprf1=$_POST['idproof'];}else{$eidprf1='';}
    if(isset($_POST['chk'])){$chk='1';}else{$chk='0';}
    
    $sql3 = "Select lu_idproof_image,lu_logo_image from loginusers where lu_id='".$id."'";
    $result3 = mysqli_query($conn, $sql3);
    $res = mysqli_fetch_array($result3);
    $img1 = $res['lu_idproof_image'];
    $img2 = $res['lu_logo_image'];
  
      if ($_FILES["image"]["error"] > 0)
       {
       }
       else
       {
         move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $_FILES["image"]["name"]);
         $file="images/".$_FILES["image"]["name"];
       }
       
       if ($_FILES["image2"]["error"] > 0)
       {
       }
       else
       {
         move_uploaded_file($_FILES["image2"]["tmp_name"],"images2/" . $_FILES["image2"]["name"]);
         $file2="images2/".$_FILES["image2"]["name"];
       }
       if($file == "")
       {
             $file= $img1;
       }
       if($file2 == "")
       {
             $file2 = $img2;
       }
       
     $sql= "update loginusers set lu_role='".$erole1."',lu_operator_id='".$eoptid1."',lu_name='".$ename1."',lu_username='".$eusername1."',lu_password='".$epass1."',lu_mobile='".$emobile1."',lu_email='".$eemail1."',lu_address='".$eadd1."',lu_idprood='".$eidprf1."',lu_idproof_image='".$file."',lu_logo_image='".$file2."',lu_status='".$chk."' where lu_id='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        echo "<script>alert('Employee Edit successfully');
        window.location.href = '../collection-boy/view.php'</script>";
     } 
     else
     {
        echo "<script>alert('Failed to add employee');</script>";
     }
}

if($id > 0)
{
     $sql = "Select * from loginusers where lu_id='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        while( $row = mysqli_fetch_array($result))
        {
           $erole     = $row['lu_role'];
           $eopid  = $row['lu_operator_id'];
           $ename   = $row['lu_name'];
           $euser  = $row['lu_username'];
           $epass = $row['lu_password'];
           $enum    = $row['lu_mobile'];
           $eemail    = $row['lu_email'];
           $eadd    = $row['lu_address'];
           $eidprf    = $row['lu_idprood'];
           $edtadd    = $row['lu_dateAdded'];
           $imgprf    = $row['lu_idproof_image'];
           $imgprf2    = $row['lu_logo_image'];
           $cchk2    = $row['lu_status'];
        }
        
     } 
}

if( $cchk2 == 0)
{
    $checkbox = "";
}
elseif( $cchk2 == 1)
{
     $checkbox = "checked";
}
 $sqllu = "Select lu_operator_id from loginusers where lu_id=".$_SESSION['lu_id']."";
 $resultlu = mysqli_query($conn, $sqllu);
 if ($resultlu) 
 {
    while( $rowlu = mysqli_fetch_array($resultlu))
    {
        
       $loginopid .=$rowlu['lu_operator_id'];
    }
 }
 

$sql = "Select operator_id,operator_name from operators";
 $result = mysqli_query($conn, $sql);
 if ($result) 
 {
    while( $row = mysqli_fetch_array($result))
    {
       if($eopid ==$row['operator_id'])
       {
            $opNa .="<option value='".$row['operator_id']."' selected>".$row['operator_name']."</option>";    
       }
       else
       {
            $opNa .="<option value='".$row['operator_id']."'>".$row['operator_name']."</option>";    
       }
       
    }
 }

  $sqlop = "Select operator_id,operator_name from operators where operator_id=".$loginopid;
 $results = mysqli_query($conn, $sqlop);
 if ($results) 
 {
    while( $rowop = mysqli_fetch_array($results))
    {
        
       $fetchop .="<option value='".$rowop['operator_id']."'>".$rowop['operator_name']."</option>";
    }
 }
  $sqlrole = "Select lr_id,lr_name from loginusers_roles where lr_id in(3,4)";
 $resultrole = mysqli_query($conn, $sqlrole);
 if ($resultrole) 
 {
    while( $row = mysqli_fetch_array($resultrole))
    {
       if($erole == $row['lr_id'])
       {
            $opRoleNa .="<option value='".$row['lr_id']."' selected>".$row['lr_name']."</option>";    
       }
       else
       {
            $opRoleNa .="<option value='".$row['lr_id']."'>".$row['lr_name']."</option>";    
       }
    }
 }
  $sqlrole2 = "Select lr_id,lr_name from loginusers_roles where lr_id=".$erole."";
 $resultrole2 = mysqli_query($conn, $sqlrole2);
 if ($resultrole2) 
 {
    while( $row2 = mysqli_fetch_array($resultrole2))
    {
         $opRoleNa2 .="<option value='".$row2['lr_id']."' selected>".$row2['lr_name']."</option>";    
    }
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Add Opeartor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo $serverurl ?>plugins/iCheck/all.css">

  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/skins/_all-skins.min.css">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include("../header.php");
include("../aside.php");

  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Employee
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <form method="POST" role="form" enctype="multipart/form-data">
              <div class="box-body">
                <?php if($row5['lu_role'] == 1){ ?>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Operator</label> (*If user login as a Super admin then only we will be showing dropdown selecting the opearator. if user login as a Operator we need to Show this name alone)
                 <select class="form-control" name='opid'>
                    <?php echo $opNa; ?>
                  </select>
                </div>
                <?php }
                else
                { ?>
                
             <select class="form-control" style="display:none;" name='opid'>
                <?php echo  $fetchop; ?>
              </select>
              <?php } ?>
                  <div class="form-group">
                  <label for="exampleInputEmail1">Select Role</label> 
                 <select class="form-control" name='roleid'>
                    <?php echo $opRoleNa2; ?>
                    <?php echo $opRoleNa; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" value="<?php echo $ename;?>" id="exampleInputEmail1" placeholder="Name">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number</label>
                  <input type="text" class="form-control" name="mobile" value="<?php echo $enum;?>" id="exampleInputEmail1" placeholder="Mobile Number">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">eMail</label>
                  <input type="email" class="form-control" name="email" value="<?php echo $eemail;?>" id="exampleInputEmail1" placeholder="eMail">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <input type="text" class="form-control" name="address" value="<?php echo $eadd;?>" id="exampleInputEmail1" placeholder="Address">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $euser;?>" id="exampleInputEmail1" placeholder=" Username">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" class="form-control" name="password" value="<?php echo $epass;?>" id="exampleInputEmail1" placeholder=" Password">
                </div>
                <!-- <div class="form-group">-->
                <!--  <label for="exampleInputEmail1">Confirm Password</label>-->
                <!--  <input type="password" class="form-control" name="cpassword" value="<?php echo $epass;?>" id="exampleInputEmail1" placeholder=" confirm Password">-->
                <!--</div>-->
                <div class="form-group">
                  <label for="exampleInputFile">Photo</label>
                  <input type="file" name="image" id="exampleInputFile">
                  <?php if($imgprf != "") { ?>
                  <img src="<?php echo $imgprf; ?>" class="img-responsive" style="height: 126px;margin-top:8px;">
                    <?php } ?>
                  <p class="help-block">&nbsp;</p>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile"> ID Proof</label>
                  <input type="text" name="idproof" value="<?php echo $eidprf;?>" id="exampleInputFile">
                  <!--<img src="se.jpg">-->
                  <p class="help-block">&nbsp;</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">ID Proof Attachment</label>
                    <input type="file" name="image2" id="exampleInputFile">
                    <?php if($imgprf2 != "") { ?>
                  <img src="<?php echo $imgprf2; ?>" class="img-responsive" style="height: 126px;margin-top:8px;">
                    <?php } ?>
                  </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                 <input type="checkbox" name="chk" value="1" class="flat-red" <?php echo $checkbox; ?>>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit"/>
              </div>
            </form>
          </div>
        
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
      
      
 <?php include("../footer.php") ?>

 

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $serverurl ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $serverurl ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo $serverurl ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
</body>
</html>
<script>
  $(function () {

       $('#datepicker').datepicker({
      autoclose: true
    })
          $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })

            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })


});
    </script>
