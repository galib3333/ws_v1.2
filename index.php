<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    echo "<script>window.location='admin/login.php'</script>";
    exit;
  }
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebSocket Chat</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
      body {
        background-color: #272727;
      }
      
      .chat-frame {
        max-width: 600px;
        margin: 0 auto;
        margin-top: 100px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        background-color: rgb(58, 58, 58);
        padding: 20px;
        border-radius: 5px;
        color: aliceblue;
      }
      
      .logout-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
      }
      
      .message-container {
        margin-bottom: 10px;
        overflow-wrap: break-word;
      }
      
      .outgoing-message {
        text-align: right;
        background-color: #104f92;
        color: #ffffff;
        padding: 10px;
        border-radius: 5px;
      }
      
      .incoming-message {
        text-align: left;
        background-color: #e9ecef;
        color: #000000;
        padding: 10px;
        border-radius: 5px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="chat-frame">
        <h1 class="text-center mb-4">WebSocket Chat</h1>
        <!-- Add the logout icon -->
        <a class="dropdown-item" href="admin/logout.php"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        <div id="messages">
        </div>
        <form id="message-form" action="#">
          <div class="mb-3">
            <label for="message-input" class="form-label">Message:</label>
            <input type="text" id="message-input" name="message" class="form-control" required>
          </div>
          <div class="mb-3">
            <!-- add a user name input field -->
            <label for="name-input" class="form-label">Name:</label>
            <input type="text" id="name-input" name="name" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS (if needed) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  </body>
</html>
    <script>
      let socket = new WebSocket("ws://192.168.0.102:8080");

      // handle incoming WebSocket messages
      socket.onmessage = function(event) {
        let message = JSON.parse(event.data);
        let messages = document.getElementById("messages");
        messages.innerHTML += "<p><strong>" + message.name + ":</strong> " + message.message + "</p>";
      };

      // handle form submission
      let form = document.getElementById("message-form");
      form.addEventListener("submit", function(event) {
        event.preventDefault();
        let messageInput = document.getElementById("message-input");
        let nameInput = document.getElementById("name-input"); // get the user name input field
        let message = {
          name: nameInput.value, // send the user name along with the message
          message: messageInput.value
        };
        // add the user's own message to the chat
        let messages = document.getElementById("messages");
        messages.innerHTML += "<p><strong>You:</strong> " + message.message + "</p>";
        // send the message to the server
        socket.send(JSON.stringify(message));
        messageInput.value = "";
      });
    </script>
  </body>
</html>
