<?php
    session_start();
    include("Backend/server.php");

    if(isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $user_query = "SELECT * FROM user WHERE user_name = '$username'";
        $user_result = $conn->query($user_query);

        if($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $user_id = $user_row["user_id"];
            $email = $user_row["user_email"];
            $balance = $user_row["balance"];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก MissShop</title>
    <!--Bootstrap 5 CSS CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!--Bootstrap 5 JS CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!--External Stylesheet Customize-->
    <link rel="stylesheet" href="stylesheet.css">

    <!--Icon for webpage-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!--Navbar Section Top-->
    <nav class="navbar navbar-expand-lg nav-main fixed-top">
        <div class="container">
            <a class="logo navbar-brand me-auto mx-lg-1" href="home.php">MissShop</a>
            <!--Offcanvas-->
            <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <!--Sidebar header-->
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">รายการเมนู</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!--Sidebar body-->
                <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
                    <ul class="navbar-nav justify-content-center align-items-center flex-grow-1">
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link active" aria-current="page" href="home.php"><span><i class="active-icon bi bi-house-door-fill"></i></span>หน้าหลัก</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" aria-current="page" href="cart.php"><span><i class="icon bi bi-cart"></i></span>ตะกร้าสินค้า</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" aria-current="page" href="product.php"><span><i class="icon bi bi-bag"></i></span>สินค้า</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <?php if(isset($_SESSION["username"])): ?>
                                <a class="nav-link" aria-current="page" href="infoUser.php">
                                    <span><i class="icon icon bi bi-person"></i></span>โปรไฟล์
                                </a>
                            <?php else: ?>
                                <a class="nav-link" aria-current="page" href="login.php">
                                    <span><i class="icon icon bi bi-person"></i></span>โปรไฟล์
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" aria-current="page" href="topup.php"><span><i class="icon bi bi-p-circle"></i></span>เติมพอยต์</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--Balance Status-->
            <div class="balance">
                <?php if(isset($_SESSION["username"])): ?>
                    <a class="balance-link" href="#">
                        <span class="balance-box">
                            <span class="balance-text"><p><?php echo $balance; ?><i class="balance-icon bi bi-p-circle"></i></p></span>
                        </span>
                    </a>
                <?php else: ?>
                    <a class="balance-link" href="login.php">
                        <span class="balance-box">
                            <span class="balance-text"><p>เข้าสู่ระบบ</p></span>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            <!--Button side menu-->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span><i class="icon bi bi-list"></i></span>
            </button>
        </div>
    </nav>

    <!--Content-->
    <section class="content container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                <div class="notification card">
                    <div class="notif-body card-body">
                        <p class="notif-text card-text">
                            <i class="bi bi-bell-fill"></i>ประกาศ ร้าน MissShop ที่มียอดโกงอันดับหนึ่ง เปิดให้บริการแล้ว
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row-2 row">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                                <img src="background/1.jpg" class="d-block w-100" alt="image">
                        </div>
                      <div class="carousel-item">
                        <img src="background/2.jpg" class="d-block w-100" alt="image">
                        </div>
                      <div class="carousel-item">
                            <img src="background/3.jpg" class="d-block w-100" alt="image">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
        </div>

        <!--Recommend product for user-->
        <div class="row-3 row">
            <div class="col-12 col-sm-6 col-md-12 col-lg-12 mx-auto">
                <h4 class="heading-group">สินค้าแนะนำสำหรับคุณ</h4>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-1 py-1"> 
            <?php
                $sql_recommend = "SELECT p.product_id, p.product_name, p.product_price, p.product_remain, p.product_img
                FROM orders o
                JOIN orders_detail od ON o.order_id = od.order_id
                JOIN product p ON od.product_id = p.product_id
                WHERE o.status = 'completed'
                GROUP BY p.product_id
                ORDER BY SUM(od.quantity) DESC
                LIMIT 4";
                 //สมมติว่ามีคอลัมน์ recommended ในตาราง product
                $result_recommend = $conn->query($sql_recommend);
                if ($result_recommend->num_rows > 0) {
                    // แสดงสินค้าแนะนำ
                    while($row_recommend = $result_recommend->fetch_assoc()) {
                        // แสดงสินค้าแนะนำด้วย HTML ตามที่ต้องการ
                        echo '<div class="col-12 col-sm-6 col-md-6 col-lg-3">';
                        echo '<div class="item card">';
                        echo '<form action="productSelect.php" method="GET">'; // เริ่ม form สำหรับส่งไปยังหน้า productSelect.php
                        echo '<input type="hidden" name="product_id" value="' . $row_recommend['product_id'] . '">'; // เพิ่ม input hidden เพื่อส่ง product_id ไปยังหน้า productSelect.php
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row_recommend['product_img']).'" class="card-img-top" alt="Product">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">' . $row_recommend["product_name"] . '</h4>';
                        echo '<p class="card-text">ราคาสินค้า ' . $row_recommend["product_price"] . '<span></span></p>';
                        echo '<p class="card-text">จำนวนคงเหลือ ' . $row_recommend["product_remain"] . '<span></span></p>';
                        echo '</div>';
                        echo '<div class="mb-5 d-flex justify-content-around">';
                        echo '<button type="submit" class="btn btn-buy">ดูรายละเอียด</button>';
                        echo '</div>';
                        echo '</form>'; // ปิด form
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "ไม่พบสินค้าแนะนำ";
                }
            ?>
        </div>

        <div class="row">
            <form action="product.php" method="POST">
                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                    <div class="more card d-flex justify-content-center align-items-center"">
                        <button class="btn btn-more">ดูเพิ่มเติม</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-1 py-1">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="topup card">
                    <div class="row g-0">
                        <div class="col-md-7 d-flex justify-content-start align-items-left">
                            <div class="topup-body card-body">
                                <h1 class="card-title">ระบบเติมพอยต์</h1>
                                <p class="card-text">เว็บไซต์ขายไอดีเกม MissShop มีบริการเติมพอยต์ผ่านเว็ปไซต์ สามารถเติมได้อย่างสะดวกสบายและปลอดภัย สบายใจหายห่วงเงินหายหมดกระเป๋า</p>
                                <form action="topup.php" method="POST">
                                    <button type="submit" class="btn btn-topup">เติมพอยต์เลย</button> 
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                            <img class="topUpLogo" src="image/TopUp.png" class="img-fluid" alt="Picture">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Footer-->
    <div class="container-fluid">
        <hr style="color: #6EC28B;" />
    </div>
    
    <div class="container-fluid">
        <footer>
            <p>&copy; Copyright 2024 MissShop. All rights reserved.</p>
        </footer>
    </div>

    <!--Bottom navbar for moblie-->
    <nav class="navbar-bottom navbar-expand-lg">
        <a class="navbar-bottom-link" aria-current="page" href="cart.php"><i class="nav-bottom-icon bi bi-cart"></i></a>
        <a class="navbar-bottom-link" aria-current="page" href="product.php"><i class="nav-bottom-icon bi bi-bag"></i></a>
        <a class="navbar-bottom-link active" aria-current="page" href="home.php"><i class="active-bottom-icon bi bi-house-door-fill"></i></a>
        <?php if(isset($_SESSION["username"])): ?>
            <a class="navbar-bottom-link" aria-current="page" href="infoUser.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php else: ?>
            <a class="navbar-bottom-link" aria-current="page" href="login.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php endif; ?>
        <a class="navbar-bottom-link" aria-current="page" href="topup.php"><i class="nav-bottom-icon bi bi-p-circle"></i></a>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>