<?php $URL = explode("/", $_SERVER['REQUEST_URI']);
    $activePage = file_exists("pages/".$URL[2]. ".php") ? $URL[2] : 'dashboard'; 
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">IMS</div>
    </a>

    <?php 
        if(isset($_SESSION["role"]) && $_SESSION["role"] == 2){

            echo('
                <div class="sidebar-heading">
                    Menu
                </div>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item '.($activePage == "dashboard" ? "active" : "").'">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                </li>


                <!-- Nav Item - Products -->
                <li class="nav-item '.($activePage == "product_master" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'product_master">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>


                <!-- Nav Item - Transactions -->
                <li class="nav-item '.($activePage == "sales" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'sales">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Sales</span>
                    </a>
                </li>

                <!-- Nav Item - Expenses -->
                <li class="nav-item '.($activePage == "expenses" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'expenses">
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                        <span>Expenses</span>
                    </a>
                </li>

                <!-- Nav Item - Transactions -->
                <li class="nav-item '.($activePage == "users" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'users">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
            
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>');
        } elseif(isset($_SESSION["role"]) && $_SESSION["role"] == 1) {

            echo('
                <div class="sidebar-heading">
                    Menu
                </div>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item '.($activePage == "dashboard" ? "active" : "").'">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                </li>


                <!-- Nav Item - Products -->
                <li class="nav-item '.($activePage == "product_master" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'product_master">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>


                <!-- Nav Item - Transactions -->
                <li class="nav-item '.($activePage == "sales" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'sales">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Sales</span>
                    </a>
                </li>

                <!-- Nav Item - Expenses -->
                <li class="nav-item '.($activePage == "expenses" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'expenses">
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                        <span>Expenses</span>
                    </a>
                </li>
                
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>');

        } elseif(isset($_SESSION["role"]) && $_SESSION["role"] == 0) {

            echo('
                <div class="sidebar-heading">
                    Menu
                </div>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item '.($activePage == "dashboard" ? "active" : "").'">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                </li>

                <!-- Nav Item - Transactions -->
                <li class="nav-item '.($activePage == "sales" ? "active" : "").'">
                    <a class="nav-link" href="'.base_url.'sales">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Sales</span>
                    </a>
                </li>
                
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>');

        } else {

            echo "";

        }

    ?>


    <!-- Nav Item - Pages Collapse Menu
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
        aria-expanded="true" aria-controls="collapseReports">
        <i class="fas fa-fw fa-cog"></i>
        <span>Reports</span>
    </a>
    <div id="collapseReports" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="#">Products</a>
            <a class="collapse-item" href="#">Sales</a>
            <a class="collapse-item" href="#">Purchases</a>
            <a class="collapse-item" href=" #">Inventory</a>
        </div>
    </div>
</li>
 -->


</ul>
<!-- End of Sidebar -->