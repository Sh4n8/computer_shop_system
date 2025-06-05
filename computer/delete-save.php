<?php
include('../include/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['computer_id'])) {
  $id = intval($_POST['computer_id']);

  $query = "DELETE FROM tblcomputer WHERE computer_id = $id";

  if ($conn->query($query)) {
    header("Location: computer.php");
    exit();
  } else {
    echo "Error deleting computer: " . $conn->error;
  }
} else {
  header("Location: computer.php");
  exit();
}
?>
