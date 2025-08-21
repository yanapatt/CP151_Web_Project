<?php
    session_start();
    include("server.php");

    // ตรวจสอบว่ามีการส่ง total_price ผ่าน URL หรือไม่
    if(isset($_GET["total_price"])) {
        // รับข้อมูลจาก URL parameters
        $total_price = $_GET["total_price"];
        // ตรวจสอบว่ามีค่า user_id อยู่ใน session หรือไม่
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            
            // ดึงรายการสินค้าในรายการออร์เดอร์ของผู้ใช้ที่มีสถานะ "Processing"
            $order_detail_query = "SELECT * FROM orders_detail 
                                    WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = $user_id AND status = 'Processing')";
            $order_detail_result = $conn->query($order_detail_query);

            if ($order_detail_result->num_rows > 0) {
                // คำนวณยอดเงินโดยรวมจากสินค้าที่อยู่ในรายการออร์เดอร์
                $total_price = 0;
                while ($row = $order_detail_result->fetch_assoc()) {
                    $total_price += $row['sub_total'];
                }
                
                // วนลูปเพื่ออัปเดตจำนวนสินค้าในตาราง product
                $order_detail_result->data_seek(0); // เริ่มต้นที่แถวแรกอีกครั้ง
                while ($row = $order_detail_result->fetch_assoc()) {
                    $product_id = $row['product_id'];
                    $quantity_ordered = $row['quantity'];

                    // ดึงจำนวนสินค้าที่เหลืออยู่ในสต็อก
                    $stock_query = "SELECT product_remain FROM product WHERE product_id = '$product_id'";
                    $stock_result = $conn->query($stock_query);

                    if($stock_result->num_rows > 0) {
                        $stock_row = $stock_result->fetch_assoc();
                        $product_remain = $stock_row['product_remain'];

                        // หักจำนวนสินค้าที่ผู้ใช้สั่งซื้อออกจากสต็อก
                        $new_product_remain = $product_remain - $quantity_ordered;

                        // อัปเดตจำนวนสินค้าในสต็อก
                        $update_stock_query = "UPDATE product SET product_remain = '$new_product_remain' WHERE product_id = '$product_id'";
                        $conn->query($update_stock_query);
                    }
                }
            }

            // อัปเดต balance ของผู้ใช้
            $update_balance_query = "UPDATE user SET balance = balance - $total_price WHERE user_id = $user_id";
            $conn->query($update_balance_query);

            // อัปเดตสถานะของออร์เดอร์เป็น completed
            $update_order_status_query = "UPDATE orders SET status = 'completed' WHERE user_id = $user_id AND status = 'Processing'";
            $conn->query($update_order_status_query);
            
            //update session ยอดเงิน
            $_SESSION['total_price'] = 0.00;
            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();

            echo "success";
            exit();
        } else {

            $conn->close();
            echo "error";
            exit();
        }
    } else {
        echo "error";
        exit();
    }
?>
