<?php
include('../include/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $computer_name = $conn->real_escape_string($_POST['computer_name']);
  $status = $conn->real_escape_string($_POST['status']);
  $last_updated = date('Y-m-d H:i:s');      

  // Manually calculate next ID
  $check = "SELECT MAX(computer_id) AS max_id FROM tblcomputer";
  $result = $conn->query($check);
  $row = $result->fetch_assoc();
  $new_id = ($row['max_id'] === null) ? 1 : $row['max_id'] + 1;

  // Insert with manually set ID
  $query = "INSERT INTO tblcomputer (computer_id, computer_name, status, last_updated)
            VALUES ($new_id, '$computer_name', '$status', '$last_updated')";

  if ($conn->query($query)) {
    header("Location: computer.php");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
} else {
  header("Location: insert.php");
  exit();
}
?>
