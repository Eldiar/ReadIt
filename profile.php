<?php
require 'db.php';
session_start();
?>

<?php
//Checking if the linked post exists
$profileId = $_GET['Id'];

$stmt = $db->prepare("SELECT Id, Username, Birthday, Firstname, Lastname, TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) AS Age FROM User WHERE User.Id = :profileId");
$stmt->execute(array(':profileId' => $profileId));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$profile){ //User doesn't exist
  $_SESSION['message'] = "Oops! The user you looked for doesnt seem to exist.";
  $_SESSION['ErrorType'] = "retrievingUserData";
  header("location: error.php");
}

$Followed = false;
$NonFollowed = false;

if ($_SESSION['userId'] == $profileId) {
  $NonFollowed = true;
  $Followed = true;
}

if (empty($_SESSION['userId'])) {
  $NonFollowed = true;
  $Followed = true;
}

$Followedsql = $db->prepare("SELECT * FROM `PersoonVolgen` WHERE Volgend=:userId AND Gevolgd=$profileId");
$Followedsql->execute(array(':userId' => $_SESSION['userId']));
$Followedcheck = $Followedsql->fetch(PDO::FETCH_ASSOC);
if (!empty($Followedcheck)){
  if(isset($_POST['followclick'])){
    $unFollow_sql = $db->prepare("DELETE FROM `PersoonVolgen` WHERE Volgend=:userId AND Gevolgd=$profileId");
    $unFollow_sql->execute(array(':userId' => $_SESSION['userId']));
  } else {
    $Followed = true;
  }
} else {
if(isset($_POST['followclick'])){
  $Follow_sql = $db->prepare("INSERT INTO `PersoonVolgen`(`Volgend`, `Gevolgd`) VALUES (:userId, $profileId)");
  $Follow_sql->execute(array(':userId' => $_SESSION['userId']));
  $Followed = true;
}
}

$stmt = $db->prepare("SELECT COUNT(PersoonVolgen.Gevolgd) AS Follows FROM PersoonVolgen WHERE PersoonVolgen.Gevolgd = $profileId");
$stmt->execute();
$follows = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Profile</title>

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

      <!-- Page indication-->
      <div class="top">
        <div class="between7-5"></div>
        <?php
        if ($Followed == false ) {
          echo"
            <div class='maintop'>
              <p>".htmlspecialchars($profile[Username])."'s profile</p>
            </div>
          <form action='profile.php?Id=".$profileId."' method='POST'>
          <input type='submit' class='buttonstyle' name='followclick' value='Follow(".$follows['Follows'].")'/>
          </form>
          ";
        }elseif ($NonFollowed == false) {
          echo"
            <div class='maintop'>
              <p>".htmlspecialchars($profile[Username])."'s profile</p>
            </div>
          <form action='profile.php?Id=".$profileId."' method='POST'>
          <input type='submit' class='buttonstyle' name='followclick' value='Follow(".$follows['Follows'].")' style='color:blue'/>
          </form>
          ";
        }else {
          echo"
            <div class='maintop'>
              <p>".htmlspecialchars($profile[Username])."'s profile</p>
            </div>
          <form action='profile.php?Id=".$profileId."' method='POST'>
          <input type='submit' class='buttonstyle' name='followclick' value='Follow(".$follows['Follows'].")' disabled/>
          </form>
          ";
        }
        ?>

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
            $Liked = false;

            $stmt = $db->prepare("SELECT Post.Id AS PostId, Post.Title AS PostTitle, Post.Message AS PostMessage, Post.Datum AS PostDate, Post.UserId As PosterId, User.Username As Username FROM Post,User WHERE Post.UserId=User.Id AND Post.UserId = :profileId ORDER BY Datum DESC LIMIT $i,1");
            $stmt->execute(array(':profileId' => $profileId));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($result)){
              break;
            }

            if (empty($_SESSION['userId'])) {
              $Liked = true;
            }

            $Likedsql = $db->prepare("SELECT * FROM `Likes` WHERE PostId=$result[PostId] AND UserId=:userId");
            $Likedsql->execute(array(':userId' => $_SESSION['userId']));
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

          $stmt = $db->prepare("SELECT COUNT(Likes.PostId) AS GivenLikes FROM Likes WHERE Likes.UserId = :profileId");
          $stmt->execute(array(':profileId' => $profileId));
          $givenlikes = $stmt->fetch(PDO::FETCH_ASSOC);

          $stmt = $db->prepare("SELECT COUNT(Likes.PostId) AS RecievedLikes FROM Likes, User, Post WHERE Likes.PostId=Post.Id AND Post.UserId=User.Id AND User.Id = :profileId");
          $stmt->execute(array(':profileId' => $profileId));
          $recievedlikes = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($Liked == False) {

          echo "
          <div class='post'>
              <div class='postheader'>
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".htmlspecialchars($result['PostTitle'])."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".htmlspecialchars($result['Username'])."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".htmlspecialchars($result['PostMessage'])."</p>
              <form action='profile.php?Id=".$profileId."' method='POST'>
              <input type='submit' class='buttonstyle' name='".$i."' value='Likes: ".$likes['Likes']."'/>
              </form>
            </div>
          ";
        } else {
          echo "
          <div class='post'>
              <div class='postheader'>
                <a href='viewpost.php?Id=".$result['PostId']."' class='posttitle'><b>".htmlspecialchars($result['PostTitle'])."</b></a>
                <a href='profile.php?Id=".$result['PosterId']."' class='postuser'>".htmlspecialchars($result['Username'])."</a>
                <span class='postdate'>".$result['PostDate']."</span>
              </div>
              <p class='posttext'>".htmlspecialchars($result['PostMessage'])."</p>
              <form action='profile.php?Id=".$profileId."' method='POST'>
              <input type='submit' class='buttonstyle' name='".$i."' value='Likes: ".$likes['Likes']."' disabled/>
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
        echo "
        <div class='sidebar'>
          <div class='sidebar-post'>
            <p class='sidebar-post-title'>".htmlspecialchars($profile['Username'])."</p>
            <p class='sidebar-post-text'>First Name: ".htmlspecialchars($profile['Firstname'])."</p>
            <p class='sidebar-post-text'>Last Name: ".htmlspecialchars($profile['Lastname'])."</p>
            <p class='sidebar-post-text'>Birthday: ".htmlspecialchars($profile['Birthday'])."</p>
            <p class='sidebar-post-text'>Age: ".htmlspecialchars($profile['Age'])."</p>
            <p class='sidebar-post-text'>Likes given: ".$givenlikes['GivenLikes']."</p>
            <p class='sidebar-post-text'>Likes Recieved: ".$recievedlikes['RecievedLikes']."</p>
          </div>
        </div>"

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
