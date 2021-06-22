<?php
include("../valid.php");
include("../head.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Add User</title>
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
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer List</h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Username</th>
          <th>Name</th>
          <th>Branch</th>
          <th>Package</th>
          <th>Mobile Number</th>
          <th>Address</th>
          <th>Registered Date</th>
          <th>View User</th>
          <th>Edit User</th>
          <th>Other details</th>
          <th>Send SMS</th>
        </tr>
        </thead>
        <tbody>
        <?php 
          $sql = "SELECT * FROM `customers` order by id desc";
          $res = mysqli_query($conn,$sql);
          if (mysqli_num_rows($res) > 0) {
              while ($row = mysqli_fetch_assoc($res)) { ?>
                  <tr>
                    <td><?php echo !empty($row['Username'])?$row['Username']:''; ?></td>
                    <td><?php echo !empty($row['Name'])?$row['Name']:''; ?></td>
                    <td><?php echo !empty($row['Branch'])?$row['Branch']:''; ?></td>
                    <td><?php echo !empty($row['Package_Name'])?$row['Package_Name']:''; ?></td>
                    <td><?php echo !empty($row['Mobile'])?$row['Mobile']:''; ?></td>
                    <td><?php echo !empty($row['Installation_Address'])?$row['Installation_Address']:''; ?></td>
                    <td><?php echo !empty($row['Date_Added'])?date('Y-m-d',strtotime($row['Date_Added'])):''; ?></td>
                    <td><a href="view-user.php?id=<?php echo $row['Id']; ?>">View User</a></td>
                    <td><a href="editUser.php?id=<?php echo $row['Id']; ?>">Edit User</a></td>
                    <td><a href="editOtherDetails.php?id=<?php echo $row['Id']; ?>">Other Details</a></td>
                    <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Send SMS</button></td>
                  </tr>

          <?php } } else { ?>

          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
      
<?php include("../footer.php") ?>

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
<!-- DataTables -->
<script src="<?php echo $serverurl ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $serverurl ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
<script>
  $(function () {
    $('#example1').DataTable();
  })
</script>

</body>
</html>

