<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "./includes/header.php";
require "../db/conn.php";

$stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
$stmt->execute();

$result = $stmt->get_result();

$products = $result->fetch_all(MYSQLI_ASSOC);
?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Products Management</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="/admin/product-create.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New Product
                </a>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card shadow">
            <div class="card-body">
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $product) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $product['image_url'] ?>" class="rounded me-3"
                                                 width="50"
                                                 height="50" alt="Product">
                                            <div>
                                                <div class="fw-bold"><a class="text-black" href="/admin/product-edit.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></div>
                                                <?php if ($product["description"]): ?>
                                                    <small class="text-muted"><?php echo substr($product['description'], 0, 50); ?>
                                                        ...</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $product['category'] ?></td>
                                    <td>$<?php echo $product['price'] ?></td>
                                    <td><?php echo $product['stock'] ?></td>
                                    <td><span class="badge bg-success"><?php echo $product['status'] ?></span></td>
                                    <td><?php echo date_format(date_create($product['created_at']), "Y-m-d") ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/product-edit.php?id=<?php echo $product['id'] ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="/controller/productController.php?action=delete" method="POST"
                                                  enctype="multipart/form-data" class="deleteForm">
                                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else:?>
                            <td><strong>No products available</strong></td>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


<?php
include "./includes/footer.php";
?>