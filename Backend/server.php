<?php
    $servername = "10.1.3.40"; //<= ใส่ server ของท่านตรงนี้ 
    $username = "66102010154"; //<= ใส่ username ของท่าน
    $password = "66102010154"; //<= ใส่ password ของท่าน
    $dbname = "66102010154"; //<= ใส่ dbname ของท่าน

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>