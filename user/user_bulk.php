<?php
include("../valid.php");
include("../head.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bulk Upload Users</title>
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
      <h1>
       Bulk Users Upload
     </h1>
   </section>

   <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="alert alert-danger alert-dismissible errordiv hide">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p class="errorText"></p>
          </div>

          <div class="alert alert-success hide successdiv">
            <p class="successText"></p>
          </div>
          <form role="form" method="post" enctype='multipart/form-data' id="excelupload">
            <div class="box-body">
              <div class="form-group">
               <a download href="<?php echo $serverurl.'user/users.csv'; ?>"> Download Sample Data File</a>
              </div>

             <div class="form-group">
              <label for="excel">Upload Data</label>
              <input type="file" name="files" id="excel_file" required accept=".csv,.excel">
             </div>

           </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" id="excelimport_btn">Submit</button>
            </div>
        </form>
      </div>

    </div>
  </div>
</div>


<?php include("../footer.php") ?>
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
<script type="text/javascript">
  $(document).ready(function(e) {
      $('#excelimport_btn').click(function(e) {
          $('.errordiv,.successdiv').hide();
          var file_data = $('#excel_file').prop('files')[0];   
          var form_data = new FormData();                  
          form_data.append('file', file_data);

          $.ajax({
            url: "<?php echo $serverurl.'user/excel_import_ajax.php'; ?>", // point to server-side PHP script 
            dataType: 'json',  // what to expect back from the PHP script, if anything
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(response){
              console.log(response.status);
               if (response.status) {
                  console.log(response.message);
                  $('.successText').text(response.message);
                  $('.successdiv').removeClass('hide').css('display','block');
                  setTimeout(function(){ $('.successdiv').hide(); }, 4000);
               } else {
                  console.log(response.message);
                  $('.errorText').text(response.message);
                  $('.errordiv').removeClass('hide').css('display','block');
               }
               $('#excelupload').trigger("reset");
            }
         });
          e.preventDefault();
      });
  });
</script>
