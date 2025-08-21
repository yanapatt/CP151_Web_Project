<?php
    session_start();
    include("Backend/cart_db.php");
    if (!isset($_SESSION['total_price'])) {
        $_SESSION['total_price'] = 0; // กำหนดค่าเริ่มต้นให้เป็น 0
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
                            <a class="nav-link active" aria-current="page" href="cart.php"><span><i class="active-icon icon bi bi-cart-fill"></i></span>ตะกร้าสินค้า</a>
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
                            <i class="bi bi-p-circle-fill"></i>
                            <h6>ชำระเงิน</h6>
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
            <div class="card card-for-table">
                <?php
                    if(isset($_SESSION["username"])) {
                        if($cart_result->num_rows > 0) {
                            echo '<table class="order-table table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col">ชื่อสินค้า</th>';
                            echo '<th scope="col">จำนวนสินค้า</th>';
                            echo '<th scope="col">ราคา</th>';
                            echo '</tr>';
                            echo '</thead>';
                            while ($cart_row = $cart_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<div class='cart-info'>";
                                echo "<img class='cart-info-pic' src='data:image/jpeg;base64," . base64_encode($cart_row['product_img']) . "' alt='Product'>";
                                echo "<div>";
                                echo "<h6>" . $cart_row['product_name'] . "</h6>";
                                echo "<button class='btn btn-outline-danger' onclick='removeFromCart(" . $cart_row['order_detail_id'] . ")'>ลบรายการสินค้า</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type='hidden' name='product_id[]' value='" . $cart_row['product_id'] . "'>";
                                echo "<div class='input-group'>";
                                echo "<div class='input-group-prepend'>";
                                echo "<button type='button' class='btn btn-outline-green minusButton'><span>&minus;</span></button>";
                                echo "</div>";
                                echo "<input type='number' name='quantity[]' class='form-control input-number numberInput' value='" . $cart_row['quantity'] . "' min='1' max='" . $cart_row['product_remain'] . "' readonly>";
                                echo "<div class='input-group-append'>";
                                echo "<button type='button' class='btn btn-outline-green plusButton'><span>&plus;</span></button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>" . $cart_row['price_per_unit'] . " พอยต์</td>";
                                echo "</tr>";
                            }
                        } else {
                            // ถ้าไม่มีสินค้าในตะกร้า
                            echo '<table class="order-table table">';
                            echo "<tbody>";
                            echo "<tr><td colspan='3' class='text-center'>กรุณาเลือกซื้อสินค้าก่อน</td></tr>";
                            echo "</tbody>";
                            echo '</table>';
                        }
                    } else {
                        // ถ้าไม่มีข้อมูลใน $_SESSION ให้แสดงข้อความว่า "กรุณาล็อกอินเพื่อดูรายการสินค้า"
                        echo '<table class="order-table table">';
                        echo "<tbody>";
                        echo "<tr><td colspan='3' class='text-center'>กรุณาล็อกอินเพื่อดูรายการสินค้า</td></tr>";
                        echo "</tbody>";
                        echo '</table>';
                    }
                ?>
                </table>
            </div>
        </div>

        <div class="row mt-1">
            <div class="cart-payment-menu card">
                <div class="row g-0">
                    <div class="col-6 col-sm-8 col-md-8 col-lg-8">
                        <div class="status-payment-text card">
                            <h2>ราคารวม</h2>
                            <?php
                                // ตรวจสอบว่ามีข้อมูลใน $_SESSION หรือไม่
                                if(isset($_SESSION["username"])) {
                                    $total_price = $_SESSION['total_price'];
                                    echo "<h4>". $total_price ." พอยต์ </h4>";
                                } else {
                                    // ถ้าไม่มีข้อมูลใน $_SESSION ให้แสดงข้อความ "กรุณาล็อกอินเพื่อดูรายการสินค้า"
                                    echo "<h4>กรุณาล็อกอินเพื่อดูรายการสินค้า</h4>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4">
                        <div class="status-payment-button buy-product card">
                            <button type="button" class="btn btn-buy">ชำระเงิน<span><i class="icon bi bi-arrow-right-square-fill"></i></span></button>
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
                    confirmButtonText: 'ไปที่หน้าล็อกอิน',
                }).then(function() {
                    window.location.href = "login.php";
                });
                exit();
            <?php endif; ?>
        });
    </script>
    <script>
        function removeFromCart(orderDetailId) {
            // ส่งคำขอลบรายการสินค้าไปยังเซิร์ฟเวอร์โดยใช้ AJAX
            $.ajax({
                type: "GET",
                url: "Backend/remove_from_cart.php",
                data: {
                    order_detail_id: orderDetailId
                },
                success: function(response) {
                    // ตรวจสอบการตอบกลับจากเซิร์ฟเวอร์
                    if (response == 'success') {
                        // แสดง Alert ด้วย Swal.fire
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบรายการสินค้าเรียบร้อยแล้ว',
                            text: 'กรุณาตรวจสอบตะกร้าสินค้าคุณอีกครั้ง',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            // หลังจากแสดง Alert เสร็จแล้ว รีโหลดหน้าเว็บหรืออัพเดทตารางรายการสินค้า
                            location.reload();
                        });
                    } else {
                        // แสดง Alert ด้วย Swal.fire เมื่อมีข้อผิดพลาด
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการลบรายการสินค้า',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }); 
        }
    </script>
    <script>
        $(document).ready(function() {
            // ฟังก์ชันสำหรับเพิ่มจำนวนสินค้า
            $(".plusButton").click(function() {
                var $input = $(this).parent().siblings(".numberInput");
                var count = parseInt($input.val()) + 1;
                var availableQuantity = parseInt($input.attr("max")); // ดึงค่าจำนวนสินค้าที่เหลืออยู่จาก attribute max

                if (count <= availableQuantity) {
                    $input.val(count);
                    updateTotalPrice();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'แจ้งเตือน',
                        text: 'จำนวนสินค้าเกินกำหนด',
                        confirmButtonText: 'OK'
                    })
                }
            });


            // ฟังก์ชันสำหรับลดจำนวนสินค้า
            $(".minusButton").click(function() {
                var $input = $(this).parent().siblings(".numberInput");
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);

                // เรียกใช้ฟังก์ชันอัปเดตราคาทั้งหมด
                updateTotalPrice();
            });

            // ฟังก์ชันอัปเดตราคาทั้งหมด
            function updateTotalPrice() {
                // ราคาเริ่มต้นที่ 0
                var totalPrice = 0;

                // วนลูปผ่านแต่ละแถวในตาราง
                $(".order-table tbody tr").each(function() {
                    var pricePerItem = parseFloat($(this).find(".numberInput").val());
                    var subtotal = parseFloat($(this).find("td:last").text());
                    totalPrice += pricePerItem * subtotal;
                });

                // แสดงราคาทั้งหมดที่อัปเดตแล้วในหน้าเว็บ
                $(".status-payment-text h4").text(totalPrice.toFixed(2) + " พอยต์");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // เมื่อคลิกปุ่ม "ชำระเงิน"
            $(".btn-buy").click(function() {
                // ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
                if ($(".order-table tbody tr").length === 0) {
                    // หากไม่มีสินค้า กำหนดราคารวมเป็น 0
                    var totalPrice = 0;
                } else {
                    // หากมีสินค้า คำนวณราคารวมทั้งหมด
                    var totalPrice = 0;
                    $(".order-table tbody tr").each(function() {
                        var quantity = parseInt($(this).find(".numberInput").val());
                        var subTotal = parseFloat($(this).find("td:last").text());
                        totalPrice += quantity * subTotal;
                    });
                }

                // กำหนดค่ารวมทั้งหมดให้กับ input hidden
                $("#totalPriceInput").val(totalPrice);

                // เก็บข้อมูลสินค้าและจำนวนที่เลือกไว้
                var productIds = [];
                var quantities = [];

                $(".order-table tbody tr").each(function() {
                    productIds.push($(this).find("input[name='product_id[]']").val());
                    quantities.push($(this).find("input[name='quantity[]']").val());
                });

                var productIdsJSON = JSON.stringify(productIds);
                var quantitiesJSON = JSON.stringify(quantities);

                // ส่งข้อมูลไปยังสคริปต์ด้วย AJAX
                $.ajax({
                    type: "POST",
                    url: "Backend/update_cart.php",
                    data: { productIds: productIdsJSON, quantities: quantitiesJSON },
                    success: function(response) {
                        // ตรวจสอบการตอบกลับจากสคริปต์
                        if (response == 'success') {
                            // เมื่ออัปเดตสำเร็จ ทำการ redirect ไปยังหน้า payment_method.php
                            window.location.href = "paymentMethod.php?total_price=" + totalPrice;
                        } else {
                            // ดำเนินการเมื่อมีข้อผิดพลาดในการอัปเดต
                            console.log(totalPrice);
                            console.log(productIds);
                            console.log(quantities);
                            console.log("Error updating orders and orders_detail");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html> 