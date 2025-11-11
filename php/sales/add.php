<?php
    session_start();
    include("../../config/db_conn.php");

    $data = json_decode(file_get_contents("php://input"), true);

    if(isset($data['customer_name']) && isset($data['products']) && is_array($data['products'])) {
        $customer_name = $data['customer_name'];
        $customer_phone = $data['customer_phone'];
        $payment = $data['payment'];
        $paid = $data['paid'];
        $discount = $data['discount'];
        $grand_total = $data['grand_total'];
        $comments = $data['comments'];
        $products = $data['products'];

        foreach($products as $item) {
            $stmt = $conn->prepare("SELECT product_qty FROM product WHERE id = ?");
            $stmt->bind_param("i", $item['product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['product_qty'] < $item['quantity']) {
                $response['status'] = 'Insufficient stock for product: ' . $item['product_name'] . '. Only ' . $row['product_qty'] . ' available.';
                $response['status_code'] = 'error';
                echo json_encode($response);
                exit;
            }
            $stmt->close();
        }

        // Insert sale record
        $stmt = $conn->prepare("INSERT INTO sales (customer_name, customer_phone, payment_method, discount, paid, grand_total, comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdds", $customer_name, $customer_phone, $payment, $discount, $paid, $grand_total, $comments);
        if($stmt->execute()) {
            $sale_id = $conn->insert_id;
            $stmt->close();

            // Insert each product into sale_items
            foreach($products as $item) {
                $stmt_item = $conn->prepare("INSERT INTO sale_items (sale_id, product_id, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
                $stmt_item->bind_param("iiddd", $sale_id, $item['product_id'], $item['price'], $item['quantity'], $item['total']);
                $stmt_item->execute();
                $stmt_item->close();

                // Update product quantity
                $select = $conn->prepare("SELECT product_qty FROM product WHERE id = ?");
                $select->bind_param("i", $item['product_id']);
                $select->execute();
                $result = $select->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $qty_left = $row['product_qty'] - $item['quantity'];
                    $update = $conn->prepare("UPDATE product SET product_qty=? WHERE id=?");
                    $update->bind_param("di", $qty_left, $item['product_id']);
                    $update->execute();
                    $update->close();
                }
                $select->close();
            }

            $response['status'] = 'Sale added successfully.';
            $response['status_code'] = 'success';
        } else {
            $response['status'] = 'Failed to add new Sale';
            $response['status_code'] = 'error';
        }
        echo json_encode($response);
    } else {
        $response['status'] = 'Bad request';
        $response['status_code'] = 'error';
        echo json_encode($response);
    }
?>