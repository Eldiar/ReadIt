<?php
require 'db.php';
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Forum Creation</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">
  </head>
  <body>
    <body>
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (isset($_POST['createForum'])){
            require 'forum_creation.php';
          }
        }
        if (!$_SESSION['logged_in']){
          $_SESSION['message'] = "You must be logged in to create a forum!";
          $_SESSION['ErrorType'] = "noAccount";

          header("location: error.php");
        }
      ?>

      <!-- Navbar -->
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
                echo "<a href='logout.php'>Logout</a>
                <a href='profile.php?Id=".$_SESSION['userId']."'>Profile</a>
                <a href='post_creation_form.php'>Post Creation</a>";
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

      <div class="content">

        <div class="mid">

          <div class="between25"></div>

          <div class="signup">
            <p>Create your forum</p>

            <form class="createpost" action="forum_creation_form.php" method="post">

              <label>Title</label><br/>
              <input type="text" name="forumTitle" size="50" value="<?php echo $_SESSION['forumTitle'];?>" placeholder="(Max. 100 Characters)" required><br/>

              <label>Description<label><br/>
              <textarea name="forumDescription" rows="8" cols="64" size="50" placeholder="(Max. 2000 Characters)" required><?php echo $_SESSION['forumDescription'];?></textarea><br/>

              <button type="submit" name="createForum" class="buttonstyle">Submit</button>
              <!-- ADD EMPTYING CACHE BUTTON -->

            </form>

          </div>

          <div class="between25"></div>

        </div>
        <?php
          if (isset($_SESSION['forumTitle']) || isset($_SESSION['forumDescription'])){
            unset($_SESSION['forumTitle']);
            unset($_SESSION['forumDescription']);
          }
        ?>
  </body>
</html>
