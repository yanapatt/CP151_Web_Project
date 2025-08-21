<?php
    session_start();
    include("server.php");
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_SESSION["username"]) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
        // เรียกใช้ข้อมูลของผู้ใช้จาก session
        $username = $_SESSION["username"];
        $user_query = "SELECT * FROM user WHERE user_name = '$username'";
        $user_result = $conn->query($user_query);

        if($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $user_id = $user_row["user_id"];
            $email = $user_row["user_email"];
            $balance = $user_row["balance"];

            // ดึงข้อมูลสินค้าที่สั่งซื้อ
            $product_id = $_GET['product_id'];
            $quantity_requested = $_GET['quantity'];

            // ดึงข้อมูลจำนวนสินค้าที่เหลืออยู่ในสต็อก
            $stock_query = "SELECT product_remain FROM product WHERE product_id = '$product_id'";
            $stock_result = $conn->query($stock_query);

            if($stock_result->num_rows > 0) {
                $stock_row = $stock_result->fetch_assoc();
                $product_remain = $stock_row['product_remain'];
                // ตรวจสอบว่าจำนวนสินค้าที่ลูกค้าต้องการไม่เกินจำนวนสินค้าที่เหลืออยู่ในสต็อก
                if($quantity_requested <= $product_remain && $quantity_requested > 0) {
                    // ตรวจสอบว่ามีรายการสั่งซื้อที่กำลังดำเนินการอยู่หรือไม่
                    $check_order_query = "SELECT order_id FROM orders WHERE user_id = '$user_id' AND status = 'Processing'";
                    $check_order_result = $conn->query($check_order_query);

                    if($check_order_result->num_rows > 0) {
                        // ถ้ามีรายการสั่งซื้อที่กำลังดำเนินการอยู่ใช้รายการนี้
                        $order_row = $check_order_result->fetch_assoc();
                        $order_id = $order_row['order_id'];
                    } else {
                        // ถ้าไม่มีให้สร้างรายการสั่งซื้อใหม่
                        $insert_order_query = "INSERT INTO orders (user_id, order_date, total_price, status) VALUES ('$user_id', NOW(), '0', 'Processing')";
                        $conn->query($insert_order_query);
                        $order_id = $conn->insert_id;

                        // เก็บ order_id ไว้ใน session
                        $_SESSION["order_id"] = $order_id;
                    }

                    // เก็บ order_id ไว้ใน session
                    $_SESSION["order_id"] = $order_id;

                    // ตรวจสอบว่าสินค้าที่ต้องการเพิ่มลงในตะกร้ามีอยู่ในตะกร้าแล้วหรือไม่
                    $check_cart_query = "SELECT orders_detail.*, orders.status 
                    FROM orders_detail 
                    INNER JOIN orders 
                    ON orders_detail.order_id = orders.order_id 
                    WHERE orders_detail.order_id = '$order_id' 
                    AND orders_detail.product_id = '$product_id' 
                    AND orders.status = 'Processing'";
                    $check_cart_result = $conn->query($check_cart_query);

                    if($check_cart_result->num_rows == 0) {
                        // ดึงข้อมูลสินค้าจากฐานข้อมูล
                        $product_query = "SELECT * FROM product WHERE product_id = '$product_id'";
                        $product_result = $conn->query($product_query);
                    
                        if($product_result->num_rows > 0) {
                            $product_row = $product_result->fetch_assoc();
                            $product_name = $product_row['product_name'];
                            $product_price = $product_row['product_price'];
                    
                            // คำนวณจำนวนสินค้าที่จะใส่ตะกร้าโดยใช้จำนวนสินค้าที่เหลืออยู่ในสต็อก
                            $quantity_to_add = min($quantity_requested, $product_remain);
                    
                            // คำนวณ sub_total
                            $sub_total = $product_price * $quantity_to_add;
                    
                            // เพิ่มข้อมูลลงในตาราง orders_detail พร้อมกับ sub_total
                            $insert_order_detail_query = "INSERT INTO orders_detail (order_id, product_id, quantity, price_per_unit, sub_total) VALUES ('$order_id', '$product_id', '$quantity_to_add', '$product_price', '$sub_total')";
                            $conn->query($insert_order_detail_query);
                    
                            // คำนวณ total_price โดยรวมราคาของรายการสินค้าทั้งหมด
                            $update_order_total_query = "UPDATE orders SET total_price = (SELECT SUM(sub_total) FROM orders_detail WHERE order_id = '$order_id') WHERE order_id = '$order_id'";
                            $conn->query($update_order_total_query);
                    
                            // คำนวณ total_price โดยรวมราคาของรายการสินค้าทั้งหมด
                            $total_price_query = "SELECT SUM(sub_total) AS total_price FROM orders_detail WHERE order_id = '$order_id'";
                            $total_price_result = $conn->query($total_price_query);
                            
                            if ($total_price_result->num_rows > 0) {
                                $total_price_row = $total_price_result->fetch_assoc();
                                $total_price = $total_price_row["total_price"];
                                                
                                // อัพเดตค่า total_price ในตาราง orders
                                $update_order_total_query = "UPDATE orders SET total_price = '$total_price' WHERE order_id = '$order_id'";
                                $conn->query($update_order_total_query);
                            
                                // เก็บค่า total_price ไว้ใน session
                                $_SESSION["total_price"] = $total_price;
                                echo $total_price;
                            }                            
                            // แสดงข้อความสำเร็จ
                            echo "success";
                        } else {
                            echo "ไม่พบข้อมูลสินค้า";
                        }
                    } else {
                        // แจ้งให้ลูกค้าทราบว่าสินค้าอยู่ในตะกร้าอยู่แล้ว
                        echo "exists";
                    }
                      
                } else {
                    // แสดงข้อความเมื่อจำนวนสินค้าที่ลูกค้าต้องการเกินจำนวนสินค้าที่เหลือในสต็อกหรือน้อยกว่าหรือเท่ากับ 0
                    echo "out_of_stock";
                }
            } else {
                echo "ไม่พบข้อมูลสินค้า";
            }
        } else {
            echo "ไม่พบข้อมูลผู้ใช้";
        }
    } else {
        echo "login_first";
    }
?>
