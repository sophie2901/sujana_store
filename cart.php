<?php include "./includes/header.php";
$cartItems = [];
$subtotal = 0;
$taxRate = 0.13;
$shippingCost = 0.00;
$tax = 0;
$total = 0;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // assume user is logged in

    $stmt = $conn->prepare("SELECT p.id AS product_id, p.name, p.price, p.image_url, p.stock, c.quantity, (p.price * c.quantity) AS total_price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?
");

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);

     // Free shipping

    if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
    }

    $tax = $subtotal * $taxRate;
    $total = $subtotal + $tax + $shippingCost;
}
?>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                <li class="breadcrumb-item active">Shopping Cart</li>
            </ol>
        </nav>
    </div>

    <!-- Cart Content -->
    <div class="container py-4">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Shopping Cart <?php if (!empty($cartItems)) {
                                echo "(" . count($cartItems) . " items)";
                            } ?></h4>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($cartItems)):
                            foreach ($cartItems as $item): ?>

                                <div class="border-bottom p-4">
                                    <form action="/controller/frontendController.php?action=removeFromCart"
                                          method="POST" enctype="multipart/form-data">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="<?php echo $item["image_url"]; ?>" class="img-fluid rounded"
                                                     alt="<?php echo $item["name"]; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="mb-1"><?php echo $item["name"]; ?></h6>
                                                <?php if ($item["stock"] > 0): ?>
                                                    <small class="text-success">In Stock</small>
                                                <?php else: ?>
                                                    <small class="text-danger">Out of Stock</small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group" style="width: 120px;">
                                                    <input type="hidden" name="product_id"
                                                           value="<?php echo $item["product_id"]; ?>">
                                                    <input type="number" name="quantity" disabled
                                                           class="form-control form-control-sm text-center"
                                                           value="<?php echo $item["quantity"]; ?>"
                                                           min="1">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <span class="h6 text-primary">$<?php echo $item["total_price"]; ?></span>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <h3>No items in cart.</h3>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="/products.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal <?= !empty($cartItems) ? "(" . count($cartItems) . " items)" : "" ?></span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span class="text-success"><?= $shippingCost == 0 ? "Free" : "$" . number_format($shippingCost, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax</span>
                            <span>$<?= number_format($tax, 2) ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary">$<?= number_format($total, 2) ?></strong>
                        </div>

                        <a href="/checkout.php" class="btn btn-primary w-100 btn-lg mb-3">
                            <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                        </a>

                        <!-- Payment Methods -->
                        <div class="text-center">
                            <small class="text-muted">We accept:</small>
                            <div class="mt-2">
                                <i class="bi bi-credit-card fs-4 me-2 text-primary"></i>
                                <i class="bi bi-paypal fs-4 me-2 text-primary"></i>
                                <i class="bi bi-apple fs-4 me-2 text-primary"></i>
                                <i class="bi bi-google fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check fs-1 text-success mb-2"></i>
                        <h6>Secure Checkout</h6>
                        <small class="text-muted">Your payment information is encrypted and secure</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "./includes/footer.php"; ?>