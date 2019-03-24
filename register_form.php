<?php
require 'db.php';
session_start();
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Register</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">

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
        <a href="forums.php">Forums</a>
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
              <a href="profile.php">Profile</a>
              <a href="post_creation_form.php">Post Creation</a>';
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
            <input type="text" name="username" placeholder="(max. 16 characters)" required><br/>

            <label>Email address</label><br/>
            <input type="email" name="email" placeholder="(max. 100 characters)" required><br/>

            <label>Password:</label><br/>
            <input type="password" name="password"placeholder="********" required><br/>

            <label>First name</label><br/>
            <input type="text" name="first_name" placeholder="(max. 30 characters)"><br/>

            <label>Last name</label><br/>
            <input type="text" name="last_name" placeholder="(max. 40 characters)"><br/>

            <label>Birthday</label><br/>
            <input type="date" name="birthday" required><br/>

            <button type="submit" name="register">register</button>
          </form>
        </div>

        <div class="between25"></div>
      </div>



  </body>
</html>
