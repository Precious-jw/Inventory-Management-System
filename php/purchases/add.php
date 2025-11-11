<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['description'])){
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $amount = $_POST['amount'];
        $entered_by = $_SESSION["admin_name"];

        //Insert Purchases
        $stmt_insert = $conn->prepare("INSERT INTO purchases (entered_by, descr, qty, amount) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("ssdd", $entered_by, $description, $quantity, $amount);

        if($stmt_insert->execute()){
            $response['status'] = 'Purchase added successfully.';
            $response['status_code'] = 'success';
        } else {
            $response['status'] = 'Failed to add Purchase';
            $response['status_code'] = 'error';
        }

        $stmt_insert->close();
        
        //Send JSON response
        echo json_encode($response);
    } else {
        $response['status'] = 'Bad request';
        $response['status_code'] = 'error';
        //Send JSON response
        echo json_encode($response);
    }
?>