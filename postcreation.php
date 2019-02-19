<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Home</title>

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
        <a href="#">Home</a>
        <a href="#">Forums</a>
        <a href="#">Top</a>
      </div>

      <div class="accountbar">
        <div class="accountbarplaceholder"></div>
        <div class="dropdown navhover">
          <button class="dropbtn">Account</button>
          <div class="dropdown-content">
            <a href="#">Login</a>
            <a href="#">Sign Up</a>
            <a href="#">Logout</a>
            <a href="#">Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->

    <div class="content">

      <div class="mid">
        <div class="between25"></div>

        <div class="signup">
          <p>Create your post</p>
          <form class="createpost" action="postcreation.php" method="post">
            <label>Title</label><br/>
            <input type="text" name="title" size="50" value="<?php echo $_POST["title"]; ?>"><br/>

            <label>Post</label><br/>
            <textarea name="postMessage" rows="12" cols="64" size="50"></textarea><br/>

            <select name="postforum" class="forumselect">
              <option value="#">select a forum</option>
              <option value="test">Dit is een test</option>
            </select>
            <input type = "submit" value = "Post" name = "submit">
          </form>


          <?php

            // title validation
            if(isset($_POST['submit'])) {

            $title = $_POST['title'];
            $postMessage = $_POST['postMessage'];

            $titlelength= strlen($title);
            $messagelength = strlen($postMessage);

              if (empty($title)){
                $output= "<br> Title can not be empty";
                echo $output;
              }

              if ($titlelength > 15){
                $output= "<br> Title is too long";
                echo $output;
              }

              // message validation
                if (empty($postMessage)){
                  $output= "<br> Post can not be empty";
                  echo $output;
                }

                if ($messagelength > 250){
                  $output= "<br> Post is too long";
                  echo $output;
                }
            }
            ?>

            <?php
            $servername = "localhost:3307";
            $username = "6in1 René Tielen";
            $password = "113924";
            $dbname = "6in1 René Tielen";
            $titlet = $_POST["title"];
            $message = $_POST["postMessage"];
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
               // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "INSERT INTO Post (UserId, ForumId, Datum, Title, Message)
              VALUES ('1', '1', CURRENT_DATE, '$titlet', '$message')";
              // use exec() because no results are returned
              $conn->exec($sql);
              echo "New record created successfully";
            }
              catch(PDOException $e)
              {
                echo $sql . "<br>" . $e->getMessage();
              }
              $conn = null;
              ?>

        </div>
        <div class="between25"></div>
      </div>

  </body>
</html>
