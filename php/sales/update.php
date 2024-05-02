<?php
session_start();
include("../../config/db_conn.php");

if (isset($_POST['update_sale_id'])) {
    $sale_id = $_POST['update_sale_id'];
    $product = $_POST['update_product'];
    $quantity = $_POST['update_quantity'];
    $payment = $_POST['update_payment'];
    $customer_name = $_POST['update_customer_name'];
    $customer_phone = $_POST['update_customer_phone'];
    $price = $_POST['update_total'];

    //Return former product quantity to the database
    $select_sale = $conn->prepare("SELECT * FROM sales WHERE id = ?");
    $select_sale->bind_param("i", $sale_id);
    $select_sale->execute();
    $sale_result = $select_sale->get_result();

    if ($sale_result->num_rows > 0) {
        foreach ($sale_result as $sale_item) {
            $return_qty = $sale_item['quantity'];
            $return_product = $sale_item['products'];

            //Check if quantity entered is greater than quantity available
            $sel = $conn->prepare("SELECT * FROM product WHERE product_name = ?");
            $sel->bind_param("s", $return_product);
            $sel->execute();
            $sel_result = $sel->get_result();

            foreach ($sel_result as $prod_item) {
                $qty_update = $prod_item['product_qty'] + $return_qty;
                $entered_qty = $quantity;

                if ($return_product == $product) {
                    //START THE UPDATING PROCESS
                    if ($entered_qty > $qty_update) {
                        $response['status'] = 'This product has only "' . $qty_update . '" quantities left';
                        $response['status_code'] = 'error';
                    } else {
                        //Insert Product and update product quantity in database
                        $qty_left = $qty_update - $entered_qty;
                        $stmt_insert = $conn->prepare("UPDATE sales SET customer_name=?, customer_phone=?, products=?, quantity=?, total_price=?, payment_method=? WHERE id = ?");
                        $stmt_insert->bind_param("sisiisi", $customer_name, $customer_phone, $product, $quantity, $price, $payment, $sale_id);
                        $stmt_update = $conn->prepare("UPDATE product SET product_qty=? WHERE product_name = ?");
                        $stmt_update->bind_param("is", $qty_left, $product);

                        if ($stmt_insert->execute()) {
                            if ($stmt_update->execute() == false) {
                                $response['status'] = 'Failed to Update product quantity';
                                $response['status_code'] = 'error';
                            } else {
                                $response['status'] = 'Sale updated successfully.';
                                $response['status_code'] = 'success';
                            }
                        } else {
                            $response['status'] = 'Failed to update Sale';
                            $response['status_code'] = 'error';
                        }
                    }
                } else {
                    $select = $conn->prepare("SELECT product_qty FROM product WHERE product_name = ?");
                    $select->bind_param("s", $product);
                    $select->execute();
                    $result = $select->get_result();

                    if ($result->num_rows > 0) {
                        foreach ($result as $row) {
                            $available_qty = $row['product_qty'];
                            $entered_qty = $quantity;
                            $final_return_qty = $return_qty + $prod_item['product_qty'];
                            if ($entered_qty > $available_qty) {
                                $response['status'] = 'This product has only "' . $available_qty . '" quantities left';
                                $response['status_code'] = 'error';
                            } else {
                                //Update Sale and update product quantity in database
                                $qty_left = $available_qty - $entered_qty;
                                $stmt_return = $conn->prepare("UPDATE product SET product_qty=? WHERE product_name = ?");
                                $stmt_return->bind_param("is", $final_return_qty, $return_product);
                                $stmt_insert = $conn->prepare("UPDATE sales SET customer_name=?, customer_phone=?, products=?, quantity=?, total_price=?, payment_method=? WHERE id = ?");
                                $stmt_insert->bind_param("sisiisi", $customer_name, $customer_phone, $product, $quantity, $price, $payment, $sale_id);
                                $stmt_update = $conn->prepare("UPDATE product SET product_qty=? WHERE product_name = ?");
                                $stmt_update->bind_param("is", $qty_left, $product);

                                if ($stmt_return->execute()){
                                    if ($stmt_insert->execute()) {
                                        if ($stmt_update->execute() == false) {
                                            $response['status'] = 'Failed to Update product quantity';
                                            $response['status_code'] = 'error';
                                        } else {
                                            $response['status'] = 'Sale updated successfully.';
                                            $response['status_code'] = 'success';
                                        }
                                    } else {
                                        $response['status'] = 'Failed to update Sale';
                                        $response['status_code'] = 'error';
                                    }
                                } else {
                                    $response['status'] = 'Failed to return product to database';
                                    $response['status_code'] = 'error';
                                }
                                
                            }
                        }
                    }
                }
            }
        }
    } else {
        $response['status'] = 'Could not fetch sale from database';
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
