<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];

    //Update the database
    $stmt_delete = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt_delete->bind_param("i", $user_id);

    if ($stmt_delete->execute()) {
        $response['status'] = 'User record Deleted successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to Delete User';
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
