<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $product_code = $_POST['product_code'];
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $retail_price = $_POST['retail_price'];
        $quantity = $_POST['quantity'];
        $threshold = $_POST['threshold'];
        $company = $_POST['company_name'];

        //Check if the product is ready in the database
        $select = $conn->prepare("SELECT * FROM product WHERE product_name = ?");
        $select->bind_param("s", $product);
        $select->execute();
        $result = $select->get_result();

        if($result->num_rows > 0){
            $response['status'] = 'Product "'. $product.'" is already added';
            $response['status_code'] = 'error';
        } else {
            //Insert Product
            $stmt_insert = $conn->prepare("INSERT INTO product (product_name, product_code, purchase_price, sale_price, retail_price, product_qty, threshold, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("ssiiiiis", $product, $product_code, $purchase_price, $sale_price, $retail_price, $quantity, $threshold, $company);

            if($stmt_insert->execute()){
                $response['status'] = 'Product added successfully.';
                $response['status_code'] = 'success';
            } else {
                $response['status'] = 'Failed to add Product';
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