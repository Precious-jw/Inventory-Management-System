<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['description'])){
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $entered_by = $_SESSION["admin_name"];

        //Insert Expenses
        $stmt_insert = $conn->prepare("INSERT INTO expenses (entered_by, descr, amount) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("ssd", $entered_by, $description, $amount);

        if($stmt_insert->execute()){
            $response['status'] = 'Expense added successfully.';
            $response['status_code'] = 'success';
        } else {
            $response['status'] = 'Failed to add Expense';
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