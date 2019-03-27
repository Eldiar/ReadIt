<?php
require 'db.php';
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Post Editing</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">
  </head>
  <body>
    <body>
      <?php
      $postId = $_GET['Id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (isset($_POST['createPost'])){
            require 'post_edit.php';
          }
        }
        if (!$_SESSION['logged_in']){
          $_SESSION['message'] = "You must be logged in to create a post!";
          $_SESSION['ErrorType'] = "noAccount";

          header("location: error.php");
        }
      ?>

      <!-- Navbar -->
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
                echo '<a href="administration_user.php">User Administration</a>';
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
            <p>Edit your post</p>
            <?php
            $stmt = $db->prepare("SELECT Post.Title AS Title, Post.Message As Message, Forum.Title As ForumTitle FROM Post,Forum WHERE Post.Id = :postId AND Post.ForumId = Forum.Id");
            $stmt->execute(array(':postId' => $postId));
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            echo"
            <form class='createpost' action='editpost.php?Id=" . $postId . "' method='post'>";
              ?>
              <label>Title</label><br/>
              <input type="text" name="postTitle" size="50" value="<?php echo $post['Title'];?>" placeholder="(Max. 100 Characters)" disabled><br/>

              <label>Post</label><br/>
              <textarea name="postMessage" rows="12" cols="64" size="50" placeholder="(Max. 4000 Characters)" required><?php echo $post['Message'];?></textarea><br/>

              <select name="postForum" class="forumselect" value="<?php echo $post['ForumTitle']; ?>" disabled>
                <?php
                for ($i = 1; $i <= 200; $i++) {
                  $stmt = $db->prepare("SELECT Forum.Id AS ForumId, Forum.Title AS ForumTitle FROM Forum ORDER BY Title LIMIT $i,1");
                  $stmt->execute();
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);

                  if (empty($result)){
                    break;
                  }
                  echo"
                <option value='".$result['ForumId']."'>".htmlspecialchars($result['ForumTitle'])."</option>
                ";
                }
                ?>
              </select>
              <?php
              echo "<select class='invisible' name='Id'>
                <option value=" . $postId . "></option>
              </select>";
              ?>
              <button type="submit" name="createPost" class='buttonstyle'>Submit</button>
              <!-- ADD EMPTYING CACHE BUTTON -->

            </form>

          </div>

          <div class="between25"></div>

        </div>
        <?php
          if (isset($_SESSION['postTitle']) || isset($_SESSION['postMessage']) || isset($_SESSION['postForum'])){
            unset($_SESSION['postTitle']);
            unset($_SESSION['postMessage']);
            unset($_SESSION['postForum']);
          }
        ?>
  </body>
</html>
