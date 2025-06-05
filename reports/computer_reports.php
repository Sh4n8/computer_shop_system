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

// --- START: Generate/update reports from sessions ---

// Aggregate data from tblsessions for completed sessions
$sql = "
    SELECT 
        DATE(start_time) AS report_date,
        computer_id,
        COUNT(*) AS total_sessions,
        SUM(duration_minutes) AS total_duration,
        SUM(cost) AS total_earnings
    FROM tblsessions
    WHERE status = 'completed'
    GROUP BY DATE(start_time), computer_id
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $report_date = $row['report_date'];
        $computer_id = $row['computer_id'];
        $total_sessions = $row['total_sessions'];
        $total_duration = $row['total_duration'];
        $total_earnings = $row['total_earnings'];

        // Check if report already exists for that date and computer
        $check = $conn->prepare("SELECT report_id FROM tblreports WHERE report_date = ? AND computer_id = ?");
        $check->bind_param("si", $report_date, $computer_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // Update existing report
            $update = $conn->prepare("UPDATE tblreports SET total_sessions = ?, total_duration = ?, total_earnings = ? WHERE report_date = ? AND computer_id = ?");
            $update->bind_param("iidsi", $total_sessions, $total_duration, $total_earnings, $report_date, $computer_id);
            $update->execute();
        } else {
            // Insert new report
            $insert = $conn->prepare("INSERT INTO tblreports (report_date, computer_id, total_sessions, total_duration, total_earnings) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("siiid", $report_date, $computer_id, $total_sessions, $total_duration, $total_earnings);
            $insert->execute();
        }
        $check->close();
    }
}
if ($result) {
    $result->free();
}
// --- END: Generate/update reports from sessions ---

// Filters
$filter_date = trim($_GET['date'] ?? '');
$filter_computer = trim($_GET['computer_id'] ?? '');

// Query building
$sql = "SELECT * FROM tblreports WHERE 1=1";

if (!empty($filter_date)) {
    $sql .= " AND report_date LIKE '%" . $conn->real_escape_string($filter_date) . "%'";
}

if (!empty($filter_computer)) {
    $sql .= " AND computer_id LIKE '%" . $conn->real_escape_string($filter_computer) . "%'";
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