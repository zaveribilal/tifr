<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	$servername = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "nms";
    $conn = new mysqli($servername, $user, $pass, $db_name);

	$email = $_POST['data'];
	$sql = "SELECT * from  `people1` where email='$data' or mobile= '$data' or ccode='$data'";
	$result = $conn->query($sql); 
	
	if ($result->num_rows > 0) {
		$user = array();
		$user_list = array();
		$count = 0;
    	while($row = mysqli_fetch_array($result)) {
			$user['surname'] = $row['surname'];
            $user['restname'] = $row['restname'];
            $user['surname'] = $row['surname'];
            $user['restname'] = $row['restname'];
            $user['surname'] = $row['surname'];
			$user['restname'] = $row['restname'];
			$user_list[$count] = $user;
			$count++;
        }
        ob_clean();
		echo json_encode($user_list);
    } else {
        ob_clean();
		echo '{"message": "No Result Found"}';
	}
	$conn-> close();
?>