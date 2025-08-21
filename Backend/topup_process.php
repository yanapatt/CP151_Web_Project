<?php
    session_start();
    include("server.php");

    if(isset($_SESSION["username"]) && isset($_POST["topup_amount"])) {
        $username = $_SESSION["username"];
        $topup_amount = $_POST["topup_amount"];
        
        // ตรวจสอบว่าเป็นตัวเลขหรือไม่
        if(is_numeric($topup_amount)) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $user_query = "SELECT * FROM user WHERE user_name = '$username'";
            $user_result = $conn->query($user_query);

            if($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                $user_id = $user_row["user_id"];
                $balance = $user_row["balance"];

                // เพิ่มเงินเข้าบัญชีผู้ใช้
                $new_balance = $balance + $topup_amount;
                
                // อัพเดทค่า balance ในฐานข้อมูล
                $update_query = "UPDATE user SET balance = $new_balance WHERE user_id = $user_id";
                if ($conn->query($update_query) === TRUE) {
                    // อัพเดทค่า balance สำเร็จ
                    echo 'success';
                } else {
                    echo 'มีข้อผิดพลาดในการเติมพอยต์';
                }
            }
        } else {
            echo 'กรุณาใส่จำนวนเงินที่เป็นตัวเลข';
        }
    } else {
        // ถ้าไม่มี session username หรือไม่มีข้อมูลจำนวนเงินที่เติมส่งมา
        echo 'กรุณาเข้าสู่ระบบและใส่จำนวนเงินที่ต้องการเติม';
    }
?>
