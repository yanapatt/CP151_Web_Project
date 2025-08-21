<?php 
    // ตรวจสอบว่ามีการส่ง ID ของสินค้ามาหรือไม่
    if(isset($_GET['product_id'])) {
        //Connect Database
        include("server.php"); 

        // ดึง ID ของสินค้าที่ถูกส่งมาจากหน้า product.php
        $product_id = $_GET['product_id'];

        // คำสั่ง SQL เพื่อดึงข้อมูลสินค้าจากฐานข้อมูล
        $sql = "SELECT * FROM product WHERE product_id = '$product_id'";
        $result = $conn->query($sql);

        // ตรวจสอบว่ามีข้อมูลสินค้าหรือไม่
        if ($result->num_rows > 0) {
            // แสดงข้อมูลสินค้า
            while($row = $result->fetch_assoc()) {
                echo '<div class="row">';
                echo '<div class="back-menu col-12 col-sm-12 col-md-12 col-lg-12">';
                echo '<a class="back-btn" href="product.php" aria-current="page"><i class="icon-back bi bi-arrow-left-circle"></i></a><span><h4 class="heading-group">' . $row["product_name"] . '</h4></span>';
                echo '</div>';
                echo '</div>';

                echo '<div class="row">';
                echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12">';
                echo '<hr style="border: 1px solid #6EC28B; margin-top: 0px;" />';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="row">';
                echo '<div class="pic-product d-flex justify-content-center align-items-center col-12 col-sm-12 col-md-6 col-lg-5">';
                echo '<div class="item card">';
                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['product_img']).'" class="card-img-top" alt="Product">';
                echo '</div>';
                echo '</div>';
            
                echo '<div class="detail-product d-flex justify-content-center align-items-center col-12 col-sm-12 col-md-6 col-lg-7">';
                echo '<div class="item card">';
                echo '<div class="card-body">';
                echo '<h2 class="card-title">' . $row["product_name"] . '</h2>';
                echo '<h4 class="card-text"><span>' . $row["product_price"] . ' พอยต์ &frasl; ชิ้น</span></h4>';
                echo '<h4 class="card-text"><span>'. 'จำนวนคงเหลือ ' . $row["product_remain"] . ' ชิ้น' . '</span></h4>';
                echo '<hr style="border: 1px solid #6EC28B; margin-top: 0px;" />';
                echo '<p class="card-text">' . $row["product_detail"] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            
                echo '<div class="buy-product d-flex justify-content-center align-items-center col-12 col-sm-12 col-md-12 col-lg-12">';
                echo '<div class="item card">';
                echo '<form method="GET" action="Backend/orders_controller.php">'; // เปลี่ยนจาก cart.php เป็น order_db.php
                echo '<input type="hidden" name="product_id" value="' . $product_id . '">'; // เพิ่ม input ซ่อนสำหรับส่ง product_id ไปยัง order_db.php
                echo '<div class="card-body">';
                echo '<h4>ตัวเลือกการสั่งซื้อ</h4>';
                echo '</div>';

                echo '<div class="card-body">';
                echo '<div class="button d-flex flex-wrap justify-content-around align-items-center">';
                echo '<button type="submit" class="btn btn-cart">เพิ่มลงตระกร้า</button>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } 
            
        } else {
            echo "ไม่พบสินค้าที่คุณเลือก";
        }
        $conn->close();
    } else {
        echo "ไม่มีข้อมูลสินค้าที่คุณเลือก";
    }
?> 
