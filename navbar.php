<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand fw-bold fs-3 text-primary" href="#home">
                <i class="bi bi-shop me-2"></i>Sujana's Store
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" href="./">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                            Shop
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#electronics">Electronics</a></li>
                            <li><a class="dropdown-item" href="#clothing">Clothing</a></li>
                            <li><a class="dropdown-item" href="#home-garden">Home & Garden</a></li>
                            <li><a class="dropdown-item" href="#sports">Sports & Outdoors</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#all-products">All Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#deals">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="./contact.php">Contact</a>
                    </li>
                </ul>

                <!-- Search Bar -->
                <form class="d-flex me-3" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search products..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Side Actions -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Cart -->
                    <a href="#cart" class="btn btn-outline-primary position-relative me-2">
                        <i class="bi bi-cart3"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>

                    <!-- Login/Register -->
                    <div class="btn-group">
                        <a href="./login.php" class="btn btn-primary">Login</a>
                        <a href="./register.php" class="btn btn-outline-primary">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-primary fw-bold">
                <i class="bi bi-shop me-2"></i>Sujana's Store
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Search in Mobile -->
            <form class="mb-4" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search products...">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Mobile Navigation Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active py-3 border-bottom" href="#home">
                        <i class="bi bi-house me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" data-bs-toggle="collapse" href="#shopSubmenu">
                        <i class="bi bi-shop me-2"></i>Shop <i class="bi bi-chevron-down float-end"></i>
                    </a>
                    <div class="collapse" id="shopSubmenu">
                        <ul class="list-unstyled ps-4">
                            <li><a class="nav-link py-2" href="#electronics">Electronics</a></li>
                            <li><a class="nav-link py-2" href="#clothing">Clothing</a></li>
                            <li><a class="nav-link py-2" href="#home-garden">Home & Garden</a></li>
                            <li><a class="nav-link py-2" href="#sports">Sports & Outdoors</a></li>
                            <li><a class="nav-link py-2" href="#all-products">All Products</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="#deals">
                        <i class="bi bi-tag me-2"></i>Deals
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="#about">
                        <i class="bi bi-info-circle me-2"></i>About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="#contact">
                        <i class="bi bi-envelope me-2"></i>Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom" href="#cart">
                        <i class="bi bi-cart3 me-2"></i>Cart (3)
                    </a>
                </li>
            </ul>

            <!-- Mobile Login/Register -->
            <div class="mt-4 d-grid gap-2">
                <a href="#login" class="btn btn-primary">Login</a>
                <a href="#register" class="btn btn-outline-primary">Sign Up</a>
            </div>
        </div>
    </div>