<?php
include("../valid.php");
include("../head.php");

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

if (!empty($_POST['submit'])) {
  unset($_POST['submit']);
  $postData = array_map('trim', $_POST);
  //checking data exist in database
  $check_sql = "select id from customers WHERE `CAF_No` = '".$postData['CAF_No']."' or `Aadhar_No` = '".$postData['Aadhar_No']."' or   `Mobile` = '".$postData['Mobile']."' or `ONU_Serial_No` = '".$postData['ONU_Serial_No']."'";
  if (!empty($postData['Alt_Mobile'])) {
    $check_sql .= " or `Alt_Mobile` = '".$postData['Alt_Mobile']."'";
  }
  $result = mysqli_query($conn, $check_sql);
  if (mysqli_num_rows($result) > 0) {
   echo "<script>alert('Failed to add user. Duplicate data found');</script>";
 } else {
  $postData['Status'] = isset($_POST['Status']) ? 1:NULL;
  $keys = array_keys($postData);
  $values = array_values($postData);

  $valueList = ''; $headingList = '';

  $headingList = implode(',', $keys);
  for ($i=0; $i < count($postData); $i++) {
    if ($i==0) {
      $valueList .= '("'.$values[$i].'",';
    } else {
      $valueList .= ' "'.$values[$i].'",';
    }
  }

  $user_image = $user_proof_image = $user_caf_image = NULL; 
  if(!empty($_FILES['user_image']['name'])) {

    $target_path = $_SERVER['DOCUMENT_ROOT'].'/cms/user_images/';  
    if (!file_exists($target_path)) {
      mkdir($target_path, 0777, true);
    }

    $filename   = $postData['Username']."_."."usrIMG".rand(1111,99999);
    $extension  = pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION);
    $basename   = $filename . '.' . $extension;
    $user_image = $basename;

    $source       = $_FILES["user_image"]["tmp_name"];
    $destination = $target_path.$basename;

    $res = move_uploaded_file( $source, $destination);
    if ($res) {
      $valueList = rtrim($valueList, ',');
      $headingList .= ", user_image";
      $valueList .= ', "'.$user_image.'"';
    }
  }

  if(!empty($_FILES['user_proof_image']['name'])) {

    $target_path = $_SERVER['DOCUMENT_ROOT'].'/cms/user_proof_images/';  
    if (!file_exists($target_path)) {
      mkdir($target_path, 0777, true);
    }

    $filename   = $postData['Username']."_"."proof_img".rand(1111,99999);
    $extension  = pathinfo($_FILES["user_proof_image"]["name"], PATHINFO_EXTENSION);
    $basename   = $filename . '.' . $extension;
    $user_proof_image = $basename;

    $source       = $_FILES["user_proof_image"]["tmp_name"];
    $destination = $target_path.$basename;

    $res = move_uploaded_file( $source, $destination);
    if ($res) {
      $valueList = rtrim($valueList, ',');
      $headingList .= ", user_id_proof";
      $valueList .= ', "'.$user_proof_image.'"';
    }
  }

  if(!empty($_FILES['user_caf_image']['name'])) {

    $target_path = $_SERVER['DOCUMENT_ROOT'].'/cms/user_caf_images/';  
    if (!file_exists($target_path)) {
      mkdir($target_path, 0777, true);
    }

    $filename   = $postData['Username']."_"."caf_img".rand(1111,99999);
    $extension  = pathinfo($_FILES["user_caf_image"]["name"], PATHINFO_EXTENSION);
    $basename   = $filename . '.' . $extension;
    $user_caf_image = $basename;

    $source       = $_FILES["user_caf_image"]["tmp_name"];
    $destination  = $target_path.$basename;

    $res = move_uploaded_file( $source, $destination);
    if ($res) {
      $valueList = rtrim($valueList, ',');
      $headingList .= ", user_caf_image";
      $valueList .= ', "'.$user_caf_image.'"';
    }
  }

  $valueList = rtrim($valueList, ',');
  $insertSQL = 'INSERT into `customers` ('.$headingList.') values '.$valueList.')';
     
  if (mysqli_query($conn, $insertSQL)) {
    echo "<script>alert('User added successfully');
    window.location.href = '../user/view.php'</script>";
  } else {
    echo "<script>alert('Failed to add user');</script>";
  }
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

  <link rel="stylesheet" href="<?php echo $serverurl ?>plugins/iCheck/all.css">

  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">

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
       Add User
       
     </h1>

   </section>

   <!-- Main content -->
   <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">

          <form role="form" method="post" action="" enctype='multipart/form-data'>
            <div class="box-body">
              <div class="form-group">
                <label>Operator</label>
                <select class="form-control" name="operator_id" id="operator_id" required onchange="getBranchPackages()">
                  <option value="">Select Operator</option>
                  <?php 
                  $sql_operator = "SELECT * FROM `operators` WHERE `status` = 1";
                  $operator_result = mysqli_query($conn, $sql_operator);
                  while($op = mysqli_fetch_assoc($operator_result)) {
                    ?>
                    <option value="<?php echo $op['operator_id']; ?>"><?php echo $op['operator_name']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Branch Name</label>
                <select class="form-control" name="Branch" id="Branch">
                  <option value="">Select Branch</option>
                </select>
              </div>

              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" name="Name" placeholder="Full Name" required autocomplete="off">
              </div>

              <div class="form-group">
                <label>CAF No</label>
                <input type="text" class="form-control" name="CAF_No" placeholder="CAF No" required autocomplete="off">
              </div> 

              <div class="form-group">
                <label>Date Added</label>
                <input type="text" class="form-control" name="Date_Added" placeholder="Date Added" id="datepicker3" required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="Email" placeholder="Email" autocomplete="off">
              </div>
              <div class="form-group">
                <label>Father Name</label>
                <input type="text" class="form-control" name="FatherCompany_Name" placeholder="Father Name">
              </div>

              <div class="form-group">
                <label>Installation Address</label>
                <textarea class="form-control" name="Installation_Address" placeholder="Installation Address" required></textarea>
              </div>

             <!--  <div class="form-group">
                <label>Billing Address</label>
                <textarea class="form-control" name="Billing_Address" placeholder="Billing Address" required></textarea>
              </div> -->

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Area</label>
                <input type="text" class="form-control" name="Area" placeholder="Area" required>
              </div> -->

              

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Colony</label>
                <input type="text" class="form-control" name="Colony" placeholder="Colony" required>
              </div> -->

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Building</label>
                <input type="text" class="form-control" name="Building" placeholder="Building" required>
              </div> -->

              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Latitude</label>
                <input type="text" class="form-control" name="Latitude" placeholder="Latitude" required>
              </div> -->

              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Longitude</label>
                <input type="text" class="form-control" name="Longitude" placeholder="Longitude" required>
              </div> -->

              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Node</label>
                <input type="text" class="form-control" name="Node" placeholder="Node" required>
              </div> -->
              
              <div class="form-group">
                <label for="exampleInputEmail1">Aaadhar No</label>
                <input type="text" class="form-control" name="Aadhar_No" placeholder="Aadhar No" required autocomplete="off">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Mobile No</label>
                <input type="text" class="form-control" id="mobile" name="Mobile" placeholder="Mobile No" required autocomplete="off">
                <small id="mobile_error" class="hide"></small>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Alt Mobile No</label>
                <input type="text" class="form-control" name="Alt_Mobile" placeholder="Alt Mobile No" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Package</label>
                <select class="form-control" name="Package_Name" id="package" onchange="getPackagePrice();">
                  <option value="">Select Package</option>
               </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Package Price</label>
                <input type="text" class="form-control" id="Package_Price" name="Package_Price" placeholder="Package Price" required readonly="readonly">
              </div>
              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Connection Type</label>
                <input type="text" class="form-control" id="Connection_Type" name="Connection_Type" placeholder="Connection Type" required>
              </div> -->
              

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Sub Package</label>
                <input type="text" class="form-control" name="Sub_Package" placeholder="Sub Package" required>
              </div> -->

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Balance Amount</label>
                <input type="text" class="form-control" id="Balance_Amount" name="Balance_Amount" placeholder="Balance Amount" required >
              </div> -->

             <!--  <div class="form-group">
                <label for="exampleInputEmail1">Spl Discount</label>
                <input type="text" class="form-control" id="Spl_Discount" name="Spl_Discount" placeholder="Spl Discount" required >
              </div> -->
              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Add Charges</label>
                <input type="text" class="form-control" id="Add_Charges" name="Add_Charges" placeholder="Add Charges" required >
              </div> -->

             <!-- <div class="form-group">
                <label>Account Type</label>
                <input type="text" class="form-control" name="Account_Type" placeholder="Account Type" required>
             </div> -->

             <!-- <div class="form-group">
                <label>Franchise Name</label>
                <input type="text" class="form-control" name="Franchise_Name" placeholder="Franchise Name" required>
             </div> -->

             <!-- <div class="form-group">
                <label>MAC</label>
                <input type="text" class="form-control" name="MAC" placeholder="MAC" required>
             </div> -->

              <!-- <div class="form-group">
                <label>Ip Address</label>
                <input type="text" class="form-control" name="IpAddress" placeholder="Ip Address" required>
              </div> -->

              <!-- <div class="form-group">
                <label>Expiry Date</label>
                <input type="text" class="form-control" name="Expiry_Date" id="datepicker" placeholder="Expire Date" required>
              </div>
 -->
              <!-- <div class="form-group">
                <label>Last Renewal</label>
                <input type="text" class="form-control" name="Last_Renewal" id="datepicker2" placeholder="Last Renewal" required>
              </div> -->

              <!-- <div class="form-group">
                <label>Auto Renew</label>
                <input type="text" class="form-control" name="Auto_Renew" id="Auto_Renew" placeholder="Auto Renew" required>
              </div> -->

            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="username" name="Username" placeholder="Operator Username" required autocomplete="off">
            </div>

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="password" class="form-control"  name="password" placeholder="Operator Password">
            </div> -->

            <div class="form-group">
              <label for="exampleInputEmail1">ONU Serial No</label>
              <input type="text" class="form-control" name="ONU_Serial_No" id="ONU_Serial_No" placeholder="Onu serial number" required autocomplete="off">
              <small id="onu_error" class="hide"></small>
            </div>

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Outage</label>
              <input type="text" class="form-control" name="Outage" placeholder="Outage" required>
            </div> -->

           <!--  <div class="form-group">
              <label for="exampleInputEmail1">FUP Limit</label>
              <input type="text" class="form-control" name="FUP_Limit" placeholder="FUP Limit" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">GST IN</label>
              <input type="text" class="form-control" name="GSTIN" placeholder="GST IN" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Pop</label>
              <input type="text" class="form-control" name="Pop" placeholder="Pop" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Switch</label>
              <input type="text" class="form-control" name="Switch" placeholder="Switch" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Door No</label>
              <input type="text" class="form-control" name="Door_No" placeholder="Door No" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">NAS IP</label>
              <input type="text" class="form-control" name="NAS_IP" placeholder="NAS IP" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">POP Tech Exe</label>
              <input type="text" class="form-control" name="POP_Tech_Exe" placeholder="POP Tech Exe" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">POP Coll Exe</label>
              <input type="text" class="form-control" name="POP_Coll_Exe" placeholder="POP Coll Exe" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Last Payment Source</label>
              <input type="text" class="form-control" name="Last_Payment_Source" placeholder="Last Payment Source" required>
            </div> -->

            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Nas Port Id</label>
              <input type="text" class="form-control" name="Nas_Port_Id" placeholder="Nas Portn Id" required>
            </div>
 -->

            <div class="form-group">
              <label for="">User Photo</label>
              <input type="file" name="user_image">

              <p class="help-block">&nbsp;</p>
            </div>

            <div class="form-group">
              <label for="">User ID Proof</label>
              <input type="file" name="user_proof_image">

              <p class="help-block">&nbsp;</p>
            </div>

            <div class="form-group">
              <label for="">User caf image</label>
              <input type="file" name="user_caf_image">

              <p class="help-block">&nbsp;</p>
            </div>

            <div class="form-group">
              <label for="">Status</label>
              &nbsp;<input type="checkbox" class="flat-red" name="Status">
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary addBtn">
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
<script src="<?php echo $serverurl ?>bower_components/bootstrap/js/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $serverurl ?>bower_components/bootstrap/js/datetimepicker.min.js" type="text/javascript"></script>

<script src="<?php echo $serverurl ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
</body>
</html>
<script>
  $(function () {

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    var CurrentDate = moment().format('YYYY-MM-DD HH:mm:ss');
    $('#datepicker3').datetimepicker({
      format : 'YYYY-MM-DD HH:mm:ss',
      clear : false
    });
    if (CurrentDate) {
      $('#datepicker3').val(CurrentDate);
    }
    

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });

    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });


  });

  function getPackagePrice() {
    let package = $('#package').val();
    if(package){
      $.ajax({
        type:'POST',
        url :'user_process.php',
        data:'act=getPrice&packageName='+package,
        dataType:'HTML',
        async:true,
            success:function(response){
             var data = JSON.parse(response);
              if(data.price){ 
                $('#Package_Price').val(data.price);
              }else{
                 $('#Package_Price').val('');
              }

            }
        }); 
    }
    else
    {
      $('#Package_Price').val('');
    }
  }

  function getBranchPackages(){
    let operator = $('#operator_id').val();
    if(operator){
      $.ajax({
        type:'POST',
        url :'user_process.php',
        data:'act=getbranchesandpackages&operator_id='+operator,
        dataType:'HTML',
            success:function(response){
             var data = JSON.parse(response);
              if(data.status){
                let htmlbranch = ''; let htmlpackage = ''; let counter = 0; let counter1 = 0;
                htmlbranch += '<option value="">Select Branch</option>';
                $(data.branch).each(function(i,v) {
                  htmlbranch += '<option value="'+v.branch_name+'">'+v.branch_name+'</option>';
                  counter++;
                });

                htmlpackage += '<option value="">Select Package</option>';
                $(data.packages).each(function(i,v) {
                  htmlpackage += '<option value="'+v.package_name+'">'+v.package_name+'</option>';
                  counter1++;
                });

                if (counter > 0) {
                  $('#Branch').html(htmlbranch);
                }

                if (counter1 > 0) {
                  $('#package').html(htmlpackage);
                }
              } else {
                alert('Failed to fetch branch and packages');
              }

            }
        }); 
    }
  }

  $('#mobile').keyup(function() {
      $('#username').val($(this).val());
  });

  $('#mobile').keyup(function(e) {
    let val = $(this).val();
    if (val.length>2) {
      $.ajax({
        type:'POST',
        url :'user_process.php',
        data:'act=checkMobile&mobile='+val,
        dataType:'json',
        success:function(response) {
          if (response) {
            if(response.status){
              $('#mobile_error').removeClass('hide');
              $('#mobile_error').text(response.message).css({'color':'red','display':'block'});
              $('.addBtn').prop('disabled',true);
            }else{
              $('#mobile_error').removeClass('hide');
              $('#mobile_error').text(response.message).css({'color':'green','display':'block'});
              $('.addBtn').prop('disabled',false);
            }
          }
        }
      }); 
    }
  });

  $('#ONU_Serial_No').keyup(function(e) {
    let val = $(this).val();
    if (val.length>1) {
      $.ajax({
        type:'POST',
        url :'user_process.php',
        data:'act=checkONUSerialNo&ONU_Serial_No='+val,
        dataType:'json',
        success:function(response) {
          if (response) {
            if(response.status){
              $('#onu_error').removeClass('hide');
              $('#onu_error').text(response.message).css({'color':'red','display':'block'});
              $('.addBtn').prop('disabled',true);
            }else{
              $('#onu_error').text('').css({'display':'none'}).addClass('hide');
              $('.addBtn').prop('disabled',false);
            }
          }
        }
      }); 
    }
  });
</script>
