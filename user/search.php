<?php 
    include("../conn.php");

$searchTerm = $_GET['term'];
$searchCategory = $_GET['category'];

if (!empty($searchTerm) && !empty($searchCategory)) {
	$sql = "SELECT id,  `".$searchCategory."` FROM customers WHERE `".$searchCategory."` LIKE '%".$searchTerm."%'";
	$result = mysqli_query($conn, $sql);
	$finalArr = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $data = array();
	        $data['id'] = $row['id'];
	        $data['value'] = $row[$searchCategory];
	        array_push($finalArr, $data);
	    }
	}
	echo json_encode($finalArr); die;
} else {
	echo json_encode(array()); die;
}


?>