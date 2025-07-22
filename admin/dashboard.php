<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "./includes/header.php";
?>
<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-primary">
                <i class="bi bi-calendar me-1"></i>This week
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,247</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">892</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$45,678</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Products</h6>
                    <a href="products-index.html" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=40&width=40" class="rounded me-2" width="40"
                                             height="40" alt="Product">
                                        <div>
                                            <div class="fw-bold">Wireless Headphones</div>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                </td>
                                <td>$79.99</td>
                                <td>45</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=40&width=40" class="rounded me-2" width="40"
                                             height="40" alt="Product">
                                        <div>
                                            <div class="fw-bold">Smart Watch</div>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                </td>
                                <td>$199.99</td>
                                <td>23</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=40&width=40" class="rounded me-2" width="40"
                                             height="40" alt="Product">
                                        <div>
                                            <div class="fw-bold">Bluetooth Speaker</div>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                </td>
                                <td>$79.99</td>
                                <td>12</td>
                                <td><span class="badge bg-warning">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=40&width=40" class="rounded me-2" width="40"
                                             height="40" alt="Product">
                                        <div>
                                            <div class="fw-bold">Gaming Mouse</div>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                </td>
                                <td>$39.99</td>
                                <td>67</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                    <a href="users-index.html" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=32&width=32" class="rounded-circle me-2"
                                             width="32" height="32" alt="User">
                                        <div>
                                            <div class="fw-bold">John Doe</div>
                                        </div>
                                    </div>
                                </td>
                                <td>john@example.com</td>
                                <td>2024-01-15</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=32&width=32" class="rounded-circle me-2"
                                             width="32" height="32" alt="User">
                                        <div>
                                            <div class="fw-bold">Sarah Smith</div>
                                        </div>
                                    </div>
                                </td>
                                <td>sarah@example.com</td>
                                <td>2024-01-14</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=32&width=32" class="rounded-circle me-2"
                                             width="32" height="32" alt="User">
                                        <div>
                                            <div class="fw-bold">Mike Johnson</div>
                                        </div>
                                    </div>
                                </td>
                                <td>mike@example.com</td>
                                <td>2024-01-13</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg?height=32&width=32" class="rounded-circle me-2"
                                             width="32" height="32" alt="User">
                                        <div>
                                            <div class="fw-bold">Emma Wilson</div>
                                        </div>
                                    </div>
                                </td>
                                <td>emma@example.com</td>
                                <td>2024-01-12</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include "./includes/footer.php";
?>