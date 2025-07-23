<?php
session_start();

require "../db/conn.php";
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category = trim($_POST['category']);
            $stock = intval($_POST['stock']);
            $status = ($_POST['status'] === 'active') ? 'active' : 'inactive';

            // Check required fields
            if (empty($name) || $price <= 0 || $stock < 0) {
                $_SESSION['error'] = "Please fill in valid product details.";
                header("Location: /admin/product-create.php");
                exit();
            }

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($imageExt, $allowedExts)) {
                    $_SESSION['error'] = "Only JPG, PNG, GIF, and WEBP images are allowed.";
                    header("Location: /admin/product-create.php");
                    exit();
                }

                $newFileName = uniqid('img_', true) . '.' . $imageExt;
                $uploadDir = '../uploads/';
                $uploadURL = '/uploads/' . $newFileName;
                $uploadPath = $uploadDir . $newFileName;

                if (!move_uploaded_file($imageTmp, $uploadPath)) {
                    $_SESSION['error'] = "Failed to upload image.";
                    header("Location: /admin/product-create.php");
                    exit();
                }

                $image_url = $uploadURL; // Store in DB
            } else {
                $_SESSION['error'] = "Image is required.";
                header("Location: /admin/product-create.php");
                exit();
            }

            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category, stock, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssis", $name, $description, $price, $image_url, $category, $stock, $status);

            if ($stmt->execute()) {
                $productId = $stmt->insert_id;
                $_SESSION['success'] = "Product added successfully!";
            } else {
                $_SESSION['error'] = "Database error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
            header("Location: /admin/product-edit.php?id=" . $productId);
            exit();
        } else {
            $_SESSION['error'] = "Invalid request.";
            header("Location: /admin/product-create.php");
            exit();
        }
    } elseif ($_GET['action'] == 'update' && isset($_GET['id']) && is_numeric($_GET['id'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category = trim($_POST['category']);
            $stock = intval($_POST['stock']);
            $status = trim($_POST['status']);

            $imagePath = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $targetDir = '../uploads/';
                $fileName = basename($_FILES["image"]["name"]);
                $targetFileURL = '/uploads/' . $fileName;
                $targetFilePath = $targetDir . $fileName;


                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $imagePath = $targetFileURL;
                    } else {
                        $_SESSION['error'] = "Failed to upload image.";
                        header("Location: product-edit.php?id=" . $id);
                        exit;
                    }
                } else {
                    $_SESSION['error'] = "Only JPG, JPEG, PNG, GIF files allowed.";
                    header("Location: product-edit.php?id=" . $id);
                    exit;
                }
            }

            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $stmt->close();

            if (!empty($product)) {
                $imageUrl = !empty($imagePath) ? $imagePath : $product['image_url'];

                $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, category = ?, stock = ?, status = ? WHERE id = ?");
                $stmt->bind_param("ssdssisi",
                    $name,
                    $description,
                    $price,
                    $imageUrl,
                    $category,
                    $stock,
                    $status,
                    $id
                );

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Product updated successfully!";
                    header("Location: /admin/product-edit.php?id=" . $_GET['id']);
                    exit();
                } else {
                    $_SESSION['error'] = "Product update failed.";
                    header("Location: /admin/product-edit.php?id=" . $_GET['id']);
                    exit();
                }
                $stmt->close();


            } else {
                $_SESSION['error'] = "Invalid request.";
                header("Location: /admin/product-edit.php?id=" . $_GET['id']);
                exit();
            }

        } else {
            $_SESSION['error'] = "Invalid request.";
            header("Location: /admin/product-edit.php?id=" . $_GET['id']);
            exit();
        }
    } elseif ($_GET['action'] == 'delete') {
        $productId = $_POST['id'];

        $stmt = $conn->prepare("SELECT image_url FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (!empty($row['image_url']) && file_exists($row['image_url'])) {
                unlink($row['image_url']); // deletes the image from server
            }
        }
        $stmt->close();

        // Delete from DB
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting product.";
        }

        $stmt->close();
        $conn->close();
        header("Location: /admin/products.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /admin/products.php");
    exit();
}