<?php
include('../include/db.php');

// Total Computers
$result1 = $conn->query("SELECT COUNT(*) AS total FROM tblcomputer");
$totalComputers = $result1->fetch_assoc()['total'];

// Total Sessions
$result3 = $conn->query("SELECT COUNT(*) AS total FROM tblsessions");
$totalSessions = $result3->fetch_assoc()['total'];

// Active PCs
$activePCsQuery = $conn->query("SELECT COUNT(*) AS total FROM tblsessions WHERE status = 'Ongoing'");
if ($activePCsQuery && $row = $activePCsQuery->fetch_assoc()) {
    $activePCs = $row['total'];
}

// Completed Sessions
$completedSessionsResult = $conn->query("SELECT COUNT(*) AS total FROM tblsessions WHERE status = 'Completed'");
$completedSessions = $completedSessionsResult->fetch_assoc()['total'];

// Total Income
//$incomeResult = $conn->query("SELECT SUM(amount) AS total_income FROM tblsessions WHERE status = 'Completed'");
//$totalIncome = $incomeResult->fetch_assoc()['total_income'] ?? 0;
//?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* (CSS same as your existing) */
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #1e1e2f;
      margin: 0;
      color: #dcdcdc;
    }
    main {
      margin-left: 250px;
      padding: 30px;
    }
    h2 {
      color: #ffffff;
      margin-bottom: 10px;
    }
    .nav-bar {
      margin-bottom: 30px;
      display: flex;
      justify-content: center;
      gap: 16px;
      padding: 20px;
    }
    .nav-bar a {
      margin-right: 15px;
      text-decoration: none;
      color: #a0c9ff;
      font-weight: 500;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }
    .nav-bar a:hover {
      background-color: #2b2b44;
      color: #ffffff;
    }
    .nav-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 150px;
      height: 45px;
      background-color: #26263f;
      color: #8ecfff;
      border: 1px solid transparent;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      transition: all 0.25s ease;
    }
    .nav-btn:hover {
      border-color: #6fa8dc;
      color: #ffffff;
    }
    .nav-btn i {
      font-size: 16px;
    }
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }
    .card {
      padding: 20px;
      border-radius: 12px;
      background-color: #2c2c3e;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card .icon {
      font-size: 32px;
      margin-bottom: 12px;
      color: #6fa8dc;
    }
    .card h3 {
      color: #d1eaff;
      margin-bottom: 6px;
    }
    .card p {
      font-size: 22px;
      font-weight: bold;
      color: #ffffff;
    }
    .summary {
      margin-top: 40px;
      padding: 20px;
      background-color: #27273f;
      border-left: 6px solid #6fa8dc;
      border-radius: 6px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .summary h4 {
      margin-bottom: 12px;
      color: #8ecfff;
    }
    .summary p {
      margin: 6px 0;
      font-size: 16px;
      color: #d3efff;
    }
  </style>
</head>
<body>
  <?php include('../include/index.php'); ?>

  <main>
    <h2>Dashboard</h2>
    <p>Welcome to the Computer Shop Management System</p>

    <div class="nav-bar">
      <a href="../computer/computer.php" class="nav-btn"><i class="fas fa-desktop"></i> Computers</a>
      <a href="../start_session/start_session.php" class="nav-btn"><i class="fas fa-play"></i> Start Session</a>
      <a href="../end_session/end_session.php" class="nav-btn"><i class="fas fa-stop"></i> End Session</a>
      <a href="../reports/reports.php" class="nav-btn"><i class="fas fa-chart-line"></i> Reports</a>
      <a href="../settings/settings.php" class="nav-btn"><i class="fas fa-cog"></i> Settings</a>
    </div>

    <div class="cards">
      <div class="card">
        <i class="fas fa-desktop icon"></i>
        <h3>Total Computers</h3>
        <p><?= $totalComputers ?></p>
      </div>

      <div class="card">
        <i class="fas fa-receipt icon"></i>
        <h3>Total Sessions</h3>
        <p><?= $totalSessions ?></p>
      </div>
    </div>

    <div class="summary">
      <h4>📊 View Summary</h4>
      <p><strong>Active PCs:</strong> <?= $activePCs ?></p>
      <p><strong>Completed Sessions:</strong> <?= $completedSessions ?></p>
      <p><strong>Total Income:</strong> ₱<?= number_format($totalIncome, 2) ?></p>
    </div>
  </main>
</body>
</html>
