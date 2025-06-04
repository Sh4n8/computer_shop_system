<?php
  $errorMsg = "";

  $conn = new mysqli("localhost", "root", "", "comp_shop_db");
  if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM dbuser WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      if ($result->num_rows === 1) {
        // start session if you wanna keep them logged in
        session_start();
        $_SESSION['username'] = $username; // save username or whatever in session

        header("Location: ../dashboard/dashboard.php"); // redirect to dashboard or whatever page
        exit(); // stop executing the script after redirect
      }
    } else {
      $errorMsg = "⚠️ Invalid Username or Password!";
    }

    $stmt->close();
  }

  $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Settings</title>
  <link rel="stylesheet" href="../assets/style.css">

  <style>
    input {
      width: 300px;
      padding: 8px 8px;
      background-color: #41416b;
      border-radius: 4px;
      border: none;
      color: #fff;
      transition: ease-in-out 0.2s;
      outline: none;
    }

    input:focus {
      width: 300px;
      padding: 8px 8px;
      background-color: #eae8e8;
      border-radius: 4px;
      border: none;
      color: #000;
      transition: ease-in-out 0.2s;
      outline: none;
    }

    .login {
      width: 316px;
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

    label {
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="formcont">
    <h1>Admin Log-in</h1>
    <?php if ($errorMsg !== ""): ?>
      <div class="error-banner">
        <?= $errorMsg ?>
      </div>
    <?php endif; ?>
    <form method="POST">
      <label name="username">Username</label>
      <br>
      <input type="text" name="username" placeholder="Username" required>
      <br>
      <br>
      <label name="password">Password</label>
      <br>
      <div style="position: relative; display: inline-block;">
        <input type="password" name="password" placeholder="Password" id="passwordInput" required>
        <button type="button" id="showPass" style="
          position: absolute;
          right: 8px;
          top: 50%;
          transform: translateY(-50%);
          background: none;
          border: none;
          color: #ccc;
          cursor: pointer;
          font-size: 14px;
        ">👁️</button>
      </div>
      <br>
      <br>
      <br>
      <input type="submit" name="login" value="Log-in" class="login">
    </form>
  </div>
  <script>
    const passInput = document.getElementById('passwordInput')
    const showBtn = document.getElementById('showPass')

    showBtn.addEventListener('mousedown', () => {
      passInput.type = 'text'
    })

    showBtn.addEventListener('mouseup', () => {
      passInput.type = 'password'
    })

    // for if they move mouse away while holding down 👀
    showBtn.addEventListener('mouseleave', () => {
      passInput.type = 'password'
    })

    // for mobile: touch support
    showBtn.addEventListener('touchstart', (e) => {
      e.preventDefault() // prevent click behavior on mobile
      passInput.type = 'text'
    })

    showBtn.addEventListener('touchend', () => {
      passInput.type = 'password'
    })
  </script>
</body>
</html>
