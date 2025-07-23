<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "./includes/header.php";
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/admin/products.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Products
            </a>
        </div>
    </div>

    <!-- Product Form -->
    <form action="/controller/productController.php?action=create" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<p style='color:red'>{$_SESSION['error']}</p>";
                            unset($_SESSION['error']);
                        } ?>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="description"
                                      rows="4"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <input type="text" class="form-control" id="productCategory" name="category" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productPrice" class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="productPrice" step="0.01" name="price"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="productStock" name="stock" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="productImages" class="form-label">Upload Images</label>
                            <input type="file" class="form-control" id="productImages" name="image" accept="image/*">
                            <div class="form-text">You can upload multiple images. First image will be the main image.
                            </div>
                        </div>

                        <div class="row" id="imagePreview">
                            <!-- Image previews will be shown here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Product Status -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="productStatus" class="form-label">Status</label>
                            <select class="form-select" id="productStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="/admin/products.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Product</button>
        </div>
    </form>
</main>

<?php
include "./includes/footer.php";
?>
