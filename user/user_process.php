<?php
include("../valid.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$act=@$_REQUEST['act']; 

switch($act){

	case 'getPrice':
	$package_name  = $_POST['packageName'];
	$resultArray   =	array(); 
	$packagePrice  = "SELECT `package_price`,
						`package_name`,
						`status` 
						FROM `packages` 
						WHERE `package_name`='".$package_name."'
						AND `status`= 1
						";

	$result = mysqli_query($conn,$packagePrice);
	$fetch  = mysqli_fetch_assoc($result);

	if($fetch){
		$resultArray['price']    = $fetch['package_price'];
	}else{
		$resultArray['price']    ='';
	}
	echo json_encode($resultArray);	   
	break;

	case 'getbranchesandpackages' :
		$operator_id  = $_POST['operator_id'];
		$resultArray  =	array(); 
		$packagePrice = "SELECT * FROM `branchs` WHERE `operator_id`='".$operator_id."' AND `status`= 1";

		$result = mysqli_query($conn,$packagePrice);
		$finalArr = array();
		while($fetch  = mysqli_fetch_assoc($result)) {
			$finalArr[] = $fetch;
		}

		$sql_package = "SELECT * FROM `packages` WHERE `status` = 1 AND `op_id`='".$operator_id."'";
	    $package_result = mysqli_query($conn, $sql_package);
	    $package_array = array();
	    while($pk = mysqli_fetch_assoc($package_result)) {
	    	$package_array[] = $pk;
	    }

		if(!empty($finalArr) && !empty($package_array)){
			$resultArray['status']    = true;
			$resultArray['branch']    = $finalArr;
			$resultArray['packages']  = $package_array;
		}else{
			$resultArray['status']    = false;
		}
		echo json_encode($resultArray);	   
		break;

	case 'getCollectionAgents' :
		$operator_id  = $_POST['operator_id'];
		$resultArray  =	array(); 
		$collectionAgents = "SELECT * FROM `collectionagents` WHERE `operator_id`='".$operator_id."' AND `status`= 1";
		$result = mysqli_query($conn,$collectionAgents);
		$finalArr = array();
		while($fetch  = mysqli_fetch_assoc($result)) {
			$finalArr[] = $fetch;
		}

		if(!empty($finalArr)){
			$resultArray['status']    = true;
			$resultArray['collectionAgents']    = $finalArr;
		}else{
			$resultArray['status']    = false;
			$resultArray['collectionAgents']    = array();
		}
		echo json_encode($resultArray);	   
		break;

	case 'updateUser' :
	$id = $_REQUEST['id'];
	
	$currentTime = date("Y-m-d");
	if (!empty($_POST['submit'])) {
				
				$status = isset($_REQUEST['Status']) ? 1:NULL;
		        $postData = array_map('trim', $_POST);
				$user_image = $user_proof_image = $user_caf_image = NULL;
				$updateSQL='';

			    $updateSQL .="UPDATE
							    `customers`
							SET
							    
							    `operator_id`  	 = '".$_REQUEST['operator_id']."',
							    `ONU_Serial_No`	 = '".$_REQUEST['ONU_Serial_No']."',
							    `CAF_No` 	   	 = '".$_REQUEST['CAF_No']."',
							    `Status` 	   	 = '".$status."',
							    `Username`       = '".$_REQUEST['Username']."',
							    `password` 		 = '".$_REQUEST['password']."',
							    `Name` 			 = '".$_REQUEST['Name']."',
							    `Aadhar_No`      = '".$_REQUEST['Aadhar_No']."',
							    `FatherCompany_Name` = '".$_REQUEST['FatherCompany_Name']."',
							    `Package_Name`  = '".$_REQUEST['Package_Name']."',
							    `Mobile` 		= '".$_REQUEST['Mobile']."',
							    `Alt_Mobile`    = '".$_REQUEST['Alt_Mobile']."',
							    `Branch` 		= '".$_REQUEST['Branch']."',
							    `Installation_Address` = '".$_REQUEST['Installation_Address']."',
							    `Email` 		= '".$_REQUEST['Email']."',
							    `Date_Added`    = '".$_REQUEST['Date_Added']."',
							    `Package_Price`  =  '".$_REQUEST['Package_Price']."'";

			if(!empty($_FILES['user_image']['name'])) {

				$target_path = $_SERVER['DOCUMENT_ROOT'].'/bb/user_images/';  
				if (!file_exists($target_path)) {
					mkdir($target_path, 0777, true);
				}

				$filename   = $postData['Username']."_."."usrIMG".rand(1111,99999);
				$extension  = pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION);
				$basename   = $filename . '.' . $extension;
				$user_image = $basename;

				$source       = $_FILES["user_image"]["tmp_name"];
				$destination = $target_path.$basename;
				$res = move_uploaded_file( $source, $destination);

				if(!empty($updateSQL)) { 
					$updateSQL .= ',';
				}
				$updateSQL .= "`user_image`     = '".$user_image."'";
			}

			if(!empty($_FILES['user_proof_image']['name'])) {

				$target_path = $_SERVER['DOCUMENT_ROOT'].'/bb/user_proof_images/';  
				if (!file_exists($target_path)) {
					mkdir($target_path, 0777, true);
				}

				$filename   = $postData['Username']."_"."proof_img".rand(1111,99999);
				$extension  = pathinfo($_FILES["user_proof_image"]["name"], PATHINFO_EXTENSION);
				$basename   = $filename . '.' . $extension;
				$user_proof_image = $basename;

				$source       = $_FILES["user_proof_image"]["tmp_name"];
				$destination = $target_path.$basename;

				$res = move_uploaded_file( $source, $destination);
				if(!empty($updateSQL)) { 
					$updateSQL .= ',';
				}
				$updateSQL .= "`user_id_proof`     = '".$user_proof_image."'";
			}
			

			if(!empty($_FILES['user_caf_image']['name'])) {

				$target_path = $_SERVER['DOCUMENT_ROOT'].'/bb/user_caf_images/';  
				if (!file_exists($target_path)) {
					mkdir($target_path, 0777, true);
				}

				$filename   = $postData['Username']."_"."caf_img".rand(1111,99999);
				$extension  = pathinfo($_FILES["user_caf_image"]["name"], PATHINFO_EXTENSION);
				$basename   = $filename . '.' . $extension;
				$user_caf_image = $basename;
				$source       = $_FILES["user_caf_image"]["tmp_name"];
				$destination  = $target_path.$basename;
				$res = move_uploaded_file( $source, $destination);
				if(!empty($updateSQL)) { 
					$updateSQL .= ',';
				}
				$updateSQL .= "`user_caf_image`  = '".$user_caf_image."'";
			}

			$updateSQL = rtrim($updateSQL,',');
			$updateSQL .= " WHERE `Id` = '".$id."'";
		
			if (mysqli_query($conn, $updateSQL)) {
				echo "<script>alert('User update successfully');
						window.location.href = '../user/view.php'
				</script>";
				
			} else {
				echo "<script>alert('Failed to update user');</script>";
			}
	}


	case 'otherupdateUser' :
		$id = $_REQUEST['id'];
		
		$currentTime = date("Y-m-d");
		if (!empty($_POST['submit'])) {
					
					$status = isset($_REQUEST['Status']) ? 1:NULL;
					$updateSQL='';
				    $updateSQL .="UPDATE
								    `customers`
								SET
								    `Outage` 	     = '".$_REQUEST['Outage']."',
								    `Account_Type`   = '".$_REQUEST['Account_Type']."',
								    `Franchise_Name` = '".$_REQUEST['Franchise_Name']."',
								    `MAC` 			 = '".$_REQUEST['MAC']."',
								    `Sub_Package`   = '".$_REQUEST['Sub_Package']."',
								    `IpAddress`     = '".$_REQUEST['IpAddress']."',
								    `Expiry_Date`   = '".$_REQUEST['Expiry_Date']."',
								    `Last_Renewal`  = '".$_REQUEST['Last_Renewal']."',
								    `FUP_Limit`     = '".$_REQUEST['FUP_Limit']."',
								    `Area` 			= '".$_REQUEST['Area']."',
								    `Colony` 		= '".$_REQUEST['Colony']."',
								    `Building`      = '".$_REQUEST['Building']."',
								    `Node` 			= '".$_REQUEST['Node']."',
								    `Pop` 			= '".$_REQUEST['Pop']."',
								    `Switch` 		= '".$_REQUEST['Switch']."',
								    `Door_No`       = '".$_REQUEST['Door_No']."',
								    `Billing_Address` ='".$_REQUEST['Billing_Address']."',
								    `GSTIN` 		= '".$_REQUEST['GSTIN']."',
								    `NAS_IP` 		= '".$_REQUEST['NAS_IP']."',
								    `POP_Tech_Exe`  = '".$_REQUEST['POP_Tech_Exe']."',
								    `POP_Coll_Exe`  = '".$_REQUEST['POP_Coll_Exe']."',
								    `Last_Payment_Source` = '".$_REQUEST['Last_Payment_Source']."',
								    `Balance_Amount` = '".$_REQUEST['Balance_Amount']."',
								    `Last_Logoff`    = '".$currentTime."',
								    `Nas_Port_Id`    = '".$_REQUEST['Nas_Port_Id']."',
								    `Spl_Discount`   = '".$_REQUEST['Spl_Discount']."',
								    `Add_Charges`    = '".$_REQUEST['Add_Charges']."',
								    `Latitude`       = '".$_REQUEST['Latitude']."',
								    `Longitude`      = '".$_REQUEST['Longitude']."',
								    `Auto_Renew`     = '".$_REQUEST['Auto_Renew']."',
								    `Connection_Type`= '".$_REQUEST['Connection_Type']."'"; 

				$updateSQL = rtrim($updateSQL,',');
				$updateSQL .= " WHERE `Id` = '".$id."'";

				if (mysqli_query($conn, $updateSQL)) {
					echo "<script>alert('User update successfully');
							window.location.href = '../user/view.php'
					</script>";
					
				} else {
					echo "<script>alert('Failed to update user');</script>";
				}
		}

	case 'saveComment' :
		if (!empty($_POST)) {
			$postData = $_POST;
			$finalArr = array();
			if (!empty($postData)) {
				$finalArr['operator_id'] = !empty($postData['operator_id'])?trim($postData['operator_id']):'';
				$finalArr['collectionagent_id'] = !empty($postData['collectionagent_id'])?trim($postData['collectionagent_id']):'';
				$finalArr['user_id'] = !empty($postData['user_id'])?trim($postData['user_id']):'';
				$finalArr['comment'] = !empty($postData['comment'])?trim($postData['comment']):'';
			}

			if (!empty($finalArr)) {
				$sql = "INSERT INTO `comments`(`operator_id`, `collectionagent_id`, `user_id`, `comment`, `status`, `comment_date`) VALUES ('".$finalArr['operator_id']."','".$finalArr['collectionagent_id']."','".$finalArr['user_id']."','".$finalArr['comment']."','1','".date('Y-m-d H:i:s')."')";

				  if (mysqli_query($conn, $sql)) {
				    echo json_encode(array('status'=>true, 'message'=>'Comment added successfully')); die;
				  } else {
				    echo json_encode(array('status'=>false, 'message'=>'Failed to add comment')); die;
				  }
			} else {
				echo json_encode(array('status'=>false, 'message'=>'invalid data')); die;
			}
		} else {
			echo json_encode(array('status'=>false, 'message'=>'invalid data')); die;
		}


	case 'viewComments' :
		$user_id = $_REQUEST['user_id'];
		if (!empty($user_id)) {
			$sql = "SELECT c.`comment`, cg.`employee_name`, op.`operator_name`, DATE_FORMAT(c.`comment_date`, '%d/%m/%Y %H:%i') AS comment_date FROM `comments` AS c LEFT JOIN `collectionagents` AS cg ON cg.`ca_id` = c.`collectionagent_id` LEFT JOIN `operators` AS op ON op.`operator_id` = c.`operator_id` WHERE c.`status` = 1 AND c.`user_id` = '".$user_id."'";
			$result = mysqli_query($conn,$sql);
			$finalArr = array();
			while($fetch  = mysqli_fetch_assoc($result)) {
				$finalArr[] = $fetch;
			}

			if (!empty($finalArr)) {
				echo json_encode(array('status'=>true, 'details'=>$finalArr)); die;
			} else {
				echo json_encode(array('status'=>false, 'nodata'=>true, 'message'=>'No Comments Available')); die;
			}
		} else {
			echo json_encode(array('status'=>false, 'message'=>'invalid data')); die;
		}

	case 'checkMobile' :
		$mobile = $_REQUEST['mobile'];
		if (!empty($mobile)) {
			$mobile = trim($mobile);
			$sql = "SELECT Mobile FROM `customers` WHERE `Mobile` LIKE '".$mobile."%'";	
			$res = mysqli_query($conn,$sql);
			if (mysqli_num_rows($res)>0) {
				echo json_encode(array('status'=>true, 'message' => 'Mobile No. already exist')); die;
			} else {
				echo json_encode(array('status'=>false,  'message' => 'Mobile No. Available')); die;
			}
		}

	case 'checkONUSerialNo' :
		$ONU_Serial_No = $_REQUEST['ONU_Serial_No'];
		if (!empty($ONU_Serial_No)) {
			$ONU_Serial_No = trim($ONU_Serial_No);
			$sql = "SELECT ONU_Serial_No FROM `customers` WHERE `ONU_Serial_No` LIKE '".$ONU_Serial_No."%'";
			$res = mysqli_query($conn,$sql);
			if (mysqli_num_rows($res)>0) {
				echo json_encode(array('status'=>true, 'message' => 'ONU Serial No. already exist')); die;
			} else {
				echo json_encode(array('status'=>false)); die;
			}
		}

}

?>