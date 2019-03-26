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
        <div class="between7-5">

        </div>

        <div class="maintop">
          <p>Topfeed</p>

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
          $timeDifference = 7;
          $orderType = 'COUNT(Post.Id)';

          for ($i = 0; $i <= 19; $i++) {
            $Liked = false;

            $stmt = $db->prepare("SELECT Post.Id AS PostId, Post.Title AS PostTitle, Post.Message AS PostMessage, Post.Datum AS PostDate, Post.UserId As PosterId, User.Username As Username FROM Post,User,Likes WHERE Post.UserId=User.Id AND TIMESTAMPDIFF(DAY, Post.Datum, CURRENT_TIME()) < $timeDifference AND Post.Id=Likes.PostId GROUP BY Post.Id ORDER BY $orderType DESC LIMIT $i,1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($result)){
              break;
            }

            if (empty($_SESSION['userId'])) {
              $Liked = true;
              $NonLiked = true;
            }

            $Likedsql = $db->prepare("SELECT * FROM `Likes` WHERE PostId=$result[PostId] AND UserId=:userId");
            $Likedsql->execute(array('userId' => $_SESSION['userId']));
            $Likedcheck = $Likedsql->fetch(PDO::FETCH_ASSOC);
            if (!empty($Likedcheck)){
              $Liked = true;
            } else {
            if(isset($_POST[$i])){
              $Like_sql = $db->prepare("INSERT INTO `Likes`(`PostId`, `UserId`) VALUES (:PostId, :userId)");
              $Like_sql->execute(array(':PostId' => $result['PostId'], ':userId' => $_SESSION['userId']));
              $Liked = true;
            }
          }

          $stmt = $db->prepare("SELECT COUNT(Likes.PostId) AS Likes FROM Likes WHERE Likes.PostId = :postId");
          $stmt->execute(array(':postId' => $result['PostId']));
          $likes = $stmt->fetch(PDO::FETCH_ASSOC);

if ($Liked == False) {

          echo "
          <div class='post'>
              <div class='postheader'>
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".htmlspecialchars($result['PostTitle'])."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".htmlspecialchars($result['Username'])."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".htmlspecialchars($result['PostMessage'])."</p>
              <form action='index.php' method='POST'>
              <input type='submit' class='buttonstyle' name='".$i."' value='Likes: ".$likes['Likes']."'/>
              </form>
            </div>
          ";
} elseif ($NonLiked == False) {
          echo "
          <div class='post'>
              <div class='postheader'>
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".htmlspecialchars($result['PostTitle'])."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".htmlspecialchars($result['Username'])."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".htmlspecialchars($result['PostMessage'])."</p>
              <form action='index.php' method='POST'>
              <input type='submit' class='likedbuttonstyle' name='".$i."' value='Likes: ".$likes['Likes']."' disabled/>
              </form>
            </div>
        ";
    }
    else{
      echo "
      <div class='post'>
          <div class='postheader'>
            <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".htmlspecialchars($result['PostTitle'])."</b></a>
            <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".htmlspecialchars($result['Username'])."</a>
            <span class='postdate'>".$result['PostDate']."</span>
          </div>
          <p class='posttext'>".htmlspecialchars($result['PostMessage'])."</p>
          <form action='index.php' method='POST'>
          <input type='submit' class='nonlikedbuttonstyle' name='".$i."' value='Likes: ".$likes['Likes']."' disabled/>
          </form>
        </div>
    ";
    }
}
         ?>
        </div>

        <!--Flex space filler-->
        <div class="between5"></div>

        <!-- Sidebar content-->
        <div class="sidebar">
          <div class="sidebar-post">
            <p class="sidebar-post-title">Top forums</p>
            <?php
            for ($i = 0; $i <= 9; $i++) {

              $stmt = $db->prepare("SELECT Forum.Title AS ForumTitle, Forum.Id AS ForumId FROM Post, Forum WHERE Post.ForumId=Forum.Id GROUP BY Forum.Id ORDER BY COUNT(Post.Id) DESC LIMIT $i,1");
              $stmt->execute();
              $Topforum = $stmt->fetch(PDO::FETCH_ASSOC);

              $stmt = $db->prepare("SELECT COUNT(Volgen.ForumId) AS Follows FROM Volgen WHERE Volgen.ForumId = :forumId");
              $stmt->execute(array(':forumId' => $Topforum['ForumId']));
              $follows = $stmt->fetch(PDO::FETCH_ASSOC);

              if (empty($Topforum)){
                break;
              }

              echo "
              <a class='sidebar-post-text' href='forum.php?Id=".htmlspecialchars($Topforum['ForumId'])."'>".htmlspecialchars($Topforum['ForumTitle'])."(".$follows['Follows'].")</a><br><br>
              ";
            }
            ?>
            </div>
        </div>

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
