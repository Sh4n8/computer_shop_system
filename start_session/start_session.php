<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "comp_shop_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Form submission
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $computer_id = $_POST['computer_id'];
  $user_name = $_POST['user_name'];
  $start_time = date('Y-m-d H:i:s');

  // Insert session
  $stmt = $conn->prepare("INSERT INTO tblsessions (computer_id, user_name, start_time, status) VALUES (?, ?, ?, 'Ongoing')");
  $stmt->bind_param("iss", $computer_id, $user_name, $start_time);
  $stmt->execute();

  // Update computer status
  $stmt2 = $conn->prepare("UPDATE tblcomputer SET status = 'In Use', last_updated = ? WHERE computer_id = ?");
  $stmt2->bind_param("si", $start_time, $computer_id);
  $stmt2->execute();

  $success = "✅ Session started successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Start Session</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      margin-left: 260px;
      padding: 20px;
    }

    form {
      margin-top: 20px;
    }

    select,
    input[type="text"],
    input[type="submit"] {
      padding: 8px;
      margin-top: 10px;
      margin-bottom: 20px;
      width: 300px;
      display: block;
    }

    .success {
      background-color: #d4edda;
      padding: 10px;
      border: 1px solid #c3e6cb;
      width: fit-content;
      color: #155724;
      margin-bottom: 20px;
    }

    .btn-start {
      background-color: #f44336;
      /* same as the Edit button's orange */
      color: white;
      border: none;
      padding: 8px 16px;
      font-weight: 600;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.2s ease;
      width: fit-content;
    }

    .btn-start:hover {
      background-color: #ea580c;
      /* darker orange on hover */
    }
  </style>
</head>

<body>

  <?php include('../include/index.php'); ?>

  <div class="container">
    <h1>Start Session</h1>
    <p>Here you can start sessions of computers.</p>

    <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>

    <form method="post">
      <label>Select Computer:</label>
      <select name="computer_id" required>
        <?php
        $result = $conn->query("SELECT * FROM tblcomputer WHERE status = 'Available'");
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['computer_id']}'>{$row['computer_name']}</option>";
          }
        } else {
          echo "<option disabled>No available computers</option>";
        }
        ?>
      </select>

      <label>Your Name:</label>
      <input type="text" name="user_name" required>

      <button type="submit" class="btn-start">Start Session</button>
    </form>
  </div>

</body>

</html>