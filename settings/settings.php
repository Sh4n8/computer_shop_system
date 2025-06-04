<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  $errorMsg = "";

  $conn = new mysqli("localhost", "root", "", "comp_shop_db");
  if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
  }
  
  $conn = new mysqli("localhost", "root", "", "comp_shop_db");

  $res = $conn->query("SELECT * FROM shopsettings LIMIT 1");
  $settings = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Settings</title>
  <style>
    input {
      width: 50px;
      padding: 8px 8px;
      background-color: #41416b;
      border-radius: 4px;
      border: none;
      color: #fff;
      transition: ease-in-out 0.2s;
      outline: none;
    }

    input:focus {
      width: 50px;
      padding: 8px 8px;
      background-color: #eae8e8;
      border-radius: 4px;
      border: none;
      color: #000;
      transition: ease-in-out 0.2s;
      outline: none;
    }

    .login {
      width: 216px;
      padding: 8px 8px;
      box-sizing: border-box; /* make width include padding and border */
      background-color: #a8f7b5 !important;
      color: #000 !important;
      font-weight: bold;
      transition: ease-in-out 0.2s;
      cursor: pointer;
      border: none; /* just in case */
    }

    .login:hover {
      background-color: #89c794 !important;
      transition: ease-in-out 0.2s;
      cursor: pointer;
    }

    .formcont {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column; /* so your inputs stack vertically */
      height: 100vh; /* optional if u want it centered in the whole screen */
    }

    .stringfield {
      width: 200px !important;
    }
  </style>
</head>

<body>

  <?php include('../include/index.php'); ?>

  <div style="margin-left: 260px; padding: 20px;">
    <h1>Settings</h1>
    <p>Set hourly rate, shop info</p>
    <form method="POST">
      <label name="hrlyrate">Hourly Rate</label>
      <br>
      ₱ <input type="number" step="0.01" name="hrlyrate" value="<?= htmlspecialchars($settings['hourly_rate']) ?>">
      <br>
      <br>
      <label name="shopname">Shop Name</label>
      <br>
      <input type="text" name="shopname" value="<?= htmlspecialchars($settings['shop_name']) ?>" class="stringfield">
      <br>
      <br>
      <label name="contactemail">Contact Email</label>
      <br>
      <input type="text" name="contactemail" value="<?= htmlspecialchars($settings['contact_email']) ?>" class="stringfield">
      <br>
      <br>
      <br>
      <input type="submit" name="login" value="Save" class="login">
    </form>
  </div>
</body>
</html>
