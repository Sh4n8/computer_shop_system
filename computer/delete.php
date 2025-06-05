<?php
include('../include/db.php');

if (!isset($_GET['id'])) {
  header("Location: computer.php");
  exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM tblcomputer WHERE computer_id = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
  echo "Computer not found.";
  exit();
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm Delete</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
    .delete-box {
      max-width: 600px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 8px;
      background-color: #1e1e2f;
      border: 1px solid #fff3f3;
    }

    .delete-box h2 {
      text-align: center;
      color: #fff3f3;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    table td {
      padding: 8px 10px;
      border-bottom: 1px solid #ddd;
    }

    .label {
      font-weight: bold;
      width: 150px;
    }

    .btn-row {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .btn-danger {
      background-color: #f44336;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-danger:hover {
      background-color: #d32f2f;
    }

    .btn-cancel {
      background-color: #9e9e9e;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }

    .btn-cancel:hover {
      background-color: #757575;
    }
  </style>
</head>
<body>
<?php include('../include/index.php'); ?>
<main>
  <div class="delete-box">
    <h2>Confirm Deletion</h2>
    <table>
      <tr>
        <td class="label">Computer ID:</td>
        <td><?php echo htmlspecialchars($row['computer_id']); ?></td>
      </tr>
      <tr>
        <td class="label">Computer Name:</td>
        <td><?php echo htmlspecialchars($row['computer_name']); ?></td>
      </tr>
      <tr>
        <td class="label">Status:</td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
      </tr>
      <tr>
        <td class="label">Last Updated:</td>
        <td><?php echo htmlspecialchars($row['last_updated']); ?></td>
      </tr>
    </table>

    <form action="delete-save.php" method="POST" class="btn-row">
      <input type="hidden" name="computer_id" value="<?php echo $row['computer_id']; ?>">
      <button type="submit" class="btn-danger">Yes, Delete</button>
      <a href="computer.php" class="btn-cancel">Cancel</a>
    </form>
  </div>
</main>
</body>
</html>