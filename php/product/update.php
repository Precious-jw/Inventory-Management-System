<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_product_id'])) {
    $product_id = $_POST['update_product_id'];
    $product_name = $_POST['update_product'];
    $purchase_prices = $_POST['update_purchase_price'];
    $sale_prices = $_POST['update_sale_price'];
    $qty = $_POST['update_qty'];

    //Update the database
    $stmt_update = $conn->prepare("UPDATE product SET product_name=?, purchase_price=?, sale_price=?, product_qty=? WHERE id = ?");
    $stmt_update->bind_param("siiii", $product_name, $purchase_prices, $sale_prices, $qty, $product_id);

    if ($stmt_update->execute()) {
        $response['status'] = 'Product updated successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update Product';
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
