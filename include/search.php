<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	$servername = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "nms";
    $conn = new mysqli($servername, $user, $pass, $db_name);

	$data = $_POST['data'];
	$sql = "SELECT DISTINCT * from  `people1` where email='$data' or mobile= '$data' or ccode='$data'";
	$result = $conn->query($sql); 
	
	if ($result->num_rows > 0) {
		$user = array();
		$user_list = array();
		$count = 0;
    	while($row = mysqli_fetch_array($result)) {
			$user['surname'] = $row['surname'];
            $user['restname'] = $row['restname'];
            $user['dept'] = $row['dept'];
            $user['room_no'] = $row['room_no'];
            $user['office'] = $row['office'];
			$user['residence'] = $row['residence'];
			$user['email'] = $row['email'];
			$user['off_1'] = $row['off_1'];
			$user['mobile'] = $row['mobile'];
			$user['ccode'] = $row['ccode'];
			$user['fax'] = $row['fax'];
			$user['off_res_ext'] = $row['off_res_ext'];
			$user['off_2'] = $row['off_2'];
			$user['off_mob'] = $row['off_mob'];
			$user['designation'] = $row['designation'];
			$user['role'] = $row['role'];
			$user['dob'] = $row['dob'];
			$user['expiry'] = $row['expiry'];
			$user['identity'] = $row['identity'];
			$user['sup_email'] = $row['sup_email'];
			$user['homepage'] = $row['homepage'];
			$user['street'] = $row['street'];
			$user['city'] = $row['city'];
			$user['pincode'] = $row['pincode'];
			$user['keyphrase_1'] = $row['keyphrase_1'];
			$user['keyphrase_2'] = $row['keyphrase_2'];
			$user['keyphrase_3'] = $row['keyphrase_3'];
			$user['tiled'] = $row['tiled'];
			$user['photo_disp'] = $row['photo_disp'];
			// echo $row['photo'];
			$url_array = explode("/", $row['photo']);
			// print_r ($url_array);
			$photo_url = "http://localhost/".$url_array[3]."/".$url_array[4]."/".$url_array[5];
			$user['photo'] = $photo_url;
			$user['design_code'] = $row['design_code'];
			$user['metadata'] = $row['metadata'];
			$user['pvt_email'] = $row['pvt_email'];
			$user['mh_id'] = $row['mh_id'];
			$user['role_email'] = $row['role_email'];
			$user['title'] = $row['title'];
			$user['gender'] = $row['gender'];
			$user['extended_expiry'] = $row['extended_expiry'];
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