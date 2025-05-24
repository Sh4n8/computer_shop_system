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
      <li class="<?= $currentPage == 'home.php' ? 'active' : '' ?>">
        <a href="../dashboard/home.php">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'computer.php' ? 'active' : '' ?>">
        <a href="../dashboard/computer.php">
          <i class="bi bi-pc-display"></i>
          <span>Computers</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'start_session.php' ? 'active' : '' ?>">
        <a href="../dashboard/session/start_session.php">
          <i class="bi bi-play-circle"></i>
          <span>Start Session</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'end_session.php' ? 'active' : '' ?>">
        <a href="../dashboard/session/end_session.php">
          <i class="bi bi-stop-circle"></i>
          <span>End Session</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'service.php' ? 'active' : '' ?>">
        <a href="../dashboard/service.php">
          <i class="bi bi-tools"></i>
          <span>Services</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'reports.php' ? 'active' : '' ?>">
        <a href="../dashboard/reports.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li>
      <li class="<?= $currentPage == 'settings.php' ? 'active' : '' ?>">
        <a href="../dashboard/settings.php">
          <i class="bi bi-gear"></i>
          <span>Settings</span>
        </a>
      </li>
    </ul>
  </div>
</body>

</html>