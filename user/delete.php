<?php
include("../conn.php");

if(isset($_GET['id']))
{
     $sql = "DELETE FROM payments WHERE payment_id=".$_GET['id']."";
      $result = mysqli_query($conn, $sql);
}

?>