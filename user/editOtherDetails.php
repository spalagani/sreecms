<?php
include("../valid.php");
include("../head.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/****** FOR EDIT USER DATA ******/
$id = $_GET['id'];
$row = array();
if($id){
  $editUser = "SELECT * FROM `customers` where id ='".$id."'";
  $resuser  = mysqli_query($conn,$editUser);
  $row      = mysqli_fetch_assoc($resuser);
}

if (!empty($row)) {
  $keys = array_keys($row);
  $counter=0;
  foreach ($row as $value) {
    if($value == 'null' || $value == null || $value == '' || empty($value)) {
      $row[$keys[$counter]] = '';
    }
    $counter++;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Edit User</title>
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
        <div class="col-md-6">
          <h3>Edit user other details</h3>
        </div>
        <div class="col-md-6">
           <button type="button" class="btn btn-primary pull-right"><a style="color: white" href="<?php echo $serverurl.'user/view.php'; ?>"> Back</a></button>
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

          <form role="form" method="post" action="user_process.php" enctype='multipart/form-data'>
            <input type="hidden" name ="id" value="<?php echo $id;?>">
            <input type="hidden" name="act" value="otherupdateUser" />
            <div class="box-body">

            
              <div class="form-group">
                <label for="exampleInputEmail1">Area</label>
                <input type="text" class="form-control" name="Area" placeholder="Area" value="<?php echo $row['Area']?>">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Colony</label>
                <input type="text" class="form-control" name="Colony" placeholder="Colony" value="<?php echo $row['Colony']?>" >
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Building</label>
                <input type="text" class="form-control" name="Building" placeholder="Building" value="<?php echo $row['Building']?>" >
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Latitude</label>
                <input type="text" class="form-control" name="Latitude" placeholder="Latitude" value="<?php echo $row['Latitude'];?>">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Longitude</label>
                <input type="text" class="form-control" name="Longitude" value="<?php echo $row['Longitude']?>" placeholder="Longitude">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Node</label>
                <input type="text" class="form-control" name="Node" value="<?php echo $row['Node']?>" placeholder="Node" >
              </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Connection Type</label>
              <input type="text" class="form-control" id="Connection_Type" value="<?php echo $row['Connection_Type']?>" name="Connection_Type" placeholder="Connection Type" >
            </div>


            <div class="form-group">
              <label for="exampleInputEmail1">Sub Package</label>
              <input type="text" class="form-control" name="Sub_Package" value="<?php echo $row['Sub_Package']?>" placeholder="Sub Package" >
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Balance Amount</label>
              <input type="text" class="form-control" id="Balance_Amount" name="Balance_Amount" value="<?php echo $row['Balance_Amount']?>" placeholder="Balance Amount" >
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Spl Discount</label>
              <input type="text" class="form-control" id="Spl_Discount" name="Spl_Discount" value="<?php echo $row['Spl_Discount']?>" placeholder="Spl Discount" >
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Add Charges</label>
              <input type="text" class="form-control" id="Add_Charges" name="Add_Charges" value="<?php echo $row['Add_Charges']?>" placeholder="Add Charges" >
            </div>

            <div class="form-group">
              <label>Account Type</label>
              <input type="text" class="form-control" name="Account_Type"  value="<?php echo $row['Account_Type']?>" placeholder="Account Type">
            </div>

            <div class="form-group">
              <label>Franchise Name</label>
              <input type="text" class="form-control" name="Franchise_Name" value="<?php echo $row['Franchise_Name']?>" placeholder="Franchise Name">
            </div>

            <div class="form-group">
              <label>MAC</label>
              <input type="text" class="form-control" name="MAC" value="<?php echo $row['MAC']?>" placeholder="MAC">
            </div>

            <div class="form-group">
                <label>Billing Address</label>
                <textarea class="form-control" name="Billing_Address" placeholder="Billing Address"><?php echo $row['Billing_Address']?></textarea>
              </div>

            <div class="form-group">
              <label>Ip Address</label>
              <input type="text" class="form-control" name="IpAddress" value="<?php echo $row['IpAddress']?>" placeholder="Ip Address">
            </div>

            <div class="form-group">
              <label>Expiry Date</label>
              <input type="text" class="form-control" name="Expiry_Date" id="datepicker" value="<?php echo $row['Expiry_Date']?>" placeholder="Expire Date">
            </div>

            <div class="form-group">
              <label>Last Renewal</label>
              <input type="text" class="form-control" name="Last_Renewal" id="datepicker2" value="<?php echo $row['Last_Renewal']?>" placeholder="Last Renewal">
            </div>

            <div class="form-group">
              <label>Auto Renew</label>
              <input type="text" class="form-control" name="Auto_Renew" id="Auto_Renew" value="<?php echo $row['Auto_Renew']?>" placeholder="Auto Renew">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Outage</label>
              <input type="text" class="form-control" name="Outage" value="<?php echo $row['Outage']?>" placeholder="Outage">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">FUP Limit</label>
              <input type="text" class="form-control" name="FUP_Limit" value="<?php echo $row['FUP_Limit']?>" placeholder="FUP Limit">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">GST IN</label>
              <input type="text" class="form-control" name="GSTIN" value="<?php echo $row['GSTIN']?>" placeholder="GST IN">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Pop</label>
              <input type="text" class="form-control" name="Pop" value="<?php echo $row['Pop']?>" placeholder="Pop">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Switch</label>
              <input type="text" class="form-control" name="Switch" value="<?php echo $row['Switch']?>" placeholder="Switch">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Door No</label>
              <input type="text" class="form-control" name="Door_No" value="<?php echo $row['Door_No']?>" placeholder="Door No">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">NAS IP</label>
              <input type="text" class="form-control" name="NAS_IP" value="<?php echo $row['NAS_IP']?>" placeholder="NAS IP">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">POP Tech Exe</label>
              <input type="text" class="form-control" name="POP_Tech_Exe" value="<?php echo $row['POP_Tech_Exe']?>" placeholder="POP Tech Exe">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">POP Coll Exe</label>
              <input type="text" class="form-control" name="POP_Coll_Exe" value="<?php echo $row['POP_Coll_Exe']?>" placeholder="POP Coll Exe">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Last Payment Source</label>
              <input type="text" class="form-control" name="Last_Payment_Source" value="<?php echo $row['Last_Payment_Source']?>" placeholder="Last Payment Source">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Nas Port Id</label>
              <input type="text" class="form-control" name="Nas_Port_Id" value="<?php echo $row['Nas_Port_Id']?>" placeholder="Nas Port Id">
            </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <input type="submit" name="submit" value="Submit" class="btn btn-primary">
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

    $('#datepicker').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
    });  
    $('#datepicker2').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
    });
    $('#datepicker3').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
    });

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

  function getPackagePrice(){
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
          /********* EDIT USER IMG (Preview an image before it is uploaded) ************/

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img1').attr('src', e.target.result);
      }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#user_image").change(function() {
  readURL(this);
});

          /************* END  ************/

 /********* EDIT ID PROOF IMG (Preview an image before it is uploaded) ************/

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img2').attr('src', e.target.result);
      }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#user_proof_image").change(function() {
  readURL2(this);
});

                            /************* END  ************/

/********* EDIT USER CAF IMG (Preview an image before it is uploaded) ************/

  function readURL3(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img3').attr('src', e.target.result);
      }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#user_caf_image").change(function() {
  readURL3(this);
});


    function getBranch(){
      let operator = $('#operator_id').val();
      if(package){
        $.ajax({
          type:'POST',
          url :'user_process.php',
          data:'act=getbranches&operator_id='+operator,
          dataType:'HTML',
              success:function(response){
               var data = JSON.parse(response);
                if(data.status){
                  let html = ''; let counter = 0;
                  html += '<option value="">Select Branch</option>';
                  $(data.details).each(function(i,v) {
                    html += '<option value="'+v.branch_name+'">'+v.branch_name+'</option>';
                    counter++;
                  });
                  if (counter > 0) {
                    $('#Branch').html(html);
                  }
                } else {
                  alert('Failed to fetch branch');
                }

              }
          }); 
      }
    }
                            /************* END  ************/

</script>
