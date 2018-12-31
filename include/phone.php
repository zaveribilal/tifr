<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

    $response;
    $phone = $_POST['phone'];

    if (isset($phone) && $phone != ""){
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
            $response['message'] = 'Server Error - '.mysqli_error($db);
        } else {
            $query = "SELECT * FROM `people1` WHERE `off_mob` = '$phone';";
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);

            if (count($user) > 0) {
                // Logging User
                $action = "PHONE QUERY";
                $status = "Success";
                $log_query = "INSERT INTO `logs`(`action`, `status`) VALUES ('$action', '$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '200';
                $response['message'] = 'CCODE Found';
                $response['session_id'] = $_COOKIE;
                $response['data'] = $user;
                ob_clean();
                echo json_encode($response);
            }else{
                // Logging User
                $action = "PHONE QUERY";
                $status = "Failed";
                $log_query = "INSERT INTO `logs`(`action`, `status`) VALUES ('$action', '$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '404';
                $response['message'] = 'CCODE not assigned';
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