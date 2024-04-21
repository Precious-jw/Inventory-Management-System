<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_product_id'])) {
    $product_id = $_POST['delete_product_id'];

    //Update the database
    $stmt_delete = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt_delete->bind_param("i", $product_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Product Deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to Delete Product';
        $response['status_code'] = 'error';
    }

    $stmt_delete->close();

    //Send JSON response
    echo json_encode($response);
} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    //Send JSON response
    echo json_encode($response);
}
