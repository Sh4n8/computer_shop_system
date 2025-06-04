<?php
include('../include/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = intval($_POST['computer_id']);
  $computer_name = $conn->real_escape_string($_POST['computer_name']);
  $status = $conn->real_escape_string($_POST['status']);
  $last_updated = date('Y-m-d H:i:s');

  $query = "UPDATE tblcomputer 
            SET computer_name = '$computer_name', 
                status = '$status', 
                last_updated = '$last_updated' 
            WHERE computer_id = $id";

  if ($conn->query($query)) {
    header("Location: computer.php");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
} else {
  header("Location: computer.php");
  exit();
}
?>
