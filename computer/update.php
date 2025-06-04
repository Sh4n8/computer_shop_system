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
  <title>Edit Computer</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
    form {
      max-width: 500px;
      margin: auto;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .form-buttons {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }

    .btn-submit {
      background-color: #ffa726;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-submit:hover {
      background-color: #fb8c00;
    }

    .btn-cancel {
      background-color: #9e9e9e;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-cancel:hover {
      background-color: #757575;
    }
  </style>
</head>
<body>
<?php include('../include/index.php'); ?>
<main>
  <h2>Edit Computer</h2>
  
  <?php if (isset($_GET['error']) && $_GET['error'] === 'name_taken'): ?>
    <p style="color: red; text-align: center;">Computer name already exists. Please choose a different name.</p>
  <?php endif; ?>

  <form action="update-save.php" method="POST">
    <input type="hidden" name="computer_id" value="<?php echo $row['computer_id']; ?>">

    <label for="computer_name">Computer Name:</label>
    <input type="text" id="computer_name" name="computer_name" value="<?php echo htmlspecialchars($row['computer_name']); ?>" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
      <?php
      $statuses = ['Available', 'In Use', 'Offline', 'Maintenance'];
      foreach ($statuses as $status) {
        $selected = ($row['status'] === $status) ? 'selected' : '';
        echo "<option value=\"$status\" $selected>$status</option>";
      }
      ?>
    </select>

    <div class="form-buttons">
      <button type="submit" class="btn-submit">Update</button>
      <a href="computer.php" class="btn-cancel">Cancel</a>
    </div>
  </form>
</main>
</body>
</html>
