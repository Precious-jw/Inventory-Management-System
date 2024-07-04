<?php
    require_once('security.php');
    require_once('initialize.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('includes/topbar.php');
    
    //print_r($_SERVER);
    $URL = explode("/", $_SERVER['REQUEST_URI']);

    //Check if a user exists in the database
    $select = $conn->prepare("SELECT * FROM users");
    $select->execute();
    $result = $select->get_result();

    if (file_exists("pages/".$URL[2]. ".php")){
        if($result->num_rows === 0){
            session_destroy();
            require_once("pages/register.php");
        } elseif (!isset($_SESSION['username'])) {
            require_once("pages/login.php");
        } else {
            require_once("pages/".$URL[2]. ".php");
        }
    } else {
        require_once("pages/dashboard.php");
    }

    include('includes/footer.php');
?>