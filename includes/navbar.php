<?php
$stmt = $conn->prepare("SELECT DISTINCT category FROM products ORDER BY category ASC");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}
$stmt->close();

$cartCount = 0;

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $cartCount = $row['total_items'] ?? 0;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand fw-bold fs-3 text-primary" href="../index.php">
            <i class="bi bi-shop me-2"></i>Sujana's Store
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-medium" href="../index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                        Shop
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $cat) : ?>
                            <li><a class="dropdown-item"
                                   href="/products.php?category=<?php echo $cat; ?>"><?php echo $cat; ?></a></li>
                        <?php endforeach; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/products.php">All Products</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="/contact.php">Contact</a>
                </li>
            </ul>

            <!-- Right Side Actions -->
            <div class="d-flex align-items-center gap-2">
                <!-- Cart -->
                <a href="/cart.php" class="btn btn-outline-primary position-relative me-2">
                    <i class="bi bi-cart3"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cartCount; ?>
                        </span>
                    <?php endif; ?>
                </a>
                <?php if (empty($_SESSION['user_name'])): ?>
                    <!-- Login/Register -->
                    <div class="btn-group">
                        <a href="../login.php" class="btn btn-primary">Login</a>
                        <a href="../register.php" class="btn btn-outline-primary">Sign Up</a>
                    </div>
                <?php else: ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button"
                                data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline"><?php echo $_SESSION['user_name']; ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Welcome, <?php echo $_SESSION['user_name']; ?>!</h6></li>
                            <li><a class="dropdown-item" href="/order-history.php">
                                    <i class="bi bi-box-seam me-2"></i>My Orders
                                </a></li>
                            <li><a class="dropdown-item text-danger" href="/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <?php if (empty($_SESSION['user_name'])): ?>
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-primary fw-bold">
                <i class="bi bi-shop me-2"></i>Sujana's Store
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    <?php else: ?>
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="offcanvas-title text-primary fw-bold mb-0"><?php echo $_SESSION['user_name']; ?></h6>
                    <small class="text-muted"><?php echo $_SESSION['email']; ?></small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    <?php endif; ?>

    <div class="offcanvas-body">
        <!-- Search in Mobile -->
        <form class="mb-4" role="search">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Search products...">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Mobile Navigation Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active py-3 border-bottom" href="/index.php">
                    <i class="bi bi-house me-2"></i>Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 border-bottom" data-bs-toggle="collapse" href="#shopSubmenu">
                    <i class="bi bi-shop me-2"></i>Shop <i class="bi bi-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="shopSubmenu">
                    <ul class="list-unstyled ps-4">
                        <?php foreach ($categories as $cat) : ?>
                            <li><a class="nav-link py-2"
                                   href="/products.php?category=<?php echo $cat; ?>"><?php echo $cat; ?></a></li>
                        <?php endforeach; ?>
                        <li><a class="nav-link py-2" href="/products.php">All Products</a></li>
                    </ul>
                </div>
            </li>
            <?php if (empty($_SESSION['user_name'])): ?>
            <li class="nav-item">
                <a class="nav-link py-3 border-bottom" href="/contact.php">
                    <i class="bi bi-envelope me-2"></i>Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 border-bottom" href="/cart.php">
                    <i class="bi bi-cart3 me-2"></i>Cart
                </a>
            </li>
        </ul>

        <!-- Mobile Login/Register -->
        <div class="mt-4 d-grid gap-2">
            <a href="../login.php" class="btn btn-primary">Login</a>
            <a href="../register.php" class="btn btn-outline-primary">Sign Up</a>
        </div>
        <?php else: ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="/cart.php">
                        <i class="bi bi-cart3 me-2"></i>Cart <?php if ($cartCount > 0): echo '(' . $cartCount . ')'; endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="/order-history.php">
                        <i class="bi bi-box-seam me-2"></i>My Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="/contact.php">
                        <i class="bi bi-envelope me-2"></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Mobile Logout -->
            <div class="mt-4 d-grid">
                <a href="/logout.php" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>