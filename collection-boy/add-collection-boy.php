<?php
include("../valid.php");
include("../head.php"); 
$dt=date("Y-m-d");
if(isset($_GET['id'])){$id=$_GET['id'];}
$opid='';$pkgname='';$pkgmon='';$pkgdesc='';$dtpkg='';$pkgprice='';$roleid='';
if(isset($_POST['submit']))
{
    if(isset($_POST['opid'])){$opid=$_POST['opid'];}else{$opid='';}
    if(isset($_POST['roleid'])){$roleid=$_POST['roleid'];}else{$roleid='';}
    if(isset($_POST['name'])){$name=$_POST['name'];}else{$name='';}
    if(isset($_POST['mobile'])){$mobile=$_POST['mobile'];}else{$mobile='';}
    if(isset($_POST['email'])){$email=$_POST['email'];}else{$email='';}
    if(isset($_POST['address'])){$address=$_POST['address'];}else{$address='';}
    if(isset($_POST['username'])){$username=$_POST['username'];}else{$username='';}
    if(isset($_POST['password'])){$password=$_POST['password'];}else{$password='';}
    if(isset($_POST['cpassword'])){$cpassword=$_POST['cpassword'];}else{$cpassword='';}
    if(isset($_POST['photo'])){$photo=$_POST['photo'];}else{$photo='';}
    if(isset($_POST['idproof'])){$idproof=$_POST['idproof'];}else{$idproof='';}
    if(isset($_POST['idprooatt'])){$idprooatt=$_POST['idprooatt'];}else{$idprooatt='';}
    if(isset($_POST['chk'])){$chk=$_POST['chk'];}else{$chk='';}
    
    //  $sql= "select count(*) as emp from loginusers where lu_name='".$name."' or lu_username='".$username."' or lu_operator_id=".$opid." ";
    $sql="SELECT count(*) as emp FROM `loginusers` WHERE lu_operator_id=".$opid." and lu_name='".$name."' or lu_username='".$username."'";
     $result = mysqli_query($conn, $sql);
     $cnt1 = mysqli_fetch_array($result);
     $cnt = $cnt1['emp'];
     echo $cnt;
    //  echo $sql;
     if ($cnt > 0) 
     {
        echo "<script>alert('Employee already exist!!');</script>";
     } 
     else
     {
          
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
         $sql= "insert into loginusers(lu_role,lu_operator_id,lu_name,lu_username,lu_password,lu_mobile,lu_email,lu_address,lu_idprood,lu_dateAdded,lu_status,lu_idproof_image,lu_logo_image) values('".$roleid."','".$opid."','".$name."','".$username."','".$password."','".$mobile."','".$email."','".$address."','".$idproof."','".$dt."',1,'$file','$file2')";
         $result = mysqli_query($conn, $sql);
         if ($result) 
         {
            echo "<script>alert('Employee added successfully');
            window.location.href = '../collection-boy/view.php'</script>";
         } 
         else
         {
            echo "<script>alert('Failed to add employee');</script>";
         }
     }
   
}

$sql = "Select operator_id,operator_name from operators";
 $result = mysqli_query($conn, $sql);
 if ($result) 
 {
    while( $row = mysqli_fetch_array($result))
    {
        
       $opNa .="<option value='".$row['operator_id']."'>".$row['operator_name']."</option>";
    }
 }
 
 $sqlrole = "Select lr_id,lr_name from loginusers_roles where lr_id in(3,4)";
 $resultrole = mysqli_query($conn, $sqlrole);
 if ($resultrole) 
 {
    while( $row = mysqli_fetch_array($resultrole))
    {
        
       $opRoleNa .="<option value='".$row['lr_id']."'>".$row['lr_name']."</option>";
    }
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
 
  $sqlop = "Select operator_id,operator_name from operators where operator_id=".$loginopid;
 $results = mysqli_query($conn, $sqlop);
 if ($results) 
 {
    while( $rowop = mysqli_fetch_array($results))
    {
        
       $fetchop .="<option value='".$rowop['operator_id']."'>".$rowop['operator_name']."</option>";
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
       Add Employee
       
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
                 <select class="form-control" required name='roleid'>
                     <option value=''>Select Role</option>
                    <?php echo $opRoleNa; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" required id="exampleInputEmail1" placeholder="Name">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number</label>
                  <input type="text" class="form-control" name="mobile" required id="exampleInputEmail1" placeholder="Mobile Number">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">eMail</label>
                  <input type="email" class="form-control" name="email" required id="exampleInputEmail1" placeholder="eMail">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <input type="text" class="form-control" name="address" required id="exampleInputEmail1" placeholder="Address">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" class="form-control" name="username" required id="exampleInputEmail1" placeholder=" Username">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" class="form-control" name="password" required id="exampleInputEmail1" placeholder=" Password">
                </div>
                <!-- <div class="form-group">-->
                <!--  <label for="exampleInputEmail1">Confirm Password</label>-->
                <!--  <input type="password" class="form-control" name="cpassword" id="exampleInputEmail1" placeholder=" confirm Password">-->
                <!--</div>-->
                <div class="form-group">
                  <label for="exampleInputFile">Photo</label>
                  <input type="file" name="image" id="exampleInputFile">

                  <p class="help-block">&nbsp;</p>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile"> ID Proof</label>
                  <input type="text" name="idproof" id="exampleInputFile">

                  <p class="help-block">&nbsp;</p>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">ID Proof Attachment</label>
                  <input type="file" name="image2" id="exampleInputFile">

                  <p class="help-block">&nbsp;</p>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                 &nbsp;<input type="checkbox" name="chk" class="flat-red">
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
