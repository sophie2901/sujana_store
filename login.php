<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "./includes/header.php"; ?>

    <!-- Login Form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm mt-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h2 class="mt-3">Welcome Back</h2>
                            <p class="text-muted">Sign in to your account</p>
                        </div>

                        <form action="./controller/loginController.php" method="POST" enctype="multipart/form-data">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<p style='color:red'>{$_SESSION['error']}</p>";
                                unset($_SESSION['error']);
                            }
                            ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Enter your email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Enter your password" required>
                                    <button class="btn btn-outline-secondary togglePassword" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">Don't have an account? <a href="./register.php" class="text-decoration-none">Sign up here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "./includes/footer.php"; ?>