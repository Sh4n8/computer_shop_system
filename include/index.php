<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

  <div class="sidebar">
    <ul>
      <li class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
        <a href="../dashboard/dashboard.php">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'computer.php' ? 'active' : '' ?>">
        <a href="../computer/computer.php">
          <i class="bi bi-pc-display"></i>
          <span>Computers</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'start_session.php' ? 'active' : '' ?>">
        <a href="../start_session/start_session.php">
          <i class="bi bi-play-circle"></i>
          <span>Start Session</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'end_session.php' ? 'active' : '' ?>">
        <a href="../end_session/end_session.php">
          <i class="bi bi-stop-circle"></i>
          <span>End Session</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'reports.php' ? 'active' : '' ?>">
        <a href="../reports/reports.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'settings.php' ? 'active' : '' ?>">
        <a href="../settings/settings.php">
          <i class="bi bi-gear"></i>
          <span>Settings</span>
        </a>
      </li>
    </ul>
  </div>
</body>

</html>