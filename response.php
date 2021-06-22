<?php
include("conn.php");

$opt = $_POST['opt'];
$val = $_POST['val'];

if( isset($opt) && $opt == 'email'){


	$email = $val;
	$sql = "select * from users where email = '".$email."'";
	$rs = mysqli_query($conn,$sql);

	$rno = mysqli_num_rows($rs);

	if( $rno > 0 )
	{
		 $data = [ 'type' => 'fail' , "chk" => 'email', "msg" => "Email already exists" ];  
          echo json_encode($data);exit; 
	}
	else
		{

			 if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
				$data = [ 'type' => 'success' , "chk" => 'email', "msg" => "Email is available" ];  
          		echo json_encode($data);exit; 
          }
          else{
          		$data = [ 'type' => 'fail' , "chk" => 'email', "msg" => "Invalid email address" ];  
          		echo json_encode($data);exit; 
          }
		}
}
else if( isset($opt) && $opt == 'username'){


	$email = $val;
	$sql = "select * from users where username = '".$email."'";
	$rs = mysqli_query($conn,$sql);

	$rno = mysqli_num_rows($rs);

	if( $rno > 0 )
	{
		 $data = [ 'type' => 'fail' , "chk" => 'username', "msg" => "Username already exists" ];  
          echo json_encode($data);exit; 
	}
	else if( $email == ' '){

			$data = [ 'type' => 'fail' , "chk" => 'username', "msg" => "Username cannot be blank" ];  
          		echo json_encode($data);exit; 
	}else
		{

			
				$data = [ 'type' => 'success' , "chk" => 'username', "msg" => "Username is available" ];  
          		echo json_encode($data);exit; 
          
		}
}
else if( isset($opt) && $opt == 'password'){

	
	if( $_POST['oldp'] == '' || $_POST['oldp'] != $val  )
	{
		$data = [ 'type' => 'fail' , "chk" => 'password', "msg" => "Password doesn't match" ];  
          		echo json_encode($data);exit; 
	}
	else{

		$data = [ 'type' => 'success' , "chk" => 'password', "msg" => "Password matched." ];  
          		echo json_encode($data);exit; 

	}
	
}
?>