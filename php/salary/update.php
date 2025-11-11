<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_salary_id'])) {
    $salary_id = $_POST['update_salary_id'];
    $staff_name = $_POST['update_staff_name'];
    $amount = $_POST['update_amount'];
    $month = $_POST['update_month'];
    $remark = $_POST['update_remarks'];
    $entered_by = $_SESSION["admin_name"];

    //Update the database
    $stmt_update = $conn->prepare("UPDATE salary SET entered_by=?, staff_name=?, amount=?, month=?, remarks=? WHERE id = ?");
    $stmt_update->bind_param("ssdssi", $entered_by, $staff_name, $amount, $month, $remark, $salary_id);

    if ($stmt_update->execute()) {
        $response['status'] = 'Salary updated successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update Salary';
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
