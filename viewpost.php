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

  if(!$post){ //User doesn't exist
    $_SESSION['message'] = "Oops! It looks like you have searched for a post that does not exist.";
    $_SESSION['ErrorType'] = "nonExistingPost";
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
             <?php echo "<p>" . $post['Title'] . "</p>" ?>
           </div>

           <div class="between7-5"></div>
        </div>

        <div class="mid">
          <div class="between7-5"></div>

          <div class="post">
            <div class="postheader">
              <a href="#" class="posttitle"><b>Longer titel than usual on this website</b></a>
              <a href="#" class="postuser">Username</a>
              <span class="postdate">dd-mm-yyyy</span>
            </div>
            <p class="posttext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>

          <div class="between7-5"></div>
        </div>


      </div>


     </div>




   </body>
</html>
