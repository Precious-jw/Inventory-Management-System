<?php
    require_once('security.php');
    require_once('initialize.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('includes/topbar.php');

    //Check if the product is ready in the database
    $select = $conn->prepare("SELECT * FROM users");
    $select->execute();
    $result = $select->get_result();

    if($result->num_rows === 0){
        session_destroy();
        $pages = 'pages/register.php';
    } elseif (!isset($_SESSION['username'])){
        $pages = 'pages/login.php';
    } elseif (isset($_GET['page'])){
        $pages = 'pages/' . $_GET['page'] . '.php';
    } else {
        $pages = 'pages/dashboard.php';
    }

    if(file_exists($pages)){
        require_once $pages;
    }

    include('includes/footer.php');

?>