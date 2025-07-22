<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h4 class="text-primary">
                <i class="bi bi-shop me-2"></i>Store Admin
            </h4>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active text-white" href="dashboard.html">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="products-index.html">
                    <i class="bi bi-box-seam me-2"></i>Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="users-index.html">
                    <i class="bi bi-people me-2"></i>Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="#">
                    <i class="bi bi-cart me-2"></i>Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="#">
                    <i class="bi bi-bar-chart me-2"></i>Analytics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="#">
                    <i class="bi bi-gear me-2"></i>Settings
                </a>
            </li>
        </ul>

        <hr class="text-white-50">

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <strong>Admin User</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
</nav>