<?php include "./includes/header.php";
if (isset($_GET['category']) && !empty($_GET['category'])) {
    // Category filter applied
    $category = trim($_GET['category']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $category);
} else {
    // No category filter, get all products
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                <?php if (isset($_GET['category']) && !empty($_GET['category'])) : ?>
                    <li class="breadcrumb-item"><a href="/products.php">Products</a></li>
                    <li class="breadcrumb-item active"><?php echo $_GET['category']; ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active">Products</li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>

    <!-- Products Section -->
    <div class="container py-4">
        <div class="row">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p style='color:green'>{$_SESSION['success']}</p>";
                unset($_SESSION['success']);
            }
            ?>
            <!-- Products Grid -->
            <div class="col-lg-12">
                <div class="row g-4">
                    <?php foreach ($products as $product) : ?>
                        <!-- Product 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="<?php echo $product["image_url"]; ?>" class="card-img-top" alt="Product">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo $product["name"]; ?></h5>
                                    <p class="card-text text-muted"><?php echo $product["description"]; ?></p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <span class="h5 text-primary mb-0">$<?php echo $product["price"]; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="/product.php?id=<?php echo $product["id"]; ?>"
                                               class="btn btn-outline-primary flex-fill">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


<?php include "./includes/footer.php"; ?>