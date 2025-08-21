<?php
    session_start();
    include("server.php");
    
    // เช็คว่ามีการส่ง user_id มาหรือไม่
    if(isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        
        // ลบสินค้าในตะกร้าที่มีสถานะ "Processing" ของผู้ใช้นี้
        $clear_cart_query = "DELETE FROM orders_detail WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = '$user_id' AND status = 'Processing')";
        
        // เพิ่มคำสั่งลบข้อมูลในตาราง orders ที่มีสถานะเป็น "Processing"
        $clear_orders_query = "DELETE FROM orders WHERE user_id = '$user_id' AND status = 'Processing'";

        // ทำการ execute คำสั่ง SQL สำหรับลบข้อมูลในตาราง orders_detail
        if($conn->query($clear_cart_query) === TRUE) {
            // ทำการ execute คำสั่ง SQL สำหรับลบข้อมูลในตาราง orders
            if($conn->query($clear_orders_query) === TRUE) {
                // ลบสินค้าในตะกร้าสำเร็จ
                // ทำลาย session
                session_destroy();

                // ส่งข้อความสำเร็จและออกจากการทำงาน
                echo json_encode(array("status" => "success", "msg" => "ออกจากระบบแล้ว"));
                exit();
            } else {
                // เกิดข้อผิดพลาดในการลบข้อมูลในตาราง orders
                echo "Error: " . $conn->error;
                exit();
            }
        } else {
            // เกิดข้อผิดพลาดในการลบสินค้าในตะกร้า
            echo "Error: " . $conn->error;
            exit();
        }
    } else {
        // ไม่มี user_id ที่ส่งมา
        echo "Error: Missing user_id parameter.";
        exit();
    }
?>
