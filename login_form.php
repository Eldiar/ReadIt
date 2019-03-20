<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Home</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">


  </head>
  <body>
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['login'])){

          require 'login.php';

        }
      }

    ?>

    <div class="header">

      <div class="logo">
        <img src="Images/logo.png" alt="ReadIt Logo">
        <h3>ReadIt</h3>
      </div>

      <div class="navbar navhover">
        <a href="index.php">Home</a>
        <a href="#">Forums</a>
        <a href="#topfeed.php">Top</a>
      </div>

      <div class="accountbar">
        <div class="accountbarplaceholder"></div>
        <div class="dropdown navhover">
          <button class="dropbtn">Account</button>
          <div class="dropdown-content">
            <a href="#">Login</a>
            <a href="signup.php">Sign Up</a>
            <a href="#">Logout</a>
            <a href="profile.php">Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->

    <div class="content">

      <div class="mid">
        <div class="between25"></div>

        <div class="login">
          <p>Login</p>
          <form class="loginform" action="login_form.php" method="post">
            <label>Username:</label><br/>
            <input type="text" name="username"><br/>

            <label>Password:</label><br/>
            <input type="password" name="password"><br/>

            <button type="submit" name="login">login</button>
          </form>
        </div>

        <div class="between25"></div>
      </div>



  </body>
</html>
