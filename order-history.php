<?php include 'includes/header.php';
$orderDetails = [];
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];


    $sql = "SELECT o.id AS order_id, o.user_id, o.total_price, o.created_at, o.email, o.shipping_name, o.shipping_address, o.shipping_city, o.shipping_province, o.shipping_postal_code, oi.product_id, oi.quantity, oi.price AS item_price, p.name AS product_name, p.description, p.image_url FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = ?
";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    $stmt->execute();
    $result = $stmt->get_result();

    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderId = $row['order_id'];

        if (!isset($orderDetails[$orderId])) {
            // Initialize order data
            $orderDetails[$orderId] = [
                'order_id' => $row['order_id'],
                'user_id' => $row['user_id'],
                'total_price' => $row['total_price'],
                'created_at' => $row['created_at'],
                'email' => $row['email'],
                'shipping_name' => $row['shipping_name'],
                'shipping_address' => $row['shipping_address'],
                'shipping_city' => $row['shipping_city'],
                'shipping_province' => $row['shipping_province'],
                'shipping_postal_code' => $row['shipping_postal_code'],
                'products' => [],
                'total_quantity' => 0
            ];
        }

        $orderDetails[$orderId]['total_quantity'] = ($orderDetails[$orderId]['total_quantity'] ?? 0) + $row['quantity'];

        // Add product to order
        $orderDetails[$orderId]['products'][] = [
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'description' => $row['description'],
            'image_url' => $row['image_url'],
            'quantity' => $row['quantity'],
            'price' => $row['item_price']
        ];
    }

    $stmt->close();
    $conn->close();
} else {
    include 'includes/404.php';
    include 'includes/footer.php';
    exit();
}
?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold text-center mb-2">Order History</h1>
            <p class="text-center text-muted">Track and manage all your orders in one place</p>
        </div>
    </div>
    <?php if (!empty($orderDetails)): ?>
        <!-- Orders List -->
        <div class="orders-container">
            <?php foreach ($orderDetails as $orderId => $orderDetail): ?>
                <div class="card order-card">
                    <div class="order-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">Order #<?= $orderDetail["order_id"]; ?></h5>
                                <p class="mb-0 opacity-75">Placed on <?= date_format(date_create($orderDetail["created_at"]), "Y-m-d H:i A"); ?></p>
                            </div>
                            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                <div class="mt-2">
                                    <strong class="fs-4">$<?= $orderDetail["total_price"]; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-bag-check text-primary me-2"></i>Items Ordered
                                    (<?= $orderDetail["total_quantity"]; ?>)
                                </h6>
                                <?php foreach ($orderDetail["products"] as $product): ?>
                                    <div class="product-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img src="<?= $product["image_url"]; ?>" class="product-image"
                                                     alt="<?= $product["product_name"]; ?>">
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-1"><?= $product["product_name"]; ?></h6>
                                            </div>
                                            <div class="col-auto">
                                                <strong>$<?= $product["quantity"] * $product["price"]; ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <hr>

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <div>
                                        <strong>Shipping to:</strong><br>
                                        <small class="text-muted"><?= $orderDetail["shipping_address"] . ', ' . $orderDetail["shipping_city"] . ', ' . $orderDetail["shipping_province"] . ' ' . $orderDetail["shipping_postal_code"]; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>

        <!-- Empty State (hidden by default) -->
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            <h3>No orders found</h3>
            <p>You haven't placed any orders yet or no orders match your current filter.</p>
            <a href="/products.php" class="btn btn-primary">
                <i class="bi bi-shop me-2"></i>Start Shopping
            </a>
        </div>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
