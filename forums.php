<?php
require 'db.php';
session_start();
?>

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

      <!-- Page indication-->
      <div class="top">
        <div class="between7-5"></div>

        <div class="maintop">
          <p>Forums</p>

        </div>

        <div class="between7-5"></div>
      </div>

      <!-- Main content (posts etc.)-->

      <div class="mid">
        <!--Flex space filler-->
        <div class="between7-5"></div>

        <!-- Main feed-->
        <div class="main">
          <?php

          for ($i = 0; $i <= 19; $i++) {

            $stmt = $db->prepare("SELECT Forum.Id AS ForumId, Forum.Title AS ForumTitle, Forum.Description AS ForumDescription FROM Forum ORDER BY Title LIMIT $i,1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)){
              break;
            }

            echo "
              <div class='post'>
                <div class='postheader'>
                  <a href='forum.php?Id=".$result['ForumId']."' class='posttitle'><b>".$result['ForumTitle']."</b></a>
                </div>
                  <p class='posttext'>".$result['ForumDescription']."</p>
              </div>
          ";
          }
         ?>
        </div>

        <!--Flex space filler-->
        <div class="between5"></div>


        <!--Flex space filler-->
        <div class="between7-5"></div>

      </div>

    <!-- Buttons for next X posts go here-->
    <div class="bottom">

    </div>


    </div>


    <!-- Footer -->

  </body>
</html>
