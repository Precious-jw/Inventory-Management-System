<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['product'])){
        $products = $_POST['product'];
        $purchase_prices = $_POST['purchase_price'];
        $sale_prices = $_POST['sale_price'];
        $quantities = $_POST['quantity'];

        //Loop the product array
        for($i = 0; $i < count($products); $i++){
            $product = $products[$i];
            $purchase_price = $purchase_prices[$i];
            $sale_price = $sale_prices[$i];
            $quantity = $quantities[$i];

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
                $stmt_insert = $conn->prepare("INSERT INTO product (product_name, purchase_price, sale_price, product_qty) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("siii", $product, $purchase_price, $sale_price, $quantity);

                if($stmt_insert->execute()){
                    $response['status'] = 'Product added successfully.';
                    $response['status_code'] = 'success';
                } else {
                    $response['status'] = 'Failed to add Product';
                    $response['status_code'] = 'error';
                }
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