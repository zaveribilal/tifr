<?php

    header("Access-Control-Allow-Origin: *");

    include($_SERVER['DOCUMENT_ROOT'] . '/tifr/include/DB_Connect.php');
    $con = new DB_Connect();
    $db = $con->connect();

    $response;

    $ftp_server = "127.0.0.1";
    $ftp_user = "user";
    $ftp_pass = "";
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to server $ftp_server");
    $ftp_login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);

    // Create connection
    $db_path = "/tifr/images";
    $file_target = $_SERVER['DOCUMENT_ROOT'].$db_path;

    $surname = $_POST['surname'];
    $restname = $_POST['restname'];
    $dept = $_POST['dept'];
    $room_no = $_POST['room_no'];
    $office = $_POST['office'];
    $residence = $_POST['residence'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $ccode = $_POST['ccode'];
    $fax = $_POST['fax'];
    $off_res_ext = $_POST['off_res_ext'];
    $off_1 = $_POST['off_1'];
    $off_2 = $_POST['off_2'];
    $off_mob = $_POST['off_mob'];
    $designation = $_POST['designation'];
    $role = $_POST['role'];
    $dob = $_POST['dob'];
    $dob = date('Y-m-d', strtotime($dob));
    $expiry = $_POST['expiry'];
    $expiry = date('Y-m-d', strtotime($expiry));
    $identity = $_POST['identity'];
    $project = $_POST['project'];
    $sup_email = $_POST['sup_email'];
    $homepage = $_POST['homepage'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $keyphrase_1 = $_POST['keyphrase_1'];
    $keyphrase_2 = $_POST['keyphrase_2'];
    $keyphrase_3 = $_POST['keyphrase_3'];
    $telid = $_POST['telid'];
    $photo_disp = $_POST['photo_disp'];
    $design_code = $_POST['design_code'];
    $metadata = $_POST['metadata'];
    $pvt_email = $_POST['pvt_email'];
    $mh_id = $_POST['mh_id'];
    $role_email = $_POST['role_email'];
    $title = $_POST['title'];
    $gender = $_POST['gender'];
    $extended_expiry = $_POST['extended_expiry'];
    if (isset($surname) && isset($restname) && isset($dept) && isset($email) && isset($ccode) && isset($designation) && isset($expiry)) {
        if (isset($_FILES['prof_pic'])) {
            $file_name = $_FILES['prof_pic']['name'];
            $file_size = $_FILES['prof_pic']['size'];
            $file_tmp = $_FILES['prof_pic']['tmp_name'];
            $file_type = $_FILES['prof_pic']['type'];

            $temp = explode(".", $file_name);
            $newfilename = $ccode . "_" . round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($file_tmp, $file_target."/".$newfilename);
            $db_store_path = $db_path."/".$newfilename;
        }
        if ($db->connect_error) { 
            die("Connection failed: " . $db->connect_error);
        } 
        else {
            $photo = $db_store_path;
            $sql = "INSERT INTO `people1`(`surname`, `restname`, `dept`, `room_no`, `office`, `residence`, `email`, `off_1`, `mobile`, `ccode`, `fax`, `off_res_ext`, `off_2`, `off_mob`, `designation`, `role`, `dob`, `expiry`, `identity`, `project`, `sup_email`, `homepage`, `street`, `city`, `pincode`, `keyphrase_1`, `keyphrase_2`, `keyphrase_3`, `telid`, `photo_disp`, `photo`, `design_code`, `metadata`, `pvt_email`, `mh_id`, `role_email`, `title`, `gender`, `extended_expiry`) VALUES ('$surname', '$restname', '$dept', '$room_no', '$office', '$residence', '$email', '$off_1', '$mobile', '$ccode', '$fax', '$off_res_ext', '$off_2', '$off_mob', '$designation', '$role', '$dob', '$expiry', '$identity', '$project', '$sup_email', '$homepage', '$street', '$city', '$pincode', '$keyphrase_1', '$keyphrase_2', '$keyphrase_3', '$telid', '$photo_disp', '$photo', '$design_code', '$metadata', '$pvt_email', '$mh_id', '$role_email','$title', '$gender','$extended_expiry')";
            if (mysqli_query($db, $sql)) {
                header('Location: ../new.html?status=Success');
            } else {
                header('Location: ../update.html?status=Failed&error='.mysqli_error($db));
            }
        }
    }
?>
