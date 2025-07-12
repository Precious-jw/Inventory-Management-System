<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_expenses_id'])) {
    $expenses_id = $_POST['update_expenses_id'];
    $description = $_POST['update_description'];
    $amount = $_POST['update_amount'];
    $entered_by = $_SESSION["admin_name"];

    //Update the database
    $stmt_update = $conn->prepare("UPDATE expenses SET entered_by=?, descr=?, amount=? WHERE id = ?");
    $stmt_update->bind_param("ssii", $entered_by, $description, $amount, $expenses_id);

    if ($stmt_update->execute()) {
        $response['status'] = 'Expense updated successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update Expense';
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
