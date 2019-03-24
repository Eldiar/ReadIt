<?php
/*Displays all error messages*/
session_start();
?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ReadIt - Error</title>

  <!-- CSS Link -->
    <link rel="stylesheet" type="text/css" href="readitstyle.css">
  <!-- PHP Links -->

  <!-- Javascript Links -->

</head>

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
          if($_SESSION['logged_in']==false){
          echo '<a href="login_form.php">Login</a>
          <a href="register_form.php">Sign Up</a>';
          }
          else{
          echo '<a href="logout.php">Logout</a>
          <a href="profile.php">Profile</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>


  <div class="error">
    <h1 class="errortitle">Error</h1>
    <p class="errortext">
      <?php
        if( isset($_SESSION['message']) AND !empty($_SESSION['message'])){
            echo $_SESSION['message'];
        }
        else{
          header("location: index.php");
        }
      ?>
    </p>
    <?php
    if( isset($_SESSION['ErrorType']) AND !empty($_SESSION['ErrorType']) ){
      if($_SESSION['ErrorType'] == "login"){
        echo '<a href="login_form.php"><button class="">Back to login!</button></a>';
      }
      if($_SESSION['ErrorType'] == "register"){
        echo '<a href="register_form.php"><button class="">Back to register!</button></a>';
      }
      if($_SESSION['ErrorType'] == "noAccount"){
        echo '<a href="register_form.php"><button class="">Register now!</button></a><br/>';
        echo '<a href="login_form.php"><button class="">Login now!</button></a>';
      }
      if($_SESSION['ErrorType'] == "postCreation"){
        echo '<a href="post_creation_form.php"><button class="">Back post creation!</button></a>';
      }

    }
    else{
      header("location: index.php");
    }
    ?>
  </div>
</body>
</html>
