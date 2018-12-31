<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

	$response;
	$data = $_POST['data'];

	if(isset($data) && $data != ''){
		if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
			$response['message'] = 'Server Error - '.mysqli_error($db);
			ob_clean();
			echo json_encode($response);
        } else {
			$sql = "SELECT DISTINCT * from  `people1` where surname='$data' or restname='$data' or off_mob= '$data' or ccode='$data'";
			$result = mysqli_query($db, $sql); 
			
			if ($result->num_rows > 0) {
				$data = array();
				$user;
				$user_list = array();
				$count = 0;
				while($row = mysqli_fetch_array($result)) {
					$user['name'] = $row['restname']." ".$row['surname'];
					$user['dept'] = $row['dept'];
					$user['email'] = $row['email'];
					$user['ccode'] = $row['ccode'];
					$user['off_mob'] = $row['off_mob'];
					$user['designation'] = $row['designation'];
					$user['role'] = $row['role'];
					$user['photo'] = $row['photo'];
					$user_list[$count] = $user;
					$response['status'] = '200';
					$response['message'] = 'User found';
					$response['data'] = $user_list;
					$count++;
				}
				// Logging User
				$action = "USER QUERY";
				$status = "Success";
				$log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
				$log_res = mysqli_query($db, $log_query);
				if ($log_res == 0){
					$response['log_status'] = "Failed";
				}
				ob_clean();
				echo json_encode($response);
			} else {
				// Logging User
				$action = "USER QUERY";
				$status = "Failed";
				$log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
				$log_res = mysqli_query($db, $log_query);
				if ($log_res == 0){
					$response['log_status'] = "Failed";
				}
				$response['status'] = '400';
				$response['message'] = 'User not found';
				ob_clean();
				echo json_encode($response);
			}
		} 
	}else{
        $response['status'] = '400';
        $response['message'] = "Invalid Input";
        echo json_encode($response);
    }
?>