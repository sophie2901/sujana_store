<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "./includes/header.php";
require "../db/conn.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $users = $result->fetch_assoc();

    $stmt->close();
    if (empty($users)) {
        $_SESSION['error'] = "Invalid user ID.";
        header("Location: /admin/products.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid user ID.";
    header("Location: /admin/users.php");
    exit();
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/admin/users.php" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i>Back to Users
            </a>
            <form action="/controller/userController.php?action=delete" method="POST" enctype="multipart/form-data" class="deleteForm">
                <input type="hidden" name="id" value="<?php echo $users['id']; ?>">
                <button type="submit" class="btn btn-outline-danger" id="deleteProductButton">
                    <i class="bi bi-trash me-1"></i>Delete Users
                </button>
            </form>
        </div>
    </div>

    <!-- User Form -->
    <form action="/controller/userController.php?action=update&id=<?php echo $users['id']; ?>" method="POST"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $users['first_name']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $users['last_name']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $users['email']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Leave password fields empty to keep current password
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current">
                                    <button class="btn btn-outline-secondary togglePassword" type="button">
                                        <i class="bi bi-eye" id="toggleIcon1"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
                                    <button class="btn btn-outline-secondary togglePassword" type="button">
                                        <i class="bi bi-eye" id="toggleIcon2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Role</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="checkbox" name="is_admin" id="userRole" <?php echo $users['is_admin'] ? "checked" : ""; ?> class="form-check-input">
                            <label class="form-check-label" for="userRole">
                                Admin User
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="/admin/users.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update User</button>
        </div>
    </form>
</main>

<?php
include "./includes/footer.php";
?>
