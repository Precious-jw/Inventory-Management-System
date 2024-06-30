<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['customer_name'])){
        $customer_names = $_POST['customer_name'];
        $customer_phones = $_POST['customer_phone'];
        $products = $_POST['product'];
        $quantitys = $_POST['quantity'];
        $prices = $_POST['grand_total'];
        $payments = $_POST['payment'];

        //Loop the product array
        for($i = 0; $i < count($products); $i++){
            $customer_name = $customer_names[$i];
            $customer_phone = $customer_phones[$i];
            $product = $products[$i];
            $quantity = $quantitys[$i];
            $price = $prices[$i];
            $payment = $payments[$i];

            //Check if quantity entered is greater than quantity available
            $select = $conn->prepare("SELECT product_qty FROM product WHERE product_name = ?");
            $select->bind_param("s", $product);
            $select->execute();
            $result = $select->get_result();


            if ($result->num_rows > 0) {
                foreach($result as $row){
                    $available_qty = $row['product_qty'];
                    $entered_qty = $quantity;
                    if($entered_qty > $available_qty){
                        $response['status'] = 'This product has only "'.$available_qty.'" quantities left';
                        $response['status_code'] = 'error';
                    } else{
                        //Insert Product and update product quantity in database
                        $qty_left = $available_qty - $entered_qty;
                        $stmt_insert = $conn->prepare("INSERT INTO sales (customer_name, customer_phone, products, quantity, total_price, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt_insert->bind_param("sisiis", $customer_name, $customer_phone, $product, $entered_qty, $price, $payment);
                        $stmt_update = $conn->prepare("UPDATE product SET product_qty=? WHERE product_name = ?");
                        $stmt_update->bind_param("is", $qty_left, $product);
        
                        if($stmt_insert->execute()){
                            if($stmt_update->execute() == false){
                                $response['status'] = 'Failed to Update product quantity';
                                $response['status_code'] = 'error';
                            } else{
                                $response['status'] = 'Sale added successfully.';
                                $response['status_code'] = 'success';
                            }
                        } else {
                            $response['status'] = 'Failed to add new Sale';
                            $response['status_code'] = 'error';
                        }
                    } 
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