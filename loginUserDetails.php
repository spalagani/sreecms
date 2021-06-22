<?php
  include("valid.php");
   
$sql5 = "select * from loginusers where lu_id='".$_SESSION['lu_id']."'";
  $rs5 = mysqli_query($conn,$sql5);
  $rno5 = mysqli_num_rows($rs5);
  $row5 = $rs5->fetch_array(MYSQLI_ASSOC);
  


?>