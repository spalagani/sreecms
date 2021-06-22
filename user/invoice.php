<?php
include("../valid.php");
include("../head.php");

$searchTerm = $_GET['id'];
$year = $_GET['year'];
$month = $_GET['month'];
$operator_id = $_GET['operator_id'];

$finalArr = array();
$paymentArr = array();
$operatorArr = array();

$invoiceId = $totalPaid = '';
if (!empty($searchTerm) && !empty($year) && !empty($month)) {
	$sql = "SELECT * FROM `customers` WHERE `id`=".$searchTerm;
	$result = mysqli_query($conn, $sql);
	$finalArr = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        $finalArr = $row;
	    }
	}
	
	$sql1 = "SELECT p.*, pm.payment_type, pc.package_name FROM `payments` AS p LEFT JOIN `payment_modes` AS pm ON pm.id = p.payment_mode  LEFT JOIN `packages` AS pc ON pc.package_id = p.package_id WHERE p.`user_id`=".$searchTerm." and p.`year`= ".$year." and p.`month` = '".$month."'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        while($row1 = mysqli_fetch_assoc($result1)) {
           $paymentArr = $row1;
        }
    }
	
	$payment_id = !empty($paymentArr['payment_id'])?$paymentArr['payment_id'] :
	    '';
	    
	$amount_paid = !empty($paymentArr['paid_amount'])?$paymentArr['paid_amount'] :
	    0;
	$extra_amount = !empty($paymentArr['extra_amount'])?$paymentArr['extra_amount'] :
	    0;
	$invoiceId = $year.'_'.$month.'_'.$payment_id;
	$totalPaid = $amount_paid+$extra_amount;
    
  $sql2 = "SELECT * FROM `operators` WHERE operator_id = ".$operator_id;
  $result2 = mysqli_query($conn, $sql2);
  if (mysqli_num_rows($result2) > 0) {
      while($row1 = mysqli_fetch_assoc($result2)) {
         $operatorArr = $row1;
      }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo !empty($finalArr['Name']) ? $finalArr['Name'] : ''; ?></title>
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
           <center><h3 style="font-weight: 600; font-size: 35px;">Invoice of <?php echo $paymentArr['month'].' month'; ?></h3></center>
           <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
           <center><img src="<?php echo $serverurl.$operatorArr['operator_logo'];?>" width=230 height=89 class="img-responsive"></center>
           <hr>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $operatorArr['operator_name'];?></strong><br>
          <?php echo $operatorArr['op_address'];?><br>
          <!--Phone: (804) 123-5432<br>-->
          <!--Email: info@almasaeedstudio.com-->
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo !empty($finalArr['Name']) ? $finalArr['Name'] : ''; ?></strong><br>
          <?php echo !empty($finalArr['Billing_Address']) ? $finalArr['Billing_Address'] : ''; ?><br>
          Phone: <?php echo !empty($finalArr['Mobile']) ? $finalArr['Mobile'] : ''; ?><br>
          Email: <?php echo !empty($finalArr['Email']) ? $finalArr['Email'] : ''; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice: </b><?php echo $invoiceId; ?><br>
        <b>Account No:</b> <?php echo !empty($finalArr['Id']) ? $finalArr['Id'] : ''; ?><br>
        <b>Payment Date:</b> <?php echo !empty($paymentArr['payment_date']) ? date('d/m/Y', strtotime($paymentArr['payment_date'])) : ''; ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row"  style="margin-top:40px">

       <div class="col-md-3"><b>Username</b><p><?php echo !empty($finalArr['Username']) ? $finalArr['Username'] : ''; ?></p></div>
      <div class="col-md-3"><b>Package Name</b><p><?php echo !empty($paymentArr['package_name']) ? $paymentArr['package_name'] : ''; ?></p></div>
      <div class="col-md-3"><b>Package amount</b><p><?php echo !empty($paymentArr['amount']) ? "&#8377; ".$paymentArr['amount'] : "&#8377; 0"; ?></p></div>
      <div class="col-md-3"><b>Subtotal</b><p><?php echo "&#8377; $totalPaid"; ?></p></div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    
    <div class="row" style="margin-top:30px">
      <div class="col-xs-8">
        <p class="lead"><span style="font-weight:500">Payment Method:</span> <?php echo !empty($paymentArr['payment_type']) ? $paymentArr['payment_type'] : ''; ?></p>
      </div>
      <div class="col-xs-4">
        <p class="lead"><span style="font-weight:500">Total:</span> <?php echo "&#8377; $totalPaid"; ?></p>
      </div>
    </div>
    <div class="row" style="margin-top:30px">
      <div class="col-md-12"><p style="font-size: 15px">Remarks:</p></div>
    </div>
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
var invoiceName = "<?php echo 'invoice_'.$invoiceId.'.pdf'; ?>"
$(document).ready(function() {
    let doc = new jsPDF('p','pt','a4');

   /* setInterval(function(){
            doc.addHTML(document.body,function() {
                doc.save(invoiceName);
            });
    }, 1000); *
});

    
</script>
</body>
</html>

