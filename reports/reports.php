<?php
// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "comp_shop_db"; // replace with your DB
$conn = new mysqli($host, $user, $pass, $db);

// Handle errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filters
$filter_date = $_GET['date'] ?? '';
$filter_computer = $_GET['computer_id'] ?? '';

// Query building
$sql = "SELECT * FROM reports WHERE 1=1";

if (!empty($filter_date)) {
    $sql .= " AND report_date = '" . $conn->real_escape_string($filter_date) . "'";
}

if (!empty($filter_computer)) {
    $sql .= " AND computer_id = '" . $conn->real_escape_string($filter_computer) . "'";
}

$result = $conn->query($sql);
?>

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
    <p>View total sales & session logsssss</p>
  </div>

</body>
</html>

<?php $conn->close(); ?>