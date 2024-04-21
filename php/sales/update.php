<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_sales_id'])) {
    $sale_id = $_POST['update_sales_id'];
    $products = $_POST['update_product'];
    $quantity = $_POST['update_quantity'];
    $payment = $_POST['update_payment'];
    $customer_name = $_POST['update_customer_name'];
    $customer_phone = $_POST['update_customer_phone'];
    $prices = $_POST['update_total'];

    //Update the database
    $stmt = $conn->prepare("UPDATE sales SET products=?, quantity=?, payment_method=?, customer_name=?, customer_phone=?, total_price=? WHERE id = ?");
    $stmt->bind_param("sissiii", $products, $quantity, $payment, $customer_name, $customer_phone, $prices, $sale_id);

    if ($stmt->execute()) {
        $response['status'] = 'Sale record updated successfully';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update Sale record';
        $response['status_code'] = 'error';
    }

    $stmt_update->close();

    //Send JSON response
    echo json_encode($response);
} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    //Send JSON response
    echo json_encode($response);
}
