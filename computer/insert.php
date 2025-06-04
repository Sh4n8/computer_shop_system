<?php include('../include/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Computer</title>
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
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-submit:hover {
      background-color: #45a049;
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
  <h2>Add New Computer</h2>
  <form action="insert-save.php" method="POST">
    <label for="computer_name">Computer Name:</label>
    <input type="text" id="computer_name" name="computer_name" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
      <option value="Available">Available</option>
      <option value="In Use">In Use</option>
      <option value="Offline">Offline</option>
      <option value="Maintenance">Maintenance</option>
    </select>

    <div class="form-buttons">
      <button type="submit" class="btn-submit">Save</button>
      <a href="computer.php" class="btn-cancel">Cancel</a>
    </div>
  </form>
</main>
</body>
</html>
