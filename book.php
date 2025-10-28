<?php require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['role'] === 'admin') {
    header('Location: admindashboard.php');
    exit;
}

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['app_date'];
    $time = $_POST['app_time'];
    $purpose = trim($_POST['purpose']);
    $uid = $_SESSION['user_id'];
    if (empty($date) || empty($time) || empty($purpose)) {
        $error = 'All fields are required.';
    } else {
        $stmt = $conn->prepare('INSERT INTO appointments (user_id, app_date, app_time, purpose) VALUES (?,?,?,?)');
        $stmt->bind_param('isss', $uid, $date, $time, $purpose);
        if ($stmt->execute()) {
            $success = 'Appointment booked successfully!';
        } else {
            $error = 'Error booking appointment.';
        }
    }
} ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid"> <span class="navbar-brand">Online Appointment System</span>
            <div> <a href="index.php" class="text-light me-3">Home</a> <a href="dashboard.php" class="text-light me-3">Dashboard</a> <a href="logout.php" class="text-light">Logout</a> </div>
        </div>
    </nav>
    <div class="container" style="max-width:500px;">
        <h2 class="text-center mb-4">Book an Appointment</h2> <?php if ($error): ?><p class="text-danger text-center"><?= htmlspecialchars($error) ?></p><?php endif; ?> <?php if ($success): ?><p class="text-success text-center"><?= htmlspecialchars($success) ?></p><?php endif; ?> <form method="post">
            <div class="mb-3"> <label>Date</label> <input type="date" class="form-control" name="app_date" required> </div>
            <div class="mb-3"> <label>Time</label> <input type="time" class="form-control" name="app_time" required> </div>
            <div class="mb-3"> <label>Purpose</label> <textarea class="form-control" name="purpose" required></textarea> </div> <button class="btn btn-glow w-100" type="submit">Book Now</button>
        </form>
    </div>
</body>

</html>