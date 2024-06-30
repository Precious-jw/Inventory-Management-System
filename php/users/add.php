<?php 
    session_start();
    include("../../config/db_conn.php");

    if(isset($_POST['name'])){
        $names = $_POST['name'];
        $emails = $_POST['email'];
        $phones = $_POST['phone'];
        $usernames = $_POST['username'];
        $passwords = $_POST['password'];
        $roles = $_POST['role'];
        $business_names = $_POST['business_name'];

        //Loop the product array
        for($i = 0; $i < count($names); $i++){
            $name = $names[$i];
            $email = $emails[$i];
            $phone = $phones[$i];
            $username = $usernames[$i];
            $password = $passwords[$i];
            $role = $roles[$i];
            $business_name = $business_names[$i];

            //Check if a user with the username or email already exists
            $select = $conn->prepare("SELECT * FROM users WHERE username = ? or email = ?");
            $select->bind_param("ss", $username, $email);
            $select->execute();
            $result = $select->get_result();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    if($email == $row['email']){
                        $response['status'] = 'The Email "'.$email.'" is already taken';
                        $response['status_code'] = 'error';
                    } elseif ($username == $row['username']){
                        $response['status'] = 'The Username "'.$username.'" is already taken';
                        $response['status_code'] = 'error';
                    }
                }
                
            } else {
                //Insert New User
                $stmt_insert = $conn->prepare("INSERT INTO users (name, email, business_name, phone, username, pass, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt_insert->bind_param("sssissi", $name, $email, $business_name, $phone, $username, $password, $role);

                if($stmt_insert->execute()){
                    $_SESSION['abc'] = $password;
                    $response['status'] = 'User added successfully.';
                    $response['status_code'] = 'success';
                } else {
                    $response['status'] = 'Failed to add User';
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