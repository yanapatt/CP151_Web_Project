<?php
    session_start();
    //Connect Database
    include("server.php");

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_1 = $conn->real_escape_string($_POST['password_1']);
    $password_2 = $conn->real_escape_string($_POST['password_2']);

    //ตรวจสอบรหัสผ่าน
    if ($password_1 !== $password_2) {
        echo json_encode(array("status" => "error", "msg" => "รหัสผ่านของคุณไม่ตรงกัน กรุณาลองอีกครั้ง"));
        exit();
    }

    //ตรวจสอบชื่อและอีเมล์
    $check_sql = "SELECT * FROM user WHERE user_name='$username' OR user_email='$email'";
    $check_result = $conn->query($check_sql);

    if($check_result->num_rows > 0) {
        echo json_encode(array("status" => "error", "msg" => "ชื่อผู้ใช้หรืออีเมล์มีอยู่ในระบบแล้ว กรุณาลองอีกครั้ง"));
        exit();
    }

    $password_hashed = md5($password_1);
    $insert_sql = "INSERT INTO user (user_name, user_email, user_password) VALUES ('$username', '$email', '$password_hashed')";

    if ($conn->query($insert_sql) === TRUE) {
        //สมัครเสร็จเก็บข้อมูล User คนนั้นทั้งหมดไว้ในตัวแปร SESSION
        
        $user_query = "SELECT * FROM user WHERE user_name = '$username'";
        $user_result = $conn->query($user_query);

        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $_SESSION["user_id"] = $user_row["user_id"];
            $_SESSION["username"] = $user_row["user_name"];
            $_SESSION["user_email"] = $user_row["user_email"];
            $balance = $user_row["balance"];

            //ทุกอย่างปกติ
            echo json_encode(array("status" => "success", "msg" => "การสมัครเสร็จสมบูรณ์"));
            exit(); //ออก
        } else {
            //กรณีไม่สามารถดึงข้อมูลได้
            echo json_encode(array("status" => "error", "msg" => "ไม่สามารถดึงข้อมูลผู้ใช้ได้ กรุณาลองใหม่อีกครั้ง"));
            exit(); //ออก
        }
    } else {
        //กรณีสมัครแล้วไม่เข้าเงื่อนไขไหนเลย
        echo json_encode(array("status" => "error", "msg" => "เกิดข้อผิดพลาดในการสมัครสมาชิก กรุณาลองใหม่อีกครั้ง"));
        exit();
    }
?>