<?php

session_start();
include("../../config/db_conn.php");

if(isset($_POST['dateFrom']) || isset($_POST['dateTo'])){
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    $stmt = $conn->prepare("SELECT * FROM expenses WHERE date BETWEEN '$dateFrom' AND '$dateTo'");
    $stmt->execute();

    $result = $stmt->get_result();
    $response = array();

    while($row = $result->fetch_assoc()){
        $response = $row;
    }

    //Check if any rows were found
    if(!empty($response)){
        echo json_encode($response);
    } else {
        $response['status'] = 200;
        $response['status_code'] ="Data not found.";
        echo json_encode($response);
    }
} else {
    $response['status'] = 400;
    $response['status_code'] ="Bad Request.";
    echo json_encode($response);
}