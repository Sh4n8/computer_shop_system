<?php
require_once __DIR__ . '/../tcpdf/tcpdf.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "comp_shop_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- START: Generate/update reports from sessions (tblreports) ---
$aggregateSQL = "
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

$aggregateResult = $conn->query($aggregateSQL);
if ($aggregateResult && $aggregateResult->num_rows > 0) {
    while ($row = $aggregateResult->fetch_assoc()) {
        $report_date = $row['report_date'];
        $computer_id = $row['computer_id'];
        $total_sessions = $row['total_sessions'];
        $total_duration = $row['total_duration'];
        $total_earnings = $row['total_earnings'];

        $check = $conn->prepare("SELECT report_id FROM tblreports WHERE report_date = ? AND computer_id = ?");
        $check->bind_param("si", $report_date, $computer_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $update = $conn->prepare("UPDATE tblreports SET total_sessions = ?, total_duration = ?, total_earnings = ? WHERE report_date = ? AND computer_id = ?");
            $update->bind_param("iidsi", $total_sessions, $total_duration, $total_earnings, $report_date, $computer_id);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO tblreports (report_date, computer_id, total_sessions, total_duration, total_earnings) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("siiid", $report_date, $computer_id, $total_sessions, $total_duration, $total_earnings);
            $insert->execute();
        }
        $check->close();
    }
}
// --- END: Reports sync ---

// Handle filters
$filter_date = $_GET['date'] ?? '';
$filter_computer = $_GET['computer_id'] ?? '';

$sql = "SELECT * FROM tblreports WHERE 1=1";
if (!empty($filter_date)) {
    $sql .= " AND report_date = '" . $conn->real_escape_string($filter_date) . "'";
}
if (!empty($filter_computer)) {
    $sql .= " AND computer_id = '" . $conn->real_escape_string($filter_computer) . "'";
}
$result = $conn->query($sql);

// If PDF export requested
if (isset($_GET['action']) && $_GET['action'] === 'pdf') {
    ob_start();
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    $html = '
    <h2>Sales & Session Reports</h2>
    <table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>#</th>
            <th>report_date</th>
            <th>computer_id</th>
            <th>total_sessions</th>
            <th>total_duration</th>
            <th>total_earnings</th>
        </tr>
    </thead>
    <tbody>';

    if ($result && $result->num_rows > 0) {
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
                <td>' . $counter++ . '</td>
                <td>' . $row['report_date'] . '</td>
                <td>' . $row['computer_id'] . '</td>
                <td>' . $row['total_sessions'] . '</td>
                <td>' . $row['total_duration'] . '</td>
                <td>' . $row['total_earnings'] . '</td>
            </tr>';
        }
    } else {
        $html .= '<tr><td colspan="6">No reports found.</td></tr>';
    }

    $html .= '</tbody></table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    ob_end_clean();
    $pdf->Output('report.pdf', 'I');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .btn-red,
        .btn-red:visited,
        .btn-red:active {
            background-color: #e74c3c;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            height: 35px;
            box-sizing: border-box;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-red:hover {
            background-color: #c0392b;
        }

        .btn-red .icon {
            width: 18px;
            height: 18px;
            margin-right: 6px;
            fill: white;
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

            <button type="submit" class="btn-red">Search</button>
            <a href="computer_reports.php" class="btn-red">Reset</a>
            <a href="computer_reports.php?action=pdf&date=<?= urlencode($filter_date) ?>&computer_id=<?= urlencode($filter_computer) ?>" class="btn-red">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 20h14v-2H5v2zm7-18l-6 6h4v6h4v-6h4l-6-6z" />
                </svg>
                Download PDF
            </a>
        </form>

        <!-- Reports Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Report Date</th>
                    <th>Computer ID</th>
                    <th>Total Sessions</th>
                    <th>Total Duration</th>
                    <th>Total Earnings</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
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