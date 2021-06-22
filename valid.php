<?php
include("conn.php");
session_start();
    if( !isset($_SESSION['user'])){
        // header("location:login.php");
        header("location:".$serverurl.'login.php');
        exit();
    }
?>