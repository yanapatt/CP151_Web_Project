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
    <section class="container">    
        <!--Detail Product-->
        <?php include 'Backend/productSelect_db.php'; ?>
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

    <!-- สร้างตัวแปร JavaScript ด้วยข้อมูลจาก PHP -->
    <!-- Alert Client -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault(); // หยุดการส่ง form ไปยังหน้าที่ระบุใน action attribute
                    
                // เพิ่มพารามิเตอร์ quantity เป็น 1 เสมอ
                $(this).append('<input type="hidden" name="quantity" value="1">');
                    
                // ส่งข้อมูล form ไปยังหน้า orders_controller.php ด้วย AJAX
                $.ajax({
                    type: 'GET',
                    url: 'Backend/orders_controller.php',
                    data: $(this).serialize(), // รวบรวมข้อมูลจาก form
                    success: function(response) {
                        if (response == 'exists') {
                            // แจ้งเตือนว่าสินค้ามีอยู่ในตะกร้าแล้ว
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                text: 'สินค้านี้มีอยู่ในตะกร้าของคุณแล้ว',
                                icon: 'error',
                                confirmButtonText: 'OK' 
                            });
                        } else if (response == 'out_of_stock') {
                            // แจ้งเตือนว่าสินค้าหมด
                            Swal.fire({
                                title: 'สินค้าหมด',
                                text: 'ขออภัย สินค้านี้หมดแล้ว',
                                icon: 'warning',
                                confirmButtonText: 'OK' 
                            });
                        } else if (response == 'login_first') {
                            // แจ้งเตือนว่ายังไม่ล็อคอิน
                            Swal.fire({
                                title: 'แจ้งเตือน',
                                text: 'คุณต้องเข้าสู่ระบบก่อน',
                                icon: 'warning',
                                confirmButtonText: 'ไปที่หน้าล็อกอิน' 
                            }).then(function() {
                                window.location.href = 'login.php'
                            });
                        } else {
                            // สินค้ายังไม่มีอยู่ในตะกร้า แสดง Alert แจ้งเตือนสำเร็จ
                            Swal.fire({
                                title: 'เพิ่มสินค้าเรียบร้อยแล้ว',
                                text: 'สามารถตรวจสอบได้ที่ตระกร้าสินค้าของคุณ',
                                icon: 'success',
                                confirmButtonText: 'OK' 
                            }).then(function() {
                                // กำหนดให้เมื่อกดปุ่ม OK ให้เปลี่ยนเส้นทางไปยังหน้า product.php
                                window.location.href = 'product.php';
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // แสดง Alert หากเกิดข้อผิดพลาด
                        Swal.fire({
                            title: 'ข้อผิดพลาด',
                            text: 'ไม่สามารถเพิ่มสินค้าได้ในขณะนี้',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>