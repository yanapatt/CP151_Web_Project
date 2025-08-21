<?php
    // เชื่อมต่อกับฐานข้อมูล
    include("server.php");
    session_start();

    // ตรวจสอบว่ามีการส่งค่ารหัสรายการสินค้าผ่านเมธอด GET หรือไม่
    if(isset($_GET['order_detail_id'])) {
        // รับค่ารหัสรายการสินค้า
        $order_detail_id = $_GET['order_detail_id'];
        
        // ดึงข้อมูลราคาและจำนวนสินค้า
        $sub_total_query = "SELECT od.sub_total, o.order_id 
                            FROM orders_detail od
                            INNER JOIN orders o ON od.order_id = o.order_id
                            WHERE od.order_detail_id = '$order_detail_id' AND o.status = 'Processing'";
        $sub_total_result = $conn->query($sub_total_query);

        if ($sub_total_result->num_rows > 0) {
            $sub_total_row = $sub_total_result->fetch_assoc();
            $sub_total = $sub_total_row["sub_total"];
            $order_id = $sub_total_row["order_id"];

            // ลบรายการสินค้าออกจากตะกร้าของผู้ใช้ในฐานข้อมูล
            $delete_query = "DELETE FROM orders_detail WHERE order_detail_id = '$order_detail_id'";
            if ($conn->query($delete_query) === TRUE) {
                // อัปเดตยอดรวมของรายการสั่งซื้อ
                $update_total_query = "UPDATE orders 
                                       SET total_price = (SELECT SUM(sub_total) 
                                                          FROM orders_detail 
                                                          WHERE order_id = '$order_id') 
                                       WHERE order_id = '$order_id'";
                if ($conn->query($update_total_query) === TRUE) {
                    // อัปเดต session สำหรับการแสดงผลใน UI
                    $_SESSION["total_price"] -= $sub_total;

                    // ตรวจสอบว่าไม่มีรายการสินค้าใน orders_detail สำหรับ order นี้อีก
                    $check_orders_detail_query = "SELECT * FROM orders_detail WHERE order_id = '$order_id'";
                    $check_orders_detail_result = $conn->query($check_orders_detail_query);

                    // ถ้าไม่มีรายการสินค้าใน orders_detail สำหรับ order นี้อีก
                    if ($check_orders_detail_result->num_rows == 0) {
                        // ลบข้อมูล order ด้วย
                        $delete_order_query = "DELETE FROM orders WHERE order_id = '$order_id'";
                        $conn->query($delete_order_query);
                    }

                    // ส่งข้อความกลับถ้าการดำเนินการเสร็จสมบูรณ์
                    echo "success";
                } else {
                    // ส่งข้อความกลับถ้าเกิดข้อผิดพลาดในการอัปเดตยอดรวม
                    echo "เกิดข้อผิดพลาดในการอัปเดตยอดรวม";
                }
            } else {
                // ส่งข้อความกลับถ้าเกิดข้อผิดพลาดในการลบรายการสินค้า
                echo "เกิดข้อผิดพลาดในการลบรายการสินค้า";
            }
        } else {
            // ส่งข้อความกลับถ้าไม่พบข้อมูลราคาของรายการสินค้า
            echo "ไม่พบข้อมูลราคาของรายการสินค้า หรือรายการสั่งซื้อไม่ได้อยู่ในสถานะ 'Processing'";
        }
    } else {
        // ส่งข้อความกลับถ้าไม่มีการส่งค่ารหัสรายการสินค้า
        echo "ไม่มีการส่งค่ารหัสรายการสินค้า";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
?>
