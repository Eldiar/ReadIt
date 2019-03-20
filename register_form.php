<?php
require 'db.php';
session_start();
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Home</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">
    <!-- PHP Links -->

    <!-- Javascript Links -->

  </head>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['register'])){
        require 'register.php';
    }
  }
  if ($_SESSION['logged_in'] == true){
    header("location: index.php");
  }

  ?>

  <body>
    <div class="header">

      <div class="logo">
        <img src="Images/logo.png" alt="ReadIt Logo">
        <h3>ReadIt</h3>
      </div>

      <div class="navbar navhover">
        <a href="index.php">Home</a>
        <a href="#">Forums</a>
        <a href="topfeed.php">Top</a>
      </div>

      <div class="accountbar">
        <div class="accountbarplaceholder"></div>
        <div class="dropdown navhover">
          <button class="dropbtn">Account</button>
          <div class="dropdown-content">
            <?php
            if($_SESSION['logged_in']==true){
              echo '<a href="logout.php">Logout</a>
              <a href="profile.php">Profile</a>';
            }
            else{
              echo '<a href="login_form.php">Login</a>
              <a href="register_form.php">Sign Up</a>';

            }
            ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->

    <div class="content">

      <div class="mid">
        <div class="between25"></div>

        <div class="signup">
          <p>Sign up</p>
          <form class="signupform" action="register_form.php" method="post">
            <label>Username:</label><br/>
            <input type="text" name="username" required><br/>

            <label>Email address</label><br/>
            <input type="email" name="email" required><br/>

            <label>Password:</label><br/>
            <input type="password" name="password" required><br/>

            <label>First name</label><br/>
            <input type="text" name="first_name"><br/>

            <label>Last name</label><br/>
            <input type="text" name="last_name"><br/>

            <label>Birthday</label><br/>
            <input type="date" name="birthday" required><br/>

            <button type="submit" name="register">register</button>
          </form>
        </div>

        <div class="between25"></div>
      </div>



  </body>
</html>
