<?php $activePage = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">IMS</div>
</a>

<!-- Heading -->
<div class="sidebar-heading">
    Menu
</div>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= $activePage == 'dashboard' ? 'active' : '' ?>">
    <a class="nav-link" href="./">  
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>


<!-- Nav Item - Products -->
<li class="nav-item <?= $activePage == 'product_master' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url ?>?page=product_master">
        <i class="fas fa-box"></i>
        <span>Products</span>
    </a>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $activePage == 'sales.php' || $activePage == 'purchases' ? 'active' : '' ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactions"
        aria-expanded="true" aria-controls="collapseTransactions">
        <i class="fas fa-fw fa-cog"></i>
        <span>Transactions</span>
    </a>
    <div id="collapseTransactions" class="collapse <?= $activePage == 'sales' || $activePage == 'purchases' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $activePage == 'sales' ? 'active' : '' ?>" href="<?= base_url ?>?page=sales">Sales</a>
            <a class="collapse-item <?= $activePage == 'purchases' ? 'active' : '' ?>" href="<?= base_url ?>?page=purchases">Purchases</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
        aria-expanded="true" aria-controls="collapseReports">
        <i class="fas fa-fw fa-cog"></i>
        <span>Reports</span>
    </a>
    <div id="collapseReports" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="?page=#">Products</a>
            <a class="collapse-item" href="?page=#">Sales</a>
            <a class="collapse-item" href="?page=#">Purchases</a>
            <a class="collapse-item" href="?page= #">Inventory</a>
        </div>
    </div>
</li>
 -->


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->