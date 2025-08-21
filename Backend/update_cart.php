<?php
    include("server.php"); 
    session_start();

    // Get user_id and order_id from $_SESSION
    $user_id = $_SESSION['user_id'];
    $order_id = $_SESSION['order_id'];

    // Check if data is received from AJAX request
    if(isset($_POST['productIds']) && isset($_POST['quantities'])) {
        // Sanitize and validate data received from AJAX request
        $productIds = json_decode($_POST['productIds'], true); // Decode JSON string to array of productIds
        $quantities = json_decode($_POST['quantities'], true); // Decode JSON string 
        
        // Initialize total price for the order
        $total_price = 0;

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Iterate through each product
            foreach ($productIds as $key => $productId) {
                $quantity = $quantities[$key];
                
                // Validate quantity and product_price
                if ($quantity <= 0) {
                    // Handle invalid quantity
                    continue; // Skip to the next iteration
                }

                // Get product_price from product table using product_id
                $get_product_price_query = "SELECT product_price FROM product WHERE product_id = ?";
                $stmt = $conn->prepare($get_product_price_query);
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $stmt->bind_result($product_price);

                if ($stmt->fetch() === null || $product_price <= 0) {
                    // Handle invalid product or price
                    $stmt->close();
                    continue; // Skip to the next iteration
                }
                $stmt->close();

                // Check if the product already exists in the order_detail table
                $check_product_query = "SELECT * FROM orders_detail WHERE order_id = ? AND product_id = ?";
                $stmt = $conn->prepare($check_product_query);
                $stmt->bind_param("ii", $order_id, $productId);
                $stmt->execute();
                $result = $stmt->get_result();
                $existing_product = $result->fetch_assoc();
                $stmt->close();

                if ($existing_product) {
                    // If product already exists, update its quantity and sub_total
                    $new_quantity = $quantity;
                    $new_sub_total = $product_price * $new_quantity;
                    $update_product_query = "UPDATE orders_detail SET quantity = ?, sub_total = ? WHERE order_id = ? AND product_id = ?";
                    $stmt = $conn->prepare($update_product_query);
                    $stmt->bind_param("iddi", $new_quantity, $new_sub_total, $order_id, $productId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // If product does not exist, insert it into orders_detail
                    // Insert new product into orders_detail
                    $insert_product_query = "INSERT INTO orders_detail (order_id, product_id, quantity, price_per_unit, sub_total) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insert_product_query);
                    $stmt->bind_param("iiidd", $order_id, $productId, $quantity, $product_price, $product_price * $quantity);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            // Calculate total price for the order
            $calculate_total_query = "SELECT SUM(sub_total) AS total_price FROM orders_detail WHERE order_id = ?";
            $stmt = $conn->prepare($calculate_total_query);
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $stmt->bind_result($total_price);
            $stmt->fetch();
            $stmt->close();

            // Update total_price in the orders table
            $update_order_query = "UPDATE orders SET total_price = ? WHERE order_id = ?";
            $stmt = $conn->prepare($update_order_query);
            $stmt->bind_param("di", $total_price, $order_id);
            $stmt->execute();
            $stmt->close();

            // Update session total_price
            $_SESSION['total_price'] = $total_price;

            // Commit the transaction
            $conn->commit();

            echo "success";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        
    } else {
        // Handle case when data is not received from AJAX request
        echo "Error: Data not received from AJAX request.";
    }
?>
