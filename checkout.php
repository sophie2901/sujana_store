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

    <div class="container py-5">
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
        <form action="/controller/frontendController.php?action=checkout"
              method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- Checkout Form -->
                <div class="col-lg-8">
                    <!-- Shipping Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-truck me-2"></i>Shipping Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="123 Main Street"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <select class="form-select" id="state" name="state" required>
                                            <option value="">Select Province</option>
                                            <option value="AB">Alberta</option>
                                            <option value="BC">British Columbia</option>
                                            <option value="MB">Manitoba</option>
                                            <option value="NB">New Brunswick</option>
                                            <option value="NL">Newfoundland and Labrador</option>
                                            <option value="NS">Nova Scotia</option>
                                            <option value="ON">Ontario</option>
                                            <option value="PE">Prince Edward Island</option>
                                            <option value="QC">Quebec</option>
                                            <option value="SK">Saskatchewan</option>
                                            <option value="NT">Northwest Territories</option>
                                            <option value="NU">Nunavut</option>
                                            <option value="YT">Yukon</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zip" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control" id="zip" name="zip" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-credit-card me-2"></i>Payment Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="cardDetails">
                                <div class="mb-3">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber"
                                           placeholder="1234 5678 9012 3456" name="card_number" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiryDate" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiryDate" name="expiry_date" placeholder="MM/YY"
                                               required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="123" name="cvv" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="cardName" class="form-label">Name on Card</label>
                                    <input type="text" class="form-control" id="cardName" name="card_name" required>
                                </div>
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
                            <div class="mb-3">
                                <?php foreach ($cartItems as $item) : ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-2">
                                            <img src="<?= $item["image_url"]; ?>" class="img-fluid rounded me-3"
                                                 alt="<?= $item["name"]; ?>">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><?= $item["name"]; ?></h6>
                                            <small class="text-muted">Qty: <?= $item["quantity"]; ?></small>
                                        </div>
                                        <span>$<?= $item["total_price"]; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <hr>

                            <!-- Order Totals -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>$<?= number_format($subtotal, 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span class="text-success">Free</span>
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

                            <!-- Place Order Button -->
                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="bi bi-check-circle me-2"></i>Place Order
                            </button>

                            <!-- Security Badge -->
                            <div class="text-center">
                                <i class="bi bi-shield-check text-success me-2"></i>
                                <small class="text-muted">Secure 256-bit SSL encryption</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php include "./includes/footer.php"; ?>