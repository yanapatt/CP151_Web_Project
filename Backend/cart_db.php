<?php
    include("server.php");

    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $product_image_url = '';
        
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $user_query = "SELECT * FROM user WHERE user_name = '$username'";
        $user_result = $conn->query($user_query);

        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $user_id = $user_row["user_id"];
            $email = $user_row["user_email"];
            $balance = $user_row["balance"];

            // ดึงข้อมูลรายการสินค้าในตะกร้าสั่งซื้อของผู้ใช้ที่มีสถานะ "Processing"
            $cart_query = "SELECT orders_detail.*, product.product_name, product.product_price, product.product_img, category.category_name, product.product_remain
                        FROM orders_detail 
                        INNER JOIN product ON orders_detail.product_id = product.product_id 
                        INNER JOIN category ON product.category_id = category.category_id
                        WHERE orders_detail.order_id IN (SELECT order_id FROM orders WHERE user_id = '$user_id')
                        AND orders_detail.order_id IN (SELECT order_id FROM orders WHERE status = 'Processing')";
            $cart_result = $conn->query($cart_query);
        }
    }
?>
