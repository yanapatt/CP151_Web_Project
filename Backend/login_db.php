<?php
    session_start();
    //Connect Database
    include("server.php");

    // Check if username and password are set
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        // Hash the password to match with the hashed password in the database
        $password_hashed = md5($password);

        // Check if the username and hashed password match in the database
        $check_sql = "SELECT * FROM user WHERE user_name='$username' AND user_password='$password_hashed'";
        $check_result = $conn->query($check_sql);

        if($check_result->num_rows > 0) {
            // Fetch user data and store it in session variables
            $user_query = "SELECT * FROM user WHERE user_name = '$username'";
            $user_result = $conn->query($user_query);
            if ($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                $_SESSION["user_id"] = $user_row["user_id"];
                $_SESSION["username"] = $user_row["user_name"];
                $_SESSION["user_email"] = $user_row["user_email"];
                $balance = $user_row["balance"];

                // Everything is normal, return success message
                echo json_encode(array("status" => "success", "msg" => "การล็อคอินเสร็จสมบูรณ์"));
                exit(); // Exit script
            } else {
                // Failed to fetch user data
                echo json_encode(array("status" => "error", "msg" => "ไม่สามารถดึงข้อมูลผู้ใช้ได้ กรุณาลองใหม่อีกครั้ง"));
                exit(); // Exit script
            }
        } else {
            // Username or password is incorrect
            echo json_encode(array("status" => "error", "msg" => "ไม่พบข้อมูลบัญชีของท่าน กรุณาลองอีกครั้ง"));
            exit(); // Exit script
        }
    } else {
        // Username or password not set
        echo json_encode(array("status" => "error", "msg" => "ไม่พบตัวแปร username หรือ password"));
        exit(); // Exit script
    }
?>
