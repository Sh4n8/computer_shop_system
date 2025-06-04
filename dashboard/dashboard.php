<?php
include('../include/db.php');

// Sample queries (replace table names if needed)
$result1 = $conn->query("SELECT COUNT(*) AS total FROM tblcomputer");
$totalComputers = $result1->fetch_assoc()['total'];

//$result2 = $conn->query("SELECT COUNT(*) AS total FROM users"); // update if your user table has a different name
//$totalUsers = $result2->fetch_assoc()['total'];

$result3 = $conn->query("SELECT COUNT(*) AS total FROM tblsessions"); // update with actual session table
$totalSessions = $result3->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
    }
    .sidebar {
      width: 220px;
      background: #333;
      color: #fff;
      height: 100vh;
      padding: 20px 0;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      padding: 10px 20px;
    }
    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      display: block;
    }
    .sidebar ul li:hover {
      background: #444;
    }
    main {
      flex: 1;
      padding: 30px;
    }
    .cards {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }
    .card {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      width: 250px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card .icon {
      font-size: 40px;
      color: #007bff;
    }
    .card h3 {
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>COMSMS</h2>
    <ul>
      <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
      <li><a href="../computer/computer.php">Computers</a></li>
      <li><a href="../start_session/start_session.php">Start Session</a></li>
      <li><a href="../end_session/end_session.php">End Session</a></li>
      <li><a href="../service/service.php">Services</a></li>
      <li><a href="../reports/reports.php">Reports</a></li>
      <li><a href="../settings/settings.php">Settings</a></li>
    </ul>
  </div>

  <main>
    <h2>Dashboard</h2>
    <p>Welcome to the Computer Shop Management System</p>

    <div class="cards">
      <div class="card">
        <i class="fas fa-desktop icon"></i>
        <h3>Total Computers</h3>
        <p><?= $totalComputers ?></p>
      </div>

      <div class="card">
        <i class="fas fa-user icon"></i>
        <h3>Total Users</h3>
        <p><?= $totalUsers ?></p>
      </div>

      <div class="card">
        <i class="fas fa-receipt icon"></i>
        <h3>Total Sessions</h3>
        <p><?= $totalSessions ?></p>
      </div>
    </div>
  </main>
</body>
</html>
