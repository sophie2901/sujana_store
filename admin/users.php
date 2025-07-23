<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../db/conn.php";
include "./includes/header.php";

$stmt = $conn->prepare("SELECT users.id AS user_id, users.first_name, users.last_name, users.email, users.is_admin, COUNT(orders.id) AS total_orders FROM users LEFT JOIN orders ON users.id = orders.user_id GROUP BY users.id ORDER BY users.id ASC;
");
$stmt->execute();

$result = $stmt->get_result();

$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/admin/user-create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Users Table -->
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
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Orders</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($users)):
                        foreach ($users as $user) : ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></div>
                                            <small class="text-muted">ID: <?php echo $user['user_id']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $user['email']; ?></td>
                                <?php if ($user['is_admin']): ?>
                                    <td><span class="badge bg-danger">Admin</span></td>
                                <?php else: ?>
                                    <td><span class="badge bg-primary">Customer</span></td>
                                <?php endif; ?>
                                <td><?php echo $user['total_orders']; ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/user-edit.php?id=<?php echo $user['user_id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/controller/userController.php?action=delete" method="POST"
                                              enctype="multipart/form-data" class="deleteForm m-0">
                                            <input type="hidden" name="id" value="<?php echo $user['user_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else:?>
                        <td><strong>No users available</strong></td>
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
