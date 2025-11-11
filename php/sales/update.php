<?php
session_start();
include("../../config/db_conn.php");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['update_sale_id']) && isset($data['products']) && is_array($data['products'])) {
    $sale_id = $data['update_sale_id'];
    $customer_name = $data['customer_name'];
    $customer_phone = $data['customer_phone'];
    $payment = $data['payment'];
    $paid = $data['paid'];
    $discount = $data['discount'];
    $total = $data['total'];    
    $comments = $data['comments'];
    $products = $data['products'];

    // Update sales table
    $stmt = $conn->prepare("UPDATE sales SET customer_name=?, customer_phone=?, payment_method=?, discount=?, paid=?, grand_total=?, comments=? WHERE id=?");
    $stmt->bind_param("ssssddsi", $customer_name, $customer_phone, $payment, $discount, $paid, $total, $comments, $sale_id);
    $stmt->execute();
    $stmt->close();

    // 1. Restore product quantities for old sale items
    $old_items = [];
    $res = $conn->query("SELECT product_id, quantity FROM sale_items WHERE sale_id = $sale_id");
    while ($row = $res->fetch_assoc()) {
        $old_items[$row['product_id']] = $row['quantity'];
    }
    foreach ($old_items as $pid => $qty) {
        // Add back the old quantity (use decimal binding)
        $update = $conn->prepare("UPDATE product SET product_qty = product_qty + ? WHERE id = ?");
        $update->bind_param("di", $qty, $pid);
        $update->execute();
        $update->close();
    }

    // Delete old sale_items
    $conn->query("DELETE FROM sale_items WHERE sale_id = $sale_id");


    // Insert new sale_items
    foreach($products as $item) {
        $stmt_item = $conn->prepare("INSERT INTO sale_items (sale_id, product_id, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
        $stmt_item->bind_param("iiddi", $sale_id, $item['product_id'], $item['price'], $item['quantity'], $item['total']);
        $stmt_item->execute();
        $stmt_item->close();

        // Update product quantity (implement logic to handle stock correctly)
        
        // Subtract the new quantity (use decimal binding)
        $update = $conn->prepare("UPDATE product SET product_qty = product_qty - ? WHERE id = ?");
        $update->bind_param("di", $item['quantity'], $item['product_id']);
        $update->execute();
        $update->close();
        // ...
    }

    $response['status'] = 'Sale updated successfully.';
    $response['status_code'] = 'success';
    echo json_encode($response);
} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    echo json_encode($response);
}
?>