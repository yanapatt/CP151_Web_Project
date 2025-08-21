<?php
    session_start();
    include("server.php");

    $new_username = $_POST["new_username"];
    $user_id = $_SESSION["user_id"];

    // เช็คว่า username ซ้ำกับในระบบหรือไม่
    $check_query = "SELECT * FROM user WHERE user_name = '$new_username'";
    $result_check = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($result_check) > 0) {
        echo json_encode(array("status" => "error", "msg" => "ชื่อผู้ใช้นี้อยู่ในระบบแล้ว กรุณาลองอีกครั้ง"));
        exit();
    } else {
        // ดำเนินการอัปเดตชื่อผู้ใช้ในฐานข้อมูล
        // อัปเดต username ในฐานข้อมูล
        $update_query = "UPDATE user SET user_name = '$new_username' WHERE user_id = '$user_id'";
        $result_update = mysqli_query($conn, $update_query);
        //อัพเดท SESSION
        $_SESSION['username'] = $new_username;
        echo json_encode(array("status" => "success", "msg" => "การเปลี่ยนชื่อเสร็จสมบูรณ์"));
        exit(); //ออก
    }
?>
