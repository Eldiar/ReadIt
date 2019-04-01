<?php
require 'db.php';
session_start();

if ($_SESSION['rank'] == 0) {
  $_SESSION['message'] = "You must be and administrator to visit this page!";
  $_SESSION['ErrorType'] = "noPermission";

  header("location: error.php");
}
if ($_SESSION['logged_in'] != true) {
  $_SESSION['message'] = "You must be logged in to visit this page!";
  $_SESSION['ErrorType'] = "login";

  header("location: error.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Forum Administration</title>

    <!-- CSS Link -->
    <link rel="stylesheet" type="text/css" href="readitstyle.css">
  </head>
  <body>
    <div class="header">

      <div class="logo">
        <a href="index.php">
          <img src="Images/logo.png" alt="ReadIt Logo">
          <h3>ReadIt</h3>
        </a>
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
              <a href='post_creation_form.php'>Post Creation</a>
              <a href='forum_creation_form.php'>Forum Creation</a>";
            }
            else{
              echo '<a href="login_form.php">Login</a>
              <a href="register_form.php">Sign Up</a>';
            }

            if ($_SESSION['rank'] == 1){
              echo '<a href="administration_user.php">User Administration</a>
              <a href="administration_forums.php">User Administration</a>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class="content">

      <!-- Page indication-->
      <div class="top">
        <div class="between7-5">

        </div>

        <div class="maintop">
          <p>User Administration</p>
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
          for ($i = 0; $i <= 1000; $i++) {

            $stmt = $db->prepare("SELECT * FROM Forum ORDER BY Forum.Title DESC LIMIT $i,1");
            $stmt->execute();

            $forum = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($forum['Id'])){
              break;
            }

            // echo bar with user info
            // Id, Username, Birthday, Firstname, Lastname, Rank
            // Button to profile (where messages can be deleted), delete account button, promote to admin button
            // use HTML table
          echo "
          <div class='post'>
            <table>
              <tr>
                <th>Title</th>
                <th>Description</th>
              </tr>
              <tr>
                <td>". htmlspecialchars($forum['Title']) . "</td>
                <td>". nl2br(htmlspecialchars($forum['Description'])) ."</td>
              </tr>
            </table>

            <form action='administration.php' method='POST'>
              <input type='submit' class='buttonstyle' name='action' value='Delete Forum' />
              <select name='Id' class='invisible'>
                <option value=". $forum['Id'] . "></option>
              </select>
            </form>

          </div>
          ";
        }

         ?>
        </div>

        <!--Flex space filler-->
        <div class="between5"></div>

        <!-- Sidebar content-->
        <div class="sidebar">
          <div class="sidebar-post">
            <p class="sidebar-post-title">Warning!</p>

            <p>Deleting a forum cannot be undone!</p>

          </div>
        </div>

        <!--Flex space filler-->
        <div class="between7-5"></div>

      </div>






  </body>
</html>
