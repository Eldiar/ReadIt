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

        <div class="main">

            <div class="post">
              <div class="postheader">
                <a href="#" class="posttitle"><b><?php echo $_POST["title"]; ?></b></a>
                <a href="#" class="postuser">Username</a>
                <span class="postdate">dd-mm-yyyy</span>
              </div>
              <p class="posttext"><?php echo $_POST["postMessage"]; ?></p>
            </div>

        </div>


        <div class="between25"></div>
      </div>



  </body>
</html>
