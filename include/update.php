<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nms";

$ftp_server = "127.0.0.1";
$ftp_user = "user";
$ftp_pass = "";

$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to server $ftp_server");
$ftp_login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

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
$off_2 = $_POST['off_2'];
$off_mob = $_POST['off_mob'];
$designation = $_POST['designation'];
$role = $_POST['role'];
$dob = $_POST['dob'];
$expiry = $_POST['expiry'];
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

if (isset($_POST['update'])){

    if (!file_exists($file_target)){
        mkdir($file_target, 0777);
        mkdir($file_target, 0777);
        chmod($file_target, 0777);
        chmod($file_target, 0777);	
    }

    if (isset($_FILES['prof_pic'])) {
        // echo "true";
		$file_name = $_FILES['prof_pic']['name'];
		$file_size = $_FILES['prof_pic']['size'];
		$file_tmp = $_FILES['prof_pic']['tmp_name'];
        $file_type = $_FILES['prof_pic']['type'];
		move_uploaded_file($file_tmp, $file_target."/".$file_name);
		if (is_uploaded_file($file_tmp)) {
            
        }
        $db_store_path = $file_target."/".$file_name;
    }

    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error);
    } 
    else {
        if ($file_name != ""){
            $photo = $file_target."/".$file_name;
            $sql= "UPDATE `people1` set `surname` = '$surname' , `restname`= '$restname', `dept`= '$dept', `room_no`= '$room_no', `office`= '$office', `residence`= '$residence', `email`= '$email', `off_1`= '$off_1',  `mobile`= '$mobile', `ccode`= '$ccode', `fax`= '$fax', `off_res_ext`= '$off_res_ext', `off_2`= '$off_2', `off_mob`= '$off_mob', `designation`= '$designation', `role`= '$role', `dob`= '$dob', `expiry`= '$expiry', `identity`= '$identity', `project`= '$project', `sup_email`= '$sup_email', `homepage`= '$homepage', `street`= '$street', `city`= '$city', `pincode`= '$pincode', `keyphrase_1`= '$keyphrase_1', `keyphrase_2`= '$keyphrase_2', `keyphrase_3`= '$keyphrase_3', `telid`= '$telid', `photo_disp`= '$photo_disp', `photo`= '$photo', `design_code`= '$design_code', `metadata`= '$metadata', `pvt_email`= '$pvt_email', `mh_id`= '$mh_id', `role_email`= '$role_email', `title`= '$title', `gender`= '$gender', `extended_expiry`= '$extended_expiry' WHERE `ccode` ='$ccode'";
        }else{
            $sql= "UPDATE `people1` set `surname` = '$surname' , `restname`= '$restname', `dept`= '$dept', `room_no`= '$room_no', `office`= '$office', `residence`= '$residence', `email`= '$email', `off_1`= '$off_1',  `mobile`= '$mobile', `ccode`= '$ccode', `fax`= '$fax', `off_res_ext`= '$off_res_ext', `off_2`= '$off_2', `off_mob`= '$off_mob', `designation`= '$designation', `role`= '$role', `dob`= '$dob', `expiry`= '$expiry', `identity`= '$identity', `project`= '$project', `sup_email`= '$sup_email', `homepage`= '$homepage', `street`= '$street', `city`= '$city', `pincode`= '$pincode', `keyphrase_1`= '$keyphrase_1', `keyphrase_2`= '$keyphrase_2', `keyphrase_3`= '$keyphrase_3', `telid`= '$telid', `photo_disp`= '$photo_disp', `design_code`= '$design_code', `metadata`= '$metadata', `pvt_email`= '$pvt_email', `mh_id`= '$mh_id', `role_email`= '$role_email', `title`= '$title', `gender`= '$gender', `extended_expiry`= '$extended_expiry' WHERE `ccode` ='$ccode'";
        }
        if (mysqli_query($conn, $sql)) {
            header('Location: ../Admin_search.html');
        } else {
            
        }
    }


}else{\
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error);
    } 
    else {
        $sql = "INSERT INTO `ex_employee`(`surname`, `restname`, `dept`, `room_no`, `office`, `residence`, `email`, `off_1`, `mobile`,
        `fax`, `off_res_ext`, `off_2`, `off_mob`, `designation`, `role`, `dob`, `expiry`, `identity`, `project`, `sup_email`, `homepage`,
        `street`, `city`, `pincode`, `keyphrase_1`, `keyphrase_2`, `keyphrase_3`, `telid`, `photo_disp`, `photo`, `design_code`, `metadata`,
        `pvt_email`, `mh_id`, `role_email`, `title`, `gender`, `extended_expiry`) 
        VALUES ('$surname', '$restname', '$dept', '$room_no', '$office', '$residence', '$email', '$off_1', '$mobile',
         '$fax', '$off_res_ext', '$off_2', '$off_mob', '$designation', '$role', '$dob', '$expiry', '$identity', '$project', '$sup_email', '$homepage',
          '$street', '$city', '$pincode', '$keyphrase_1', '$keyphrase_2', '$keyphrase_3', '$telid', '$photo_disp', '$photo', '$design_code', '$metadata',
           '$pvt_email', '$mh_id', '$role_email', '$title', '$gender', '$extended_expiry')";
        // $result = mysqli_query($conn, $sql);
        // echo ($result->error_log);
        if (mysqli_query($conn, $sql)) {
            header('Location: ../Admin_search.html');
            $delete_sql= "UPDATE `people1` set `surname` = '' , `restname`= '', `dept`= '', `room_no`= '', `office`= '', `residence`= '', `email`= '', `off_1`= '' ,`mobile`= '', `ccode`= '$ccode', `fax`= '', `off_res_ext`= '', `off_2`= '', `off_mob`= '', `designation`= '', `role`= '', `dob`= '', `expiry`= '', `identity`= '', `project`= '', `sup_email`= '', `homepage`= '', `street`= '', `city`= '', `pincode`= '', `keyphrase_1`= '', `keyphrase_2`= '', `keyphrase_3`= '', `telid`= '', `photo_disp`= '', `photo`= '', `design_code`= '', `metadata`= '', `pvt_email`= '', `mh_id`= '', `role_email`= '', `title`= '', `gender`= '', `extended_expiry`= '' WHERE `ccode` ='$ccode'";
            if (mysqli_query($conn, $delete_sql)) {
                header('Location: ../Admin_search.html');
            }
        } else {
            echo "unsuccess". mysqli_error($conn);
        }
    }
}