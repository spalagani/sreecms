<?php
include("../valid.php");


 if(isset($_FILES)){

    $errorCounter = array();
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
        $heading = fgetcsv($file);
        if (empty($heading)) {
          echo json_encode(array('status'=>false,'message'=>'Invalid excel format')); die;
          return;
        }

          $sql = "insert into `customers` ";
          $arr = array();
          $i=0;
          $headingList = '';
          $valueList = '';
          $duplicateValueArr = array();
          $inArrCheck = array(1,2,11,16);
          //$inArrCheck = array(1,2,11,15,16);
          
          while (! feof($file)) {
            $arr = fgetcsv($file);
  
              if (!empty($arr[0])) {
                  for ($j=0; $j < count($heading); $j++) {
                    if ($j==0) {
                      $arr[$j] = !empty($arr[$j])?trim($arr[$j]):'';
                      $valueList .= '("'.$arr[$j].'",';
                    }
                    elseif ($j< (count($heading)-1)) {
                        $arr[$j] = !empty($arr[$j])?trim($arr[$j]):'';
                        if (!empty($arr[$j]) && in_array($j, $inArrCheck)) {
                          $errorCounter[] = checkDuplicate($j, $arr[$j]);
                          $duplicateValueArr[] = $arr[$j];
                        }
                        $valueList .= '"'.$arr[$j].'",';
                    } else {
                        $arr[$j] = !empty($arr[$j])?trim($arr[$j]):'';
                        $valueList .= '"'.$arr[$j].'"),';
                    }
                  }
              }
            $i++;
          }

          $dup = returndup($duplicateValueArr);
          if (!empty($dup)) {
            $filter = array_filter($dup);
            if (!empty($filter)) {
                $errors = implode(', ', $filter);
                echo json_encode(array('status'=>false, 'message'=>"These data may be duplicate or in wrong format :- ".$errors)); die;
            }
          }
          
          if (!empty($errorCounter)) {
            $filter = array_filter($errorCounter);
            if (!empty($filter)) {
                $errors = implode(', ', $filter);
                echo json_encode(array('status'=>false, 'message'=>"These data may be duplicate or in wrong format :- ".$errors)); die;
            }
          }

          for ($j=0; $j < count($heading); $j++) {
            if ($j< (count($heading)-1)) {
                $headingList .= "`".$heading[$j]."`,";
            } else {
                $headingList .= "`".$heading[$j]."`";
            }
          }
          fclose($file); 
          $valueList = rtrim($valueList, ',');
          $sql .= "(".$headingList.") values ".$valueList;

          if (mysqli_query($conn, $sql)) {
            echo json_encode(array('status'=>true,'message'=>'Data imported successfully')); die;
          } else {
            echo json_encode(array('status'=>false,'message'=>'Failed to insert. Try again later.')); die;
          }

     }
  } else {
    echo json_encode(array('status'=>false,'message'=>'No file selected')); die;
  }

  function checkDuplicate($counter, $value) {

    $present = ''; 
    switch ($counter) {
       case 1:
                if (!empty($value)) {
                  $sql = "select `ONU_Serial_No` from customers where `ONU_Serial_No` = '".$value."'";
                  $result = mysqli_query($GLOBALS['conn'],$sql);
                  if (mysqli_num_rows($result)>0) {
                    $present = $value;
                  }
                } else {
                  // $present = $value;
                }
                break;
       case 2:
                if (!empty($value)) {
                  $sql = "select `CAF_No` from customers where `CAF_No` = '".$value."'";
                  $result = mysqli_query($GLOBALS['conn'],$sql);
                  if (mysqli_num_rows($result)>0) {
                    $present = $value;
                  }
                } else {
                  // $present = $value;
                }
                break;
      case 11:
                if (is_numeric($value) && strlen($value)==12) {
                  $sql = "select `Aadhar_No` from customers where `Aadhar_No` = '".$value."'";
                  $result = mysqli_query($GLOBALS['conn'],$sql);
                  if (mysqli_num_rows($result)>0) {
                    $present = $value;
                  }
                } else {
                  $present = $value;
                }
                break;
     /* case 15:
                if (is_numeric($value) && strlen($value)==10) { 
                  $sql = "select `Mobile` from customers where `Mobile` = '".$value."'";
                  $result = mysqli_query($GLOBALS['conn'],$sql);
                  if (mysqli_num_rows($result)>0) {
                    $present = $value;
                  }
                } else {
                  $present = $value;
                }
                break;
                */
      case 16:
                if (is_numeric($value) && strlen($value)==10) { 
                    $sql = "select `Alt_Mobile` from customers where `Alt_Mobile` = '".$value."'";
                    $result = mysqli_query($GLOBALS['conn'],$sql);
                    if (mysqli_num_rows($result)>0) {
                      $present = $value;
                    }
                } else {
                  $present = $value;
                }
                break;
      default:
        break;
    }
    return $present;
  }



function returndup($array) 
{

    $results = array();
    $duplicates = array();
    foreach ($array as  $item) {
        if (!empty($item) && in_array($item, $results)) {
            $duplicates[] = $item;
        }

        $results[] = $item;
    }

    return $duplicates;
}

 ?>