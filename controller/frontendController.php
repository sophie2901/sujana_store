<?php
session_start();

require "../db/conn.php";
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'addToCart') {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $userId = $_SESSION['user_id'];
            $productId = (int)$_POST['product_id'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Check if product exists and is active
            $stmt = $conn->prepare("SELECT id, stock FROM products WHERE id = ? AND status = 'active'");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if (!$product) {
                $_SESSION['error'] = "Product Not Found";
                header("Location: /products.php?error=ProductNotFound");
                exit();
            }
            if ($quantity > $product['stock']) {
                $_SESSION['error'] = "Insufficient Stock";
                header("Location: /product.php?id=" . $product['id']);
                exit();
            }

            // Check if product is already in cart
            $checkStmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
            $checkStmt->bind_param("ii", $userId, $productId);
            $checkStmt->execute();
            $existing = $checkStmt->get_result()->fetch_assoc();

            if ($existing) {
                // Update quantity
                $newQty = $existing['quantity'] + $quantity;
                $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                $updateStmt->bind_param("ii", $newQty, $existing['id']);
                $updateStmt->execute();
            } else {
                // Insert into cart
                $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insertStmt->bind_param("iii", $userId, $productId, $quantity);
                $insertStmt->execute();
            }
            $_SESSION['success'] = "Product added successfully!";
            header("Location: /cart.php");
            exit();
        }
        $_SESSION['error'] = "Invalid Request";
        header("Location: /products.php?error=InvalidRequest");
        exit();
    } else if ($_GET['action'] == 'removeFromCart') {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $userId = $_SESSION['user_id'];
            $productId = (int)$_POST['product_id'];
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $userId, $productId);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Item removed from cart.";
            } else {
                $_SESSION['error'] = "Failed to remove item from cart.";
            }

            $stmt->close();
            $conn->close();
            header("Location: /cart.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid request.";
            header("Location: /cart.php");
            exit();
        }
    } else if ($_GET['action'] == 'checkout') {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login.php");
            exit;
        }

        $name = $_POST['first_name'] . " " . $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $province = $_POST['state'];
        $postal = $_POST['zip'];

        $card = $_POST['card_number'];
        $exp = $_POST['expiry_date'];
        $cvc = $_POST['cvv'];

        if (empty($card) || empty($exp) || empty($cvc)) {
            $_SESSION['error'] = "Payment details invalid.";
            header("Location: /checkout.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT c.product_id, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);

        if (empty($cartItems)) {
            $_SESSION['error'] = "Cart is empty.";
            header("Location: /cart.php");
            exit();
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $taxRate = 0.13;
        $shippingCost = 0.00;
        $tax = $total * $taxRate;
        $total = $total + $tax + $shippingCost;

        $orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_price, email, shipping_name, shipping_address, shipping_city, shipping_province, shipping_postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $orderStmt->bind_param("idssssss", $userId, $total, $email, $name, $address, $city, $province, $postal);

        $orderStmt->execute();
        $orderId = $orderStmt->insert_id;

        $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cartItems as $item) {
            $itemStmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
            $itemStmt->execute();
        }

        $clearCartStmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clearCartStmt->bind_param("i", $userId);
        $clearCartStmt->execute();

        header("Location: /order-success.php?order_id=$orderId");
        exit;
    }
}
