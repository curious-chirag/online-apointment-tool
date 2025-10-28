<?php require 'config.php';
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT id FROM users WHERE email=?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $error = 'Email already registered!';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?,?,?)');
        $stmt->bind_param('sss', $name, $email, $hashed);
        if ($stmt->execute()) {
            $success = 'Registration successful! You can now log in.';
        } else {
            $error = 'Error creating account.';
        }
    }
} ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Online Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid"> <span class="navbar-brand mb-0 h1">Online Appointment System</span> </div>
    </nav>
    <div class="container" style="max-width:450px;margin-top:80px;">
        <h2 class="text-center mb-4">Create Account</h2> <?php if ($error): ?><p class="text-danger text-center"><?= htmlspecialchars($error) ?></p><?php endif; ?> <?php if ($success): ?><p class="text-success text-center"><?= htmlspecialchars($success) ?></p><?php endif; ?> <form method="post">
            <div class="mb-3"> <label>Full Name</label> <input type="text" class="form-control" name="name" required> </div>
            <div class="mb-3"> <label>Email</label> <input type="email" class="form-control" name="email" required> </div>
            <div class="mb-3"> <label>Password</label> <input type="password" class="form-control" name="password" required> </div> <button type="submit" class="btn btn-glow w-100">Register</button>
            <p class="text-center mt-3 text-secondary">Already registered? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>

</html>