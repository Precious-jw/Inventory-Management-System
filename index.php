<?php
    require_once('security.php');
    require_once('initialize.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('includes/topbar.php');

    
    if(isset($_GET['page'])){
        $pages = 'pages/' . $_GET['page'] . '.php';
    } else {
        $pages = 'pages/dashboard.php';
    }

    if(file_exists($pages)){
        require_once $pages;
    }

    include('includes/footer.php');

?>