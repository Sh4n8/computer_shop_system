<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "comp_shop_db";
$conn = new mysqli($host, $user, $pass, $db);

// Handle errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filters
$filter_date = $_GET['date'] ?? '';
$filter_computer = $_GET['computer_id'] ?? '';

// Query building
$sql = "SELECT * FROM tblreports WHERE 1=1";

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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        form {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <?php include('../include/index.php'); ?>

    <div style="margin-left: 260px; padding: 20px;">
        <h1>Reports</h1>
        <p>View total sales & session logs</p>

        <!-- Filter Form -->
        <form method="get">
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($filter_date) ?>">

            <label for="computer_id">Computer ID:</label>
            <input type="text" name="computer_id" value="<?= htmlspecialchars($filter_computer) ?>">

            <button type="submit">Filter</button>
            <a href="computer_reports.php">Reset</a>
        </form>

        <!-- Reports Table -->
        <table>
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Report Date</th>
                    <th>Computer ID</th>
                    <th>Total Sessions</th>
                    <th>Total Duration</th>
                    <th>Total Earnings</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['report_id'] ?></td>
                            <td><?= $row['report_date'] ?></td>
                            <td><?= $row['computer_id'] ?></td>
                            <td><?= $row['total_sessions'] ?></td>
                            <td><?= $row['total_duration'] ?></td>
                            <td><?= $row['total_earnings'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>

<?php $conn->close(); ?>