<?php
include("../valid.php");
include("../head.php"); 
if(isset($_GET['id'])){$id=$_GET['id'];}
$opid='';$pkgname='';$pkgmon='';$pkgdesc='';$dtpkg='';$pkgprice='';$sel1='';$sel2='';$sel3='';$sel4='';$sel5='';$mon1='';$mon2='';$mon3='';$mon4='';$mon5='';$mon6='';
if(isset($_POST['submit']))
{
    if(isset($_POST['opid'])){$opid=$_POST['opid'];}else{$opid='';}
    if(isset($_POST['pkgname'])){$pkgname=$_POST['pkgname'];}else{$pkgname='';}
    if(isset($_POST['pkgmon'])){$pkgmon=$_POST['pkgmon'];}else{$pkgmon='';}
    if(isset($_POST['pkgdesc'])){$pkgdesc=$_POST['pkgdesc'];}else{$pkgdesc='';}
    if(isset($_POST['pkgprice'])){$pkgprice=$_POST['pkgprice'];}else{$pkgprice='';}
    if(isset($_POST['dtpkg'])){$dtpkg=$_POST['dtpkg'];}else{$dtpkg='';}
     $sql= "update packages set op_id='".$opid."',package_name='".$pkgname."',sub_package='".$pkgmon."',package_desc='".$pkgdesc."',package_price='".$pkgprice."',package_date='".$dtpkg."' where package_id='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        echo "<script>alert('Package Edit successfully');
        window.location.href = '../package/view.php'</script>";
     } 
     else
     {
        echo "<script>alert('Failed to add user');</script>";
     }
    // echo $sql;
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
     $sql = "Select * from packages where package_id='".$id."'";
     $result = mysqli_query($conn, $sql);
     if ($result) 
     {
        while( $row = mysqli_fetch_array($result))
        {
           $opid1     = $row['op_id'];
           $pkgname1  = $row['package_name'];
           $pkgmon1   = $row['sub_package'];
           $pkgdesc1  = $row['package_desc'];
           $pkgprice1 = $row['package_price'];
           $pkgdt1    = $row['package_date'];
        }
        // if($opid1 ==1)
        // {
        //     $sel1='Selected';
        // }
        // elseif($opid1 ==2)
        // {
        //     $sel2='Selected';
        // }
        // elseif($opid1 ==3)
        // {
        //     $sel3='Selected';
        // }
        // elseif($opid1 ==4)
        // {
        //     $sel4='Selected';
        // }
        // elseif($opid1 ==5)
        // {
        //     $sel5='Selected';
        // }
        
        
         if($pkgmon1 ==1)
        {
            $mon1='Selected';
        }
        elseif($pkgmon1 ==2)
        {
            $mon2='Selected';
        }
        elseif($pkgmon1 ==3)
        {
            $mon3='Selected';
        }
        elseif($pkgmon1 ==4)
        {
            $mon4='Selected';
        }
        elseif($pkgmon1 ==5)
        {
            $mon5='Selected';
        }
        elseif($pkgmon1 ==5)
        {
            $mon6='Selected';
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
  <title>Shree | Edit Package</title>
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
       Edit Package
      </h1>
    
    </section>
    <div class="text-right">
        <a href='http://sreecorp.com/cms/package/view.php' type='buttton' class="btn btn-primary mr-2" style="margin-right:15px;">Back</a>
    </div>
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
                 <select class="form-control" name='opid' required>
                     <?php echo $opname1; ?>
                    <?php echo $opNa; ?>
                  </select>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="exampleInputEmail1">Package Name</label>
                  <input type="text" name='pkgname' class="form-control" value='<?php echo $pkgname1; ?>'  id="exampleInputEmail1" placeholder="Package Name" required>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Package Months</label> 
                 <select class="form-control" name='pkgmon'>
                    <option value='1' <?php echo $mon1; ?>> 1</option>
                    <option value='2' <?php echo $mon2; ?>> 2</option>
                    <option value='3' <?php echo $mon3; ?>> 3</option>
                    <option value='4' <?php echo $mon4; ?>> 4</option>
                    <option value='5' <?php echo $mon5; ?>> 5</option>
                    <option value='6' <?php echo $mon6; ?>> 6</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Package Description</label>
                  <textarea class="form-control" name='pkgdesc' placeholder="Package Description"><?php echo $pkgdesc1; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Package Price</label>
                  <input type="number" class="form-control" value='<?php echo $pkgprice1; ?>' name='pkgprice' id="exampleInputEmail1" placeholder="Package Price">
                </div>
                <div class="form-group ">
                  <label for="exampleInputEmail1">Package Date</label>
                   <div class="input-group date col-md-2">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <!--<input type="date" class="form-control pull-right" name='dtpkg' id="datepicker">-->
                      <input type="date" class="form-control " value='<?php echo date("Y-m-d", strtotime($pkgdt1)); ?>' name='dtpkg' >
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
