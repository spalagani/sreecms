<?php
ob_start();
include("../valid.php");
include("../head.php");
if(!empty($_POST)) {
    $agent = (isset($_POST['agent'])?$_POST['agent'] : '');
    $branch = (isset($_POST['branch'])?$_POST['branch'] : '');
    $start = (isset($_POST['start_date'])? date('Y-m-d', strtotime($_POST['start'])) : '');
    $end = (isset($_POST['end'])? date('Y-m-d', strtotime($_POST['end'])) : '');
    
    $search_url = $serverurl.'payment/user-payment-list.php?';
    if(!empty($_POST['agent'])) {
        $search_url .= "agent=".$_POST['agent'];
    }
    if(!empty($_POST['branch'])) {
        $search_url .= "&branch=".$_POST['branch'];
    }
    if(!empty($_POST['start_date'])) {
        $search_url .= "&start_date=".date('Y-m-d',strtotime($_POST['start_date']));
    }
    if(!empty($_POST['end_date'])) {
        $search_url .= "&end_date=".date('Y-m-d',strtotime($_POST['end_date']));
    }
    if(!empty($_POST['payment_mode'])) {
        $search_url .= "&payment_mode=".$_POST['payment_mode'];
    }
    header("location:".$search_url); die();
}


$sql = "select * from `collectionagents`";
$result_agent = mysqli_query($conn, $sql);
$agentArr = array();
if (mysqli_num_rows($result_agent) > 0) {
        while($row = mysqli_fetch_assoc($result_agent)) {
            array_push($agentArr,$row);
        }
}

$sql1 = "select * from `branchs`";
$result_branch = mysqli_query($conn, $sql1);
$branchArr = array();
if (mysqli_num_rows($result_branch) > 0) {
        while($row = mysqli_fetch_assoc($result_branch)) {
            array_push($branchArr,$row);
        }
}


// payment modes
$paymentArr = array();
$sql_payment_mode = "SELECT * FROM `payment_modes` WHERE `is_active` = '1'";
$payment_result = mysqli_query($conn, $sql_payment_mode);
  if (mysqli_num_rows($payment_result) > 0) {
    while($row = mysqli_fetch_assoc($payment_result)) {
      array_push($paymentArr,$row);
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

<?php 
 include("../header.php");
 include("../aside.php");
?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Search Payments By Collection Agent / Branch / Dates
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <form role="form" action="" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="">Collection Agent</label>
                 <select class="form-control" name="agent">
                     <option value="">All</option>
                     
                     <?php if(!empty($agentArr)) { 
                        foreach($agentArr as $agent) {
                     ?>
                        <option value="<?php echo $agent['ca_id']; ?>"><?php echo $agent['employee_name']; ?></option>
                    <?php } } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Branch</label>
                 <select class="form-control" name="branch">
                     <option value="">All</option>
                     
                    <?php if(!empty($branchArr)) { 
                        foreach($branchArr as $branch) {
                    ?>
                    
                    <option value="<?php echo $branch['bid']; ?>"><?php echo $branch['branch_name']; ?></option>
                    
                    <?php } }?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Payment Mode</label>
                 <select class="form-control" name="payment_mode">
                     <option value="">All</option>
                     
                    <?php if(!empty($paymentArr)) { 
                        foreach($paymentArr as $payment) {
                    ?>
                    
                    <option value="<?php echo $payment['id']; ?>"><?php echo $payment['payment_type']; ?></option>
                    
                    <?php } }?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Start Date</label>
                  <input id="start_date" name="start_date" type="text" class="form-control" placeholder="Start date" required>
                </div>
              
                <div class="form-group">
                  <label>End Date</label>
                  <input id="end_date" name="end_date" type="text" class="form-control" placeholder="End date" required>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" nam="submit" value="Search" class="btn btn-primary">
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

    $('#start_date,#end_date').datepicker({
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
