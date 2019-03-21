<?php
require 'db.php';
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ReadIt - Post Creation</title>
  </head>
  <body>
    <body>
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (isset($_POST['createPost'])){
            require 'post_creation.php';
          }
        }
        if ($_SESSION['userId']){
          $_POST['message'] = "You must be logged in to create a post!"
          $_POST['ErrorType'] = "noAccount";

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

      <div class="content">

        <div class="mid">

          <div class="between25"></div>

          <div class="signup">
            <p>Create your post</p>
            <?php
            <form class="createpost" action="postcreation.php" method="post">

              <label>Title</label><br/>
              <input type="text" name="postTitle" size="50" value="$_POST['postTitle']" required><br/>

              <label>Post</label><br/>
              <textarea name="postMessage" rows="12" cols="64" size="50" value="$_POST['postMessage']" required></textarea><br/>

              <select name="postForum" class="forumselect" value="$_POST['postForum']" required>
                <option value="#">select a forum</option>
                <option value="test">Dit is een test</option>
              </select>

              <button type="submit" name="createPost">Submit</button>

            </form>
            ?>
          </div>

          <div class="between25"></div>

        </div>
  </body>
</html>
