<?php
include("../valid.php");
include("../head.php");
if(isset($_GET['id'])){$id=$_GET['id'];}
$dt=date("Y-m-d");
$opid='';$BracnchName='';$BranchAddress='';$ContactPerson='';$Phone='';$Email='';
if(isset($_POST['submit']))
{
    if(isset($_POST['opid'])){$opid=$_POST['opid'];}else{$opid='';}
    if(isset($_POST['BracnchName'])){$BracnchName=$_POST['BracnchName'];}else{$BracnchName='';}
    if(isset($_POST['BranchAddress'])){$BranchAddress=$_POST['BranchAddress'];}else{$BranchAddress='';}
    if(isset($_POST['ContactPerson'])){$ContactPerson=$_POST['ContactPerson'];}else{$ContactPerson='';}
    if(isset($_POST['Phone'])){$Phone=$_POST['Phone'];}else{$Phone='';}
    if(isset($_POST['Email'])){$Email=$_POST['Email'];}else{$Email='';}
     $sql= "update branchs set operator_id='".$opid."',branch_name='".$BracnchName."',branch_contactperson='".$ContactPerson."',branch_address='".$BranchAddress."',branch_mobile='".$Phone."',branch_email='".$Email."' where bid='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        echo "<script>alert('Branch update successfully');
        window.location.href = '../branch/view.php'</script>";
     } 
     else
     {
        echo "<script>alert('Failed to update branch');</script>";
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

 if($id > 0)
{
     $sql = "Select * from branchs where bid='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        while( $row = mysqli_fetch_array($result))
        {
           $opid1     = $row['operator_id'];
           $branchName  = $row['branch_name'];
           $branchcontact   = $row['branch_contactperson'];
           $branchmob  = $row['branch_mobile'];
           $branchemail = $row['branch_email'];
           $branchAdd    = $row['branch_address'];
        }
        
     } 
}

 $sql4 = "Select operator_id,operator_name from operators where operator_id='".$opid1."'";
 $result4 = mysqli_query($conn, $sql4);
 if ($result4) 
 {
    while( $row = mysqli_fetch_array($result4))
    {
        
       $opname1 ="<option value='".$row['operator_id']."'>".$row['operator_name']."</option>";
    }
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Search Payments</title>
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
       Update Branch
       
      </h1>
    
    </section>
    <div class="text-right">
        <a href='http://sreecorp.com/cms/branch/view.php' type='buttton' class="btn btn-primary mr-2" style="margin-right:15px;">Back</a>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <form method="POST" role="form">
              <div class="box-body">
                  <?php if($row5['lu_role'] == 1){ ?>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Operator</label> (*If user login as a Super admin then only we will be showing dropdown selecting the opearator. if user login as a Operator we need to Show this name alone)
                     <select class="form-control" name='opid'>
                        <?php echo $opname1; ?>
                        <?php echo $opNa; ?>
                      </select>
                    </div>
                    <?php } ?>
                  
                 
                <div class="form-group">
                  <label for="exampleInputEmail1">Branch Name</label>
                  <input type="text" class="form-control" name="BracnchName" value="<?php echo $branchName; ?>" id="exampleInputEmail1" placeholder="Operator Username">
                </div>
             
 <div class="form-group">
                  <label for="exampleInputEmail1">Branch Address</label>
                  <input type="text" class="form-control" name="BranchAddress" value="<?php echo $branchAdd; ?>" id="exampleInputEmail1" placeholder="Operator Username">
                </div>
               
 <div class="form-group">
                  <label for="exampleInputEmail1">Contact Person</label>
                  <input type="text" class="form-control" name="ContactPerson" value="<?php echo $branchcontact; ?>" id="exampleInputEmail1" placeholder="Operator Username">
                </div>
                
                 <div class="form-group">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="text" class="form-control" name="Phone" value="<?php echo $branchmob; ?>" id="exampleInputEmail1" placeholder="Operator Username">
                </div>
                
                
                      <div class="form-group">
                  <label for="exampleInputEmail1">e-Mail</label>
                  <input type="email" class="form-control" name="Email" value="<?php echo $branchemail; ?>" id="exampleInputEmail1" placeholder="Operator Username">
                </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary"/>
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
