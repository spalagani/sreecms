<?php
include("../valid.php");
include("../head.php");

$agent = isset($_GET['agent'])?$_GET['agent']:'';
$branch = isset($_GET['branch'])?$_GET['branch']:'';
$start_date = isset($_GET['start_date'])?$_GET['start_date'].' 00:00:00':'';
$end_date = isset($_GET['end_date'])?$_GET['end_date'].' 23:59:59':'';
$payment_mode = isset($_GET['payment_mode'])?$_GET['payment_mode']:'';
$operator_id = isset($_GET['operator_id'])?$_GET['operator_id']:'1';

$operatorArr = array();
if (!empty($operator_id)) {
  $sql2 = "SELECT * FROM `operators` WHERE operator_id = ".$operator_id;
  $result2 = mysqli_query($conn, $sql2);
  if (mysqli_num_rows($result2) > 0) {
      while($row1 = mysqli_fetch_assoc($result2)) {
         $operatorArr = $row1;
      }
  }
}


$sql = '';
 $sql .= "select p.*, su.Name, pm.payment_type, ca.employee_name from payments as p left join `customers` as su on su.Id = p.user_id left join `branchs` as b on b.branch_name = p.branch_name LEFT JOIN `payment_modes` AS pm ON pm.id = p.payment_mode LEFT JOIN `collectionagents` as ca ON ca.ca_id = p.`collectionagent_id` where ";
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " p.payment_date between '".$start_date."' and '".$end_date."' ";
} else {
    $sql .= "1 ";
}

if (!empty($agent)) {
  $sql .= " and p.`collectionagent_id` = '".$agent. "'";
}

if (!empty($branch)) {
  $sql .= " and b.bid = '".$branch. "'";
} 
if (!empty($payment_mode)) {

  $sql .= " and pm.id = '".$payment_mode."'";
}

$finalArr = array();
$total = 0;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $total += $row['paid_amount'];
            array_push($finalArr,$row);
        }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Payment List</title>
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
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/jqueryui.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="wrapper">

  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
          <center><h3>Payment List between <?php echo date('d/m/Y', strtotime($start_date)).' and '.date('d/m/Y', strtotime($end_date)); ?></h3></center><br>
          <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
          <center><img src="<?php echo $serverurl.$operatorArr['operator_logo'];?>" width=230 height=89 class="img-responsive"></center>
      </div>
      <div class="col-xs-12">
        <h3 class="pull-right">Total <?php echo $total; ?></h3>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <?php if(!empty($finalArr)) { ?>
    <div class="row">
      <div class="col-xs-12 table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Customer Name</th>
                <th>User Name</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Paid Date</th>
                <th>Payment Mode</th>
                <th>Location</th>
                <th>Collection By</th>
                
              </tr>
              </thead>
              <tbody>
                  <?php foreach($finalArr as $value) { 
                    $total += $value['paid_amount'];
                    ?>
                      <tr>
                        <td><?php echo !empty($value['Name'])?ucwords($value['Name']):''; ?></td>
                        <td><?php  echo ucwords($value['Username']);  ?></td>
                        <td><?php echo ucwords($value['month']); ?></td>
                        <td><?php echo $value['paid_amount']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($value['payment_date'])); ?></td>
                        
                        <td><?php echo $value['payment_type']; ?></td>
                        <td><?php echo $value['branch_name']; ?></td>
                        <td><?php echo $value['employee_name']; ?></td>
                      </tr>
              <?php } ?>

            </table>
      </div>
      <!-- /.col -->
    </div>
    <?php } else { ?>
      <div class="row"><center>No data found</center></div>
    <?php } ?>
    <!-- /.row -->

  </section>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $serverurl ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $serverurl ?>bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  let invoiceName = "<?php echo 'payment_list_'.date('d/m/Y', strtotime($start_date)).' and '.date('d/m/Y', strtotime($end_date)); ?>";
    let doc = new jsPDF('p','pt','a4');

   /* setInterval(function(){
            doc.addHTML(document.body,function() {
                doc.save(invoiceName);
            });
    }, 1000);
    
    */
});

    
</script>
</body>
</html>

