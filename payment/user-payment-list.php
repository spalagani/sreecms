<?php
include("../valid.php");
include("../head.php"); 

$agent = isset($_GET['agent'])?$_GET['agent']:'';
$branch = isset($_GET['branch'])?$_GET['branch']:'';
$start_date = isset($_GET['start_date'])?$_GET['start_date'].' 00:00:00':'';
$end_date = isset($_GET['end_date'])?$_GET['end_date'].' 23:59:59':'';
$payment_mode = isset($_GET['payment_mode'])?$_GET['payment_mode']:'';

$sql = '';
 $sql .= "select p.*, su.Name, pm.payment_type, ca.employee_name, ca.operator_id as `operatorid` from payments as p left join `customers` as su on su.Id = p.user_id left join `branchs` as b on b.branch_name = p.branch_name LEFT JOIN `payment_modes` AS pm ON pm.id = p.payment_mode LEFT JOIN `collectionagents` as ca ON ca.ca_id = p.`collectionagent_id` where ";
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
$operatorid = 1;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $operatorid = $row['operatorid'];
        $total += $row['paid_amount'];
        array_push($finalArr,$row);
    }
}
$payment_list_pdf_url = $_SERVER['REQUEST_URI'].'&operator_id='.$operatorid;
$payment_list_pdf_url = str_replace('user-payment-list', 'payment-list-invoice', $payment_list_pdf_url);
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
      <div class="row">
        <div class="col-md-10">
                <h3>User Payment List between <?php echo date('d/m/Y', strtotime($_GET['start_date'])).' and '.date('d/m/Y', strtotime($_GET['end_date'])); ?></h3>
        </div>
        <div class="col-md-2">
          <a style="margin-top: 15px" href="<?php echo $serverurl ?>payment/pay-search.php" class="btn btn-primary pull-right">Back</a>
        </div>

      </div>

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            
              <div class="box-body">
                 <h3 class="pull-right total_show" style="margin-right: 25px;">Total: <?php echo $total; ?></h3>
                <?php if(!empty($finalArr)) { ?>
                  <div class="col-md-12">
                      <div class="table-responsive">
                              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>Customer</th>
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
                        </div>
                        <?php } else { ?>
                        <p>No data found</p>
                        <?php } ?>
                   <div class="row">
                     <div class="col-md-6">
                       <button type="button" class="btn btn-primary pull-left printList" data-link="<?php echo $payment_list_pdf_url; ?>">Print</button>
                     </div>
                   </div> 
              </div>
          </div>
        
            </div>
          </div>
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
  var pdfname = "<?php echo 'payment_list_'.date('d/m/Y', strtotime($_GET['start_date'])).'_'.date('d/m/Y', strtotime($_GET['end_date'])).'.pdf'; ?>"
  $(function () {

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

  $(document).ready(function() {
    $(".printList").click(function() {
        let link = $(this).attr('data-link');
        download(link);
    });
    function download(link){
      var popout = window.open(link);
      window.setTimeout(function(){
         //popout.close();
      }, 3500);
    }
});

</script>
