<?php include "./includes/header.php";

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    include "./includes/404.php";
    include "./includes/footer.php";
    exit();
}

$orderId = $_GET['order_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT o.id AS order_id, o.total_price, o.email, o.shipping_name, o.shipping_address, o.shipping_city, o.shipping_province, o.shipping_postal_code, o.created_at, oi.product_id, p.name AS product_name, oi.quantity, oi.price AS item_price, p.image_url FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON p.id = oi.product_id WHERE o.id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$orderInfo = [];
$orderItems = [];

while ($row = $result->fetch_assoc()) {
    if (empty($orderInfo)) {
        $orderInfo = [
            'id' => $row['order_id'],
            'total_price' => $row['total_price'],
            'shipping_name' => $row['shipping_name'],
            'email' => $row['email'],
            'shipping_address' => $row['shipping_address'],
            'shipping_city' => $row['shipping_city'],
            'shipping_province' => $row['shipping_province'],
            'shipping_postal_code' => $row['shipping_postal_code'],
            'created_at' => $row['created_at'],
        ];
    }

    $orderItems[] = [
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'image_url' => $row['image_url'],
        'quantity' => $row['quantity'],
        'item_price' => $row['item_price'],
    ];
}
$subtotal = 0;
$taxRate = 0.13;
$shippingCost = 0.00;
$tax = 0;
$total = 0;
if (!empty($orderItems)) {
    foreach ($orderItems as $item) {
        $subtotal += $item['item_price'] * $item['quantity'];
    }
}
$tax = $subtotal * $taxRate;
?>
<div class="success-page">
    <div class="success-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="success-card">
                        <!-- Success Header -->
                        <div class="success-header">
                            <h1 class="success-title">Order Confirmed!</h1>
                            <p class="success-subtitle">Thank you for your purchase. Your order has been successfully
                                placed.</p>
                        </div>

                        <!-- Order Details -->
                        <div class="p-4">
                            <div class="order-details">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-2">
                                            <i class="bi bi-receipt text-primary me-2"></i>Order Number
                                        </h5>
                                        <div class="order-number">#<?= $orderInfo["id"]; ?></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-2">
                                            <i class="bi bi-calendar-check text-primary me-2"></i>Order Date
                                        </h5>
                                        <div class="fs-5"><?= $orderInfo["created_at"]; ?></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-2">
                                            <i class="bi bi-envelope text-primary me-2"></i>Confirmation Email
                                        </h5>
                                        <div class="text-muted">Sent to <?= $orderInfo["email"]; ?></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-2">
                                            <i class="bi bi-currency-dollar text-primary me-2"></i>Total Amount
                                        </h5>
                                        <div class="fs-4 fw-bold text-success">$<?= $orderInfo["total_price"]; ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Timeline -->
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <h4 class="mb-4">
                                        <i class="bi bi-truck text-primary me-2"></i>Order Status
                                    </h4>
                                    <div class="timeline">
                                        <div class="timeline-item active">
                                            <h6 class="fw-bold">Order Confirmed</h6>
                                            <p class="text-muted mb-0">Your order has been received and confirmed</p>
                                            <small class="text-success">Completed - Just now</small>
                                        </div>
                                        <div class="timeline-item pending">
                                            <h6 class="fw-bold">Processing</h6>
                                            <p class="text-muted mb-0">We're preparing your items for shipment</p>
                                            <small class="text-muted">Estimated: 1-2 business days</small>
                                        </div>
                                        <div class="timeline-item pending">
                                            <h6 class="fw-bold">Shipped</h6>
                                            <p class="text-muted mb-0">Your order is on its way</p>
                                            <small class="text-muted">Estimated: 2-3 business days</small>
                                        </div>
                                        <div class="timeline-item pending">
                                            <h6 class="fw-bold">Delivered</h6>
                                            <p class="text-muted mb-0">Package delivered to your address</p>
                                            <small class="text-muted">Estimated: 5-7 business days</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Information -->
                                <div class="col-lg-6">
                                    <h4 class="mb-4">
                                        <i class="bi bi-geo-alt text-primary me-2"></i>Shipping Details
                                    </h4>
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="fw-bold">Delivery Address</h6>
                                        <p class="mb-2">
                                            <?= $orderInfo["shipping_name"]; ?><br>
                                            <?= $orderInfo["shipping_address"]; ?><br>
                                            <?= $orderInfo["shipping_city"]; ?>
                                            , <?= $orderInfo["shipping_province"]; ?> <?= $orderInfo["shipping_postal_code"]; ?>
                                            <br>
                                            Canada
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Ordered Items -->
                            <div class="mt-4">
                                <h4 class="mb-4">
                                    <i class="bi bi-bag-check text-primary me-2"></i>Your Items
                                </h4>
                                <?php foreach ($orderItems as $item): ?>
                                    <div class="product-item">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="<?= $item["image_url"]; ?>" class="img-fluid rounded"
                                                     alt="<?= $item["product_name"]; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-1"><?= $item["product_name"]; ?></h6>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <span class="fw-bold">Qty: <?= $item["quantity"]; ?></span>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <span class="fw-bold fs-5">$<?= $item["item_price"] * $item["quantity"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Order Summary -->
                                <div class="bg-light p-3 rounded mt-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <span>$<?= number_format($subtotal, 2); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Shipping:</span>
                                                <span class="text-success">Free</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Tax:</span>
                                                <span>$<?= number_format($tax, 2); ?></span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <strong>Total:</strong>
                                                <strong class="text-success fs-4">$<?= number_format($orderInfo["total_price"], 2); ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./includes/footer.php"; ?>



