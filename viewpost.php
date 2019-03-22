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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php
      echo "<title>ReadIt - " . $post['Title'] . "</title> "
   ?>

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

     <div class="content">
       <div class="top">

           <div class="between7-5"></div>


           <div class="maintop">
             <?php
              // Echoing the post title
              echo "<p>" . $post['Title'] . "</p>"

              ?>
           </div>

           <div class="between7-5"></div>
        </div>

        <div class="mid">
          <div class="between7-5"></div>

          <div class="viewpost standarpostheight">
            <?php

            // Echoing the post message
            echo '<p>' . $post['Message'] . '</p>';

            // Echoing post information (User, datetime)
            echo '<p> Post created by: <a href="profile.php?UserId=' . $userdata['Id'] . '" >' . $userdata['Username'] . '</a> On: ' . $post['Datum'] . '</p>';

            // Echoing the amount of likes a post has
            echo '<p> This post is liked by: ' . $likes['Likes'] . ' people.';

            // ADD LIKE BUTTON HERE!

            ?>
          </div>

          <div class="between7-5"></div>
        </div>


      </div>


     </div>




   </body>
</html>
