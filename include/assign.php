<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();
    $response;
    
    $from = $_POST['from'];
    $to = $_POST['to'];
    $phone = $_POST['phone'];

    if(isset($from) && $to && $phone){
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
            $response['message'] = 'Server Error - '.mysqli_error($db);
        } else {
            $delete_query = "UPDATE `people1` set `off_mob` = '' WHERE `ccode` = '$from'";
            $result = mysqli_query($db, $delete_query);
            // Logging User
            $action = "PHONE DELETE";
            $status = "Success";
            $log_query = "INSERT INTO `logs`(`action`, `status`) VALUES ('$action', '$status')";
            $log_res = mysqli_query($db, $log_query);
            if ($log_res == 0){
                $response['log_status'] = "Failed";
            }

            $response['message'] = "Delete Successful, ";
            $query = "UPDATE `people1` set `off_mob` = '$phone' WHERE `ccode` = '$to'";
            $result1 = mysqli_query($db, $query);
        
            if ($result > 0 && $result1 > 0){
                // Logging User
                $action = "PHONE UPDATE";
                $status = "Success";
                $log_query = "INSERT INTO `logs`(`action`, `status`) VALUES ('$action', '$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '200';
                $response['message'] = 'Phone No Updated';
                ob_clean();
                echo json_encode($response);
            }else{
                // Logging User
                $action = "PHONE UPDATE";
                $status = "Failed";
                $log_query = "INSERT INTO `logs`(`action`, `status`) VALUES ('$action', '$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }

                $response['status'] = '400';
                $response['message'] = 'Something went wrong - '.mysqli_error($db);
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