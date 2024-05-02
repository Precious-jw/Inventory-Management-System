<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_sale_id'])) {
    $sale_id = $_POST['delete_sale_id'];

    //Update the database
    $stmt_delete = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt_delete->bind_param("i", $sale_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Sale record Deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to Delete Sale';
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
