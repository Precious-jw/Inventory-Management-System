<?php
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['sales_id'])){
        $id = $_POST['sales_id'];

        $stmt = $conn->prepare("SELECT * FROM sales WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = array();

        if($row = $result->fetch_assoc()){
            $response = $row;
            // Get sale items
            $items = [];
            $stmt_items = $conn->prepare("SELECT si.*, p.product_name FROM sale_items si JOIN product p ON si.product_id = p.id WHERE si.sale_id = ?");
            $stmt_items->bind_param("i", $id);
            $stmt_items->execute();
            $items_result = $stmt_items->get_result();
            while($item = $items_result->fetch_assoc()){
                $items[] = $item;
            }
            $response['items'] = $items;
            $stmt_items->close();
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
?>