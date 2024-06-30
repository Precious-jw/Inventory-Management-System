<?php 
    session_start();
    include("../../config/db_conn.php");

    //LOGIN
    if(isset($_POST['username'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        //Check if the product is ready in the database
        $select = $conn->prepare("SELECT * FROM users WHERE username = ? or email = ?");
        $select->bind_param("ss", $username, $username);
        $select->execute();
        $result = $select->get_result();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                //Decrypt the password
                $confirm_pass = password_verify($password, $row['pass']);
                if($confirm_pass){
                    //Set the user's session variables
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["admin_name"] = $row['name'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["business_name"] = $row['business_name'];
                    $_SESSION["admin_address"] = $row['address'];
                    $_SESSION["phone"] = $row['phone'];
                    $_SESSION["role"] = $row['role'];

                    //Send a success message
                    $response['status'] = 'Login Successful.';
                    $response['status_code'] = 'success';
                } elseif ($password == $row['pass']) {
                    //Set the user's session variables
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["admin_name"] = $row['name'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["business_name"] = $row['business_name'];
                    $_SESSION["admin_address"] = $row['address'];
                    $_SESSION["phone"] = $row['phone'];
                    $_SESSION["role"] = $row['role'];

                    //Send a success message
                    $response['status'] = 'Login Successful.';
                    $response['status_code'] = 'success';
                } else {
                    $response['status'] = 'Invalid Username or password';
                    $response['status_code'] = 'error';
                }
            }
            
        } else {
            $response['status'] = 'Invalid Username or password';
            $response['status_code'] = 'error';
        }

        
        //Send JSON response
        echo json_encode($response);

    } else {

        $response['status'] = 'Bad request';
        $response['status_code'] = 'error';
        //Send JSON response
        echo json_encode($response);

    };


?>