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

        $order_query = "SELECT orders.order_date, product.product_name, product.product_detail 
                        FROM orders 
                        INNER JOIN orders_detail ON orders.order_id = orders_detail.order_id
                        INNER JOIN product ON orders_detail.product_id = product.product_id
                        WHERE orders.user_id = '$user_id' AND orders.status = 'Completed'";
        $order_result = $conn->query($order_query);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ MissShop</title>
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
                            <a class="nav-link" aria-current="page" href="home.php"><span><i class="icon bi bi-house-door"></i></span>หน้าหลัก</a>
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
                                    <span><i class="icon icon bi bi-person-fill"></i></span>โปรไฟล์
                                </a>
                            <?php else: ?>
                                <a class="nav-link" aria-current="page" href="login.php">
                                    <span><i class="icon icon bi bi-person-fill"></i></span>โปรไฟล์
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

    <!-- Back -->
    <section class="container">
        <div class="row">
            <div class="back-menu col-12 col-sm-12 col-md-12 col-lg-12">
                <a class="back-btn" href="infoUser.php" aria-current="page"><i class="icon-back bi bi-arrow-left-circle"></i></a><span><h4 class="heading-group">โปรไฟล์ &gt; ประวัติการสั่งซื้อ</h4></span>
            </div>
        </div>
    </section>

    <!--Login Form-->
    <section class="container">
        <div class="row">
            <div class="login-register col-12 col-sm-12 col-md-12 col-lg-12 mt-0">
                <h2>ประวัติการสั่งซื้อ</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <table class="history-table table">
                    <thead>
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อสินค้า</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">ซื้อเมื่อ</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php if ($order_result->num_rows > 0): ?>
                            <?php $counter = 1; ?>
                            <?php while ($order_row = $order_result->fetch_assoc()): ?>
                                <tr>
                                    <th scope="row"><?php echo $counter; ?></th>
                                    <td><?php echo $order_row["product_name"]; ?></td>
                                    <td><?php echo $order_row["product_detail"]; ?></td>
                                    <td><?php echo $order_row["order_date"]; ?></td>
                                </tr>
                                <?php $counter++; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">ไม่พบประวัติการสั่งซื้อ</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
        <a class="navbar-bottom-link" aria-current="page" href="home.php"><i class="nav-bottom-icon bi bi-house-door"></i></a>
        <?php if(isset($_SESSION["username"])): ?>
            <a class="navbar-bottom-link" aria-current="page" href="infoUser.php"><i class="active-bottom-icon bi bi-person-fill"></i></a>
        <?php else: ?>
            <a class="navbar-bottom-link" aria-current="page" href="login.php"><i class="active-bottom-icon bi bi-person-fill"></i></a>
        <?php endif; ?>
        <a class="navbar-bottom-link" aria-current="page" href="topup.php"><i class="nav-bottom-icon bi bi-p-circle"></i></a>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>