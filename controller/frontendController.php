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
        }else {
            $_SESSION['error'] = "Invalid request.";
            header("Location: /cart.php");
            exit();
        }
    }
}
