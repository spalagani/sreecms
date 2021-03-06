<?php
include("../valid.php");
include("../head.php"); 
 $sqllu1 = "Select lu_operator_id from loginusers where lu_id=".$_SESSION['lu_id']."";
 $resultlu1 = mysqli_query($conn, $sqllu1);
 if ($resultlu1) 
 {
    while( $rowlu1 = mysqli_fetch_array($resultlu1))
    {
        
       $loginopid .=$rowlu1['lu_operator_id'];
    }
 }
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
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
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
      <h3 class="box-title">Packages List</h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Package ID</th>
          <th>Operator ID</th>
          <th>Package Name</th>
          <th>Package Months</th>
          <th>Package Description</th>
          <th>Package Price</th>
          <th>Package Date</th>
          <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>
          <th>Edit Package</th>
          <th>Delete Package</th>
          <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php 
           if($row5['lu_role'] == 1)
        {
            $sql = "SELECT P.*,(select operator_name from operators where operator_id=P.op_id) as Opet FROM `packages` P order by P.package_id ";
        }
        else
        {
            $sql = "SELECT P.*,(select operator_name from operators where operator_id=P.op_id) as Opet FROM `packages` P where P.op_id=".$loginopid." order by P.package_id ";
        }
          
          $res = mysqli_query($conn,$sql);
          if (mysqli_num_rows($res) > 0) {
              while ($row = mysqli_fetch_assoc($res)) { ?>
                  <tr id="<?php echo $row['package_id']; ?>">
                    <td><?php echo !empty($row['package_id'])?$row['package_id']:''; ?></td>
                    <td><?php echo !empty($row['Opet'])?$row['Opet']:''; ?></td>
                    <td><?php echo !empty($row['package_name'])?$row['package_name']:''; ?></td>
                    <td><?php echo !empty($row['sub_package'])?$row['sub_package']:''; ?></td>
                    <td><?php echo !empty($row['package_desc'])?$row['package_desc']:''; ?></td>
                    <td><?php echo !empty($row['package_price'])?$row['package_price']:''; ?></td>
                    <td><?php echo !empty($row['package_date'])?date('Y-m-d',strtotime($row['package_date'])):''; ?></td>
                     <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>
                    <td><a href="edit-package.php?id=<?php echo $row['package_id']; ?>">Edit Package</a></td>
                    <td><button class="btn btn-danger btn-sm remove">Delete</button></td>
                    <?php } ?>
                    <!--<td><a href="#" class="btn btn-danger remove">Delete Package</a></td>-->
                  </tr>

          <?php } } else { ?>

          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");
        console.log(id);

        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: 'http://sreecorp.com/cms/package/delete.php',
               type: 'GET',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully");  
               }
            });
        }
    });


</script>
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

