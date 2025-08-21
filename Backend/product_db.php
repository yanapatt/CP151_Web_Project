<?php
    // เชื่อมต่อกับฐานข้อมูล
    include("server.php");

    // ตรวจสอบว่ามีการส่งค่า category มาหรือไม่
    if(isset($_GET['category'])) {
        // ดึงค่า category ที่ถูกส่งมา
        $category_id = $_GET['category'];

        // คำสั่ง SQL เพื่อดึงข้อมูลสินค้าตามหมวดหมู่ที่เลือก
        $sql = "SELECT * FROM product WHERE category_id = $category_id";
    } else {
        // คำสั่ง SQL เพื่อดึงข้อมูลสินค้าแนะนำจาก orders ของผู้ใช้
        $sql = "SELECT p.product_id, p.product_name, p.product_price, p.product_remain, p.product_img
        FROM orders o
        JOIN orders_detail od ON o.order_id = od.order_id
        JOIN product p ON od.product_id = p.product_id
        WHERE o.status = 'completed'
        GROUP BY p.product_id
        ORDER BY SUM(od.quantity) DESC
        LIMIT 4";
    }

    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลสินค้าหรือไม่
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // แสดงสินค้าด้วย HTML ตามที่ต้องการ
            echo '<div class="col-12 col-sm-6 col-md-6 col-lg-3">';
            echo '<div class="item card">';
            echo '<form action="productSelect.php" method="GET">'; // เริ่ม form สำหรับส่งไปยังหน้า productSelect.php
            echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">'; // เพิ่ม input hidden เพื่อส่ง product_id ไปยังหน้า productSelect.php
            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['product_img']).'" class="card-img-top" alt="Product">';
            echo '<div class="card-body" style="height: 200px">';
            echo '<h4 class="card-title">' . $row["product_name"] . '</h4>';
            echo '<p class="card-text">ราคาสินค้า ' . $row["product_price"] . '<span></span></p>';
            echo '<p class="card-text">จำนวนคงเหลือ ' . $row["product_remain"] . '<span></span></p>';
            echo '</div>';
            echo '<div class="mb-5 d-flex justify-content-around">';
            echo '<button type="submit" class="btn btn-buy">ดูรายละเอียด</button>';
            echo '</div>';
            echo '</form>'; // ปิด form
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "ไม่พบสินค้า";
    }

    $conn->close();
?>
