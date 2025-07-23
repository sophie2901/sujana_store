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
                } ?>
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
                                                <div class="fw-bold"><?php echo $product['name'] ?></div>
                                                <?php if ($product["description"]): ?>
                                                    <small class="text-muted"><?php echo substr($product['description'],0, 50); ?>...</small>
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
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteProduct(<?php echo $product['id'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
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
    </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete Product</button>
                </div>
            </div>
        </div>
    </div>


<?php
include "./includes/footer.php";
?>