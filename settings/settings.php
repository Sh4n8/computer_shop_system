<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  $errorMsg = "";

  $conn = new mysqli("localhost", "root", "", "comp_shop_db");
  if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hourlyRate = floatval($_POST['hrlyrate']);
    $shopName = $conn->real_escape_string($_POST['shopname']);
    $contactEmail = $conn->real_escape_string($_POST['contactemail']);

    $updateQuery = "
      UPDATE shopsettings
      SET hourly_rate = $hourlyRate,
          shop_name = '$shopName',
          contact_email = '$contactEmail'
      LIMIT 1
    ";

    if ($conn->query($updateQuery) === TRUE) {
      // reload the updated data after saving
      $settings['hourly_rate'] = $hourlyRate;
      $settings['shop_name'] = $shopName;
      $settings['contact_email'] = $contactEmail;

      $savedSuccess = true;
    } else {
      $errorMsg = "Error updating settings: " . $conn->error;
    }
  }

  $res = $conn->query("SELECT * FROM shopsettings LIMIT 1");
  $settings = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop Settings</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f5f5;
      color: #333;
    }

    .container {
      margin-left: 260px;
      padding: 40px;
      max-width: 600px;
    }

    h1 {
      margin-bottom: 5px;
    }

    p {
      color: #666;
      margin-bottom: 30px;
    }

    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      font-size: 14px;
    }

    input[type="number"],
    input[type="text"] {
      width: 100%;
      max-width: 300px;
      padding: 10px;
      background-color: #41416b;
      border-radius: 6px;
      border: none;
      color: #fff;
      margin-bottom: 20px;
      transition: 0.2s ease-in-out;
      font-size: 14px;
    }

    input[type="number"]:focus,
    input[type="text"]:focus {
      background-color: #eae8e8;
      color: #000;
    }

    .peso {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .submit-btn {
      padding: 10px 20px;
      background-color: #a8f7b5;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.2s ease-in-out;
    }

    .submit-btn:hover {
      background-color: #89c794;
    }

    .slider-container {
      width: 250px;
      margin-top: 40px;
      user-select: none;
    }

    .slider-label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #fff;
    }

    .slider {
      width: 100%;
      -webkit-appearance: none;
      appearance: none;
      height: 40px;
      border-radius: 20px;
      background: #ddd;
      outline: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      background-color: #41416b;
    }

    .slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 40px;
      height: 40px;
      background: #a8f7b5;
      cursor: pointer;
      border-radius: 50%;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
      transition: background-color 0.3s ease;
      position: relative;
      z-index: 2;
    }

    .slider::-moz-range-thumb {
      width: 40px;
      height: 40px;
      background: #a8f7b5;
      cursor: pointer;
      border-radius: 50%;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
      position: relative;
      z-index: 2;
    }

    .slider:active::-webkit-slider-thumb {
      background-color: #89c794;
    }
  </style>
</head>

<body>
  <?php include('../include/index.php'); ?>

  <div class="container">
    <h1>Shop Settings</h1>
    <form method="POST">
      <label for="hrlyrate">Hourly Rate (₱)</label>
      <div class="peso">
        <input type="number" step="0.01" name="hrlyrate" id="hrlyrate" value="<?= htmlspecialchars(number_format($settings['hourly_rate'], 2)) ?>">
      </div>

      <label for="shopname">Shop Name</label>
      <input type="text" name="shopname" id="shopname" value="<?= htmlspecialchars($settings['shop_name']) ?>">

      <label for="contactemail">Contact Email</label>
      <input type="text" name="contactemail" id="contactemail" value="<?= htmlspecialchars($settings['contact_email']) ?>">

      <input type="submit" name="login" value="Save" class="submit-btn">
    </form>
    <?php if (!empty($savedSuccess)) : ?>
      <p style="color: white; margin-top: 10px;">✅ Changes saved!</p>
    <?php elseif (!empty($errorMsg)) : ?>
      <p style="color: red; margin-top: 10px;">⚠️ <?= htmlspecialchars($errorMsg) ?></p>
    <?php endif; ?>

    <div class="slider-container">
      <label for="logout-slider" class="slider-label">Slide to Log Out</label>
      <input type="range" min="0" max="100" value="0" id="logout-slider" class="slider">
    </div>
  </div>
  <script>
    const slider = document.getElementById('logout-slider');

    slider.addEventListener('input', () => {
      if (slider.value >= 95) {
        // just slide it to max, then redirect logout
        window.location.href = '../login/login.php'; // change path if needed
      }
    });
  </script>
</body>
</html>
