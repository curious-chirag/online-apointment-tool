<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT id, name, password, role FROM users WHERE email=?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $dbPass = $row['password'];
        $valid = false;

        if (password_verify($password, $dbPass) || $dbPass === md5($password)) {
            $valid = true;
        }

        if ($valid) {
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role']     = $row['role'];

            if ($row['role'] === 'admin') {
                header('Location: admindashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Invalid email or password.';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Online Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Online Appointment System</span>
        </div>
    </nav>

    <div class="container" style="max-width:400px;margin-top:80px;">
        <h2 class="text-center mb-4">User Login</h2>
        <?php if (!empty($error)): ?>
            <p class="text-danger text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-glow w-100">Login</button>
            <p class="text-center mt-3 text-secondary">
                Don't have an account? <a href="register.php">Register</a>
            </p>
        </form>
    </div>
</body>

</html>