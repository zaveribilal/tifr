<?php
	ob_start();

	header("Access-Control-Allow-Origin: *");

	include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
	$con = new DB_Connect();
    $db = $con->connect();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE `username` = '$username';";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);  

    if (count($user) > 0) {
        $encrypt_pass = md5($password);
        if($user['password'] == $encrypt_pass){
            echo "Logged in";
            header('Location: ../Admin_search.html');
        }
    }else{
        echo "problem";
    }

?>