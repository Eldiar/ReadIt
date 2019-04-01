<?php
require 'db.php';
session_start();
?>

<?php
  //Checking if the linked post exists
  $postId = $_GET['Id'];

  $stmt = $db->prepare("SELECT * FROM Post WHERE Post.Id = :postId");
  $stmt->execute(array(':postId' => $postId));
  $post = $stmt->fetch(PDO::FETCH_ASSOC);

  // Post details (Username, Date, Likes)

  if(!$post){ //Post doesn't exist
    $_SESSION['message'] = "Oops! It looks like you have searched for a post that does not exist.";
    $_SESSION['ErrorType'] = "nonExistingPost";
    header("location: error.php");
  }

  // Retrieving User Data
  $stmt = $db->prepare("SELECT User.Id, User.Username FROM User, Post WHERE Post.UserId = User.Id AND Post.Id = :postId");
  $stmt->execute(array(':postId' => $postId));
  $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!$userdata){ //User doesn't exist
    $_SESSION['message'] = "Oops! Something went wrong retrieving the post data.";
    $_SESSION['ErrorType'] = "retrievingUserData";
    header("location: error.php");
  }

  // Retrieving Amount Of Likes
  $stmt = $db->prepare("SELECT COUNT(Likes.PostId) AS Likes FROM Likes WHERE Likes.PostId = :postId");
  $stmt->execute(array(':postId' => $postId));
  $likes = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!$likes){ //User doesn't exist
    $_SESSION['message'] = "Oops! Something went wrong retrieving the post data.";
    $_SESSION['ErrorType'] = "retrievingUserData";
    header("location: error.php");
  }





  $Followed = false;
  $NonFollowable = false;

  if (empty($_SESSION['userId'])) {
    $NonFollowable = true;
  }

  $Followedsql = $db->prepare("SELECT * FROM `PersoonVolgen` WHERE Volgend=:userId AND Gevolgd=:gevolgdId");
  $Followedsql->execute(array(':userId' => $_SESSION['userId'], ':gevolgdId' => $userdata['Id']));
  $Followedcheck = $Followedsql->fetch(PDO::FETCH_ASSOC);
  if (!empty($Followedcheck)){
    if(isset($_POST['followclick'])){
      $unFollow_sql = $db->prepare("DELETE FROM `PersoonVolgen` WHERE Volgend=:userId AND Gevolgd=:gevolgdId");
      $unFollow_sql->execute(array(':userId' => $_SESSION['userId'], ':gevolgdId' => $userdata['Id']));
    } else {
      $Followed = true;
    }
  } else {
  if(isset($_POST['followclick'])){
    $Follow_sql = $db->prepare("INSERT INTO `PersoonVolgen`(`Volgend`, `Gevolgd`) VALUES (:userId, :gevolgdId)");
    $Follow_sql->execute(array(':userId' => $_SESSION['userId'], ':gevolgdId' => $userdata['Id']));
    $Followed = true;
  }
}

$stmt = $db->prepare("SELECT COUNT(PersoonVolgen.Gevolgd) AS Follows FROM PersoonVolgen WHERE PersoonVolgen.Gevolgd = :gevolgdId ");
$stmt->execute(array(':gevolgdId' => $userdata['Id']));
$follows = $stmt->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php
      echo "<title>ReadIt - " . htmlspecialchars($post['Title']) . "</title> "
   ?>

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
               <a href="administration_forums.php">Forum Administration</a>';
             }
             ?>
           </div>
         </div>
       </div>
     </div>

     <div class="content">
       <div class="top">

           <div class="between7-5"></div>


           <div class="maintop">
             <?php
              // Echoing the post title
              echo "<p>" . htmlspecialchars($post['Title']) . "</p>"

              ?>
           </div>

           <div class="between7-5"></div>
        </div>

        <div class="mid">
          <div class="between7-5"></div>

          <div class="viewpost standarpostheight">
            <?php
            $Liked=false;
            if (empty($_SESSION['userId'])) {
              $NonLiked = true;
              $Liked = true;
            }
            $Likedsql = $db->prepare("SELECT * FROM `Likes` WHERE PostId=$postId AND UserId=:userId");
            $Likedsql->execute(array('userId' => $_SESSION['userId']));
            $Likedcheck = $Likedsql->fetch(PDO::FETCH_ASSOC);
            if (!empty($Likedcheck)){
              $Liked = true;
            } else {
            if(isset($_POST['likeclick'])){
              $Like_sql = $db->prepare("INSERT INTO `Likes`(`PostId`, `UserId`) VALUES ($postId, :userId)");
              $Like_sql->execute(array(':userId' => $_SESSION['userId']));
              $Liked = true;
            }
          }

          $editable = false;

          $stmt = $db->prepare("SELECT User.Rank AS Ranking FROM User WHERE User.Id = :userId");
          $stmt->execute(array(':userId' => $_SESSION['userId']));
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($result['Ranking'] == 1) {
            $deletable = true;
          }

          if ($userdata['Id'] == $_SESSION['userId']) {
            $editable = true;
            $deletable = true;
            $NonFollowable = true; //sets the user as non logged in for use on the follow button
          }


          if(isset($_POST['deleteclick'])){
            $delete = $db->prepare("DELETE FROM `Likes` WHERE PostId = :postId");
            $delete->execute(array(':postId' => $postId));

            $delete = $db->prepare("DELETE FROM `Comments` WHERE PostId = :postId");
            $delete->execute(array(':postId' => $postId));

            $delete = $db->prepare("DELETE FROM `Post` WHERE Id = :postId");
            $delete->execute(array(':postId' => $postId));

            header("location:index.php");
          }elseif (isset($_POST['editclick'])) {
            header("location: editpost.php?Id=" . $postId . " ");
          }


          $stmt = $db->prepare("SELECT COUNT(Likes.PostId) AS Likes FROM Likes WHERE Likes.PostId = :postId");
          $stmt->execute(array(':postId' => $postId));
          $likes = $stmt->fetch(PDO::FETCH_ASSOC);

            // Echoing the post message
            echo '<p class="mainpost">' . nl2br(htmlspecialchars($post['Message'])) . '</p>';

            // Echoing post information (User, datetime)

            // Post Option Buttons

            echo "
              <b><p class='extrainfo'> Post created by: <a class='userlink' href='profile.php?Id=".$userdata['Id']."' class='userlink'>" . htmlspecialchars($userdata['Username']) . "</a>
              <form action='viewpost.php?Id=".$postId."' method='POST'>
            ";

            if ($NonFollowable == true){
              echo "
                <input type='submit' class='followedbuttonstyle' name='followclick' value='Follow(".$follows['Follows'].")' disabled/>
              ";
            }
            elseif ($Followed == true){
              echo "
                <input type='submit' class='followedbuttonstyle' name='followclick' value='Follow(".$follows['Follows'].")' style='color:blue'/>
              ";
            }
            else {
              echo "
                <input type='submit' class='buttonstyle' name='followclick' value='Follow(".$follows['Follows'].")'/>
              ";
            }
            // Displays delete button
            if ($deletable == true){
              echo "
              <input type='submit' class='buttonstyle' name='deleteclick' value='Delete'/>
              ";
            }
            // Displays edit button
            if ($editable == true){
              echo "
                <input type='submit' class='buttonstyle' name='editclick' value='Edit'/>
              ";
            }

            echo"
              </form>
              On: " . $post['Datum'] . "</p></b>
            ";

            echo '<b><p class="extrainfo"> Post created by: <a class="userlink" href="profile.php?Id=' . $userdata['Id'] . '" class="userlink" >' . htmlspecialchars($userdata['Username']) . '</a> On: ' . $post['Datum'] . '</p></b>';

            // Display like button with amount of likes
            if ($Liked == false) {
              echo " <form action='viewpost.php?Id=".$postId."' method='POST'>
                     <input type='submit' class='buttonstyle' name='likeclick' value='Likes: ".$likes['Likes']."'/>
                     </form>";
            } elseif ($NonLiked == false){
              echo " <form action='viewpost.php?Id=".$postId."' method='POST'>
                     <input type='submit' class='likedbuttonstyle' name='likeclick' value='Likes: ".$likes['Likes']."' disabled/>
                     </form>";
            } else {
              echo " <form action='viewpost.php?Id=".$postId."' method='POST'>
                     <input type='submit' class='nonlikedbuttonstyle' name='likeclick' value='Likes: ".$likes['Likes']."' disabled/>
                     </form>";
            }

            // ADD LIKE BUTTON HERE!

            echo "
            <div class = 'post'>
            <form class='createpost commentonpost' action='viewpost.php?Id=".$postId."' method='post'>

              <textarea name='commentMessage' rows='6' cols='64' size='50' placeholder='Comment here' required></textarea><br/>

              <input type='submit' class='buttonstyle' name='createComment' value='Comment'/>

            </form>
            </div>
            ";
            $Commented = false;
            for ($i = 0; $i <= 1000; $i++) {

              $stmt = $db->prepare("SELECT User.Username As Username, User.Id AS CommenterId, Comments.Datum As CommentDate, Comments.Message As CommentMessage FROM Comments ,User WHERE Comments.UserId=User.Id AND Comments.PostId = $postId ORDER BY Comments.Datum DESC LIMIT $i,1");
              $stmt->execute();
              $result = $stmt->fetch(PDO::FETCH_ASSOC);

              if (empty($result)){
                break;
              }

              if (isset($_POST['createComment'])) {
                if ($result['CommentMessage'] == $_POST['commentMessage']) {
                  $Commented = true;
                }
              }
              }

              if ($Commented == false) {
                if (isset($_POST['createComment'])) {
                  $Comment_sql = $db->prepare("INSERT INTO `Comments`(`PostId`, `UserId`, `Message`) VALUES ($postId, :userId, :commentMessage)");
                  $Comment_sql->execute(array(':userId' => $_SESSION['userId'], ':commentMessage' => $_POST['commentMessage']));
                }
              }

              // Displaying the comments on a post
              for ($i = 0; $i <= 19; $i++) {

                $stmt = $db->prepare("SELECT User.Username As Username, User.Id AS CommenterId, Comments.Datum As CommentDate, Comments.Message As CommentMessage FROM Comments,User WHERE Comments.UserId=User.Id AND Comments.PostId = $postId ORDER BY Comments.Datum DESC LIMIT $i,1");
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (empty($result)){
                  break;
                }

                if (isset($_POST['createComment'])) {
                  if ($result['CommentMessage'] == $_POST['commentMessage']) {
                    $Commented = true;
                  }
                }

                echo"
                <div class='post'>
                      <p class='commenttext mainpost'>". nl2br(htmlspecialchars($result['CommentMessage']))."</p>
                      <b><a href='profile.php?Id=".$result['CommenterId']."' class='commentuser extrainfo'>".htmlspecialchars($result['Username'])."</a></b>
                      <br>
                      <b><span class='commentdate extrainfo'>".$result['CommentDate']."</span></b>
                  </div>
                  ";
                }

            ?>
          </div>

          <div class="between7-5"></div>
        </div>


      </div>


     </div>




   </body>
</html>
