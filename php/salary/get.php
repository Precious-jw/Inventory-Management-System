<?php

session_start();
include("../../config/db_conn.php");

if(isset($_POST['salary_id'])){
    $id = $_POST['salary_id'];

    $stmt = $conn->prepare("SELECT * FROM salary WHERE id = ?");
    $stmt->bind_param("i", $id);
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