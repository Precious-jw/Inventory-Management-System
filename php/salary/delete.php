<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_salary_id'])) {
    $salary_id = $_POST['delete_salary_id'];

    //Update the database
    $stmt_delete = $conn->prepare("DELETE FROM salary WHERE id = ?");
    $stmt_delete->bind_param("i", $salary_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'Salary Deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to Delete Salary';
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
