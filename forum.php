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
          home
          <form action="index.php" method="get">
            <select name="Sort_Type">
              <option value="New">New</option>
              <option value="Top">Top</option>
              <option value="controversial">Controversial(Doesnt work yet so will show New)</option>
              <option value="Hot">Hot</option>
            </select>
            <select name="Sort_Date">
              <option value="Today">Today</option>
              <option value="Pastweek">Past Week</option>
              <option value="Pastmonth">Past Month</option>
              <option value="Pastyear">Past Year</option>
              <option value="Alltime">All Time</option>
            </select>
            <input type="submit" value='Sort'>
         </form>

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
          $forumId = $_GET['Id'];

          $timeDifference = 999999999;
          $orderType = 'Datum';
          if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($_GET['Sort_Date'] == 'Today') {
              $timeDifference = 1;
            }
            elseif ($_GET['Sort_Date'] == 'Pastweek') {
              $timeDifference = 7;
            }
            elseif ($_GET['Sort_Date'] == 'Pastmonth') {
              $timeDifference = 30;
            }
            elseif ($_GET['Sort_Date'] == 'Pastyear') {
              $timeDifference = 365;
            }
            else {
              $timeDifference = 999999999;
            }
            if ($_GET['Sort_Type'] == 'New') {
              $timeDifference = 999999999;
              $orderType = 'Datum';
            }
            elseif ($_GET['Sort_Type'] == 'Hot') {
              $timeDifference = 7;
              $orderType = 'COUNT(Post.Id)';
            }
            elseif ($_GET['Sort_Type'] == 'Top') {
              $orderType = 'COUNT(Post.Id)';
            }
            elseif ($_GET['Sort_Type'] == 'Controversial') {
              //most commented posts
            }
          }

          for ($i = 0; $i <= 19; $i++) {
            $Liked = false;

            $stmt = $db->prepare("SELECT Post.Id AS PostId, Post.Title AS PostTitle, Post.Message AS PostMessage, Post.Datum AS PostDate, Post.UserId As PosterId, User.Username As Username FROM Post,User,Likes WHERE Post.UserId=User.Id AND TIMESTAMPDIFF(DAY, Post.Datum, CURRENT_TIME()) < $timeDifference AND Post.Id=Likes.PostId AND Post.ForumId=$forumId GROUP BY Post.Id ORDER BY $orderType DESC LIMIT $i,1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($result)){
              break;
            }

            if (empty($_SESSION['userId'])) {
              $Liked = true;
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
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".$result['PostTitle']."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".$result['Username']."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".$result['PostMessage']."</p>
              <form action='index.php' method='POST'>
              <input type='submit' name='".$i."' value='Likes: ".$likes['Likes']."'/>
              </form>
            </div>
          ";
} else {
          echo "
          <div class='post'>
              <div class='postheader'>
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".$result['PostTitle']."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".$result['Username']."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".$result['PostMessage']."</p>
              <form action='index.php' method='POST'>
              <input type='submit' name='".$i."' value='Likes: ".$likes['Likes']."' disabled/>
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
        <?php
        $stmt = $db->prepare("SELECT Forum.Id AS ForumId, Forum.Title AS ForumTitle, Forum.Description AS ForumDescription FROM Forum WHERE Forum.Id=$forumId");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo"
        <div class='sidebar'>
          <div class='sidebar-post'>
            <p class='sidebar-post-title'>".$result['ForumTitle']."</p>
            <p class='sidebar-post-text'>".$result['ForumDescription']."</p>
          </div>
        </div>
        ";
        ?>

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
