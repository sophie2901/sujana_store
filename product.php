<?php include "./includes/header.php";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);

    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!empty($product)) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? AND id != ? ORDER BY created_at DESC LIMIT 6");
        $stmt->bind_param("si", $product['category'], $productId);

        $stmt->execute();
        $result = $stmt->get_result();

        $relatedProducts = [];
        while ($row = $result->fetch_assoc()) {
            $relatedProducts[] = $row;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    $product = [];
}
if (!empty($product)): ?>
    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="/products.php">Products</a></li>
                <li class="breadcrumb-item"><a
                            href="/products.php?category=<?php echo $product["category"]; ?>"><?php echo $product["category"]; ?></a>
                </li>
                <li class="breadcrumb-item active"><?php echo $product["name"]; ?></li>
            </ol>
        </nav>
    </div>


    <!-- Product Detail -->
    <div class="container py-4">
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
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body p-0">
                        <!-- Main Image -->
                        <div class="">
                            <img src="<?php echo $product["image_url"]; ?>" class="img-fluid w-100"
                                 alt="<?php echo $product["name"]; ?>" id="mainImage">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <form action="/controller/frontendController.php?action=addToCart" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <span class="badge bg-success mb-2"><?php if ($product["stock"] > 0): ?>In Stock<?php else: ?>Out of Stock<?php endif; ?></span>
                        <h1 class="h2 mb-3"><?php echo $product["name"]; ?>s</h1>

                        <!-- Price -->
                        <div class="mb-4">
                            <span class="h3 text-primary me-3">$<?php echo $product["price"]; ?></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p class="text-muted"><?php echo $product["description"]; ?></p>
                        </div>

                        <!-- Stock -->
                        <div class="mb-4">
                            <h5>Stock</h5>
                            <p class="text-muted"><?php echo $product["stock"]; ?> remaining</p>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <h6>Quantity</h6>
                            <div class="input-group" style="width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-
                                </button>
                                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                <input type="number" class="form-control text-center" name="quantity" value="1" min="1" id="quantity">
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mb-4">
                            <button class="btn btn-primary btn-lg flex-fill">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>

                        <!-- Shipping Info -->
                        <div class="border rounded p-3">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-truck text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted">Free Shipping</small><br>
                                            <small>Orders over $50</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted">Easy Returns</small><br>
                                            <small>30-day policy</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (!empty($relatedProducts)): ?>

            <!-- Related Products -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row g-4">
                        <?php foreach ($relatedProducts as $relatedProduct): ?>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm">
                                    <img src="<?php echo $relatedProduct["image_url"]; ?>" class="card-img-top"
                                         alt="<?php echo $relatedProduct["name"]; ?>">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo $relatedProduct["name"]; ?></h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h6 text-primary mb-0">$<?php echo $relatedProduct["price"]; ?></span>
                                            <a href="/product.php?id=<?php echo $relatedProduct["id"]; ?>"
                                               class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>

        function increaseQuantity() {
            const qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        }

        function decreaseQuantity() {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }
    </script>
<?php else:
    include "./includes/404.php";
endif; ?>

<?php include "./includes/footer.php"; ?>