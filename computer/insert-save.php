<?php
include('../include/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $computer_name = $conn->real_escape_string($_POST['computer_name']);
  $status = $conn->real_escape_string($_POST['status']);
  $last_updated = date('Y-m-d H:i:s');

  $query = "INSERT INTO tblcomputer (computer_name, status, last_updated)
            VALUES ('$computer_name', '$status', '$last_updated')";

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
