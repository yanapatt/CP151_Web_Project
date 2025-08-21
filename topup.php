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
    <title>เติมพอยต์ MissShop</title>
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
                            <a class="nav-link" aria-current="page" href="cart.php"><span><i class="icon bi bi-cart"></i></span>ตระกร้าสินค้า</a>
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
                            <a class="nav-link active" aria-current="page" href="topup.php"><span><i class="active-icon bi bi-p-circle-fill"></i></span>เติมพอยต์</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--Balance Status-->
            <div class="balance">
                <?php if(isset($_SESSION["username"])): ?>
                    <a class="balance-link" href="#">
                        <span class="balance-box">
                            <span class="balance-text"><p><?php echo $balance ; ?><i class="balance-icon bi bi-p-circle"></i></p></span>
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
    <section class="container">
        <div class="row">
            <div class="login-register col-12 col-sm-12 col-md-12 col-lg-12">
            <form id="topupForm">
                <div class="d-flex justify-content-center align-items-center">
                    <img class="topup-pic" src="image/TopUp.png" alt="Picture">
                </div>
                <h2>เติมพอยต์</h2>
                <h6>กรุณาใส่จำนวนพอยต์ที่คุณต้องการเติม</h6>
                <div class="mb-2 mt-4 form-group">
                    <input type="number" class="en form-control" id="topup" name="topup_amount" placeholder="จำนวนเงินที่ต้องการเติม" required><i class="bi bi-cash"></i>
                </div>
                <button type="submit" class="btn btn-login mb-2">เติมพอยต์</button>
            </form>
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
            <a class="navbar-bottom-link" aria-current="page" href="infoUser.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php else: ?>
            <a class="navbar-bottom-link" aria-current="page" href="login.php"><i class="nav-bottom-icon bi bi-person"></i></a>
        <?php endif; ?>
        <a class="navbar-bottom-link active" aria-current="page" href="topup.php"><i class="active-bottom-icon bi bi-p-circle-fill"></i></a>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Alert Client -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            // Check if user is logged in
            <?php if(!isset($_SESSION["username"])): ?>
                // If not logged in, show alert
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: 'คุณต้องเข้าสู่ระบบก่อน',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'ไปที่หน้าล็อคอิน',
                }).then(function() {
                    // Redirect to login page after 3 seconds
                    window.location.href = "login.php";
                });
            <?php endif; ?>
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#topupForm').submit(function(event) {
                event.preventDefault(); // หยุดการ submit แบบปกติ

                // ส่ง AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'Backend/topup_process.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        // ตรวจสอบ response และแสดง Alert ตามผลลัพธ์ที่ได้
                        if(response === "success") {
                            Swal.fire({
                                title: 'แจ้งเตือน',
                                text: 'เติมพอยต์สำเร็จ',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'ตกลง',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // หากผู้ใช้กดปุ่ม "ตกลง" ใน Alert ให้โหลดหน้า top_up.php อีกครั้ง
                                    window.location.href = "topup.php";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'แจ้งเตือน',
                                text: response, // ใช้ข้อความที่ส่งกลับมาจาก topup_process.php
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'ตกลง',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด',
                            text: 'มีข้อผิดพลาดในการส่งข้อมูล',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>