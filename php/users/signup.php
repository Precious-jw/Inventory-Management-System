<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['admin_name'])){

        $name = $_POST['admin_name'];
        $email = $_POST['admin_email'];
        $business_name = $_POST['business_name'];
        $address = $_POST['admin_address'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = 2;

        //Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Insert Admin Details in the Database in database
        $stmt_insert = $conn->prepare("INSERT INTO users (name, email, business_name, address, phone, username, pass, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("ssssissi", $name, $email, $business_name, $address, $phone, $username, $hashed_password, $role);

        if($stmt_insert->execute()){
            $response['status'] = 'Registration Successful.';
            $response['status_code'] = 'success';
        } else {
            $response['status'] = 'Registration Unsuccessful';
            $response['status_code'] = 'error';
        }
        //Send JSON response
        echo json_encode($response);
    } else {
        $response['status'] = 'Bad request';
        $response['status_code'] = 'error';
        //Send JSON response
        echo json_encode($response);
    }

?>