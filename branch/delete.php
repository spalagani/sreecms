<?php
include("../conn.php");

if(isset($_GET['id']))
{
     $sql = "DELETE FROM branchs WHERE bid=".$_GET['id'];
      $result = mysqli_query($conn, $sql);
}

?>