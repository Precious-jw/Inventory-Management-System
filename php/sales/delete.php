<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_sale_id'])) {
    $sale_id = $_POST['delete_sale_id'];

    // Delete related sale_items first
    $stmt_items = $conn->prepare("DELETE FROM sale_items WHERE sale_id = ?");
    $stmt_items->bind_param("i", $sale_id);
    $stmt_items->execute();
    $stmt_items->close();

    // Delete the sale record itself (or set deleted=1 if you want soft delete)
    $stmt_delete = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt_delete->bind_param("i", $sale_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Sale record and items deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to delete sale';
        $response['status_code'] = 'error';
    }

    $stmt_delete->close();

    echo json_encode($response);
} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    echo json_encode($response);
}