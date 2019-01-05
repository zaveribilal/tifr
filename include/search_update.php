<?php
	ob_start();
    header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

    $response;
    $ccode = $_POST['ccode'];
    if ($ccode != ''){
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
            $response['status'] = '500';
            $response['message'] = 'Server Error - '.mysqli_error($db);
            ob_clean();
            echo json_encode($response);
        }else{
            $sql = "SELECT DISTINCT * from  `people1` where ccode='$ccode'";
            $result = mysqli_query($db, $sql);
            if (count($result) > 0) {
                $response['status'] = '200';
                $response['message'] = 'User Found';
                $user = mysqli_fetch_assoc($result);
                $response['data'] = $user;
                ob_clean();
                echo json_encode($response);
            } else {
                $response['status'] = '400';
                $response['message'] = 'User not found - '.mysqli_error($db);
                ob_clean();
                echo json_encode($response);
            }
        }
    }
	$db-> close();
?>