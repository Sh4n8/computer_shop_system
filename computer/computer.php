<?php include('../include/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Computer Stations</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
    .status-indicator {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .status-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      display: inline-block;
    }

    .dot-Available { background-color: #4caf50; }
    .dot-InUse { background-color: #f44336; }
    .dot-Offline { background-color: #ffca28; }
    .dot-Maintenance { background-color: #9e9e9e; }

    .btn-add {
      display: inline-block;
      margin-bottom: 15px;
      color: #fff;
      background-color: #f44336;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .btn-add:hover {
      background-color: #d32f2f; 
    }

    .btn-action {
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 0.9em;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .btn-edit {
      background-color: #ffa726;
      color: white;
    }

    .btn-edit:hover {
      background-color: #fb8c00;
    }

    .btn-delete {
      background-color: #ef5350;
      color: white;
      margin-left: 8px;
    }

    .btn-delete:hover {
      background-color: #e53935;
    }

    .table-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
<?php include('../include/index.php'); ?>
<main>
  <div class="table-header-row">
    <div>
      <h2 style="margin: 0;">Computer Stations</h2>
      <p style="margin-top: 5px;">Manage your computer stations below.</p>
    </div>
    <a href="insert.php" class="btn-add">+ Add Computer</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>Computer ID</th>
        <th>Computer Name</th>
        <th>Status</th>
        <th>Last Updated</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT * FROM tblcomputer ORDER BY computer_id ASC";
        $result = $conn->query($query);

            //hfygggugu
        if (!$result) {
          echo '<tr><td colspan="5">Error: ' . $conn->error . '</td></tr>';
        } else if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $status = htmlspecialchars($row['status']);
            $dotClass = 'dot-' . str_replace(' ', '', $status);

            echo '<tr>
                    <td>' . htmlspecialchars($row['computer_id']) . '</td>
                    <td>' . htmlspecialchars($row['computer_name']) . '</td>
                    <td class="status-indicator">
                      <span class="status-dot ' . $dotClass . '"></span>' . $status . '
                    </td>
                    <td>' . htmlspecialchars($row['last_updated']) . '</td>
                    <td>
                      <a href="update.php?id=' . $row['computer_id'] . '" class="btn-action btn-edit">Edit</a>
                      <a href="delete.php?id=' . $row['computer_id'] . '" class="btn-action btn-delete" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                  </tr>';
          }
        } else {
          echo '<tr><td colspan="5">No computers found.</td></tr>';
        }
      ?>
    </tbody>
  </table>
</main>
</body>
</html>
 