<?php
    $base_url = "http://localhost/ws/";
    require_once('../class/crud.php');
    $mysqli = new crud;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: rgb(32, 33, 35);
    }

    .card {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 50px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      background-color: rgb(52, 53, 65);
      color: aliceblue;
    }
    h1 {
      color: aliceblue;
      font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>
    <h1>Websocket Chatapp</h1>
    <div class="card">
        <div class="card-body">
        <h3 class="card-title text-center">Register</h3>
        <form method="POST" action="">
            <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
        <?php
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Check if the email is already registered
            $condition = array('email' => $email);
            $existingUser = $mysqli->common_select('users', '*', $condition);
    
            if (!$existingUser['error'] && count($existingUser['data']) === 0) {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // Prepare the data for insertion
                $data = array(
                    'username' => $username,
                    'email' => $email,
                    'hashed_password' => $hashedPassword,
                    'role' => 'user' // Assuming a default role of 'user'
                );
    
                // Insert the new user into the database
                $result = $mysqli->common_create('users', $data);
    
                if (!$result['error']) {
                    echo "<script>window.location='login.php'</script>";
                } else {
                    echo $result['error'];
                }
            } else {
                echo "<script>alert('Email is already registered. Please use a different email.');</script>";
            }
        }
        ?>
        </div>
    </div>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
