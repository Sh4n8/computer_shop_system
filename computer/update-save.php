<?php
include('../include/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = intval($_POST['computer_id']);
  $computer_name = trim($_POST['computer_name']);
  $status = trim($_POST['status']);
  $last_updated = date('Y-m-d H:i:s');

  // Check if the name already exists for another computer
  $stmt = $conn->prepare("SELECT computer_id FROM tblcomputer WHERE computer_name = ? AND computer_id != ?");
  $stmt->bind_param("si", $computer_name, $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Duplicate name found
    header("Location: update.php?id=$id&error=name_taken");
    exit();
  }

  // Proceed with update
  $stmt = $conn->prepare("UPDATE tblcomputer SET computer_name = ?, status = ?, last_updated = ? WHERE computer_id = ?");
  $stmt->bind_param("sssi", $computer_name, $status, $last_updated, $id);

  if ($stmt->execute()) {
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