<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['description'])){
        $descriptions = $_POST['description'];
        $amounts = $_POST['amount'];
        $entered_by = $_SESSION["admin_name"];

        //Loop the product array
        for($i = 0; $i < count($descriptions); $i++){
            $description = $descriptions[$i];
            $amount = $amounts[$i];
           
            //Insert Expenses
            $stmt_insert = $conn->prepare("INSERT INTO expenses (entered_by, descr, amount) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("ssi", $entered_by, $description, $amount);

            if($stmt_insert->execute()){
                $response['status'] = 'Expense added successfully.';
                $response['status_code'] = 'success';
            } else {
                $response['status'] = 'Failed to add Expense';
                $response['status_code'] = 'error';
            }
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