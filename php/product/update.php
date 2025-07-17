<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_product_id'])) {
    $product_id = $_POST['update_product_id'];
    $product_name = $_POST['update_product'];
    $product_code = $_POST['update_product_code'];
    $purchase_price = $_POST['update_purchase_price'];
    $sale_price = $_POST['update_sale_price'];
    $retail_price = $_POST['update_retail_price'];
    $qty = $_POST['update_qty'];
    $threshold = $_POST['update_threshold'];
    $company = $_POST['update_company'];

    //Update the database
    $stmt_update = $conn->prepare("UPDATE product SET product_name=?, product_code=?, purchase_price=?, sale_price=?, retail_price=?, product_qty=?, threshold=?, company=? WHERE id = ?");
    $stmt_update->bind_param("ssiiiiisi", $product_name, $product_code, $purchase_price, $sale_price, $retail_price, $qty, $threshold, $company, $product_id);

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
