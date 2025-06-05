<?php include('../include/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Computers</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
    .search-box {
      margin: 30px 0;
      display: flex;
      gap: 10px;
    }

    .search-box input[type="text"] {
      padding: 8px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .search-box button {
      background-color: #f44336;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
    }

    .search-box button:hover {
      background-color: #d32f2f;
    }

    .btn-red {
      background-color:  #f44336;
      color: white;
      border: none;
      padding: 8px 15px;
      cursor: pointer;
      border-radius: px;
      text-decoration: none;
      display: inline-block;
      font-weight: bold;
    }

    .status-indicator {
      display: flex;
      align-items: center;
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
  </style>
</head>
<body>
<?php include('../include/index.php'); ?>
<main>
  <h2>Search Computers</h2>

  <form method="GET" class="search-box">
    <input type="text" name="query" placeholder="Search by name or status..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
    <button type="submit">Search</button>
    <a href="computer.php" class="btn-red" style="margin-left: auto;">← Back to List</a>
  </form>

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
      if (isset($_GET['query']) && trim($_GET['query']) !== '') {
        $q = $conn->real_escape_string($_GET['query']);
        $sql = "SELECT * FROM tblcomputer 
                WHERE computer_name LIKE '%$q%' OR status LIKE '%$q%'
                ORDER BY computer_id ASC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
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
          echo '<tr><td colspan="5">No results found for "<strong>' . htmlspecialchars($q) . '</strong>".</td></tr>';
        }
      } else {
        echo '<tr><td colspan="5">Please enter a search term above.</td></tr>';
      }
    ?>
    </tbody>
  </table>
</main>
</body>
</html>
