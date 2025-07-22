<?php include "./includes/header.php"; ?>

<!-- Breadcrumb -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Shopping Cart</li>
        </ol>
    </nav>
</div>

<!-- Cart Content -->
<div class="container py-4">
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Shopping Cart (3 items)</h4>
                </div>
                <div class="card-body p-0">
                    <!-- Cart Item 1 -->
                    <div class="border-bottom p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="/placeholder.svg?height=100&width=100" class="img-fluid rounded"
                                     alt="Wireless Headphones">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">Wireless Headphones</h6>
                                <p class="text-muted mb-1">Color: Black</p>
                                <small class="text-success">In Stock</small>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" value="1"
                                           min="1">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="h6 text-primary">$79.99</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="border-bottom p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="/placeholder.svg?height=100&width=100" class="img-fluid rounded"
                                     alt="Smart Watch">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">Smart Watch</h6>
                                <p class="text-muted mb-1">Color: Silver</p>
                                <small class="text-success">In Stock</small>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" value="1"
                                           min="1">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="h6 text-primary">$199.99</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item 3 -->
                    <div class="p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="/placeholder.svg?height=100&width=100" class="img-fluid rounded"
                                     alt="Bluetooth Speaker">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">Bluetooth Speaker</h6>
                                <p class="text-muted mb-1">Color: Blue</p>
                                <small class="text-success">In Stock</small>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" value="1"
                                           min="1">
                                    <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="h6 text-primary">$79.99</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="products.html" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                        </a>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Update Cart
                        </button>
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (3 items)</span>
                        <span>$359.97</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>$28.80</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-primary">$388.77</strong>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-3">
                        <label class="form-label">Promo Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter code">
                            <button class="btn btn-outline-secondary" type="button">Apply</button>
                        </div>
                    </div>

                    <a href="checkout.html" class="btn btn-primary w-100 btn-lg mb-3">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </a>

                    <!-- Payment Methods -->
                    <div class="text-center">
                        <small class="text-muted">We accept:</small>
                        <div class="mt-2">
                            <i class="bi bi-credit-card fs-4 me-2 text-primary"></i>
                            <i class="bi bi-paypal fs-4 me-2 text-primary"></i>
                            <i class="bi bi-apple fs-4 me-2 text-primary"></i>
                            <i class="bi bi-google fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Info -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check fs-1 text-success mb-2"></i>
                    <h6>Secure Checkout</h6>
                    <small class="text-muted">Your payment information is encrypted and secure</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recently Viewed -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4">You might also like</h4>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="/placeholder.svg?height=200&width=250" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h6 class="card-title">Gaming Mouse</h6>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 text-primary mb-0">$39.99</span>
                                <button class="btn btn-sm btn-outline-primary">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="/placeholder.svg?height=200&width=250" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h6 class="card-title">Wireless Charger</h6>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 text-primary mb-0">$29.99</span>
                                <button class="btn btn-sm btn-outline-primary">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="/placeholder.svg?height=200&width=250" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h6 class="card-title">Phone Case</h6>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 text-primary mb-0">$19.99</span>
                                <button class="btn btn-sm btn-outline-primary">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="/placeholder.svg?height=200&width=250" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h6 class="card-title">USB Cable</h6>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 text-primary mb-0">$12.99</span>
                                <button class="btn btn-sm btn-outline-primary">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./includes/footer.php"; ?>