<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_user_id'])) {
    $user_id = $_POST['update_user_id'];
    $name = $_POST['update_name'];
    $email = $_POST['update_email'];
    $phone = $_POST['update_phone'];
    $username = $_POST['update_username'];
    $password = $_POST['update_password'];
    $role = $_POST['update_role'];
    $hashed_pass = '';

    //hash admin's password
    if ($role == 2){
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_pass = $password;
    }

    //Update the database
    $stmt_update = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, username=?, pass=?, role=? WHERE id = ?");
    $stmt_update->bind_param("ssissii", $name, $email, $phone, $username, $hashed_pass, $role, $user_id);

    if ($stmt_update->execute()) {
        $response['status'] = 'User records updated successfully.';
        $response['status_code'] = 'success';
    } else {
        $response['status'] = 'Failed to update User records';
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
