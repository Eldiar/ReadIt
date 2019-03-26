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

          for ($i = 0; $i <= 190; $i++) {
            $Followed = false;
            $NonFollowed = false;

            $stmt = $db->prepare("SELECT Forum.Id AS ForumId, Forum.Title AS ForumTitle, Forum.Description AS ForumDescription FROM Forum ORDER BY Title LIMIT $i,1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)){
              break;
            }

            if (empty($_SESSION['userId'])) {
              $NonFollowed = true;
              $Followed = true;
            }

            $Followedsql = $db->prepare("SELECT * FROM `Volgen` WHERE ForumId=$result[ForumId] AND UserId=:userId");
            $Followedsql->execute(array('userId' => $_SESSION['userId']));
            $Followedcheck = $Followedsql->fetch(PDO::FETCH_ASSOC);
            if (!empty($Followedcheck)){
              if(isset($_POST[$i])){
                $unFollow_sql = $db->prepare("DELETE FROM `Volgen` WHERE Volgen.UserId = :userId AND Volgen.ForumId = :ForumId");
                $unFollow_sql->execute(array(':ForumId' => $result['ForumId'], ':userId' => $_SESSION['userId']));
              } else {
                $Followed = true;
              }
            } else {
            if(isset($_POST[$i])){
              $Follow_sql = $db->prepare("INSERT INTO `Volgen`(`ForumId`, `UserId`) VALUES (:ForumId, :userId)");
              $Follow_sql->execute(array(':ForumId' => $result['ForumId'], ':userId' => $_SESSION['userId']));
              $Followed = true;
            }
          }

          $stmt = $db->prepare("SELECT COUNT(Volgen.ForumId) AS Follows FROM Volgen WHERE Volgen.ForumId = :forumId");
          $stmt->execute(array(':forumId' => $result['ForumId']));
          $follows = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($Followed == false ) {
              echo "
                <div class='post'>
                  <div class='postheader'>
                    <a href='forum.php?Id=".$result['ForumId']."' class='posttitle'><b>".htmlspecialchars($result['ForumTitle'])."</b></a>
                  </div>
                    <p class='posttext'>".htmlspecialchars($result['ForumDescription'])."</p>
                    <form action='forums.php?Id=".$result['ForumId']."' method='POST'>
                    <input type='submit' class='buttonstyle' name='".$i."' value='Follow(".$follows['Follows'].")'/>
                    </form>
                </div>
            ";
          }elseif ($NonFollowed == false) {
              echo "
                <div class='post'>
                  <div class='postheader'>
                    <a href='forum.php?Id=".$result['ForumId']."' class='posttitle'><b>".htmlspecialchars($result['ForumTitle'])."</b></a>
                  </div>
                    <p class='posttext'>".htmlspecialchars($result['ForumDescription'])."</p>
                    <form action='forums.php?Id=".$result['ForumId']."' method='POST'>
                    <input type='submit' class='buttonstyle' name='".$i."' value='Follow(".$follows['Follows'].")' style='color:blue'/>
                    </form>
                </div>
            ";
          }else {
            echo "
              <div class='post'>
                <div class='postheader'>
                  <a href='forum.php?Id=".$result['ForumId']."' class='posttitle'><b>".htmlspecialchars($result['ForumTitle'])."</b></a>
                </div>
                  <p class='posttext'>".htmlspecialchars($result['ForumDescription'])."</p>
                  <form action='forums.php?Id=".$result['ForumId']."' method='POST'>
                  <input type='submit' class='likedbuttonstyle' name='".$i."' value='Follow(".$follows['Follows'].")' disabled/>
                  </form>
              </div>
          ";
          }
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
