<?php require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['role'] === 'admin') {
    header('Location: admindashboard.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT * FROM appointments WHERE user_id=? ORDER BY app_date DESC');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$apps = $stmt->get_result(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid"> <span class="navbar-brand">Online Appointment System</span>
            <div> <a href="index.php" class="text-light me-3">Home</a> <a href="book.php" class="text-light me-3">Book Appointment</a> <a href="logout.php" class="text-light">Logout</a> </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="mb-4">Your Appointments</h2>
        <table class="table table-bordered table-dark">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Action</th>
            </tr> <?php while ($r = $apps->fetch_assoc()): ?> <tr>
                    <td><?= htmlspecialchars($r['app_date']) ?></td>
                    <td><?= htmlspecialchars($r['app_time']) ?></td>
                    <td><?= htmlspecialchars($r['purpose']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($r['status'])) ?></td>
                    <td> <?php if ($r['status'] == 'pending'): ?> <a href="?cancel=<?= $r['id'] ?>" class="btn btn-outline-light btn-sm">Cancel</a> <?php else: ?> - <?php endif; ?> </td>
                </tr> <?php endwhile; ?>
        </table>
    </div>
</body>

</html>