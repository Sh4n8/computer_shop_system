<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "comp_shop_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Rate per minute (you can adjust this)
$rate_per_minute = 2;

// Handle end session
if (isset($_GET['end_id'])) {
  $session_id = $_GET['end_id'];

  // Get session data
  $result = $conn->query("SELECT * FROM tblsessions WHERE session_id = $session_id AND status = 'Ongoing'");
  $session = $result->fetch_assoc();

  if ($session) {
    $end_time = date('Y-m-d H:i:s');
    $start_time = strtotime($session['start_time']);
    $end_time_unix = strtotime($end_time);
    $duration_minutes = ceil(($end_time_unix - $start_time) / 60);
    $cost = $duration_minutes * $rate_per_minute;

    // Update session
    $stmt = $conn->prepare("UPDATE tblsessions SET end_time = ?, status = 'Completed', duration_minutes = ?, cost = ? WHERE session_id = ?");
    $stmt->bind_param("sidi", $end_time, $duration_minutes, $cost, $session_id);
    $stmt->execute();

    // Update computer status
    $stmt2 = $conn->prepare("UPDATE tblcomputer SET status = 'Available', last_updated = ? WHERE computer_id = ?");
    $stmt2->bind_param("si", $end_time, $session['computer_id']);
    $stmt2->execute();

    $success = "✅ Session ended successfully.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>End Session</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      margin-left: 260px;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ccc;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    .btn-end {
      background-color: #dc3545;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 5px;
    }

    .success {
      background-color: #d4edda;
      padding: 10px;
      border: 1px solid #c3e6cb;
      color: #155724;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>

  <?php include('../include/index.php'); ?>

  <div class="container">
    <h1>End Session</h1>
    <p>See the list of active sessions and click 'End' to stop them.</p>

    <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>

    <table>
      <tr>
        <th>#</th>
        <th>Computer</th>
        <th>User</th>
        <th>Start Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php
      $result = $conn->query("SELECT s.session_id, c.computer_name, s.user_name, s.start_time, s.status
                              FROM tblsessions s
                              JOIN tblcomputer c ON s.computer_id = c.computer_id
                              WHERE s.status = 'Ongoing'");

      if ($result->num_rows > 0) {
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$counter}</td>
                  <td>{$row['computer_name']}</td>
                  <td>{$row['user_name']}</td>
                  <td>{$row['start_time']}</td>
                  <td>{$row['status']}</td>
                  <td><a class='btn-end' href='end_session.php?end_id={$row['session_id']}'>End</a></td>
              </tr>";
          $counter++;
        }
      } else {
        echo "<tr><td colspan='6'>No ongoing sessions.</td></tr>";
      }
      ?>
    </table>
  </div>

</body>

</html>
