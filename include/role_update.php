<?php
    ob_start();
    header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

    $response;
    $role = $_POST['role'];
    $ccode = $_POST['ccode'];

    if (isset($role) && $role != '' && $ccode != ''){
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
            $response['message'] = 'Server Error - '.mysqli_error($db);
            ob_clean();
            echo json_encode($response);
        }
        else {
            $sql= "UPDATE `people1` set `role` = '$role' WHERE `ccode` ='$ccode'";
            if (mysqli_query($db, $sql)) {
                // Logging User
                $action = "USER UPDATE";
                $status = "Success";
                $log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '200';
                $response['message'] = 'Role Updated';
                ob_clean();
                echo json_encode($response);
            } else {
                // Logging User
                $action = "USER UPDATE";
                $status = "Failed";
                $log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '400';
                $response['message'] = 'Update Failed - '.mysqli_error($db);
                ob_clean();
                echo json_encode($response);
            }
        }
    }else{

    }

?>