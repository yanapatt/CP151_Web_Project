<?php
    session_start();
    include("Backend/server.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ MissShop</title>
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
                            <a class="nav-link active" aria-current="page" href="login.php"><span><i class="active-icon icon bi bi-person-fill"></i></span>โปรไฟล์</a>
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
    <section class="container">
        <div class="row">
            <div class="login-register col-12 col-sm-12 col-md-12 col-lg-12">
                <form method="POST" id="loginFrom" action="Backend/login_db.php">
                    <h2>ล็อกอิน</h2>
                    <div class="mb-2 mt-4 form-group">
                        <input type="text" class="en form-control" id="username" placeholder="Username" name="username" required><i class="bi bi-person-fill"></i>
                    </div>
                    <div class="mb-2 form-group">
                        <input type="password" class="en form-control" id="pwd" placeholder="Password" name="password" required><i class="bi bi-key-fill"></i>
                    </div>
                    <button type="submit" name="log_user" class="btn btn-login mb-2">เข้าสู่ระบบ</button>
                    <div class="mb-2">
                        <span class="register">ยังไม่มีบัญชีใช่หรือไม่&#63;<a href="register.php">สมัครบัญชี</a></span>
                    </div>
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
        <a class="navbar-bottom-link active" aria-current="page" href="login.php"><i class="active-bottom-icon bi bi-person-fill"></i></a>
        <a class="navbar-bottom-link" aria-current="page" href="topup.php"><i class="nav-bottom-icon bi bi-p-circle"></i></a>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Alert Client -->
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginFrom').submit(function (e) {
                e.preventDefault();

                let formURL = $(this).attr("action");
                let regMethod = $(this).attr("method");
                let formData = $(this).serialize();

                $.ajax({
                    url: formURL,
                    type: regMethod,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);
                        
                        if (result.status == "success") {
                            console.log("Success", result);
                            Swal.fire("สำเร็จ", result.msg, result.status).then(function() {
                                window.location.href="home.php";
                            });
                        } else {
                            console.log("Error", result);
                            Swal.fire("ล้มเหลว", result.msg, result.status);
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>