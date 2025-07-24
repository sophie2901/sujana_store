<?php
include "./includes/header.php";
require "../db/conn.php";

$sql = "SELECT o.id AS order_id, o.user_id, o.total_price, o.created_at, o.email, o.shipping_name, o.shipping_address, o.shipping_city, o.shipping_province, o.shipping_postal_code, oi.product_id, oi.quantity, oi.price AS item_price, p.name AS product_name, p.description, p.image_url FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id
";
$stmt = $conn->prepare($sql);

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
            'total_quantity' => 0,
            'products' => [],
            'product_names_concat' => ''
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

    $orderDetails[$orderId]['product_names_concat'] .= $row['product_name'] . ', ';
}

$stmt->close();
$conn->close();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders Management</h1>

    </div>

    <!-- Orders Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Date</th>
                        <th>Payment</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orderDetails as $orderId => $orderDetail) : ?>
                        <tr class="order-row">
                            <td>
                                <div class="fw-bold text-primary">#<?= $orderId; ?></div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold"><?= $orderDetail["shipping_name"]; ?></div>
                                        <small class="text-muted"><?= $orderDetail["email"]; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="order-details-preview">
                                    <div><?= $orderDetail["total_quantity"]; ?> items</div>
                                    <small class="text-muted">
                                        <?= $orderDetail["product_names_concat"]; ?>
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div><?= date_format(date_create($orderDetail["created_at"]), "Y-m-d"); ?></div>
                                <small class="text-muted"><?= date_format(date_create($orderDetail["created_at"]), "H:i A"); ?></small>
                            </td>
                            <td>
                                            <span class="badge bg-success status-badge">
                                                <i class="bi bi-check-circle me-1"></i>Paid
                                            </span>
                            </td>
                            <td>
                                <div class="fw-bold">$<?= $orderDetail["total_price"]; ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php
include "./includes/footer.php";
?>
