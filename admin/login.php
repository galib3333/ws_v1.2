<?php
session_start();
$base_url = "http://localhost/ws/";
require_once('../class/crud.php');
$mysqli = new crud;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <!-- Google Material Design Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
      <h3 class="card-title text-center">Login</h3>
      <form method="POST" action="../index.html">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Enter password">
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Sign In</button>
        </div>
        <div class="text-center mt-3">
          <span class="material-icons">lock</span>
          <a href="#">Forgot password?</a>
        </div>
        <div class="text-center mt-3">
          <p>Not registered? <a href="register_process.php">Register here</a></p>
        </div>
      </form>
      <?php
        if ($_POST) {
          $email = $_POST['email'];
          $password = $_POST['password'];
      
          // Query the database to retrieve the user record based on the provided email
          $condition = array('email' => $email);
          $result = $mysqli->common_select('users', '*', $condition);
      
          if (!$result['error']) {
              if (isset($result['data'][0])) {
                  $user = $result['data'][0];
                  $hashedPassword = $user->hashed_password;
      
                  // Verify the provided password against the hashed password stored in the database
                  if (password_verify($password, $hashedPassword)) {
                      $_SESSION['userid'] = $user->user_id;
                      $_SESSION['email'] = $user->email;
                      $_SESSION['username'] = $user->username;
                      $_SESSION['contact_no'] = $user->contact_no;
      
                      echo "<script>window.location='../index.php'</script>";
                      exit;
                  } else {
                      echo "<script>alert('Incorrect email or password. Please try again.');</script>";
                  }
              } else {
                  echo "<script>alert('Incorrect email or password. Please try again.');</script>";
              }
          } else {
              echo $result['error'];
          }
        }      
      ?>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
