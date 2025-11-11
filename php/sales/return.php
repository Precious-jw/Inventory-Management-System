<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['return_sale_id'])) {
    $sale_id = $_POST['return_sale_id'];

    //Return Quantity
    $res = $conn->prepare("SELECT product_id, quantity FROM sale_items WHERE sale_id = ?");
    $res->bind_param("i", $sale_id);
    $res->execute();
    $result = $res->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $pid = $row['product_id'];
        $qty = $row['quantity'];
        $update = $conn->prepare("UPDATE product SET product_qty = product_qty + ? WHERE id = ?");
        $update->bind_param("di", $qty, $pid);
        $update->execute();
        $update->close();
    }
    
    $res->close();

    // Delete related sale_items first
    $stmt_items = $conn->prepare("DELETE FROM sale_items WHERE sale_id = ?");
    $stmt_items->bind_param("i", $sale_id);
    $stmt_items->execute();
    $stmt_items->close();

    // Delete the sale record itself (or set deleted=1 if you want soft delete)
    $stmt_delete = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt_delete->bind_param("i", $sale_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Sale items returned successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to return sale';
        $response['status_code'] = 'error';
    }

    $stmt_delete->close();

    echo json_encode($response);
} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    echo json_encode($response);
}