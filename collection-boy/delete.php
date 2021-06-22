<?php
include("../conn.php");

if(isset($_GET['id']))
{
     $sql = "DELETE FROM loginusers WHERE lu_id=".$_GET['id'];
      $result = mysqli_query($conn, $sql);
}

?>