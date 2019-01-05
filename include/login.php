<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($username) && isset($password) && $username != "" && $password != ""){
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
            $response['message'] = 'Server Error - '.mysqli_error($db);
        } else {
            $query = "SELECT * FROM `users` WHERE `username` = '$username';";
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);  
        
            $response;
        
            if (count($user) > 0) {
                $encrypt_pass = md5($password);
                if($user['password'] == $encrypt_pass){
                    // Logging User
                    $action = "LOGIN";
                    $status = "Success";
                    $log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
                    $log_res = mysqli_query($db, $log_query);
                    if ($log_res == 0){
                        $response['log_status'] = "Failed";
                    }
                    session_start();
                    setcookie("username", $username, time() + 86400, '/');
                    $response['status'] = '200';
                    $response['message'] = 'Login Success';
                    $response['session_id'] = session_id();
                    ob_clean();
                    echo json_encode($response);
                }else{
                    $response['status'] = '400';
                    $response['message'] = "Password doesn't match";
                    ob_clean();
                    echo json_encode($response);
                }
            }else{
                // Logging User
                $action = "LOGIN";
                $status = "Failed";
                $log_query = "INSERT INTO `logs`(`action`,  `status`) VALUES ('$action','$status')";
                $log_res = mysqli_query($db, $log_query);
                if ($log_res == 0){
                    $response['log_status'] = "Failed";
                }
                $response['status'] = '404';
                $response['message'] = 'Invalid Credentials';
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
