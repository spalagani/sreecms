<?php
include("valid.php");
include("head.php");
  ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include("header.php") ?>
  <!-- Left side column. contains the logo and sidebar -->

<?php include("aside.php");

$sql = "select * from customers where operator_id = '1'";
  $rs = mysqli_query($conn,$sql);
  $rno = mysqli_num_rows($rs);
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
     <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
       
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $rno ?></h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php") ?>


 
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<?php include("footer-script.php") ?>
</body>
</html>
