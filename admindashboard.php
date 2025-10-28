<?php
require 'config.php';

// Check login and role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle approve/cancel actions
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $stmt = $conn->prepare('UPDATE appointments SET status="approved" WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: admindashboard.php');
    exit;
}

if (isset($_GET['cancel'])) {
    $id = intval($_GET['cancel']);
    $stmt = $conn->prepare('UPDATE appointments SET status="cancelled" WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: admindashboard.php');
    exit;
}

// Fetch all appointments with user details
$q = 'SELECT a.*, u.name, u.email 
      FROM appointments a 
      JOIN users u ON a.user_id = u.id 
      ORDER BY a.app_date DESC, a.app_time DESC';
$res = $conn->query($q);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Online Appointment System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Admin Dashboard</span>
    <div>
      <a href="index.php" class="text-light me-3">Home</a>
      <a href="logout.php" class="text-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2 class="mb-4">All Appointments</h2>
  <table class="table table-bordered table-dark table-hover align-middle">
    <thead>
      <tr>
        <th>User</th>
        <th>Email</th>
        <th>Date</th>
        <th>Time</th>
        <th>Purpose</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['app_date']) ?></td>
        <td><?= htmlspecialchars($r['app_time']) ?></td>
        <td><?= htmlspecialchars($r['purpose']) ?></td>
        <td><?= htmlspecialchars(ucfirst($r['status'])) ?></td>
        <td>
          <?php if ($r['status'] === 'pending'): ?>
            <a href="?approve=<?= $r['id'] ?>" class="btn btn-glow btn-sm me-2">Approve</a>
            <a href="?cancel=<?= $r['id'] ?>" class="btn btn-outline-light btn-sm">Cancel</a>
          <?php else: ?>
            <span class="text-secondary">—</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
