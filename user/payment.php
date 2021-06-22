<?php
include("../valid.php");
include("../head.php");
$searchTerm = $_GET['id'];
$getYear = (isset($_GET['year'])?$_GET['year']:date('Y'));
if(!empty($_POST['submit'])) {

    if(empty($_POST['month'])) {
        echo "<script>alert('Please select month');</script>";
    }
    
    $file_name = '';
    
    if(!empty($_POST['uploadedBill_name'])) {
         
            $target_path = $_SERVER['DOCUMENT_ROOT'].'/cms/user_payments/';  
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
          
            $filename   = $_POST['username']."_".$_POST['year']."_".$_POST['month'][0];
            $extension  = pathinfo($_POST['uploadedBill_name'], PATHINFO_EXTENSION);
            $basename   = $filename . '.' . $extension;
            $file_name = $basename;
            
            $destination = $target_path.$basename;

            $source       = $_POST['uploadedBill_content'];
            $image_array_1 = explode(";", $source);
            $image_array_2 = explode(",", $image_array_1[1]);
            $source = base64_decode($image_array_2[1]);
            
            file_put_contents($destination, $source);
    }


    $monthCount = count($_POST['month']);
    $extra_amount = trim($_POST['amount_paid']) - trim($_POST['package_amount'])*$monthCount;
    $data = array(
        'operator_id' => !empty($_POST['operator_id']) ? trim(strip_tags($_POST['operator_id'])):0, 
        'user_id' => !empty($searchTerm) ? trim(strip_tags($searchTerm)):0,    
        'collectionagent_id' => !empty($_POST['agent']) ? trim(strip_tags($_POST['agent'])):0,    
        'year' => !empty($_POST['year']) ? trim(strip_tags($_POST['year'])):date('Y'),    
        'package_id' => !empty($_POST['package_id']) ? trim(strip_tags($_POST['package_id'])):0,    
        // 'month' => !empty($_POST['month']) ? trim(strip_tags($_POST['month'])):'', 
        'amount' => !empty($_POST['package_amount']) ? trim(strip_tags($_POST['package_amount'])):0,
        'extra_amount' => !empty($extra_amount) ? $extra_amount:0,
        'remarks' => !empty($_POST['notes']) ? trim(strip_tags($_POST['notes'])):'',
        'paid_amount' => !empty($_POST['package_amount']) ? trim(strip_tags($_POST['package_amount'])):0,
        'payment_mode' => !empty($_POST['payment_type']) ? trim(strip_tags($_POST['payment_type'])):0,
        'payment_proof_attach' => $file_name,
        'payment_date' => date('Y-m-d H:i:s'),
        'branch_name' => !empty($_POST['branch_name']) ? $_POST['branch_name']:'',
        'status'=> 1
    );
    
    $counter = 0;
    for($i=0; $i<count($_POST['month']);$i++) {
        if($i > 0) {
            $data['extra_amount'] = 0;
        }
        $sql_insert = "INSERT INTO `payments` (operator_id, user_id, collectionagent_id, year, package_id, month, amount, extra_amount, remarks, paid_amount, payment_mode, payment_proof_attach, payment_date, status,branch_name)
            VALUES (".$data['operator_id'].", ".$data['user_id'].",".$data['collectionagent_id'].", ".$data['year'].", ".$data['package_id'].", '".$_POST['month'][$i]."',  ".$data['amount'].", ".$data['extra_amount'].", '".$data['remarks']."', ".$data['paid_amount'].",".$data['payment_mode'].",'".$data['payment_proof_attach']."','".$data['payment_date']."', ".$data['status'].", '".$data['branch_name']."')";
        
            if (mysqli_query($conn, $sql_insert)) {
                $counter++;
            } 
    }
   
   
    if ($counter >0) {
        unset($_POST['submit']);
        echo "<script>alert('Payment added successfully');</script>";
    } else {
       echo "<script>alert('Failed to add record');</script>";
    }

}



$finalArr = array();
if (!empty($searchTerm)) {
	$sql = "SELECT `customers`.* FROM `customers` WHERE `id` = ".$searchTerm;
	$result = mysqli_query($conn, $sql);
	$finalArr = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        $finalArr = $row;
	    }
	}
}

// payment modes
$sql_payment_mode = "SELECT * FROM `payment_modes` WHERE `is_active` = '1'";
$payment_result = mysqli_query($conn, $sql_payment_mode);

// package type
$sql_package_type = "SELECT `pk`.*, `su`.Username FROM `packages` AS `pk` LEFT JOIN `customers` AS `su` ON `su`.`Package_Name` = `pk`.`package_name` WHERE `su`.`id` =".$searchTerm;
$package_type_result = mysqli_query($conn, $sql_package_type);
$package_arr = mysqli_fetch_assoc($package_type_result);

// Payment table
$sql_payment = "SELECT * FROM `payments` WHERE `user_id`=".$searchTerm." and `year` = ".$getYear;
$payments_result = mysqli_query($conn, $sql_payment);
$balance = 0;
$invoice = 0;
$month = array();
while($r = mysqli_fetch_assoc($payments_result)) {
    $month[]  = $r['month'];
    $payment_arr = $r;
    $balance += $r['extra_amount'];
    $invoice += $r['paid_amount'];
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
  
  <!-- Crop image files -->
  <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
  <script src="https://unpkg.com/dropzone"></script>
  <script src="https://unpkg.com/cropperjs"></script>
  
  <style type="text/css">
    img {
      display: block;
      max-width: 100%;
    }
    .preview {
        overflow: hidden;
        width: 160px; 
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
    .img-container{
      padding: 0;
    }
    #sample_image{
      max-width: 100%;
    }
    @media only screen and (max-width: 600px) {
      #crop {
        position: absolute;
        top: 2rem;
        right: 5rem;
        width: 14rem;
      }
    }
  </style>
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
      <h1><?php echo !empty($finalArr['Name'])?$finalArr['Name']."'s ":''; ?>Payment</h1>
      <a class="btn btn-primary pull-right" style="margin-top:-25px" href="<?php echo $serverurl.'user/user-search.php';?>">Back</a>
    
    </section>
    
    <!-- Upload modal -->
    <div class="modal fade" id="uploadBillModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crop Image Before Upload</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <div class="row">
                <div class="col-md-8 img-container">
                  <img src="" id="sample_image" />
                </div>
                <div class="col-md-4">
                  <div class="preview"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="crop" class="btn btn-primary">Crop</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default">
            <div class="row">
              <form role="form" action="<?php echo $serverurl."user/payment.php?id=".$searchTerm; ?>" method="POST" enctype='multipart/form-data' id="payment_form">
                <div class="col-md-6">
                    <div class="box-body">
                <div class="form-group">
                  <label for="">Select Year</label>
                  <select class="form-control" name="year" required id="select_year">
                    <option value="">Select Year</option>

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
                
                <div class="form-group">
                <?php if(empty($month)) { ?>
                  <input type="checkbox" <?php echo ((date("m") == "01") && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="jan">
                  <label for="Jan">Jan</label>
                  <input type="checkbox" <?php echo ((date("m") == "02") && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="feb">
                  <label for="feb">Feb</label>
                  <input type="checkbox" <?php echo ((date("m") == "03")  && ($getYear == date('Y'))) ? "checked='true'":''; ?> id="month_check" name="month[]" value="mar">
                  <label for="mar">Mar</label>
                  <input type="checkbox" <?php echo ((date("m") == "04")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="april">
                  <label for="mar">April</label>
                  <input type="checkbox" <?php echo ((date("m") == "05")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="may">
                  <label for="mar">May</label>
                  <input type="checkbox" <?php echo ((date("m") == "06")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="june">
                  <label for="mar">June</label>
                  <input type="checkbox" <?php echo ((date("m") == "07")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="july">
                  <label for="mar">July</label>
                  <input type="checkbox" <?php echo ((date("m") == "08")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="aug">
                  <label for="mar">Aug</label>
                  <input type="checkbox" <?php echo ((date("m") == "09")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="sep">
                  <label for="mar">Sep</label>
                  <input type="checkbox" <?php echo ((date("m") == "10")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="oct">
                  <label for="mar">Oct</label>
                  <input type="checkbox" <?php echo ((date("m") == "11")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="nov">
                  <label for="mar">Nov</label>
                  <input type="checkbox" <?php echo ((date("m") == "12")  && ($getYear == date('Y'))) ? "checked='true'":'';  ?> id="month_check" name="month[]" value="dec">
                  <label for="mar">Dec</label>
                  (If Paid - we need to disable check box with checked symbol)
                <?php } else { ?>
                    <?php
                      $month = array_unique($month); ?>
                      <input type="checkbox" <?php echo (in_array("jan",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="jan">
                      <label for="Jan">Jan</label>
                      <input type="checkbox" <?php echo (in_array("feb",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="feb">
                      <label for="feb">Feb</label>
                      <input type="checkbox" <?php echo (in_array("mar",$month)) ? 'checked disabled':''; ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="mar">
                      <label for="mar">Mar</label>
                      <input type="checkbox" <?php echo (in_array("april",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="april">
                      <label for="mar">April</label>
                      <input type="checkbox" <?php echo (in_array("may",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="may">
                      <label for="mar">May</label>
                      <input type="checkbox" <?php echo (in_array("june",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="june">
                      <label for="mar">June</label>
                      <input type="checkbox" <?php echo (in_array("july",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="july">
                      <label for="mar">July</label>
                      <input type="checkbox" <?php echo (in_array("aug",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="aug">
                      <label for="mar">Aug</label>
                      <input type="checkbox" <?php echo (in_array("sep",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="sep">
                      <label for="mar">Sep</label>
                      <input type="checkbox" <?php echo (in_array("oct",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="oct">
                      <label for="mar">Oct</label>
                      <input type="checkbox" <?php echo (in_array("nov",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="nov">
                      <label for="mar">Nov</label>
                      <input type="checkbox" <?php echo (in_array("dec",$month)) ? 'checked disabled':'';  ?> id="month_check" name="month[]" data-month_count="<?php echo count($month); ?>" value="dec">
                      <label for="mar">Dec</label>
                <?php } ?>
                </div>
              
                <div class="form-group">
                  <label for="exampleInputEmail1">Paid On Date</label>
                  <input type="text" class="form-control" placeholder="Paid Date" id="datepicker" required autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Paying Amount</label>
                  <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Paying Amount" onkeypress="return isNumberKey(event,this)" value="<?php echo !empty($package_arr['package_price'])?round($package_arr['package_price'],2):0; ?>" required> (Here we need to show the amount as per the package and out standing)
                </div>
                <input type="hidden" name="package_id" value="<?php echo !empty($package_arr['package_id'])?$package_arr['package_id']:0; ?>">
                <input type="hidden" name="operator_id" value="<?php echo !empty($finalArr['operator_id'])?$finalArr['operator_id']:''; ?>">
                <input type="hidden" name="branch_name" value="<?php echo !empty($finalArr['Branch'])?$finalArr['Branch']:''; ?>">
                <input type="hidden" name="package_amount" value="<?php echo !empty($package_arr['package_price'])?$package_arr['package_price']:0; ?>">
                <input type="hidden" name="username" value="<?php echo !empty($package_arr['Username'])?$package_arr['Username']:0; ?>">
                <div class="form-group">
                  <label for="">Payment type</label>
                  <select class="form-control" name="payment_type" required>
                    <option value="">Select option</option>
                    
                    <?php 
                    if (mysqli_num_rows($payment_result) > 0) {
			         while($row = mysqli_fetch_assoc($payment_result)) { ?>
			            <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_type']; ?></option>
		            <?php } } ?>

                  </select>
                </div>
                
                <div class="form-group">
                  <label for="">Collection Agent Name</label>
                  <select class="form-control" name="agent" required>
                    <option value="">Select option</option>
                    <?php 
                    
                    // Agents
                    $agent_sql = "SELECT * FROM `collectionagents`";
                    $agent_result = mysqli_query($conn, $agent_sql);
                    if (mysqli_num_rows($agent_result) > 0) {
			             while($row_agent = mysqli_fetch_assoc($agent_result)) {  ?>
			            <option value="<?php echo $row_agent['ca_id']; ?>"><?php echo $row_agent['employee_name']; ?></option>
		            <?php } }?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="uploadBill">Attach Bill copy
                  <img src="https://via.placeholder.com/200x200.png?text=Bill%20Copy" width="200" id="uploaded_image">
                  <input type="file" required="" class="form-control" accept=".png, .jpg, .jpeg" id="uploadBill" style="display: none;">
                  </label>
                </div>
                
                <input type="hidden" name="uploadedBill_name" id="uploadedBill_name">
                <input type="hidden" name="uploadedBill_content" id="uploadedBill_content">
                
                <div class="form-group">
                  <label>Notes</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." name="notes"></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="submit" value = "Submit" class="btn btn-primary" id="payment_submit">
              </div>
          </div>
          
                  
                  
                  
                <!--Right section-->
                <div class="col-md-6">
                      <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="margin-top:23px">
                                <tbody>
                                    <tr>
                                      <td>Order No</td>
                                      <td>
                                        <?php echo !empty($payment_arr['payment_id'])?$payment_arr['payment_id']:'';  ?>
                                      </td>
                                    </tr>
                                <tr>
                                  <td>A/C No.</td>
                                  <td>
                                   <?php echo !empty($finalArr['Id'])?$finalArr['Id']:'';  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Username</td>
                                  <td>
                                   <?php echo !empty($finalArr['Username'])?$finalArr['Username']:'';  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Package</td>
                                  <td>
                                   <?php echo !empty($package_arr['package_name'])?$package_arr['package_name']:''; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Sub Package</td>
                                  <td>
                                   <?php echo !empty($package_arr['sub_package'])?$package_arr['sub_package']:''; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Package Price</td>
                                  <td class="package_price" data-package_amount=<?php echo !empty($package_arr['package_price'])? round($package_arr['package_price'],2):0; ?>>
                                  <?php echo !empty($package_arr['package_price'])? "&#8377; ".round($package_arr['package_price'],2):''; ?>  
                                  </td>
                                </tr>
                                <tr class="bg-primary">
                                  <td  style="color:white">Total Paid Invoice Amount</td>
                                  <td  style="color:white" class="package_invoice" data-invoice="<?php echo !empty($invoice)?round($invoice,2):0; ?>">
                                   <?php echo !empty($invoice)? "&#8377; ".round($invoice,2): "&#8377; 0"; ?>
                                  </td>
                                </tr>
                                <tr class="bg-danger btn-danger">
                                  <td  style="color:white">Balance</td>
                                  <td style="color:white">
                                   <?php echo ($balance != 0) ? "&#8377; ".$balance : "&#8377; 0"; ?>
                                  </td>
                                </tr>
                                <tr class="bg-info">
                                  <td colspan="2"  style="color:white; text-align:center;"><a href="<?php echo $serverurl."user/user-payment-history.php?id=$searchTerm"; ?>">User Payment History</a></td>
                                </tr>
                              </tbody>
                              </table>
                            </div>
                      </div>
                 </div>
              </form>
            </div>
        </div>
    </section>
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
<script src="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo $serverurl ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
<script type="text/javascript">
let localurl = "<?php echo $serverurl.'user/payment.php?id='.$searchTerm ?>";
$(document).ready(function() {
  
  /* Cropper */
  var $modal = $('#uploadBillModal');

  var image = document.getElementById('sample_image');

  var cropper;

  $('#uploadBill').change(function(event){
    var files = event.target.files;

    var done = function(url){
      image.src = url;
      $modal.modal('show');
    };

    if(files && files.length > 0)
    {
      reader = new FileReader();
      reader.onload = function(event)
      {
        done(reader.result);
      };
      reader.readAsDataURL(files[0]);
    }
  });

  $modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 10,
      preview:'.preview'
    });
  }).on('hidden.bs.modal', function(){
    cropper.destroy();
      cropper = null;
  });

  $('#crop').click(function(){
    canvas = cropper.getCroppedCanvas({
      width:350,
      height:1050
    });

    canvas.toBlob(function(blob){
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function(){
        var base64data = reader.result;
        $('#uploaded_image').attr('src', base64data);
        $('#uploadedBill_name').val($('#uploadBill').val().replace(/C:\\fakepath\\/i, ''));
        $('#uploadedBill_content').val(base64data);
        $modal.modal('hide');
      };
    });
  });
  /* End Cropper */
  
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format: "mm/dd/yyyy",
      todayHighlight: true,
    });
    $('#datepicker').datepicker('setDate', today);
});
function isNumberKey(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
    return false;
  else {
    var len = $(element).val().length;
    var index = $(element).val().indexOf('.');
    if (index > 0 && charCode == 46) {
      return false;
    }
    if (index > 0) {
      var CharAfterdot = (len + 1) - index;
      if (CharAfterdot > 3) {
        return false;
      }
    }

  }
  return true;
}

$("#select_year").change(function(e) {
    let year = $(this).val();
    if(year !== undefined) {
        window.location.href= localurl+'&year='+year;
    }
});

let prev_month_counter = $("#month_check").attr('data-month_count');
let counter = $('input:checkbox:checked').length;
if(prev_month_counter !== undefined) {
    counter = $('input:checkbox:checked').length - prev_month_counter;
}
$(document.body).on('change','#month_check',function(e){
    let package_amount = $(".package_price").attr('data-package_amount');
    let package_invoice = $(".package_invoice").attr('data-invoice');
    if($(this).is(':checked')) {
        counter++;
        let newAmount = parseInt(counter)*parseInt(package_amount);
        let newAmount1 = "&#8377; "+newAmount;
        $(".package_price").html(newAmount1);
        let new_invoice = parseInt(package_invoice)+parseInt(newAmount);
        // $(".package_invoice").html("&#8377; "+new_invoice);
        $("#amount_paid").val(newAmount);
        
        
    } else {
        counter--;
        let newAmount = parseInt(counter)*parseInt(package_amount);
        if(counter>0) {
            newAmount1 = "&#8377; "+newAmount;
            $(".package_price").html(newAmount1);
            $("#amount_paid").val(newAmount);
        }
        let new_invoice = parseInt(package_invoice)+parseInt(newAmount);
        // $(".package_invoice").html("&#8377; "+new_invoice);
    }
});


</script>
</body>
</html>
