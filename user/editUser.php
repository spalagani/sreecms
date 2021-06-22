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
} else {
  header('Location:'.$serverurl.'user/view.php');
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
      <h1>
       Edit User
       
     </h1>

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
            <input type="hidden" name="act" value="updateUser" />
            <div class="box-body">
              <div class="form-group">
                <label>Opeartor</label>
                <select class="form-control" name="operator_id" required onchange="getBranchPackages()">

                  <?php 
                  $sql_operator = "SELECT * FROM `operators` WHERE `status` = 1";
                  $operator_result = mysqli_query($conn, $sql_operator);
                  echo '<option value="">Select Opeartor</option> ';
                  while ($result = mysqli_fetch_assoc($operator_result)) {
                    echo ' <option ' . ($result['operator_id'] == $row['operator_id'] ? "selected" : "") . ' value=' . $result['operator_id'] . '>' . $result['operator_name'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label>Branch Name</label>
                <select class="form-control" name="Branch">
                  <?php 
                  $sql_branch = "SELECT * FROM `branchs` WHERE `status` = 1 and `operator_id`= '".$row['operator_id']."'";
                  $branch_result = mysqli_query($conn, $sql_branch);
                  // echo '<option value="">Select Branch</option> ';
                  while ($result = mysqli_fetch_assoc($branch_result)) {
                    echo ' <option ' . ($result['branch_name'] == $row['Branch'] ? "selected" : "") . ' value=' . $result['branch_name'] . '>' . $result['branch_name'] . '</option>';
                  }

                  ?>
                </select>
              </div>

              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" name="Name" placeholder="Full Name" value ="<?php echo $row['Name']?>" required>
              </div>

              <div class="form-group">
                <label>CAF No</label>
                <input type="text" class="form-control" name="CAF_No" placeholder="CAF No" value ="<?php echo $row['CAF_No']?>" required>
              </div> 

              <div class="form-group">
                <label>Date Added</label>
                <input type="text" class="form-control" name="Date_Added" placeholder="Date Added" value ="<?php echo date('Y-m-d', strtotime($row['Date_Added'])); ?>" id="datepicker3" required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="Email" value ="<?php echo $row['Email']?>" placeholder="Email">
              </div>
              <div class="form-group">
                <label>Father Name</label>
                <input type="text" class="form-control" name="FatherCompany_Name" value ="<?php echo $row['FatherCompany_Name']?>" placeholder="FatherCompany Name">
              </div>

              <div class="form-group">
                <label>Installation Address</label>
                <textarea class="form-control" name="Installation_Address" placeholder="Installation Address" required><?php echo $row['Installation_Address']?></textarea>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Aaadhar No</label>
                <input type="text" class="form-control" name="Aadhar_No" value="<?php echo $row['Aadhar_No']?>" placeholder="Aadhar No" required>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Mobile No</label>
                <input type="text" class="form-control" id="mobile" name="Mobile" value="<?php echo $row['Mobile']?>" placeholder="Mobile No" required>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Alt Mobile No</label>
                <input type="text" class="form-control" name="Alt_Mobile" value="<?php echo $row['Alt_Mobile']?>" placeholder="Alt Mobile No">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Package</label>
                <select class="form-control" name="Package_Name" id="package" onchange="getPackagePrice();">

                 <?php 
                 $sql_package = "SELECT * FROM `packages` WHERE `status` = 1 AND `op_id`='".$row['operator_id']."'";
                 $package_result = mysqli_query($conn, $sql_package);
                 echo '<option value="">Select Package</option> ';
                 while ($resPack = mysqli_fetch_assoc($package_result)) {
                  echo ' <option ' . ($resPack['package_name'] == $row['Package_Name'] ? "selected" : "") . ' value=' . $resPack['package_name'] . '>' . $resPack['package_name'] . '</option>';
                }

                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Package Price</label>
              <input type="text" class="form-control" id="Package_Price" value="<?php echo $row['Package_Price']?>" name="Package_Price" placeholder="Package Price" required readonly="readonly">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="username" name="Username" value="<?php echo $row['Username']?>" placeholder="Operator Username" required>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="password" class="form-control"  name="password" value="<?php echo $row['password']?>" placeholder="Operator Password">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">ONU Serial No</label>
              <input type="text" class="form-control" name="ONU_Serial_No" value="<?php echo $row['ONU_Serial_No']?>" placeholder="Onusrino" required>
            </div>

            <div class="form-group">
              <label for="">User Photo</label>
              <input type="file" name="user_image" id="user_image">

              <p class="help-block">&nbsp;</p>
              <span><img src="<?php echo $serverurl.'user_images/'.$row['user_image']?>" width="68px" height="50px" id= "img1"></span>
            </div>

            <div class="form-group">
              <label for="">User ID Proof</label>
              <input type="file" name="user_proof_image" id="user_proof_image">
              <p class="help-block">&nbsp;</p>
              <span><img src="<?php echo $serverurl.'user_proof_images/'.$row['user_id_proof']?>" width="68px" height="50px" id= "img2"></span>
            </div>

            <div class="form-group">
              <label for="">User caf image</label>
              <input type="file" name="user_caf_image" id="user_caf_image">
              <p class="help-block">&nbsp;</p>
              <span><img src="<?php echo $serverurl.'user_caf_images/'.$row['user_caf_image']?>" width="68px" height="50px" id="img3"></span>
              </div>

              <div class="form-group">
                <label for="">Status</label>
                &nbsp;<input type="checkbox" class="flat-red" name="Status" <?php if (!empty($row['Status'])) { echo "checked";} ?> value="<?php echo $row['Status']?>">
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


  function getBranchPackages(){
    let operator = $('#operator_id').val();
    if(package){
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
                            /************* END  ************/

</script>
