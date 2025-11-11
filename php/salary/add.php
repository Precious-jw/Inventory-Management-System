<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['staff_name'])){
        $staff_name = $_POST['staff_name'];
        $amount = $_POST['amount'];
        $month = $_POST['month'];
        $remark = $_POST['remarks'];
        $entered_by = $_SESSION["admin_name"];

        //Insert Expenses
        $stmt_insert = $conn->prepare("INSERT INTO salary (entered_by, staff_name, amount, month, remarks) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("ssdss", $entered_by, $staff_name, $amount, $month, $remark);

        if($stmt_insert->execute()){
            $response['status'] = 'Salary added successfully.';
            $response['status_code'] = 'success';
        } else {
            $response['status'] = 'Failed to add Salary';
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