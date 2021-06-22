<?php
include("../valid.php");
include("../head.php"); 
$dt= date("Y-m-d");
if(isset($_GET['id'])){$id=$_GET['id'];}
$opid='';$pkgname='';$pkgmon='';$pkgdesc='';$dtpkg='';$pkgprice='';
if(isset($_POST['submit']))
{
    if(isset($_POST['opid'])){$opid=$_POST['opid'];}else{$opid='';}
    if(isset($_POST['pkgname'])){$pkgname=$_POST['pkgname'];}else{$pkgname='';}
    if(isset($_POST['pkgmon'])){$pkgmon=$_POST['pkgmon'];}else{$pkgmon='';}
    if(isset($_POST['pkgdesc'])){$pkgdesc=$_POST['pkgdesc'];}else{$pkgdesc='';}
    if(isset($_POST['pkgprice'])){$pkgprice=$_POST['pkgprice'];}else{$pkgprice='';}
    if(isset($_POST['dtpkg'])){$dtpkg=$_POST['dtpkg'];}else{$dtpkg='';}
    
    $sql1= "select count(*) as pkg33 from packages where package_name='".$pkgname."' and op_id=".$opid."";
     $result1 = mysqli_query($conn, $sql1);
     $cnt1 = mysqli_fetch_array($result1);
     $cnt = $cnt1['pkg33'];
     if ($cnt == 1) 
     {
        echo "<script>alert('Package already exist!!');</script>";
     } 
     else
     {
         $sql= "insert into packages(op_id,package_name,sub_package,package_desc,package_price,package_date,status) values('".$opid."','".$pkgname."','".$pkgmon."','".$pkgdesc."','".$pkgprice."','".$dtpkg."',1)";
         $result = mysqli_query($conn, $sql);
         if ($result) 
         {
            echo "<script>alert('Package added successfully');
            // window.location.href = '../user/view.php'</script>";
         } 
         else
         {
            echo "<script>alert('Failed to add user');</script>";
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

if(!empty($id))
{
   $sql = "Select * from Packages where package_id=".$id."";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Add Package</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/Ionicons/css/ionicons.min.css">

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
       Add Package
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <form role="form" method='POST'>
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
                  <label for="exampleInputEmail1">Package Name</label>
                  <input type="text" name='pkgname' class="form-control"  id="exampleInputEmail1" placeholder="Package Name" required>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Package Months</label> 
                 <select class="form-control" name='pkgmon'>
                    <option value='1'> 1</option>
                    <option value='2'> 2</option>
                    <option value='3'> 3</option>
                    <option value='4'> 4</option>
                    <option value='5'> 5</option>
                    <option value='6'> 6</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Package Description</label>
                  <textarea class="form-control" name='pkgdesc' placeholder="Package Description"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Package Price</label>
                  <input type="number" class="form-control" name='pkgprice' id="exampleInputEmail1" placeholder="Package Price">
                </div>
                <div class="form-group ">
                  <label for="exampleInputEmail1">Package Date</label>
                   <div class="input-group date col-md-2">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <!--<input type="date" class="form-control pull-right" name='dtpkg' id="datepicker">-->
                      <input type="date" class="form-control " value="<?php echo $dt; ?>" name='dtpkg' >
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <input type='submit' name='submit' value='Submit' class="btn btn-primary"/>
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
       
});
    </script>
