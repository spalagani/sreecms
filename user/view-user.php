<?php
  include("../valid.php");
  include("../head.php");
  $id  = $_GET['id']; 
  $sql = "SELECT * FROM `customers` where id = '".$id."' order by id desc";
  $res = mysqli_query($conn,$sql);
  $finalArr = array();
  while ($row = mysqli_fetch_assoc($res)) { 
    $finalArr = $row;
  }

  if (!empty($finalArr)) {
    $keys = array_keys($finalArr);
    $counter=0;
    foreach ($finalArr as $value) {
      if($value == 'null' || $value == null || $value == '') {
        $finalArr[$keys[$counter]] = '';
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
        <div class="col-md-6">
          <h3><?php echo !empty($finalArr['Name'])?ucwords($finalArr['Name']):'';?> User Profile</h3>
        </div>
        <div class="col-md-6">
           <button type="button" class="btn btn-primary pull-right"><a style="color: white" href="<?php echo $serverurl.'user/view.php'; ?>"> Back</a></button>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <?php 
              $profile_img = $serverurl.'dist/img/avatar5.png';
              if (!empty($finalArr['user_image'])) {
               $profile_img = $serverurl.'user_images/'.$finalArr['user_image'];
             }
             ?>
             <img class="profile-user-img img-responsive img-rounded" style="max-width: 100px; max-height: 100px;" src="<?php echo $profile_img; ?>" alt="User profile picture">

             <h3 class="profile-username text-center"><?php echo !empty($finalArr['Name'])?$finalArr['Name']:''; ?></h3>
             <ul class="list-group list-group-unbordered">

              <li class="list-group-item" style="padding-bottom: 30px;">
                <b>Address</b> <a class="pull-right"><?php echo !empty($finalArr['Installation_Address'])?$finalArr['Installation_Address']:''; ?></a>
              </li>
              <li class="list-group-item">
                <b>Phone</b> <a class="pull-right"><?php echo !empty($finalArr['Mobile'])?$finalArr['Mobile']:''; ?></a>
              </li>

              <li class="list-group-item">
                <b>Branch </b> &nbsp;&nbsp;<a style="float: right;"><?php echo !empty($finalArr['Branch'])?$finalArr['Branch']:''; ?></a>
              </li>
              <li class="list-group-item">
                <a href="<?php echo $serverurl.'user/user-payment-history.php?id='.$finalArr['Id']; ?>" class="btn btn-primary btn-block">Payment History</a>
              </li>
            </ul> 
          </div>
        </div>

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab">Details</a></li>
            <li class=""><a href="#extraactivity" data-toggle="tab">Extra Details</a></li>
            <li class=""><a href="#comments" data-toggle="tab">Comments</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
              <div class="post">
                <div class="row">
                  <div class="col-md-4"><b>ONU Serial No :</b> <?php echo !empty($finalArr['ONU_Serial_No'])? $finalArr['ONU_Serial_No'] : ''; ?></div>
                  <div class="col-md-4"><b>CAF No :</b> <?php echo !empty($finalArr['CAF_No'])?$finalArr['CAF_No']:''; ?></div>
                  <div class="col-md-4"><b>Aadhar No :</b> <?php echo !empty($finalArr['Aadhar_No'])?$finalArr['Aadhar_No']:''; ?></div>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-4"><b>Alt Mobile :</b> <?php echo !empty($finalArr['Alt_Mobile'])?$finalArr['Alt_Mobile']:''?></div>
                  <div class="col-md-4"><b>Ip Address :</b> <?php echo !empty($finalArr['IpAddress']) ? $finalArr['IpAddress'] : ''; ?></div>
                  <div class="col-md-4"><b>Installation Address :</b> <?php echo !empty($finalArr['Installation_Address']) ? $finalArr['Installation_Address'] : ''; ?></div>
                  
                </div>
                <br>
                <div class="row">
                  <div class="col-md-4"><b>User image :</b> 
                    <?php if (!empty($finalArr['user_image'])) { ?>
                      <img class="img-responsive img-rounded" src="<?php echo $serverurl.'user_images/'.$finalArr['user_image']?>" width="68px" height="50px" id= "img1" style="max-width: 68px; max-height: 50px;">
                      <br>
                      <a download href="<?php echo $serverurl.'user_images/'.$finalArr['user_image']; ?>" title="">Download</a>
                    <?php } ?>
                    </div>

                  <div class="col-md-4"><b>User id proof :</b> 
                    <?php if ($finalArr['user_id_proof']) { ?>
                       <img class="img-responsive img-rounded" src="<?php echo $serverurl.'user_proof_images/'.$finalArr['user_id_proof']?>" width="68px" height="50px" id= "img2" style="max-width: 68px; max-height: 50px;">
                       <br>
                       <a download href="<?php echo $serverurl.'user_proof_images/'.$finalArr['user_id_proof']; ?>" title="">Download</a>
                    <?php } ?>
                   </div>
                  <div class="col-md-4"><b>User caf image :</b> 
                    <?php if (!empty($finalArr['user_caf_image'])) { ?>
                      <img class="img-responsive img-rounded" src="<?php echo $serverurl.'user_caf_images/'.$finalArr['user_caf_image']?>" width="68px" height="50px" id="img3" style="max-width: 68px; max-height: 50px;">
                      <br>
                      <a download href="<?php echo $serverurl.'user_caf_images/'.$finalArr['user_caf_image']; ?>" title="">Download</a>
                    <?php } ?>
                  </div>
                </div>


              </div>
            </div>

            <div class="tab-pane" id="extraactivity">
              <div class="row">
                  <div class="col-md-4"><b>Outage :</b> <?php echo !empty($finalArr['Outage'])?$finalArr['Outage']:''; ?></div>
                  <div class="col-md-4"><b>Account Type :</b> <?php echo !empty($finalArr['Account_Type'])?$finalArr['Account_Type']:''; ?></div>
                  <div class="col-md-4"><b>Franchise Name :</b> <?php echo !empty($finalArr['Franchise_Name'])?$finalArr['Franchise_Name']:''; ?></div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4"><b>MAC :</b> <?php echo !empty($finalArr['MAC'])?$finalArr['MAC']:''; ?></div>
                <div class="col-md-4"><b>Father Name :</b> <?php echo !empty($finalArr['FatherCompany_Name'])?$finalArr['FatherCompany_Name']:''; ?></div>
                <div class="col-md-4"><b>Last Renewal :</b> <?php echo !empty($finalArr['Last_Renewal'])?$finalArr['Last_Renewal']:''; ?></div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4"><b>Add Charges:</b> <?php echo !empty($finalArr['Add_Charges'])?$finalArr['Add_Charges']:''; ?></div>
                <div class="col-md-4"><b>Latitude :</b> <?php echo !empty($finalArr['Latitude'])?$finalArr['Latitude']:''; ?></div>
                <div class="col-md-4"><b>Longitude :</b> <?php echo !empty($finalArr['Longitude'])?$finalArr['Longitude']:''; ?></div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4"><b>Sub Package :</b> <?php echo !empty($finalArr['Sub_Package'])?$finalArr['Sub_Package']:''; ?></div>
                <div class="col-md-4"><b>Expiry Date :</b> <?php echo !empty($finalArr['Expiry_Date'])?$finalArr['Expiry_Date']:''; ?></div>
                <div class="col-md-4"><b>Spl Discount :</b> <?php echo !empty($finalArr['Spl_Discount'])?$finalArr['Spl_Discount']:''; ?></div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4"><b>Last Payment Source :</b> <?php echo !empty($finalArr['Last_Payment_Source'])?$finalArr['Last_Payment_Source']:''; ?></div>
                <div class="col-md-4"><b>Auto Renew :</b> <?php echo !empty($finalArr['Auto_Renew'])?$finalArr['Auto_Renew']:''; ?></div>
                <div class="col-md-4"><b>Connection Type:</b> <?php echo !empty($finalArr['Connection_Type'])?$finalArr['Connection_Type']:''; ?></div>
              </div>
              <br>
              <div class="row">
                  
                  <div class="col-md-4"><b>Balance Amount:</b> <?php echo !empty($finalArr['Balance_Amount'])?$finalArr['Balance_Amount']:''; ?></div>
                  <div class="col-md-4"><b>Last Logoff :</b> <?php echo !empty($finalArr['Last_Logoff'])?$finalArr['Last_Logoff']:''; ?></div>
                  <div class="col-md-4"><b>Nas Port Id :</b> <?php echo !empty($finalArr['Nas_Port_Id'])?$finalArr['Nas_Port_Id']:''; ?></div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-4"><b>FUP Limit :</b> <?php echo !empty($finalArr['FUP_Limit'])?$finalArr['FUP_Limit']:''; ?></div>
                  <div class="col-md-4"><b>Area :</b> <?php echo !empty($finalArr['Area'])?$finalArr['Area']:''; ?></div>
                  <div class="col-md-4"><b>Colony :</b> <?php echo !empty($finalArr['Colony'])?$finalArr['Colony']:''; ?></div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-4"><b>Building :</b> <?php echo !empty($finalArr['Building'])?$finalArr['Building']:''; ?></div>
                  <div class="col-md-4"><b>Node :</b> <?php echo !empty($finalArr['Node'])?$finalArr['Node']:""; ?></div>
                  <div class="col-md-4"><b>Pop :</b> <?php echo !empty($finalArr['Pop'])?$finalArr['Pop']:""; ?></div>
                  
              </div>
              <br>
              <div class="row">
                  <div class="col-md-4"><b>NAS IP :</b> <?php echo !empty($finalArr['NAS_IP'])?$finalArr['NAS_IP']:''; ?></div>
                  <div class="col-md-4"><b>POP Tech Exe :</b> <?php echo !empty($finalArr['POP_Tech_Exe'])?$finalArr['POP_Tech_Exe']:''; ?></div>
                  <div class="col-md-4"><b>POP Coll Exe :</b> <?php echo !empty($finalArr['POP_Coll_Exe'])?$finalArr['POP_Coll_Exe']:''; ?></div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4"><b>Date Added :</b> <?php echo !empty($finalArr['Date_Added'])?$finalArr['Date_Added']:''; ?></div>
                <div class="col-md-4"><b>Switch :</b> <?php echo !empty($finalArr['Switch'])?$finalArr['Switch']:''; ?></div>
                <div class="col-md-4"><b>GSTIN :</b> <?php echo !empty($finalArr['GSTIN'])?$finalArr['GSTIN']:''; ?></div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-4"><b>Door No :</b> <?php echo !empty($finalArr['Door_No'])?$finalArr['Door_No']:''; ?></div>
                <div class="col-md-4"><b>Billing Address :</b> <?php echo !empty($finalArr['Billing_Address'])?$finalArr['Billing_Address']:''; ?></div>
                
              </div>
              <br>
            </div>

            <div class="tab-pane" id="comments">
              <div class="row">
                <form role="form" id="commentForm" method="post" action="">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Operator</label>
                      <select class="form-control" name="operator_id" id="operator_id" required onchange="getCollectionAgents()">
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
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Collection Agents</label>
                      <select class="form-control" name="collectionagent_id" id="collectionagent_id" required>
                        <option value="">Select Agent</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Comment</label>
                      <input type="text" name="comment" id="comment" class="form-control" required autocomplete="off">
                      <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo !empty($_GET['id'])?trim($_GET['id']):''; ?>" required autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-block addComment">Add Comment</button>
                  </div>
                  <div class="col-md-2"></div>
                </form>
              </div>

              <hr>
              <div class="row" style="margin-top: 10px">
                <div class="commentContainer col-md-12" style="height: 500px; overflow: scroll;">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
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
<script>
  var user_id = "<?php echo isset($_GET['id'])?$_GET['id']:''; ?>";
$(function () {

    $('#datepicker').datepicker({
      autoclose: true
    });
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


  function getCollectionAgents(){
    let operator = $('#operator_id').val();
    if(operator){
      $.ajax({
        type:'POST',
        url :'user_process.php',
        data:'act=getCollectionAgents&operator_id='+operator,
        dataType:'HTML',
            success:function(response){
             var data = JSON.parse(response);
              if(data.status){
                let htmlpackage = ''; let counter = 0;
                htmlpackage += '<option value="">Select Agent</option>';
                $(data.collectionAgents).each(function(i,v) {
                  htmlpackage += '<option value="'+v.ca_id+'">'+v.employee_name+'</option>';
                  counter++;
                });

                if (counter > 0) {
                  $('#collectionagent_id').html(htmlpackage);
                }
              } else {
                alert('Failed to fetch branch and packages');
              }

            }
        }); 
    }
  }

  $('.addComment').click(function(e) {

     if($("#operator_id").val() == '') {
      alert('Please select operator');
      e.preventDefault();
     }
     else if($("#collectionagent_id").val() == '') {
      alert('Please select agent');
      e.preventDefault();
     }
     else if($("#comment").val() == '') {
      alert('Comment is required');
      e.preventDefault();
     } else {
         let formData = $('#commentForm').serializeArray();
         formData.push({ name : 'act', value : 'saveComment'});
          $.ajax({
            type:'POST',
            url :'user_process.php',
            data:formData,
            dataType:'json',
                success:function(response){
                 if (response) {
                  if (response.status) {
                      $('#commentForm').trigger("reset");
                      getallComments();
                  }
                  else {
                    alert(response.message);
                  }
                 }
                }
            }); 
         e.preventDefault();
     }
  });

  $().ready(function() {
      getallComments();

      $('#comment').keypress(function (event) {
          if (event.keyCode === 10 || event.keyCode === 13) {
              if ($(this).val()) {
                $('.addComment').trigger('click');
              }
              event.preventDefault();
          }
      });
  });
  function getallComments() {
    if (user_id) {
        $.ajax({
          type:'POST',
          url :'user_process.php',
          data:'act=viewComments&user_id='+user_id,
          dataType:'json',
            success:function(response){
              if (response) {
                if (response.status == true) {
                  let html = ''; let counter=0;
                  $(response.details).each(function(i,v) {
                      html += '<div class="post">';
                        html += '<div class="post clearfix">';
                          html += '<div class="">';
                            html += '<span class="username">';
                              html += '<a href="javascript::void(0)"><p><span style="font-size:18px">'+v.employee_name+'</span> ('+v.operator_name+')</p>';
                              html += '<small class="text-muted pull-right"><i class="fa fa-clock-o"></i>'+v.comment_date+'</small>';
                              html += '</a>';
                            html += '</span>';
                          html += '</div>';
                          html += '<p>'+v.comment+'</p>';
                        html += '</div>';
                      html += '</div>';
                      counter++;
                  });

                  if(counter>0) {
                    $('.commentContainer').html(html);
                  }
                }

                if (response.nodata) {
                  $('.commentContainer').html(response.message);
                }
              }
            }
        });
    }
  }
</script>
