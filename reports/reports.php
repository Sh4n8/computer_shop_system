<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        form { margin-bottom: 15px; }
    </style>
</head>
<body>

  <?php include('../include/index.php'); ?>

  <div style="margin-left: 260px; padding: 20px;">
    <h1>Reports</h1>
    <p>View total sales & session logs</p>
  </div>

</body>
</html>

<?php $conn->close(); ?>