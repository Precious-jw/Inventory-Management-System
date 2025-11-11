<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_purchase_id'])) {
    $purchase_id = $_POST['delete_purchase_id'];

    //Update the database and delete the purchase
    $stmt_delete = $conn->prepare("DELETE FROM purchases WHERE id = ?");
    $stmt_delete->bind_param("i", $purchase_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Purchase Deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to Delete Purchase';
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
