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
    <title>รายการสินค้า MissShop</title>
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
                            <a class="nav-link active" aria-current="page" href="product.php"><span><i class="active-icon bi bi-bag-fill"></i></span>สินค้า</a>
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h4 class="heading-group">รายการสินค้าและไอเท็มทั้งหมด</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <hr style="border: 1px solid #6EC28B; margin-top: 0px;" />
            </div>
        </div>
    </section>

    <section class="menu container">
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <a class="menu-btn" href="product.php" onclick="setActiveLink(this)">สินค้าแนะนำ</a>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <a class="menu-btn" href="product.php?category=1" onclick="setActiveLink(this)">StartPack</a>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <a class="menu-btn" href="product.php?category=2" onclick="setActiveLink(this)">ไอเท็ม</a>
            </div>
        </div>
    </section>

    <section class="content container">
        <div class="row row-cols-1 row-cols-md-3 g-1 py-1">
            <!-- วนลูปแสดงสินค้า -->
            <?php include 'Backend/product_db.php'; ?> 
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
        <a class="navbar-bottom-link active" aria-current="page" href="product.php"><i class="active-bottom-icon bi bi-bag-fill"></i></a>
        <a class="navbar-bottom-link" aria-current="page" href="home.php"><i class="nav-bottom-icon bi bi-house-door"></i></a>
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

    <!--Click Menu-->
    <script>
        window.onload = function() {
            var menuBtns = document.querySelectorAll('.menu-btn');

            // เพิ่ม event listener ให้กับทุกปุ่ม
            menuBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    // ลบ class 'active-menu-btn' ที่ถูกกำหนดไว้ก่อนหน้านี้จากทุกปุ่ม
                    menuBtns.forEach(function(btn) {
                        btn.classList.remove('active-menu-btn');
                    });
                    // เพิ่ม class 'active-menu-btn' ให้กับปุ่มที่ถูกคลิก
                    this.classList.add('active-menu-btn');
                });
            });

            // ตรวจสอบ URL เพื่อกำหนด active link
            var urlParams = new URLSearchParams(window.location.search);
            var category = urlParams.get('category');

            // กำหนด active link โดยตรวจสอบ category
            if (category === null) {
                setActiveLink(document.querySelector('.menu-btn[href="product.php"]'));
            } else {
                setActiveLink(document.querySelector('.menu-btn[href="product.php?category=' + category + '"]'));
            }
        }

        // ฟังก์ชัน setActiveLink เพื่อเปลี่ยน active link
        function setActiveLink(element) {
            // ลบ class 'active-menu-btn' จากทุกปุ่มที่มี class 'menu-btn'
            document.querySelectorAll('.menu-btn').forEach(function(btn) {
                btn.classList.remove('active-menu-btn');
            });
            // เพิ่ม class 'active-menu-btn' ให้กับ element ที่รับเข้ามา
            element.classList.add('active-menu-btn');
        }
    </script>
</body>
</html>