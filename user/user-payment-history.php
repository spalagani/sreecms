<?php
include("../valid.php");
include("../head.php"); 

$searchTerm = $_GET['id'];
$getYear = (isset($_GET['year'])?$_GET['year']:date('Y'));
if(!empty($searchTerm)) {
    $sql = "SELECT p.*, pm.payment_type FROM `payments` AS p LEFT JOIN `payment_modes` AS pm ON pm.id = p.payment_mode  WHERE p.`user_id`=".$searchTerm." and p.`year`= ".$getYear;
    $result = mysqli_query($conn, $sql);
    $finalArr = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($finalArr,$row);
        }
    }
    
    $invoiceUrl = $serverurl.'user/invoice.php?id='.$searchTerm;
    $invoiceDownloadUrl = $serverurl.'user/invoice_download.php?id='.$searchTerm;
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
    <section class="content-header">
      <div class="row">
        <div class="col-md-10">
          <h3>User Payment History</h3>
        </div>
        <div class="col-md-2">
          <a style="margin-top: 15px" href="<?php echo $serverurl.'user/payment.php?id='.$searchTerm; ?>" class="btn btn-primary pull-right">Back</a>
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
            
            <form role="form" method="get">
              <div class="box-body">
                 <div class="row">
                     <div class="col-md-10">
                        <input type="hidden" name="id" value="<?php echo $searchTerm; ?>">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Select Year</label> (*On Change of the year, we have show all the months with Paid / un paid / send sms / multiselect option / payment link)
                         <select class="form-control" name="year">
                            <?php 
                                $currentYear = date('Y');
                                for($i = $currentYear-5; $i<=$currentYear+5; $i++) { 
                                if($getYear == $i) {
                            ?>
                                <option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            <?php } ?>
                          </select>
                        </div>
                     </div>
                     <div class="col-md-2">
                         <input type="submit" value="Submit" class="btn btn-primary" style="margin-top:25px" name="submit">
                     </div>
                 </div>
            </form>
                 
                <div class="form-group">
                <?php if(!empty($finalArr)) { ?>
                  <div class="box-body">
                      <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Month</th>
                          <th>Paid / Unpaid</th>
                          <th>Paid Date</th>
                          <th>Amount Paid</th>
                          <th>Payment Mode</th>
                          <th>Receipt</th>
                          <th>View Invoice</th>
                          <th>Download Invoice</th>
                          <th>Send SMS Notification</th>
                          <th>Action</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($finalArr as $value) { ?>
                                <tr id="<?php echo $value['payment_id']; ?>">
                                  <td><?php echo ucwords($value['month']); ?></td>
                                 <td><?php if($value['extra_amount'] >=0) { echo "Paid"; } else { echo "Partially paid"; } ?></td>
                                  <td><?php echo date('d/m/Y', strtotime($value['payment_date'])); ?></td>
                                  <td><?php echo $value['paid_amount']; ?></td>
                                  <td><?php echo $value['payment_type']; ?></td>
                                  <td><a download href="<?php echo $serverurl.'user_payments/'.$value['payment_proof_attach']; ?>" class="btn btn-primary">Receipt</a></td>
                                  <td><a data-link="<?php echo $invoiceUrl.'&year='.$value['year'].'&month='.$value['month'].'&operator_id='.$value['operator_id']; ?>" class="btn btn-primary downloadInv">View Invoice</a></td>
                                  <td><a data-link="<?php echo $invoiceDownloadUrl.'&year='.$value['year'].'&month='.$value['month'].'&operator_id='.$value['operator_id']; ?>" class="btn btn-primary downloadInv">Download Invoice</a></td>
                                  <td><a href="#" class="btn btn-primary">Send SMS Notification</a></td>
                                  <td><button class="btn btn-danger btn-sm remove">Delete</button></td>
                                </tr>
                        <?php } ?>
        
                      </table>
                      </div>
                </div>
                <?php } else { ?>
                <p>No data found</p>
                <?php } ?>
           </div>
             

               
              </div>
              <!-- /.box-body -->

            
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

  $(".downloadInv").click(function() {
      let link = $(this).attr('data-link');
      download(link);
  });
    function download(link){
      var popout = window.open(link);
      window.setTimeout(function(){
         //popout.close();
      }, 3500);
    }

</script>
<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");
        console.log(id);

        if(confirm('Are you sure to remove this Payment ?'))
        {
            $.ajax({
              url: 'http://sreecorp.com/cms/user/delete.php',
              type: 'GET',
              data: {id: id},
              error: function() {
                  alert('Something is wrong');
              },
              success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully"); 
                    location.reload();
              }
            });
        }
    });


</script>
