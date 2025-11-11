<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_purchases_id'])) {
    $purchases_id = $_POST['update_purchases_id'];
    $description = $_POST['update_description'];
    $quantity = $_POST['update_quantity'];
    $amount = $_POST['update_amount'];
    $entered_by = $_SESSION["admin_name"];

    //Update the database
    $stmt_update = $conn->prepare("UPDATE purchases SET entered_by=?, descr=?, qty=?, amount=? WHERE id = ?");
    $stmt_update->bind_param("ssddi", $entered_by, $description, $quantity, $amount, $purchases_id);

    if ($stmt_update->execute()) {
        $response['status'] = 'Purchase updated successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update Purchase';
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
