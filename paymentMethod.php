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
<?php
    if(isset($_GET["total_price"])) {
        // ดึงค่า total_price จาก URL parameters
        $total_price = $_GET["total_price"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตระกร้าสินค้า MissShop</title>
    <!--Bootstrap 5 CSS CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!--Bootstrap 5 JS CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!--External Stylesheet Customize-->
    <link rel="stylesheet" href="stylesheet.css">

    <!--Icon for webpage-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<>
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
                            <a class="nav-link" aria-current="page" href="home.html"><span><i class="icon bi bi-house-door"></i></span>หน้าหลัก</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link active" aria-current="page" href="cart.html"><span><i class="active-icon icon bi bi-cart-fill"></i></span>ตะกร้าสินค้า</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" aria-current="page" href="product.html"><span><i class="icon bi bi-bag"></i></span>สินค้า</a>
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

    <!--Login Form-->
    <div class="container">
        <div class="row">
            <div class="status card">
                <div class="row g-0">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="status-cart card">
                            <i class="select bi bi-list-task"></i>
                            <h6 class="select">ออร์เดอร์สินค้า</h6>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="status-cart card">
                            <i class="select bi bi-p-circle-fill"></i>
                            <h6 class="select">ชำระเงิน</h6>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="status-cart card">
                            <i class="bi bi-patch-check-fill"></i>
                            <h6>การสั่งซื้อสำเร็จ</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-1">
            <div class="card card-for-list">
                <div class="row mt-1">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center align-items-center">
                        <div class="card card-method-title">
                            <h2>ช่องทางการชำระเงิน</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="cart-payment-method card">
                        <div class="row">
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-center align-items-center">
                                <i class="icon-wallet bi bi-wallet"></i>
                            </div>
                            <div class="method-detail col-6 col-sm-8 col-md-8 col-lg-8">
                                <h4>พอยต์ MissShop</h4>
                                <h6><?php echo $balance; ?> พอยต์</h6>
                            </div>
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-center align-items-center">
                                <a class="method-payment-topup" href="topup.php">เติมพอยต์</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-1">
            <div class="cart-payment-menu card">
                <div class="row g-0">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="status-payment-text card">
                            <h2>ราคารวม</h2>
                            <?php
                                // ตรวจสอบว่า $total_price เป็น NaN หรือไม่
                                if (is_numeric($total_price)) {
                                    // แปลงเป็นทศนิยม 2 ตำแหน่งหากเป็นตัวเลข
                                    $formatted_price = number_format($total_price, 2);
                                } else {
                                    // ให้ค่าเป็น 0 หากไม่ใช่ตัวเลข
                                    $formatted_price = "0.00";
                                    echo "<script>
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'แจ้งเตือน',
                                            text: 'ยังไม่มีสินค้าในตะกร้า',
                                            confirmButtonText: 'ตกลง'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'cart.php';
                                            }
                                        });
                                    </script>";
                                }
                            ?>
                            <h4><?php echo $formatted_price; ?> พอยต์</h4>
                        </div>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="status-payment-button-phaseT buy-product card">
                            <form action="cart.php" method="GET">
                                <button type="submit" class="btn btn-cart">ย้อนกลับ</button>
                                <button type="submit" class="btn btn-cart-icon"><i class="icon bi bi-arrow-left-square-fill"></i></button>
                            </form>
                            <button type="submit" class="btn btn-buy" onclick="payNow()">ชำระเงิน<span><i class="icon bi bi-arrow-right-square-fill"></i></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        <a class="navbar-bottom-link active" aria-current="page" href="cart.php"><i class="active-bottom-icon nav-bottom-icon bi bi-cart-fill"></i></a>
        <a class="navbar-bottom-link" aria-current="page" href="product.php"><i class="nav-bottom-icon bi bi-bag"></i></a>
        <a class="navbar-bottom-link" aria-current="page" href="home.php"><i class="nav-bottom-icon bi bi-house-door"></i></a>
        <?php if(isset($_SESSION["username"])): ?>
            <a class="navbar-bottom-link" aria-current="page" href="infoUser.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php else: ?>
            <a class="navbar-bottom-link" aria-current="page" href="login.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php endif; ?>
        <a class="navbar-bottom-link" aria-current="page" href="topup.php"><i class="bi bi-p-circle"></i></a>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check if total_price is greater than balance
            var total_price = <?php echo $total_price; ?>;
            var balance = <?php echo $balance; ?>;

            if (total_price > balance) {
                // If total price is greater than balance, show alert and disable payment button
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ยอดเงินในบัญชีของคุณไม่เพียงพอ',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'cart.php';
                    }
                });

                // Disable payment button
                $('.btn-buy').prop('disabled', true);
            }
        });
    </script>
    <!-- ตรวจสอบการกดปุ่มชำระเงินและส่งข้อมูลไปยัง payment_db.php ผ่าน AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Function เมื่อกดปุ่มชำระเงิน
        function payNow() {
            // เรียกใช้งาน AJAX
            $.ajax({
                type: "GET", // รูปแบบการส่งข้อมูล
                url: "Backend/payment_db.php", // ไฟล์ที่รับข้อมูล
                data: { total_price: <?php echo $total_price; ?> }, // ข้อมูลที่ต้องการส่ง
                success: function(response) { // เมื่อรับ response กลับมา
                    // ตรวจสอบ response
                    if(response == "success") {
                        // ถ้าชำระเงินสำเร็จ แสดง Alert ด้วย SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'การชำระเงินสำเร็จ',
                            text: 'ข้อมูลการชำระเงินถูกบันทึกเรียบร้อยแล้ว',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            if (result.isConfirmed) {
                            // เด้งไปที่หน้า history.php
                            window.location.href = 'history.php';
                            }
                        });
                    } else {
                        // ถ้าเกิดข้อผิดพลาด แสดง Alert ด้วย SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถบันทึกข้อมูลการชำระเงินได้',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>